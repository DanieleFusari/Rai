<?php

require_once "../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

$secretkey = getenv("secret_key");
$response = $_POST["g-recaptcha-response"];
$confirm = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$response");
$confirm = json_decode($confirm);

if($confirm->success == true && $confirm->score > .6) {
  $filter = [
    "name"=> FILTER_SANITIZE_STRING,
    "code"=> FILTER_SANITIZE_STRING,
    "phone"=> FILTER_SANITIZE_NUMBER_INT,
    "email"=> FILTER_SANITIZE_EMAIL,
    "information"=> FILTER_SANITIZE_STRING,
  ];

  $email_details = filter_input_array(INPUT_POST, $filter);

  $message = "
  <pre>
  <style>
  * {
    font-size: 18px;
    color: dodgerblue;
  }
  </style>
  Name: " . $email_details["name"]
  . "Phone Number " . $email_details["phone"]
  . "Code: " .$email_details["code"]
  . "Message: " . $email_details["information"]
  . "</pre>";

  // Create the Transport
  $transport = (new Swift_SmtpTransport("smtp.gmail.com", 587, "tls"))
    ->setUsername(getenv("emailfr"))
    ->setPassword(getenv("password"));

  // Create the Mailer using your created Transport
  $mailer = new Swift_Mailer($transport);

  // Create a message
  $message = (new Swift_Message("Question From " . $email_details["name"]))
    ->setContentType("text/html")
    ->setFrom(getenv("emailfr"))
    ->setTo(getenv("emailto"))
    ->setReplyTo($email_details["email"], $email_details["name"])
    ->setBody($message);

  // Send the message
  try {
      $result = $mailer->send($message);
  } catch (\Exception $e) {
      echo $e;
      exit;
  }

  if ($result) {
    header("Location: ../contact.php?mail=ok");
  } else {
    header("Location: ../contact.php?mail=failed");
  }
} else {
  header("Location: ../contact.php?mail=failed");
}
