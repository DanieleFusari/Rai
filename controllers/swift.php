<?php

require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$filter = [
  'name'=> FILTER_SANITIZE_STRING,
  'phone'=> FILTER_SANITIZE_NUMBER_INT,
  'email'=> FILTER_SANITIZE_EMAIL,
  'information'=> FILTER_SANITIZE_STRING,
];

$email_details = filter_input_array(INPUT_POST, $filter);

$message = 'Phone Number ' . $email_details['phone'] . "</br>" . 'Message: ' . $email_details['information'];


// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
  ->setUsername(getenv('email'))
  ->setPassword(getenv('password'));

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message("Raistudios Question From" . $email_details['name']))
  ->setFrom(getenv('email'))
  ->setTo([getenv('email') => $email_details['name']])
  ->setBcc([getenv('emaildd') => $email_details['name']])
  ->setBcc([getenv('emailrr') => $email_details['name']])
  ->setReplyTo($email_details['email'], $email_details['name'])
  ->setBody($message);

// Send the message
$result = $mailer->send($message);

if ($result) {
  header('Location: ../contact.php?mail=ok');
} else {
  header('Location: ../contact.php?mail=failed');
}
