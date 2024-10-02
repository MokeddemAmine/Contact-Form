<?php
    error_reporting(0);
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $name   = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $email  = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $subject  = filter_var($_POST['subject'],FILTER_SANITIZE_STRING);
        $msg    = filter_var($_POST['message'],FILTER_SANITIZE_STRING);

        $formErrors = array();
        if(empty($name)){
            $formErrors[] = 'Name can\'t be empty';
        }
        if(!empty($name) && strlen($name) < 3){
            $formErrors[] = 'Type a valid name';
        }
        if(empty($email)){
            $formErrors[] = 'email can\'t be empty';
        }
        if(empty($_POST['subject'])){
            $formErrors[] = 'Subject can\'t be empty';
        }
        if(empty($msg)){
            $formErrors[] = 'Message can\'t be empty';
        }
        if(!empty($msg) && strlen($msg) < 10){
            $formErrors[] = 'Massage can\'t be than 10 caracters';
        }

        if(empty($formErrors)){
            $mail = new PHPMailer();

            try {
                
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                   
                $mail->isSMTP();                                        
                $mail->Host       = 'smtp.gmail.com';                   
                $mail->SMTPAuth   = true;                              
                $mail->Username   = 'your email';               
                $mail->Password   = 'your apps password in your gamil';                           
                $mail->SMTPSecure = 'ssl'; 
                $mail->Port       = 465;                                  

                //Recipients
                $mail->setFrom($email,$name);
                $mail->addAddress('mokeddemamine1707@gmail.com'); 

                //Content
                $mail->isHTML(true);   
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Contact Form';
                $mail->Body    = "<p><b>From:</b> <b>$name</b></p>
                                <p><b>Email:</b> $email</p>
                                <p><b>Subject:</b> $subject</p>
                                <p><b>Message:</b></p>
                                <p style='margin-left:50px'>$msg</p>";

                $mail->send();
                $success = '<div class="alert alert-success p-1">Message send with success</div>';
                // clear the fields
                $name = '';
                $email = '';
                $msg = '';
                $subject = '';
            
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Contact form</title>
</head>
<body>
    <div class="container">
        <form action="<?= $_SERVER['PHP_SELF']?>" method="POST" class="contact-form needs-validation bg-white d-block  p-5 mt-3 rounded border-white" novalidate>
            <h1 class="text-center text-capitalize my-5 fs-4 fw-bold">contact us</h1>
            <div class="form-group mb-4">
                <label for="name" class="text-capitalize">name:</label>
                <input type="text" name="name" placeholder="Enter name" id="name" class="form-control border-0 bg-light"  required pattern="[a-zA-Z ]{3,}" value="<?php if(!empty($formErrors)) echo $name; ?>"/>
                <div class="valid-feedback">valid name</div>
                <div class="invalid-feedback">Name must has 3 characters or more</div>
            </div>
            <div class="form-group mb-4">
                <label for="email" class="text-capitalize">email:</label>
                <input type="email" name="email" placeholder="Enter a valid email" id="email" class="form-control border-0 bg-light" required value="<?php if(!empty($formErrors)) echo $email; ?>"/>
                <div class="valid-feedback">valid email</div>
                <div class="invalid-feedback">Email must be valid</div>
            </div>
            <div class="form-group mb-4">
                <label for="subject" class="text-capitalize">subject</label>
                <input type="text" name="subject" placeholder="Enter a valid email" id="subject" class="form-control border-0 bg-light" required value="<?php if(!empty($formErrors)) echo $email; ?>"/>
                <div class="valid-feedback">valid subject</div>
                <div class="invalid-feedback">subject must be valid</div>
            </div>
            <div class="form-group mb-3">
                <label for="message" class="text-capitalize">message</label>
                <textarea name="message" placeholder="Enter your messade" class="form-control border-0 bg-light" id="message"><?php if(!empty($formErrors)) echo $msg; ?></textarea>
                <div class="invalid-feed text-danger"></div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn text-capitalize text-white" style="background: -webkit-radial-gradient(0 50%, circle, #6b69cd, #9a69bb);"><i class="fa-solid fa-paper-plane"></i> send message</button>
            </div>
            <div class="show-errors text-center">
            <?php
                if(isset($formErrors)){
                    if(!empty($formErrors)){
                        foreach($formErrors as $error){
                            echo '<div class="alert alert-danger alert-dismissible py-1"><button class="close p-1" data-dismiss="alert">&times;</button>'.$error.'</div>';
                        }
                    }
                }
                if(isset($success)){
                    echo $success;
                }
            ?>
            </div>
        </form>
    </div>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>
