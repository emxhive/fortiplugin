<?php
declare(strict_types=1);

namespace Timeax\FortiPlugin\Installations\Support;

/**
 * Single authority for constructing emit payloads.
 */
final class EmitPayloadFactory
{
    /**
     * Build a canonical payload.
     *
     * @param non-empty-string $stream
     * @param non-empty-string $phase
     * @param non-empty-string $code
     * @param non-empty-string $severity
     * @param array<string,mixed> $data
     */
    public static function make(
        string $stream,
        string $phase,
        string $code,
        string $severity = EmitSeverity::INFO,
        array $data = [],
        ?string $text = null
    ): array {
        $normalizedSeverity = EmitSeverity::normalize($severity);
        $normalizedData = is_array($data) ? $data : [];

        $payload = [
            'stream' => $stream,
            'phase' => $phase,
            'code' => $code,
            'severity' => $normalizedSeverity,
            'timestamp' => gmdate('c'),
            'data' => $normalizedData,
            // Legacy compatibility
            'title' => EmitCodes::label($code),
            'meta' => $normalizedData,
        ];

        if ($text !== null) {
            $payload['text'] = $text;
            $payload['description'] = $text;
        } else {
            $payload['description'] = null;
        }

        if (isset($normalizedData['error']) && is_array($normalizedData['error'])) {
            $payload['error'] = $normalizedData['error'];
        }

        if (isset($normalizedData['stats']) && is_array($normalizedData['stats'])) {
            $stats = $normalizedData['stats'];
            $payload['stats'] = [
                'filePath' => $stats['filePath'] ?? null,
                'size' => $stats['size'] ?? null,
            ];
        }

        if (!isset($payload['stats'])) {
            $payload['stats'] = ['filePath' => null, 'size' => null];
        }

        return $payload;
    }

    /**
     * Return a channelled emitter that always builds canonical payloads first.
     *
     * @return callable(string,string|null,string|null,array<string,mixed>):void
     */
    public static function emitter(
        ?callable $emit,
        string $stream,
        string $phase,
        string $defaultSeverity = EmitSeverity::INFO
    ): callable {
        return static function (
            string $code,
            ?string $severity = null,
            ?string $text = null,
            array $data = []
        ) use ($emit, $stream, $phase, $defaultSeverity): void {
            if (!$emit) {
                return;
            }
            $payload = self::make(
                $stream,
                $phase,
                $code,
                $severity ? EmitSeverity::normalize($severity) : $defaultSeverity,
                $data,
                $text
            );
            $emit($payload);
        };
    }
}
