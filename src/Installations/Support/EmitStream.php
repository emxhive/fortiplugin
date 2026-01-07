<?php
declare(strict_types=1);

namespace Timeax\FortiPlugin\Installations\Support;

/**
 * Logical streams for emit payloads.
 */
final class EmitStream
{
    public const INSTALLER = 'installer';
    public const VALIDATION = 'validation';
    public const BACKGROUND = 'background';
}
