<?php

// Define the Google Sheets endpoint URL
$googleSheetsUrl = 'https://script.google.com/macros/s/AKfycbxsOY1sygb6erQKUYy4oQTBncyn6p8lpFIjlMwmW_ZzOjb-Ymg-ebT2FFoFbUq7N6oC/exec';

// Define the form data
$formData = array(
    'form-identifier' => 'TestForm',
    'sheet-name' => 'johnmogi_ms',
    'customer-name' => 'John Doe',
    'phone-number' => '1234567890',
    'source' => 'Website'
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
    echo 'Error: ' . curl_error($ch);
} else {
    echo 'Form data sent successfully!';
}

// Close cURL session
curl_close($ch);
