<?php
/*
Plugin Name: MOGI Custom Form
Description: One Stop Google sheets light weight form.
Version: 1.1.1
Author: John Mogi
Author Email: dev@johnmogi.com
*/

// Initialize the plugin
function custom_form_plugin_init()
{
    // Register admin menu for managing forms
    add_action('admin_menu', 'custom_form_plugin_menu');

    // Register shortcode for displaying forms
    add_shortcode('custom_form', 'custom_form_shortcode');
}
add_action('init', 'custom_form_plugin_init');

// Create admin menu for form management
function custom_form_plugin_menu()
{
    add_menu_page(
        'mogi Form Management', // Page title
        'mogi Form Management', // Menu title
        'manage_options',      // Capability
        'custom-form-management', // Menu slug
        'custom_form_management_page', // Function to display the page content
        'dashicons-format-status' // Dashicon icon class
    );
}

function custom_form_enqueue_assets()
{
    // Enqueue JavaScript
    wp_enqueue_script(
        'custom-form-handler',
        plugin_dir_url(__FILE__) . 'js/form_handle.js',
        array('jquery'),
        '1.0.0',
        true
    );
    // Localize script with the AJAX URL
    wp_localize_script('custom-form-handler', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
    // Enqueue CSS
    wp_enqueue_style(
        'custom-form-styles',
        plugin_dir_url(__FILE__) . 'css/form_styles.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'custom_form_enqueue_assets');

// Admin page for managing forms
function custom_form_management_page()
{
    echo '<div class="wrap">';
    echo '<h1>mogi Form Management</h1>';
    echo '<p>One place to rule them all: Set your global submission handler URL below.</p>';

    if ( isset( $_POST['submission_url'] ) && isset( $_POST['nonce_field'] ) && wp_verify_nonce( $_POST['nonce_field'], 'update_custom_form_settings' ) ) {
        update_option( 'custom_form_submission_url', sanitize_text_field( $_POST['submission_url'] ) );
        update_option( 'custom_form_submission_email', sanitize_email( $_POST['submission_email'] ) );
    }
    

 #   $submissionUrl = get_option('custom_form_submission_url', '');
    $submissionUrl = 'https://script.google.com/macros/s/AKfycbxsOY1sygb6erQKUYy4oQTBncyn6p8lpFIjlMwmW_ZzOjb-Ymg-ebT2FFoFbUq7N6oC/exec';  // Hardcoded URL

 #   $submissionEmail = get_option('custom_form_submission_email', '');
    $submissionEmail = 'anguru@gmail.com';  // Hardcoded email


    // Form for updating the Submission Handler URL
    echo '<form method="post">';
    echo '<label for="submission_url">Submission Handler URL:</label><br>';
    echo '<input type="text" id="submission_url" name="submission_url" value="' . esc_attr($submissionUrl) . '"><br>';
    echo '<label for="submission_email">Submission Email Address:</label><br>';
    echo '<input type="email" id="submission_email" name="submission_email" value="' . esc_attr($submissionEmail) . '"><br>';
    wp_nonce_field( 'update_custom_form_settings' );
    echo '<input type="submit" value="Save Settings">';
    echo '</form>';

    echo '<h2>Available Forms</h2>';
    $form_templates_dir = plugin_dir_path(__FILE__) . 'forms/'; // Adjusted path
    if (is_dir($form_templates_dir)) {
        foreach (new DirectoryIterator($form_templates_dir) as $file) {
            if ($file->isFile() && $file->getExtension() == 'php') {
                $form_id = $file->getBasename('.php');
                echo '<p><strong>' . esc_html($form_id) . ':</strong> [custom_form id="' . esc_attr($form_id) . '"]</p>';
            }
        }
    } else {
        echo '<p>No form templates found.</p>';
    }


    echo '</div>';
}


function handle_custom_form_ajax_submission() {
    // Define the Google Sheets endpoint URL
    $googleSheetsUrl = 'https://script.google.com/macros/s/AKfycbxsOY1sygb6erQKUYy4oQTBncyn6p8lpFIjlMwmW_ZzOjb-Ymg-ebT2FFoFbUq7N6oC/exec';

    // Define the form data
    $formData = array(
        'form-identifier' => 'TestForm',
        'sheet-name' => 'johnmogi_ms',
        'customer-name' => isset($_POST['customer-name']) ? sanitize_text_field($_POST['customer-name']) : '',
        'phone-number' => isset($_POST['phone-number']) ? sanitize_text_field($_POST['phone-number']) : '',
        'source' => isset($_POST['source']) ? sanitize_text_field($_POST['source']) : ''
        // Add more form fields as needed
    );

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $googleSheetsUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($formData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if(curl_errno($ch)) {
        $email_result = false;
    } else {
        $email_result = true;
    }

    // Close cURL session
    curl_close($ch);

    // Send email
    $email = get_option('custom_form_submission_email', 'anguru@gmail.com');
    $site_name = get_bloginfo('name');
    $subject = "New lead from site: " . $site_name;
    $body = "";

    // Define field mappings
    $field_mappings = array(
        'customer-name' => 'Customer Name',
        'phone-number' => 'Phone Number',
        'source' => 'Source',
        'marketing-consent' => 'Marketing Consent'
    );

    foreach ($field_mappings as $field_key => $field_label) {
        if (isset($_POST[$field_key])) {
            $field_value = sanitize_text_field($_POST[$field_key]);
            $body .= $field_label . ': ' . $field_value . "\n";
        }
    }

    // Send email if form submission was successful
    if ($email_result) {
        wp_mail($email, $subject, $body);
        echo 'Email sent successfully';
    } else {
        echo 'Failed to send email';
    }

    wp_die();
}

// Hook for logged-in users
add_action('wp_ajax_submit_custom_form', 'handle_custom_form_ajax_submission');

// Hook for non-logged-in users
add_action('wp_ajax_nopriv_submit_custom_form', 'handle_custom_form_ajax_submission');

/**
 * Processes form submissions collect into json
 * custom newletter form
 */
function handle_json_form_submission() {
    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Include the WordPress Filesystem API for file operations
        include_once( ABSPATH . 'wp-admin/includes/file.php' );

        // Initialize the WordPress Filesystem
        WP_Filesystem();

        // Get the uploads directory path
        $uploads_dir = wp_upload_dir();
        $filename = trailingslashit( $uploads_dir['basedir'] ) . 'submissions.json';

        // Handle form submission
        $data = array(
            'email' => filter_input(INPUT_POST, 'customer-email', FILTER_SANITIZE_EMAIL),
            'source' => filter_input(INPUT_POST, 'source', FILTER_SANITIZE_STRING),
            'submitted_at' => gmdate('Y-m-d H:i:s') // Use gmdate() instead of date()
        );

        // Read existing data
        $existing_data = array();
        if ( file_exists( $filename ) ) {
            $existing_data = json_decode( WP_Filesystem()->get_contents( $filename ), true );
        }

        // Append new data
        $existing_data[] = $data;

        // Write data back to file
        WP_Filesystem()->put_contents( $filename, wp_json_encode( $existing_data, JSON_PRETTY_PRINT ) );

        echo "<p>Submission saved.</p>";
        wp_die(); // Terminate AJAX request
    } else {
        // Form has not been submitted, display the form
        ob_start();
        // Adjust the path as needed to point to your form template
        include( plugin_dir_path( __FILE__ ) . 'forms/newsletter-form.php' );
        return ob_get_clean();
    }
}

function register_json_form_submission_shortcode() {
    add_shortcode('json_form_submission', 'handle_json_form_submission');
}
add_action('init', 'register_json_form_submission_shortcode');


// END custom newletter form

function custom_form_shortcode($atts)
{
    // Extract shortcode attributes
    $atts = shortcode_atts(
        array(
            'id' => '', // Default value for ID attribute
        ),
        $atts,
        'custom_form'
    );

    // Get the form ID from shortcode attributes
    $form_id = isset($atts['id']) ? $atts['id'] : '';

    // Check if form ID is provided
    if (!empty($form_id)) {
        // Load the form template based on the form ID
        ob_start();
        include(plugin_dir_path(__FILE__) . 'forms/' . $form_id . '.php');
        return ob_get_clean();
    } else {
        return '<p>No form ID provided.</p>';
    }
}
