<?php
/**
 * Get Current User API Endpoint
 * GET /api/auth/me
 *
 * Headers:
 * Authorization: Bearer {token}
 *
 * Response:
 * {
 *   "id": 1,
 *   "name": "Admin User",
 *   "email": "admin@sylcroad.com",
 *   "role": "admin"
 * }
 */

require_once '../config.php';

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendError('Method not allowed. Use GET.', 405);
}

// Get Bearer token from Authorization header
$token = getBearerToken();

if (!$token) {
    sendError('Authorization token required', 401);
}

// Verify JWT token
$userData = verifyJWT($token);

if (!$userData) {
    sendError('Invalid or expired token', 401);
}

// Get full user data
$user = getUserByEmail($userData['email']);

if (!$user) {
    sendError('User not found', 404);
}

// Send response
sendResponse($user, 200);
