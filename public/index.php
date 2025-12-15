<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Sanitize environment variables injected by the host
|--------------------------------------------------------------------------
|
| Some hosts (or export tools) add surrounding quotes or extra spaces to
| environment variables. We clean APP_KEY (and optionally ASSET_URL/APP_URL)
| early so Laravel will parse a correct key and avoid encryption errors.
|
*/
if (!function_exists('sanitise_env_var')) {
    function sanitise_env_var(string $name): void
    {
        $val = getenv($name);
        if ($val === false || $val === null) {
            return;
        }

        $orig = $val;
        $val = trim($val);

        // Remove surrounding single or double quotes
        if ((str_starts_with($val, '"') && str_ends_with($val, '"')) ||
            (str_starts_with($val, "'") && str_ends_with($val, "'"))) {
            $val = substr($val, 1, -1);
        }

        // If it's a base64 key and contains spaces (e.g. "base64: AAA..."), remove spaces in payload
        if (str_starts_with($val, 'base64:')) {
            $parts = explode(':', $val, 2);
            // Remove whitespace inside the encoded part and trim
            $payload = preg_replace('/\s+/', '', $parts[1]);
            $payload = trim($payload);
            $val = $parts[0] . ':' . $payload;
        }

        // If value changed, export the sanitized value back to env
        if ($val !== $orig) {
            putenv("$name=$val");
            $_ENV[$name] = $val;
            $_SERVER[$name] = $val;
        }
    }
}

// Sanitize the keys we care about (add more names if needed)
sanitise_env_var('APP_KEY');
sanitise_env_var('ASSET_URL');
sanitise_env_var('APP_URL');

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());