<?php
declare(strict_types=1);

namespace Timeax\FortiPlugin\Installations\Support;

/**
 * Canonical severity levels for emit payloads.
 */
final class EmitSeverity
{
    public const INFO = 'info';
    public const WARNING = 'warning';
    public const ERROR = 'error';

    public static function normalize(string $value): string
    {
        return in_array($value, [self::INFO, self::WARNING, self::ERROR], true)
            ? $value
            : self::INFO;
    }
}
