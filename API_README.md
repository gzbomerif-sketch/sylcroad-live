# 🚀 Sylcroad API Documentation

## Overview

This is the backend API for Sylcroad Campaign Management Platform. It provides authentication and user management endpoints.

## 🔐 Authentication

The API uses JWT (JSON Web Tokens) for authentication. After logging in, include the token in the Authorization header for protected endpoints.

---

## 📍 API Endpoints

### Base URL
```
Production: https://sylcroad.com/api
Development: http://localhost/api
```

### 1. Login
**Endpoint:** `POST /api/auth/login`

**Description:** Authenticate a user and receive a JWT token.

**Request Body:**
```json
{
  "email": "admin@sylcroad.com",
  "password": "admin123"
}
```

**Response (200 OK):**
```json
{
  "success": true,
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@sylcroad.com",
    "role": "admin"
  }
}
```

**Error Response (401 Unauthorized):**
```json
{
  "error": true,
  "message": "Invalid email or password"
}
```

---

### 2. Get Current User
**Endpoint:** `GET /api/auth/me`

**Description:** Get the currently authenticated user's information.

**Headers:**
```
Authorization: Bearer {your_jwt_token}
```

**Response (200 OK):**
```json
{
  "id": 1,
  "name": "Admin User",
  "email": "admin@sylcroad.com",
  "role": "admin"
}
```

**Error Response (401 Unauthorized):**
```json
{
  "error": true,
  "message": "Invalid or expired token"
}
```

---

## 👥 Default Credentials

### Admin Account
- **Email:** `admin@sylcroad.com`
- **Password:** `admin123`
- **Role:** `admin`

### Demo/Client Account
- **Email:** `demo@sylcroad.com`
- **Password:** `demo123`
- **Role:** `client`

> ⚠️ **IMPORTANT:** Change these default credentials in production!

---

## 🔧 Configuration

### JWT Token
- **Expiry:** 7 days
- **Algorithm:** HS256
- **Secret:** Defined in `api/config.php`

### CORS
- **Allowed Origins:** All (`*`)
- **Allowed Methods:** GET, POST, PUT, DELETE, OPTIONS
- **Allowed Headers:** Content-Type, Authorization

---

## 🗂️ File Structure

```
api/
├── config.php          # Configuration and utility functions
├── .htaccess           # API routing and CORS
└── auth/
    ├── login.php       # Login endpoint
    └── me.php          # Get current user endpoint
```

---

## 🚢 Deployment

The API is automatically deployed via GitHub and cPanel integration. The deployment script is defined in `.cpanel.yml`.

### Manual Deployment Steps:
1. Push changes to GitHub
2. cPanel webhook automatically triggers deployment
3. Files are copied to `/home/sylcdvaa/public_html/`
4. Permissions are set automatically

---

## 🛠️ Troubleshooting

### Login fails with "Invalid credentials"
- Verify you're using the correct email/password
- Check the credentials in `api/config.php` ($ADMIN_CREDENTIALS array)

### CORS errors
- Ensure `.htaccess` files are deployed correctly
- Check that Apache mod_headers is enabled on the server

### "Token expired" errors
- Tokens expire after 7 days
- Log in again to get a new token

### API returns 500 errors
- Check PHP error logs in cPanel
- Ensure all API files have correct permissions (755 for directories, 644 for files)
- Verify PHP version is 7.4 or higher

---

## 🔒 Security Notes

1. **Change the JWT_SECRET** in `api/config.php` before going to production
2. **Update default passwords** - don't use the default credentials in production
3. **Enable HTTPS** - Always use HTTPS in production to encrypt authentication tokens
4. **Consider database storage** - The current implementation stores credentials in PHP. For production, use a proper database.
5. **Rate limiting** - Consider implementing rate limiting for the login endpoint to prevent brute force attacks

---

## 📝 Next Steps

- [ ] Move credentials to database
- [ ] Add password reset functionality
- [ ] Implement refresh tokens
- [ ] Add rate limiting
- [ ] Create campaign management endpoints
- [ ] Add input validation and sanitization
- [ ] Implement proper logging system
- [ ] Add unit tests

---

## 📞 Support

For issues or questions, please contact the development team or create an issue in the GitHub repository.

---

**Version:** 1.0.0
**Last Updated:** November 2025
