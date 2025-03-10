<?php
/*
Plugin Name: Vulnerable User Data
Description: Unsafe database query with SQL Injection vulnerability. DO NOT INSTALL ON PUBLIC SERVERS! 
Version: 1.0
Author: Volkan Sah
URL: https://github.com/NemesisCyberForce/
*/

function vulnerable_get_user_shortcode() {
    global $wpdb;
    
    // Check if 'user_id' parameter is set in the GET request
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id']; // Directly taking input from user (DANGEROUS!)
        
        // Constructing SQL query with unsanitized input - HIGH SECURITY RISK!
        $query = "SELECT * FROM {$wpdb->users} WHERE ID = $user_id";
        
        // Executing the query without using prepared statements - VULNERABLE TO SQL INJECTION!
        $results = $wpdb->get_results($query);

        if ($results) {
            $output = '<ul>';
            foreach ($results as $row) {
                // Escaping output to prevent XSS attacks
                $output .= '<li>' . esc_html($row->user_login) . '</li>';
            }
            $output .= '</ul>';
            return $output;
        }
    }
    
    return 'No user found.';
}

// Registering the shortcode 'get_user' that will trigger the function
add_shortcode('get_user', 'vulnerable_get_user_shortcode');
