
<?php
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$message = $_POST["message"];

$sendToAddress = "levi.spam3@outlook.com";
$sendFromAddress = "NursingNucleus@greenriverdev.com";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: $sendFromAddress" . "\r\n";

$subject = "Nursing Nucleus Contact Page";

$contactPage = "<ul>
                  <il>Name: $name </il><br>
                  <il>Email: $email </il><br>
                  <il>Phone: $phone </il><br>
                  <il>Message:$message</il>
                   </ul>";

if ($phone == ""){

    $contactPage = "<ul>
                  <il>Name: $name </il><br>
                  <il>Email: $email </il><br>
                  <il>Message:$message</il>
                   </ul>";
} else {
    $contactPage = "<ul>
                  <il>Name: $name </il><br>
                  <il>Email: $email </il><br>
                  <il>Phone: $phone </il><br>
                  <il>Message:$message</il>
                   </ul>";
}

mail($sendToAddress,$subject,$contactPage,$headers);

echo" Your message was received";
