<?php
// Router for Sylcroad
// Handles clean URLs without .html extensions

// Get the requested URI
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = dirname($_SERVER['SCRIPT_NAME']);

// Remove script name from URI to get the path
$path = str_replace($script_name, '', $request_uri);
$path = trim($path, '/');

// Remove query string if present
$path = strtok($path, '?');

// Define routes
$routes = [
    '' => 'index.html',
    'login' => 'login.html',
    'dashboard' => 'views/dashboard.php',
];

// Check if route exists
if (array_key_exists($path, $routes)) {
    $file = $routes[$path];

    // Include PHP files, serve HTML files
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        require_once $file;
    } else {
        readfile($file);
    }
} else {
    // 404 Not Found
    http_response_code(404);
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Page Not Found</title>
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
                background: #0a0a0a;
                color: #ffffff;
            }
            .container {
                text-align: center;
            }
            h1 {
                font-size: 72px;
                margin: 0;
                color: #4cd137;
            }
            p {
                font-size: 20px;
                color: #a0a0a0;
            }
            a {
                color: #4cd137;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>404</h1>
            <p>Page not found</p>
            <a href="/">Go back home</a>
        </div>
    </body>
    </html>';
}
?>
