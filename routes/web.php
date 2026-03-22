<?php
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// Map routes strictly to expected MVC paths
$routes = [
    '' => ['HomeController', 'index'],
    'home' => ['HomeController', 'index'],
    'about-us' => ['HomeController', 'about'],
    'our-rooms' => ['HomeController', 'rooms'],
    'room-details' => ['HomeController', 'roomDetails'],
    'our-services' => ['HomeController', 'services'],
    'luxury-gallery' => ['HomeController', 'gallery'],
    'contact-us' => ['HomeController', 'contact'],
    'make-reservation' => ['HomeController', 'booking'],
    'make-reservation/submit' => ['HomeController', 'submitReservation'],
    'dashboard' => ['DashboardController', 'index'],
    'telegram/webhook' => ['TelegramController', 'webhook'],
    'telegram/setup-webhook' => ['TelegramController', 'setupWebhook'],

    'login' => ['AuthController', 'login'],
    'login/post' => ['AuthController', 'postLogin'],
    'register' => ['AuthController', 'register'],
    'register/post' => ['AuthController', 'postRegister'],
    'logout' => ['AuthController', 'logout'],
    'auth/logout' => ['AuthController', 'logout'],

    'floors' => ['FloorController', 'index'],
    'floors/create' => ['FloorController', 'create'],
    'floors/store' => ['FloorController', 'store'],
    'floors/edit' => ['FloorController', 'edit'],
    'floors/update' => ['FloorController', 'update'],
    'floors/delete' => ['FloorController', 'delete'],

    'room-types' => ['RoomTypeController', 'index'],
    'room-types/create' => ['RoomTypeController', 'create'],
    'room-types/store' => ['RoomTypeController', 'store'],
    'room-types/edit' => ['RoomTypeController', 'edit'],
    'room-types/update' => ['RoomTypeController', 'update'],
    'room-types/delete' => ['RoomTypeController', 'delete'],
    'room-types/deleteGalleryImage' => ['RoomTypeController', 'deleteGalleryImage'],
    'room-types/deletePrimaryImage' => ['RoomTypeController', 'deletePrimaryImage'],

    'language/switch' => ['DashboardController', 'switchLanguage'],

    'rooms' => ['RoomController', 'index'],
    'rooms/create' => ['RoomController', 'create'],
    'rooms/store' => ['RoomController', 'store'],
    'rooms/edit' => ['RoomController', 'edit'],
    'rooms/update' => ['RoomController', 'update'],
    'rooms/delete' => ['RoomController', 'delete'],

    'guests' => ['GuestController', 'index'],
    'guests/create' => ['GuestController', 'create'],
    'guests/store' => ['GuestController', 'store'],
    'guests/edit' => ['GuestController', 'edit'],
    'guests/update' => ['GuestController', 'update'],
    'guests/delete' => ['GuestController', 'delete'],

    'bookings' => ['BookingController', 'index'],
    'bookings/show' => ['BookingController', 'show'],
    'bookings/create' => ['BookingController', 'create'],
    'bookings/store' => ['BookingController', 'store'],
    'bookings/confirm' => ['BookingController', 'confirm'],
    'bookings/check-in' => ['BookingController', 'checkIn'],
    'bookings/check-out' => ['BookingController', 'checkOut'],
    'bookings/cancel' => ['BookingController', 'cancel'],
    'bookings/edit' => ['BookingController', 'edit'],
    'bookings/update' => ['BookingController', 'update'],

    'payments' => ['PaymentController', 'index'],
    'payments/create' => ['PaymentController', 'create'],
    'payments/store' => ['PaymentController', 'store'],

    'services' => ['ServiceController', 'index'],
    'services/store' => ['ServiceController', 'store'],
    'services/update' => ['ServiceController', 'update'],
    'services/delete' => ['ServiceController', 'delete'],
    'services/add-to-booking' => ['ServiceController', 'addToBooking'],

    'admins' => ['AdminController', 'index'],
    'admins/store' => ['AdminController', 'store'],
    'admins/update' => ['AdminController', 'update'],
    'admins/delete' => ['AdminController', 'delete'],
    'admins/profile' => ['AdminController', 'profile'],
    'admins/updateProfile' => ['AdminController', 'updateProfile']
];

if (array_key_exists($url, $routes)) {
    $controllerName = $routes[$url][0];
    $methodName = $routes[$url][1];
    
    // Explicitly check for the controller file if not loaded by autoloader
    if (!class_exists($controllerName)) {
        $controllerFile = APP_DIR . '/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        }
    }

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            $controller->$methodName();
        } else {
            die("Method $methodName not found in $controllerName");
        }
    } else {
        // More descriptive error for debugging
        $checkedPath = defined('APP_DIR') ? APP_DIR . '/controllers/' . $controllerName . '.php' : 'APP_DIR not defined';
        
        // Diagnostic: List files in the controllers directory
        $dirToScan = defined('APP_DIR') ? APP_DIR . '/controllers' : '';
        $filesInDir = "Directory not found";
        if (is_dir($dirToScan)) {
            $files = scandir($dirToScan);
            $filesInDir = implode(', ', $files);
        }

        // Diagnostic: List files in the root
        $rootDir = defined('ROOT_DIR') ? ROOT_DIR : '';
        $rootFiles = "Root directory not found";
        if (is_dir($rootDir)) {
            $files = scandir($rootDir);
            $rootFiles = implode(', ', $files);
        }

        die("Controller $controllerName not found.<br>
             Checked: $checkedPath<br>
             Files in controllers folder: $filesInDir<br>
             Files in root folder: $rootFiles");
    }
} else {
    // Luxury 404 Page
    header("HTTP/1.0 404 Not Found");
    $errorPage = APP_DIR . '/views/errors/404.php';
    if (file_exists($errorPage)) {
        include $errorPage;
    } else {
        die("404 Not Found - Error page missing at: $errorPage");
    }
}
