<?php
/**
 * Hotel Aura - Root Entry Point
 * 
 * This file redirects or includes the public/index.php to handle requests 
 * coming to the root directory. This helps prevent 403 Forbidden errors 
 * when the server is configured to not allow directory listing.
 */

require_once __DIR__ . '/public/index.php';
