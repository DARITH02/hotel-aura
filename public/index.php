<?php
session_start();

// Define Path Constants
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . DS . 'app');

// --- Translation System ---
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en'; // Default
}

$langSet = $_SESSION['lang'];
$langFile = APP_DIR . DS . 'lang' . DS . $langSet . '.php';
$translations = file_exists($langFile) ? include $langFile : [];

/**
 * Global translation helper
 * @param string $key
 * @return string
 */
function __($key) {
    global $translations;
    return $translations[$key] ?? $key;
}
// --------------------------

// --- Global Configuration ---
$config = require_once ROOT_DIR . DS . 'config' . DS . 'config.php';

// Automatically detect BASE_URL for routing
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($scriptName === '/' || $scriptName === '\\') $scriptName = '';

// Allow override from config
$baseUrl = $config['app']['url_path'] ?? $scriptName;
// If we are using a root .htaccess to hide /public, we might want to strip /public from BASE_URL
if (strpos($baseUrl, '/public') !== false && !file_exists(ROOT_DIR . DS . 'index.php')) {
    // This is a common setup on shared hosting
    $baseUrl = str_replace('/public', '', $baseUrl);
}
define('BASE_URL', $baseUrl);

// Detect Full URL for external services (Telegram, etc.)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST']; 
define('FULL_BASE_URL', $protocol . $host . BASE_URL);

// Autoloader for Controllers and Models
spl_autoload_register(function ($className) {
    if (file_exists(APP_DIR . DS . 'controllers' . DS . $className . '.php')) {
        require_once APP_DIR . DS . 'controllers' . DS . $className . '.php';
    } elseif (file_exists(APP_DIR . DS . 'models' . DS . $className . '.php')) {
        require_once APP_DIR . DS . 'models' . DS . $className . '.php';
    } elseif (file_exists(ROOT_DIR . DS . 'config' . DS . $className . '.php')) {
        require_once ROOT_DIR . DS . 'config' . DS . $className . '.php';
    }
});

// Require Base MVC Core Classes implicitly if missing from autoloader execution mapping
if (file_exists(APP_DIR . DS . 'controllers' . DS . 'Controller.php')) require_once APP_DIR . DS . 'controllers' . DS . 'Controller.php';
if (file_exists(APP_DIR . DS . 'models' . DS . 'Model.php')) require_once APP_DIR . DS . 'models' . DS . 'Model.php';

// Route the request
require_once ROOT_DIR . DS . 'routes' . DS . 'web.php';
