<?php
/**
 * Login API Endpoint
 * POST /api/auth/login
 *
 * Request Body:
 * {
 *   "email": "admin@sylcroad.com",
 *   "password": "admin123"
 * }
 *
 * Response:
 * {
 *   "token": "jwt_token_here",
 *   "user": {
 *     "id": 1,
 *     "name": "Admin User",
 *     "email": "admin@sylcroad.com",
 *     "role": "admin"
 *   }
 * }
 */

require_once '../config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendError('Method not allowed. Use POST.', 405);
}

// Get request body
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (empty($input['email']) || empty($input['password'])) {
    sendError('Email and password are required', 400);
}

$email = trim($input['email']);
$password = $input['password'];

// Log login attempt (for debugging)
error_log("=== LOGIN ATTEMPT ===");
error_log("Email: " . $email);
error_log("Time: " . date('Y-m-d H:i:s'));

// Verify credentials
if (!verifyPassword($email, $password)) {
    error_log("LOGIN FAILED: Invalid credentials for " . $email);
    sendError('Invalid email or password', 401);
}

// Get user data
$user = getUserByEmail($email);
if (!$user) {
    error_log("LOGIN FAILED: User not found for " . $email);
    sendError('User not found', 404);
}

// Generate JWT token
$token = generateJWT($user['id'], $email, $user['role']);

// Log successful login
error_log("LOGIN SUCCESS: " . $email . " (Role: " . $user['role'] . ")");

// Send response
sendResponse([
    'success' => true,
    'token' => $token,
    'user' => $user
], 200);
