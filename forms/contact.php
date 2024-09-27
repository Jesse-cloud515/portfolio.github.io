<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Replace contact@example.com with your real receiving email address
  $receiving_email_address = 'nasamujesse@gmail.com';

  // Check if the PHP Email Form library exists
  if( file_exists($php_email_form = '../vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  // Input validation
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize input
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Check if required fields are filled
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
      
      // Validate email
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $contact = new PHP_Email_Form;
        $contact->ajax = true;
        $contact->to = $receiving_email_address;
        $contact->from_name = $name;
        $contact->from_email = $email;
        $contact->subject = $subject;

        // Uncomment the below code if you want to use SMTP
        /*
        $contact->smtp = array(
          'host' => 'example.com',
          'username' => 'example',
          'password' => 'pass',
          'port' => '587'
        );
        */

        $contact->add_message( $name, 'From');
        $contact->add_message( $email, 'Email');
        $contact->add_message( $message, 'Message', 10);

        echo $contact->send();
      } else {
        echo 'Invalid email address';
      }
    } else {
      echo 'Please fill in all the required fields.';
    }
  } else {
    echo 'Invalid request method';
  }
?>
