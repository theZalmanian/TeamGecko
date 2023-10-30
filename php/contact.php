<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Submission</title>
    <link rel="icon" type="image/x-icon" href="/nursing-images/nursing-logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/nursing.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3">
            </div>
            <div class="col-12 col-md-8 col-lg-6">
                <div class="my-3">
                <?php
                    $name = $_POST["name"];
                    $email = $_POST["email"];
                    $phone = $_POST["phone"];
                    $message = $_POST["message"];

                    $sendToAddress = "";
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

                    echo "<div class='card p-3 my-1 text-center'>
                            <h4>
                                Error: No submission received from Contact Form.
                            </h4>
                        </div>";

                    echo "<div class='card p-3 my-1 text-center'>
                            <p class='h4'>
                                Please fill out the form and try again:
                            </p>
                            <a class='btn btn-success py-2 m-2' href='/sprint-2/contact.html'>
                                Contact
                            </a>
                        </div>";
                ?>
                </div>
            </div>
            <div class="col-md-2 col-lg-3">
            </div>
        </div>
    </div>
</body>
</html>