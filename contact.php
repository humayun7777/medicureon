<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input data and sanitize it
    $to = "info@medicureon.com"; // Your email address where the form submissions will go
    $from = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email
    $sender_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING); // Sanitize name
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING); // Sanitize phone
    $business = filter_var($_POST['business'], FILTER_SANITIZE_STRING); // Sanitize business
    $message_content = filter_var($_POST['message'], FILTER_SANITIZE_STRING); // Sanitize message

    // Validate the email address
    if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email format"]);
        exit;
    }

    // Email subject and message body
    $subject = "New Contact Form Submission";
    $message = "Name: $sender_name\nPhone: $phone\nBusiness Type: $business\nMessage: $message_content";

    // Email headers
    $headers = 'From: ' . $from . "\r\n" .
               'Reply-To: ' . $from . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(["status" => "success", "message" => "Your message has been sent successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to send your message. Please try again."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
