<?php
/**
 * Sylcroad API Configuration
 * Backend API for authentication and campaign management
 */

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CORS headers - Allow React frontend to access API
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration (update these with your actual cPanel database credentials)
define('DB_HOST', 'localhost');
define('DB_NAME', 'sylcdvaa_sylcroad');
define('DB_USER', 'sylcdvaa_admin');
define('DB_PASS', ''); // Set your database password

// JWT Secret Key - IMPORTANT: Change this to a random string in production
define('JWT_SECRET', 'your-secret-key-change-this-in-production-' . md5('sylcroad-2025'));

// Default admin credentials (for initial setup)
// TODO: Move these to database after first login
$ADMIN_CREDENTIALS = [
    'admin@sylcroad.com' => [
        'password' => password_hash('admin123', PASSWORD_BCRYPT),
        'name' => 'Admin User',
        'role' => 'admin',
        'id' => 1
    ],
    'demo@sylcroad.com' => [
        'password' => password_hash('demo123', PASSWORD_BCRYPT),
        'name' => 'Demo User',
        'role' => 'client',
        'id' => 2
    ]
];

/**
 * Generate JWT Token
 */
function generateJWT($userId, $email, $role) {
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $payload = json_encode([
        'user_id' => $userId,
        'email' => $email,
        'role' => $role,
        'iat' => time(),
        'exp' => time() + (60 * 60 * 24 * 7) // 7 days expiry
    ]);

    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}

/**
 * Verify JWT Token
 */
function verifyJWT($jwt) {
    if (empty($jwt)) {
        return false;
    }

    $tokenParts = explode('.', $jwt);
    if (count($tokenParts) !== 3) {
        return false;
    }

    $header = base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[0]));
    $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenParts[1]));
    $signatureProvided = $tokenParts[2];

    // Check expiration
    $payloadData = json_decode($payload, true);
    if ($payloadData['exp'] < time()) {
        return false;
    }

    // Verify signature
    $signature = hash_hmac('sha256', $tokenParts[0] . "." . $tokenParts[1], JWT_SECRET, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    if ($base64UrlSignature !== $signatureProvided) {
        return false;
    }

    return $payloadData;
}

/**
 * Get Authorization Header
 */
function getAuthorizationHeader() {
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } else if (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

/**
 * Get Bearer Token from Authorization Header
 */
function getBearerToken() {
    $headers = getAuthorizationHeader();
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

/**
 * Send JSON Response
 */
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit();
}

/**
 * Send Error Response
 */
function sendError($message, $statusCode = 400) {
    http_response_code($statusCode);
    echo json_encode(['error' => true, 'message' => $message]);
    exit();
}

/**
 * Get User by Email
 */
function getUserByEmail($email) {
    global $ADMIN_CREDENTIALS;
    if (isset($ADMIN_CREDENTIALS[$email])) {
        $user = $ADMIN_CREDENTIALS[$email];
        $user['email'] = $email;
        unset($user['password']); // Don't send password
        return $user;
    }
    return null;
}

/**
 * Verify Password
 */
function verifyPassword($email, $password) {
    global $ADMIN_CREDENTIALS;
    if (isset($ADMIN_CREDENTIALS[$email])) {
        return password_verify($password, $ADMIN_CREDENTIALS[$email]['password']);
    }
    return false;
}
