<?php
/*
Plugin Name: Secure User Data
Description: Safe database query using PDO prepared statements.
Version: 1.0
Author: Volkan Sah
*/

function secure_get_user_shortcode() {
    if (isset($_GET['user_id'])) {
        try {
            // Retrieve WordPress database configuration constants
            $dbHost = DB_HOST;
            $dbName = DB_NAME;
            $dbUser = DB_USER;
            $dbPassword = DB_PASSWORD;

            // Create a PDO connection with error handling enabled
            $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8";
            $pdo = new PDO($dsn, $dbUser, $dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Use a prepared statement to prevent SQL injection
            $stmt = $pdo->prepare("SELECT * FROM wp_users WHERE ID = ?");
            $stmt->execute([$_GET['user_id']]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Check if any results were returned
            if ($results) {
                $output = '<ul>';
                foreach ($results as $row) {
                    // Properly escape user data before displaying it
                    $output .= '<li>' . esc_html($row['user_login']) . '</li>';
                }
                $output .= '</ul>';
                return $output;
            }
        } catch (PDOException $e) {
            // Log database errors securely without exposing details to the user
            error_log('PDO Error: ' . $e->getMessage());
            return 'An error occurred.';
        }
    }
    return 'No user found.';
}

// Register the shortcode to allow users to retrieve user data securely
add_shortcode('get_user_secure', 'secure_get_user_shortcode');
