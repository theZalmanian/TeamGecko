<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Submission</title>
    <link rel="icon" type="image/x-icon" href="/nursing-images/nursing-logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/nursing-sprint-2.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-4">
            </div>
            <div class="col-12 col-md-8 col-lg-4">
                <div class="my-3">
                    <?php
                        // setup variables to hold Contact form inputs
                        $name = $_POST["name"];
                        $email = $_POST["email"];
                        $phone = $_POST["phone"];
                        $message = $_POST["message"];

                        // check that all required inputs were submitted on the Contact form
                        if( isset($name) && isset($email) && isset($message) ) {
                            // setup sending and receiving addresses
                            $sendToAddress = "";
                            $sendFromAddress = "NursingNucleus@greenriverdev.com";

                            // setup headers for html email
                            $headers = "MIME-Version: 1.0" . "\r\n";
                            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                            $headers .= "From: $sendFromAddress" . "\r\n";

                            $subject = "Nursing Nucleus Contact Page";

                            // attempt to send email with given data
                            $messageSent = mail($sendToAddress, $subject, setupEmailContent(), $headers);

                            // if the message was sent, display success 
                            if($messageSent) {
                                echo displayCardWithContent("<h4>Your message was sent successfully!</h4>");
                            }

                            // if message was not sent, display error
                            else {
                                echo displayError("Your message could not be sent at this time. Try again later.");
                            }
                        }
                        
                        // otherwise display error and link to contact form
                        else {
                            echo displayError("No submission received from Contact Form.");
                            
                            echo displayCardWithContent("<h4>
                                                            Please fill out the form and try again:
                                                        </h4>
                                                        <a class='btn btn-success py-2 m-2' href='/sprint-2/contact.html'>
                                                            Contact
                                                        </a>");
                        }
                    ?>
                </div>
            </div>
            <div class="col-md-2 col-lg-4">
            </div>
        </div>
    </div>
</body>
</html>

<?php
    /**
     * Generates and returns HTML content for the email message based on contact form data
     * @return string HTML content for the email message
     */
    function setupEmailContent() {
        // retrieve form variables from global scope
        global $name, $email, $phone, $message;

        // setup most of email content
        $emailContent = "<html lang='en'>
                        <head>
                            <title>Nursing Nucleus Contact Page</title>
                            <style>
                                ul {
                                    list-style-type: none;
                                }
                            </style>
                        </head>
                        <body>
                        <ul>
                            <li>Name: $name</li>
                            <li>Email: $email</li>";

        // only add the phone number to the message if it was provided
        if ( !empty($phone) ) {
            $emailContent .= "<li>Phone: $phone </li>";
        } 

        // Add the message to the end of email content
        $emailContent .= "<li>Message: $message</li>
                        </ul>
                        </body>
                        </html";

        // Return the generated email content
        return $emailContent;
    }

    /**
     * Returns a Bootstrap card containing the given error message
     * @param string $errorMessage The error message being displayed in the Bootstrap card
     * @return string a Bootstrap card containing the given error message
     */
    function displayError($errorMessage) {
        // setup error content
        $errorContent = "<h4>
                            Error: {$errorMessage}
                        </h4>";

        return displayCardWithContent($errorContent);
    }

    /**
     * Returns a Bootstrap card containing the given HTML content
     * @param string $content The HTML element(s) being displayed in the Bootstrap card
     * @return string a Bootstrap card containing the given HTML content
     */
    function displayCardWithContent($content) {
        return "<div class='card p-3 my-1 text-center'>{$content}</div>";
    }
?>