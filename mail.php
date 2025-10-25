<?php
// Validate and sanitize input
$name = trim($_POST['name']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$location = trim($_POST['location']);
$message = trim($_POST['message']);

if (empty($name) || empty($email) || empty($location) || empty($message)) {
  http_response_code(400);
  echo "Error: All fields are required.";
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo "Error: Invalid email format.";
  exit;
}

// Compose email message
$to = "feedback@boraksolutions.com";
$subject = "Contact form submission from $name";
$headers = array(
  "From: $name <$email>",
  "Reply-To: $name <$email>",
  "Return-Path: $email",
  "X-Mailer: PHP/" . phpversion(),
  "Content-Type: text/plain; charset=utf-8"
);
$message_body = "Name: $name\n";
$message_body .= "Email: $email\n";
$message_body .= "Location: $location\n";
$message_body .= "Message:\n$message\n";
$message_body .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
$message_body .= "User Agent: " . $_SERVER['HTTP_USER_AGENT'];

// Send email
if (mail($to, $subject, $message_body, implode("\r\n", $headers))) {
  http_response_code(200);
  echo "Message sent successfully.";
} else {
  http_response_code(500);
  echo "Error: Failed to send message.";
}
?>

