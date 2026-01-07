<?php
declare(strict_types=1);

namespace Timeax\FortiPlugin\Installations\Support;

/**
 * Stable machine-readable emit codes for installer + validation streams.
 * Human-friendly labels remain available via label().
 */
final class EmitCodes
{
    // ── Installer / sections ────────────────────────────────────────────
    public const INSTALLER_TOKEN_INVALID = 'INSTALLER_TOKEN_INVALID';
    public const INSTALLER_TOKEN_MISMATCH = 'INSTALLER_TOKEN_MISMATCH';
    public const RESUME_PRECHECK_FAILED = 'RESUME_PRECHECK_FAILED';
    public const ROUTES_NONE_DISCOVERED = 'ROUTES_NONE_DISCOVERED';
    public const DB_TRANSACTION_ROLLBACK = 'DB_TRANSACTION_ROLLBACK';
    public const INSTALLATION_ASK = 'INSTALLATION_ASK';
    public const INSTALLATION_BREAK = 'INSTALLATION_BREAK';

    public const PROVIDERS_CHECK_START = 'PROVIDERS_CHECK_START';
    public const PROVIDERS_CHECK_OK = 'PROVIDERS_CHECK_OK';
    public const PROVIDERS_CHECK_FAIL = 'PROVIDERS_CHECK_FAIL';

    public const ROUTES_WRITE_START = 'ROUTES_WRITE_START';
    public const ROUTES_WRITE_OK = 'ROUTES_WRITE_OK';
    public const ROUTES_WRITE_FAIL = 'ROUTES_WRITE_FAIL';

    public const DB_PERSIST_START = 'DB_PERSIST_START';
    public const DB_PERSIST_OK = 'DB_PERSIST_OK';
    public const DB_PERSIST_FAIL = 'DB_PERSIST_FAIL';

    public const VENDOR_POLICY_INSPECT = 'VENDOR_POLICY_INSPECT';
    public const VENDOR_POLICY_STRIPPED = 'VENDOR_POLICY_STRIPPED';
    public const VENDOR_POLICY_STRIP_FAILED = 'VENDOR_POLICY_STRIP_FAILED';
    public const VENDOR_POLICY_KEEP = 'VENDOR_POLICY_KEEP';

    public const COMPOSER_PLAN_START = 'COMPOSER_PLAN_START';
    public const COMPOSER_PLAN_COMPUTED = 'COMPOSER_PLAN_COMPUTED';
    public const COMPOSER_PLAN_FAIL = 'COMPOSER_PLAN_FAIL';

    public const TOKEN_INVALID = 'TOKEN_INVALID';
    public const ZIP_STATUS_CHECK = 'ZIP_STATUS_CHECK';
    public const INSTALL_DECISION = 'INSTALL_DECISION';

    public const INSTALL_FILES_START = 'INSTALL_FILES_START';
    public const INSTALL_FILES_OK = 'INSTALL_FILES_OK';
    public const INSTALL_FILES_FAIL = 'INSTALL_FILES_FAIL';

    public const UI_BUILD_PUBLISH_START = 'UI_BUILD_PUBLISH_START';
    public const UI_BUILD_PUBLISH_OK = 'UI_BUILD_PUBLISH_OK';
    public const UI_BUILD_PUBLISH_FAIL = 'UI_BUILD_PUBLISH_FAIL';
    public const UI_BUILD_PUBLISH_SKIPPED = 'UI_BUILD_PUBLISH_SKIPPED';

    public const INTERNAL_CONFIG_START = 'INTERNAL_CONFIG_START';
    public const INTERNAL_CONFIG_OK = 'INTERNAL_CONFIG_OK';
    public const INTERNAL_CONFIG_FAIL = 'INTERNAL_CONFIG_FAIL';

    public const UI_CONFIG_CHECK_START = 'UI_CONFIG_CHECK_START';
    public const UI_CONFIG_CHECK_OK = 'UI_CONFIG_CHECK_OK';
    public const UI_CONFIG_CHECK_FAIL = 'UI_CONFIG_CHECK_FAIL';

    public const FILE_SCAN_START = 'FILE_SCAN_START';
    public const FILE_SCAN_DECISION = 'FILE_SCAN_DECISION';

    public const ROUTE_DISCOVERY_START = 'ROUTE_DISCOVERY_START';
    public const ROUTE_DISCOVERY_DONE = 'ROUTE_DISCOVERY_DONE';
    public const ROUTE_COMPILE_START = 'ROUTE_COMPILE_START';
    public const ROUTE_COMPILE_DONE = 'ROUTE_COMPILE_DONE';

    // ── Activation ───────────────────────────────────────────────────────
    public const ACTIVATION_START = 'ACTIVATION_START';
    public const ACTIVATION_LOCK_FAIL = 'ACTIVATION_LOCK_FAIL';
    public const ACTIVATION_FAIL = 'ACTIVATION_FAIL';
    public const ACTIVATION_NOOP = 'ACTIVATION_NOOP';
    public const INSTALL_LOG_READ_START = 'INSTALL_LOG_READ_START';
    public const INSTALL_LOG_READ_FAIL = 'INSTALL_LOG_READ_FAIL';
    public const INSTALL_LOG_READ_OK = 'INSTALL_LOG_READ_OK';
    public const VALIDATION_PRECHECK_FAIL = 'VALIDATION_PRECHECK_FAIL';
    public const VALIDATION_PRECHECK_OK = 'VALIDATION_PRECHECK_OK';
    public const STAGE_REGISTRIES_START = 'STAGE_REGISTRIES_START';
    public const STAGE_REGISTRIES_OK = 'STAGE_REGISTRIES_OK';
    public const DB_TX_START = 'DB_TX_START';
    public const REGISTRIES_COMMIT_START = 'REGISTRIES_COMMIT_START';
    public const REGISTRIES_COMMIT_OK = 'REGISTRIES_COMMIT_OK';
    public const DB_TX_COMMIT_OK = 'DB_TX_COMMIT_OK';
    public const DB_TX_ROLLBACK = 'DB_TX_ROLLBACK';
    public const REGISTRY_ROLLBACK_ATTEMPT = 'REGISTRY_ROLLBACK_ATTEMPT';
    public const CACHE_CLEAR_START = 'CACHE_CLEAR_START';
    public const CACHE_CLEAR_DONE = 'CACHE_CLEAR_DONE';
    public const ACTIVATION_OK = 'ACTIVATION_OK';

    // ── Background scan ──────────────────────────────────────────────────
    public const BACKGROUND_SCAN_FILE_START = 'BACKGROUND_SCAN_FILE_START';
    public const BACKGROUND_SCAN_FILE_END = 'BACKGROUND_SCAN_FILE_END';
    public const BACKGROUND_SCAN_SECURITY = 'BACKGROUND_SCAN_SECURITY';

    // ── Validation ───────────────────────────────────────────────────────
    public const VALIDATION_INIT_START = 'VALIDATION_INIT_START';
    public const VALIDATION_HEADLINE_START = 'VALIDATION_HEADLINE_START';
    public const VALIDATION_HEADLINE_DONE = 'VALIDATION_HEADLINE_DONE';
    public const VALIDATION_SCAN_START = 'VALIDATION_SCAN_START';
    public const VALIDATION_SCAN_DONE = 'VALIDATION_SCAN_DONE';
    public const VALIDATION_FINALIZE = 'VALIDATION_FINALIZE';

    public const VALIDATION_COMPOSER_ISSUE = 'VALIDATION_COMPOSER_ISSUE';
    public const VALIDATION_COMPOSER_EXCEPTION = 'VALIDATION_COMPOSER_EXCEPTION';
    public const VALIDATION_CONFIG_ERROR = 'VALIDATION_CONFIG_ERROR';
    public const VALIDATION_CONFIG_EXCEPTION = 'VALIDATION_CONFIG_EXCEPTION';
    public const VALIDATION_HOST_CONFIG_ERROR = 'VALIDATION_HOST_CONFIG_ERROR';
    public const VALIDATION_PERMISSION_MANIFEST_ERROR = 'VALIDATION_PERMISSION_MANIFEST_ERROR';
    public const VALIDATION_ROUTE_FILE_ERROR = 'VALIDATION_ROUTE_FILE_ERROR';
    public const VALIDATION_SCAN_FILE_START = 'VALIDATION_SCAN_FILE_START';
    public const VALIDATION_SCAN_FILE_END = 'VALIDATION_SCAN_FILE_END';
    public const VALIDATION_SCAN_SECURITY_ISSUE = 'VALIDATION_SCAN_SECURITY_ISSUE';
    public const VALIDATION_SCAN_EXCEPTION = 'VALIDATION_SCAN_EXCEPTION';

    private const LABELS = [
        self::VENDOR_POLICY_INSPECT => 'VendorPolicy: Inspect',
        self::VENDOR_POLICY_STRIPPED => 'VendorPolicy: Stripped vendor',
        self::VENDOR_POLICY_STRIP_FAILED => 'VendorPolicy: Strip failed',
        self::VENDOR_POLICY_KEEP => 'VendorPolicy: Keep vendor',
        self::BACKGROUND_SCAN_FILE_START => 'Background Scan: File',
        self::BACKGROUND_SCAN_FILE_END => 'Background Scan: File',
        self::BACKGROUND_SCAN_SECURITY => 'Background Scan: Security',
        self::VALIDATION_COMPOSER_ISSUE => 'Headline: Composer',
        self::VALIDATION_COMPOSER_EXCEPTION => 'Headline: Composer',
        self::VALIDATION_CONFIG_ERROR => 'Headline: Config',
        self::VALIDATION_CONFIG_EXCEPTION => 'Headline: Config',
        self::VALIDATION_HOST_CONFIG_ERROR => 'Headline: HostConfig',
        self::VALIDATION_PERMISSION_MANIFEST_ERROR => 'Headline: Permission manifest',
        self::VALIDATION_ROUTE_FILE_ERROR => 'Headline: Route file',
        self::VALIDATION_SCAN_SECURITY_ISSUE => 'Scan: Security',
        self::VALIDATION_SCAN_FILE_START => 'Scan: File',
        self::VALIDATION_SCAN_FILE_END => 'Scan: File',
        self::VALIDATION_SCAN_EXCEPTION => 'Scan',
    ];

    public static function label(string $code): string
    {
        return self::LABELS[$code] ?? $code;
    }
}
