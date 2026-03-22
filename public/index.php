<?php
session_start();

// Define Path Constants
$publicPath = str_replace('\\', '/', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
// Get root by going up one level from public/
define('ROOT_DIR', dirname($publicPath)); 
define('APP_DIR', ROOT_DIR . '/app'); 

// --- DEBUG SECTION (You can remove after testing) ---
// if (!file_exists(APP_DIR . '/controllers/HomeController.php')) {
//    die("Critical Error: APP_DIR is " . APP_DIR . " but HomeController.php was NOT found there.");
// }
// ----------------------------------------------------

// --- Translation System ---
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en'; // Default
}

$langSet = $_SESSION['lang'];
$langFile = APP_DIR . '/lang/' . $langSet . '.php';
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
$configFile = ROOT_DIR . '/config/config.php';
$config = file_exists($configFile) ? require_once $configFile : [];

// Set Timezone
if (!empty($config['app']['timezone'])) {
    date_default_timezone_set($config['app']['timezone']);
}

// Automatically detect BASE_URL for routing
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($scriptName === '/' || $scriptName === '\\') $scriptName = '';

// Allow override from config
$baseUrl = $config['app']['url_path'] ?? $scriptName;
// If we are using a root .htaccess to hide /public, we might want to strip /public from BASE_URL
if (strpos($baseUrl, '/public') !== false && !file_exists(ROOT_DIR . '/index.php')) {
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
    // Priority check for exact case
    $paths = [
        APP_DIR . '/controllers/',
        APP_DIR . '/models/',
        ROOT_DIR . '/config/'
    ];

    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Secondary check for lowercase filenames (common on Linux/InfinityFree)
    foreach ($paths as $path) {
        $file = $path . strtolower($className) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Require Base MVC Core Classes
$databaseClass = ROOT_DIR . '/config/Database.php';
$baseController = APP_DIR . '/controllers/Controller.php';
$baseModel = APP_DIR . '/models/Model.php';

if (file_exists($databaseClass)) require_once $databaseClass;
if (file_exists($baseController)) require_once $baseController;
if (file_exists($baseModel)) require_once $baseModel;

// Route the request
require_once ROOT_DIR . DS . 'routes' . DS . 'web.php';
