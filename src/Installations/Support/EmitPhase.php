<?php
declare(strict_types=1);

namespace Timeax\FortiPlugin\Installations\Support;

/**
 * Canonical lifecycle phases for installer + validation emits.
 */
final class EmitPhase
{
    public const PREFLIGHT = 'installer.preflight';
    public const ZIP_VALIDATION = 'installer.zip_validation';
    public const PROVIDER_VALIDATION = 'installer.providers';
    public const VENDOR_POLICY = 'installer.vendor_policy';
    public const COMPOSER_PLAN = 'installer.composer_plan';
    public const DB_PERSIST = 'installer.db_persist';
    public const ROUTE_DISCOVERY = 'installer.route_discovery';
    public const ROUTE_COMPILE = 'installer.route_compile';
    public const ROUTE_WRITE = 'installer.route_write';
    public const INTERNAL_CONFIG = 'installer.internal_config';
    public const INSTALL_FILES = 'installer.install_files';
    public const PUBLISH_ASSETS = 'installer.publish_assets';
    public const UI_CONFIG = 'installer.ui_config';
    public const FILE_SCAN = 'installer.file_scan';
    public const DECISION = 'installer.decision';
    public const ACTIVATION = 'installer.activation';
    public const BACKGROUND_SCAN = 'installer.background_scan';

    public const VALIDATION_INIT = 'validation.init';
    public const VALIDATION_HEADLINE = 'validation.headline';
    public const VALIDATION_SCAN = 'validation.scan';
    public const VALIDATION_FINALIZE = 'validation.finalize';
}
