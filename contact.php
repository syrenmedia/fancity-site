<?php

// Update this to your desired email address.
$recipient = "fancity@syrenmedia.com";

// Set the email subject.
$subject = "New FanCity Contact";

if($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = strip_tags(trim($_POST["name"]));
  $name = str_replace(array("\r", "\n"), array(" ", " "), $name);
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $message = trim($_POST["message"]);

  if(empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {

    header("HTTP/1.1 400 Bad Request");
    echo "Oops! There was a problem with your submission. Please complete the form and try again.";
    exit;

  }

  $email_headers = "From: $name <$email>";

  $email_content = "Name: $name\n";
  $email_content .= "Email: $email\n\n";
  $email_content .= "Message:\n$message\n";

  if(mail($recipient, $subject, $email_content, $email_headers)) {

    header("HTTP/1.1 200 OK");
    echo "Thank You! Your message has been sent.";

  } else {

    header("HTTP/1.0 500 Internal Server Error");
    echo "Oops! Something went wrong and we couldn't send your message.";

  }

} else {

  header("HTTP/1.1 403 Forbidden");
  echo "There was a problem with your submission, please try again.";

}

