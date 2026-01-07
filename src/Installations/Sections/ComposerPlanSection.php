<?php
declare(strict_types=1);

namespace Timeax\FortiPlugin\Installations\Sections;

use Throwable;
use Timeax\FortiPlugin\Installations\Support\ComposerInspector;
use Timeax\FortiPlugin\Installations\Support\EmitCodes;
use Timeax\FortiPlugin\Installations\Support\EmitPayloadFactory;
use Timeax\FortiPlugin\Installations\Support\EmitPhase;
use Timeax\FortiPlugin\Installations\Support\EmitSeverity;
use Timeax\FortiPlugin\Installations\Support\EmitStream;
use Timeax\FortiPlugin\Installations\Support\InstallationLogStore;

/**
 * ComposerPlanSection
 *
 * Responsibilities
 * - Read host composer.lock and plugin composer.json.
 * - Build the per-package “foreign map” (is_foreign + initial UNVERIFIED status).
 * - Compute a conservative Composer plan (add/skip + core_conflicts).
 * - Persist to installation.json under "composer_plan":
 *     {
 *       "packages": { "<name>": { is_foreign, status } ... },
 *       "plan": { actions: {...}, core_conflicts: [...] }
 *     }
 *
 * Notes
 * - This section does NOT execute Composer or modify vendor code.
 * - It merely prepares data for the host UI/flows (and later, optional scans of foreign packages).
 */
final class ComposerPlanSection
{
    public function __construct(
        private readonly InstallationLogStore $log,
        private readonly ComposerInspector    $inspector,
    )
    {
    }

    /**
     * @param string $pluginDir Plugin root directory (must contain composer.json)
     * @param string|null $hostComposerLock Absolute path to host composer.lock; if null, defaults to getcwd().'/composer.lock'
     * @param callable $emit Installer-level emitter fn(array $payload): void (non-null; persisted by installer emitter)
     * @return array{
     *   status: 'ok'|'fail',
     *   packages?: array<string, array{is_foreign:bool,status:string}>,
     *   plan?: array{actions: array<string,string>, core_conflicts: list<string>}
     * }
     */
    public function run(
        string    $pluginDir,
        ?string   $hostComposerLock = null,
        callable  $emit
    ): array
    {
        $emitSignal = EmitPayloadFactory::emitter($emit, EmitStream::INSTALLER, EmitPhase::COMPOSER_PLAN);
        $emitSignal(
            EmitCodes::COMPOSER_PLAN_START,
            EmitSeverity::INFO,
            'Collecting packages & computing plan'
        );

        $pluginComposer = rtrim($pluginDir, "\\/") . DIRECTORY_SEPARATOR . 'composer.json';
        $hostLock = $hostComposerLock ?: (getcwd() . DIRECTORY_SEPARATOR . 'composer.lock');

        try {
            // 1) Collect package map (foreign vs host-present)
            $packages = $this->inspector->collectPackages($hostLock, $pluginComposer); // array<string,PackageEntry>

            // 2) Compute plan (actions + core_conflicts)
            $plan = $this->inspector->plan($packages); // ComposerPlan

            // 3) Persist to installation.json under "composer_plan"
            $this->log->writeSection('composer_plan', [
                'packages' => array_map(static fn($e) => $e->toArray(), $packages),
                'plan' => $plan->toArray(),
            ]);

            $emitSignal(
                EmitCodes::COMPOSER_PLAN_COMPUTED,
                EmitSeverity::INFO,
                'Composer plan persisted',
                [
                    'path' => $this->log->path(),
                    'packages' => count($packages),
                    'core_conflicts' => $plan->core_conflicts,
                ]
            );

            $packagesMeta = array_map(static fn($e) => $e->toArray(), $packages);

            return [
                'status' => 'ok',
                'packages' => $packagesMeta,     // keep for summary/UI
                'packages_dto' => $packages,     // NEW: for DbPersist (DTO map)
                'plan' => $plan->toArray(),
            ];


        } catch (Throwable $e) {
            // Emit a concise failure and return
            $emitSignal(
                EmitCodes::COMPOSER_PLAN_FAIL,
                EmitSeverity::ERROR,
                'Failed to compute Composer plan',
                [
                    'error' => $e->getMessage(),
                    'host_lock' => $hostLock,
                    'plugin_composer' => $pluginComposer,
                ]
            );

            return ['status' => 'fail'];
        }
    }
}
