<?php
declare(strict_types=1);

namespace Timeax\FortiPlugin\Installations\Sections;

use JsonException;
use RuntimeException;
use Throwable;
use Timeax\FortiPlugin\Installations\Support\AtomicFilesystem;
use Timeax\FortiPlugin\Installations\Support\EmitCodes;
use Timeax\FortiPlugin\Installations\Support\EmitPayloadFactory;
use Timeax\FortiPlugin\Installations\Support\EmitPhase;
use Timeax\FortiPlugin\Installations\Support\EmitSeverity;
use Timeax\FortiPlugin\Installations\Support\EmitStream;
use Timeax\FortiPlugin\Installations\Support\InstallationLogStore;
use Timeax\FortiPlugin\Installations\Support\RouteMaterializer;
use Timeax\FortiPlugin\Installations\Support\RouteRegistryStore;
use Timeax\FortiPlugin\Models\Plugin;

/**
 * RouteWriteSection (registry-first)
 *
 * - Reads registry (.internal/routes.registry.json) written by RouteUiBridge.
 * - Materializes per-route PHP files into <staging>/routes/.
 * - Writes aggregator "fortiplugin.route.php" with a health route and requires.
 * - Persists a "routes_write" block (dir, files, aggregator, registry).
 * - Emits start/ok/fail installer events.
 */
final readonly class RouteWriteSection
{
    public function __construct(
        private InstallationLogStore $log,
        private AtomicFilesystem     $afs,
        private RouteRegistryStore   $registry,
        private RouteMaterializer    $materializer,
    )
    {
    }

    /**
     * @param Plugin $plugin Eloquent Plugin model (slug used for health route)
     * @param array<int, array{
     *   source?: string,
     *   php: string,
     *   routeIds: string[],
     *   slug: string
     * }> $compiled (ignored for writing; kept for compatibility with caller)
     * @param callable $emit Installer emitter fn(array $payload): void (non-null; persistence handled upstream)
     *
     * @return array{
     *   status: 'ok'|'fail',
     *   dir?: string,
     *   files?: string[],
     *   aggregator?: string,
     *   registry?: string,
     *   reason?: string
     * }
     *
     * @throws JsonException
     */
    public function run(
        Plugin    $plugin,
        array     $compiled,
        callable  $emit
    ): array
    {
        $emitSignal = EmitPayloadFactory::emitter($emit, EmitStream::INSTALLER, EmitPhase::ROUTE_WRITE);
        // Resolve STAGING root from installation log meta
        $doc = $this->log->read();
        $meta = (array)($doc['meta'] ?? []);
        $paths = (array)($meta['paths'] ?? []);
        $stagingRoot = (string)($paths['staging'] ?? '');

        if ($stagingRoot === '') {
            throw new RuntimeException('RouteWriteSection: missing meta.paths.staging in InstallationLogStore.');
        }

        $emitSignal(
            EmitCodes::ROUTES_WRITE_START,
            EmitSeverity::INFO,
            'Materializing routes from registry',
            ['staging_root' => $stagingRoot, 'chunks_seen' => count($compiled)]
        );

        try {
            $entries = $this->registry->read($stagingRoot);
            if ($entries === []) {
                // Nothing to write (okay)
                $doc = [
                    'dir' => 'routes',
                    'files' => [],
                    'aggregator' => null,
                    'registry' => '.internal/routes.registry.json',
                ];
                $this->log->writeSection('routes_write', $doc);

                $emitSignal(
                    EmitCodes::ROUTES_WRITE_OK,
                    EmitSeverity::INFO,
                    'No registry entries to write',
                    ['dir' => $doc['dir'], 'file_count' => 0]
                );

                return ['status' => 'ok'] + $doc;
            }

            $slug = (string)($plugin->placeholder->slug ?? $plugin->slug ?? 'plugin');
            $mat = $this->materializer->materialize($stagingRoot, $slug, $entries);

            $out = [
                'dir' => 'routes',
                'files' => $mat['files'],
                'aggregator' => 'routes/fortiplugin.route.php',
                'registry' => '.internal/routes.registry.json',
            ];

            $this->log->writeSection('routes_write', $out);

            $emitSignal(
                EmitCodes::ROUTES_WRITE_OK,
                EmitSeverity::INFO,
                'Routes registry materialized',
                ['dir' => $out['dir'], 'file_count' => count($out['files']), 'aggregator' => $out['aggregator']]
            );

            return ['status' => 'ok'] + $out;
        } catch (Throwable $e) {
            $emitSignal(
                EmitCodes::ROUTES_WRITE_FAIL,
                EmitSeverity::ERROR,
                'Materialization error',
                ['exception' => $e->getMessage()]
            );

            $this->log->writeSection('routes_write', [
                'error' => 'exception',
                'exception' => $e->getMessage(),
                'registry' => '.internal/routes.registry.json',
            ]);

            return ['status' => 'fail', 'reason' => 'exception'];
        }
    }
}
