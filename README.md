# E-Warranty Registration System

This is a simple E-Warranty Registration System built with CodeIgniter and Bootstrap.

## Prerequisites

*   A web server with PHP and MySQL (e.g., XAMPP, WAMP, MAMP).
*   A web browser.

## Installation

1.  **Download the code:**
    Clone or download this repository to your web server's document root (e.g., `htdocs` in XAMPP).

2.  **Set up the database:**
    *   Open your MySQL database management tool (e.g., phpMyAdmin).
    *   Create a new database named `warranty_system`.
    *   Import the `schema.sql` file into the `warranty_system` database. This will create the necessary tables and insert the admin user.

3.  **Configure CodeIgniter:**
    *   Open `application/config/config.php` and set your `base_url`:
        ```php
        $config['base_url'] = 'http://localhost/your-project-directory/';
        ```
    *   Open `application/config/database.php` and configure your database settings:
        ```php
        'hostname' => 'localhost',
        'username' => 'your_db_username',
        'password' => 'your_db_password',
        'database' => 'warranty_system',
        'dbdriver' => 'mysqli',
        ```
    *   Make sure to also load the session library. You can autoload it in `application/config/autoload.php`:
        ```php
        $autoload['libraries'] = array('database', 'session');
        ```

## Running the Application

*   **Admin Panel:**
    Access the admin login page at `http://localhost/your-project-directory/admin`.
    *   **Email:** `Ultraflex@gmail.cpm`
    *   **Password:** `Ultra@112233`

*   **Warranty Registration Form:**
    Access the registration form at `http://localhost/your-project-directory/warranty`.

## Testing the Flow

1.  **Admin Login:**
    *   Go to the admin login page.
    *   Enter the admin credentials and click "Login".
    *   You should be redirected to the admin dashboard.
    *   Click the "Logout" link to log out.

2.  **Warranty Registration:**
    *   Go to the warranty registration form.
    *   Fill in all the required fields.
    *   Click the "Add Product" button to add one or more products.
    *   Click "Register Warranty".
    *   You should be redirected to a success page.

3.  **Verify Data in Admin Panel:**
    *   Log in to the admin panel.
    *   The dashboard should now display the warranty you just registered. (Note: The code to display warranties on the dashboard still needs to be implemented in `Admin.php` and `admin/dashboard.php`).

4.  **Automated Messaging (Cron Job):**
    *   To test the automated messaging, you would need to set up a cron job on your server to run the `send_feedback_requests` method in the `Cron.php` controller.
    *   For example, you could set up a cron job to run daily at a specific time, which would call a URL like:
        `wget http://localhost/your-project-directory/cron/send_feedback_requests`
    *   Check your CodeIgniter logs (`application/logs/`) for messages indicating that feedback requests have been "sent".

## Next Steps

The following features still need to be fully implemented:
*   Displaying the list of warranties on the admin dashboard.
*   QR code scanning for product entry.
*   OTP generation and verification.
*   Full implementation of the feedback collection system.
*   Proper password hashing for user authentication.
