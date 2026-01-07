<?php
declare(strict_types=1);

namespace Timeax\FortiPlugin\Installations\Support;

trait EmitPayload
{
    protected function emitPayload(
        string $stream,
        string $phase,
        string $code,
        string $severity = EmitSeverity::INFO,
        array $data = [],
        ?string $text = null
    ): array {
        return EmitPayloadFactory::make($stream, $phase, $code, $severity, $data, $text);
    }
}
