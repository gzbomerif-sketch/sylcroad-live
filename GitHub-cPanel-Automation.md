# Task: Automate deployment of the GitHub repository "Obre" to the cPanel-hosted "Sylcroad" website.
# This setup should use:
# - GitHub webhooks to trigger automatic deployment.
# - A secure deployment script to pull updates for the `main` branch directly to the server.

---

## Access Details:

### cPanel Access:
- Server: https://server370.web-hosting.com:2083
- Server IP: 69.57.162.167
- Username: sylcdvaa
- SSH Port: 21098
- SSH Password: Tywcy6-ragxan-bymdav

### Repository Details:
- Repository URL: https://github.com/gzbomerif-sketch/Obre.git
- Deployment Branch: main

### Deployment Directory:
- Target folder: `/home/sylcdvaa/public_html`

---

# Subtasks:

1. **Connect to the cPanel Server via SSH:**
   - Use the provided SSH credentials (username, password, and port) to log in to the server.

---

2. **Create a Deployment Script:**
   - Write a Bash script (`deploy.sh`) with the following functionality:
      - Navigate to the `public_html` directory: `cd /home/sylcdvaa/public_html`.
      - Reset the repository to discard any local edits: `git reset --hard`.
      - Pull the latest changes from the `main` branch of the GitHub repository: `git pull origin main`.
      - Adjust all file permissions for security:
         - Files: `chmod 644`
         - Directories: `chmod 755`
      - Log the deployment actions and status to a `deploy-log.txt` file in the same directory.
   - Save this script as `/home/sylcdvaa/public_html/deploy.sh`.
   - Make it executable:
     ```bash
     chmod +x /home/sylcdvaa/public_html/deploy.sh
     ```

---

3. **Set Up a Webhook Listener Script:**
   - Create a PHP script in the `public_html` directory to listen for GitHub webhook events.
   - Use the following PHP template:

```php
<?php
// Webhook listener for automatic deployment

// Define a secret token (choose your own secure key)
$secret = "your_webhook_secret_key\";

// Read the raw webhook payload
$rawPost = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

// Verify the payload signature
if ($signature && $secret) {
    $hash = 'sha1=' . hash_hmac('sha1', $rawPost, $secret);
    if (!hash_equals($signature, $hash)) {
        // Invalid signature
        http_response_code(403);
        error_log("Invalid webhook signature.");
        exit('Webhook validation failed.');
    }
}

// Decode the JSON payload
$payload = json_decode($rawPost, true);

// Check if the event references the `main` branch
if ($payload['ref'] === 'refs/heads/main') {
    // Log webhook trigger
    file_put_contents('deploy-log.txt', "Webhook triggered: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

    // Run the deployment script
    $output = shell_exec('/bin/bash /home/sylcdvaa/public_html/deploy.sh 2>&1');

    // Log script output
    file_put_contents('deploy-log.txt', $output, FILE_APPEND);

    echo "Deployment completed.";
} else {
    echo "No deployment for this branch.";
}
?>
```

4. Save the file as `/home/sylcdvaa/public_html/webhook-listener.php`.

---

4. **Configure Permissions for Webhook Listener and Deployment Script:**
   - Ensure both the `deploy.sh` and `webhook-listener.php` scripts have appropriate permissions:
     ```bash
     chmod 755 /home/sylcdvaa/public_html/deploy.sh
     chmod 644 /home/sylcdvaa/public_html/webhook-listener.php
     ```

---

5. **Set Up a GitHub Webhook:**
   - Access the GitHub repository: https://github.com/gzbomerif-sketch/Obre.git.
   - Go to `Settings > Webhooks > Add Webhook`.
   - Configure the webhook:
     - Payload URL: `https://sylcroad.com/webhook-listener.php`
     - Content-Type: `application/json`
     - Secret: Set the same value as `$secret` in `webhook-listener.php`.
     - Event: Only trigger on `push` to the `main` branch.

---

6. **Test the Configuration:**
   - Push a new commit to the `main` branch in the GitHub repository.
   - Verify:
     - The `webhook-listener.php` logs the webhook event.
     - The `deploy.sh` script is executed and updates the files in `/public_html`.
     - Check the `deploy-log.txt` for errors or success logs.

---

# Deliverables:
1. Deployment script (`deploy.sh`).
2. PHP webhook listener script (`webhook-listener.php`).
3. Logs stored in `deploy-log.txt`.
4. Fully automated deployment pipeline that requires no manual intervention for updates pushed to the GitHub repository.
