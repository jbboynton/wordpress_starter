<?php

/**
 * These configurations are loaded for all environments.
 */

$root_directory = dirname(__DIR__);
$web_root_directory = "${root_directory}/app";
$site_url = "https://" . $_SERVER['HTTP_HOST'];

/**
 * Expose `env()` globally.
 * See https://github.com/oscarotero/env for more information about this
 * package.
 */
Env::init();

/**
 * Load environment variables.
 * See https://github.com/vlucas/phpdotenv for more information about this
 * package.
 */
$env = Dotenv\Dotenv($root_directory);
$env_file = "${root_directory}/.env";

if (file_exists($env_file)) {
  $env->load();
  $env->required(array(
    "SITE_NAME",
    "WP_ENV",
    "DB_NAME",
    "DB_USER",
    "DB_PASSWORD",
    "DB_HOST",
    "DB_CHARSET",
    "DB_COLLATE",
    "DB_TABLE_PREFIX",
    "S3_UPLOADS_BUCKET",
    "S3_UPLOADS_KEY",
    "S3_UPLOADS_SECRET",
    "S3_UPLOADS_REGION"
  ));
}

/**
 * Set the global environment constant (default value is `production`). Then,
 * load the configuration file for the specified environment.
 */
define("WP_ENV", env("WP_ENV") ?: "production");
$env_filename = WP_ENV . ".php";
$env_directory = "${root_path}/config/environments";
$env_config_file = "${env_directory}/${env_filename}";

if (file_exists($env_config_file)) {
  require_once $env_config_file;
}

/**
 * Define paths.
 */
define("WP_HOME", "${site_url}");
define("WP_SITEURL", "${site_url}/wp");

define("CONTENT_DIR", "/content");
define("WP_CONTENT_DIR", $web_root_directory . CONTENT_DIR);
define("WP_CONTENT_URL", WP_HOME . CONTENT_DIR);

/**
 * Database configuration.
 */
define("DB_NAME", env("DB_NAME"));
define("DB_USER", env("DB_USER"));
define("DB_PASSWORD", env("DB_PASSWORD"));
define("DB_HOST", env("DB_HOST"));
define("DB_CHARSET", env("DB_CHARSET"));
define("DB_COLLATE", env("DB_COLLATE");
$table_prefix = env("DB_TABLE_PREFIX");

/**
 * Miscellaneous configuration.
 */
define("AUTOMATIC_UPDATER_DISABLED", true);
define("DISABLE_WP_CRON", false);
define("DISALLOW_FILE_EDIT", true);

/**
 * Reverse proxy detection.
 */
$header     = $_SERVER['HTTP_X_FORWARDED_PROTO'];
$header_set = (isset($header) ? true : false);
$is_https   = ($header === "https" ? true : false);

if ($header_set && $is_https) {
  $_SERVER['HTTPS'] = "on";
}

/**
 * Define `ABSPATH`.
 */
if (!defined("ABSPATH")) {
  define('ABSPATH', "${web_root_directory}/wp/");
}

