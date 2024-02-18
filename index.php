<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $name   = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $email  = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $phone  = filter_var($_POST['prenumber'].$_POST['number'],FILTER_SANITIZE_NUMBER_INT);
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
        if(empty($_POST['number'])){
            $formErrors[] = 'Phone number can\'t be empty';
        }
        if(!empty($_POST['number']) && strlen($_POST['number']) < 6){
            $formErrors[] = 'Type a valid phone number';
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
                $mail->Username   = 'mokeddemamine1707@gmail.com';               
                $mail->Password   = 'kswf yxvp evqh edth';                           
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
                                <p><b>Phone:</b> $phone</p>
                                <p><b>Content:</b></p>
                                <p style='margin-left:50px'>$msg</p>";

                $mail->send();
                $success = '<div class="alert alert-success p-1">Message send with success</div>';
                // clear the fields
                $name = '';
                $email = '';
                $msg = '';
                $_POST['number'] = '';
            
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
    <link rel="stylesheet" href="css/4.5.3_bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Contact form</title>
</head>
<body>
    <div class="container">
        <form action="<?= $_SERVER['PHP_SELF']?>" method="POST" class="contact-form px-3 needs-validation" novalidate>
            <h1 class="text-center text-capitalize my-5">contact us</h1>
            <div class="form-group mb-3">
                <input type="text" name="name" placeholder="Enter your name" id="" class="form-control" required pattern="[a-zA-Z ]{3,}" value="<?php if(!empty($formErrors)) echo $name; ?>"/>
                <i class="fa-solid fa-user"></i>
                <div class="valid-feedback">valid</div>
                <div class="invalid-feedback">Name must has 3 characters or more</div>
                <span class="asterisk">*</span>
            </div>
            <div class="form-group mb-3">
                <input type="email" name="email" placeholder="Enter a valid email" id="" class="form-control" required value="<?php if(!empty($formErrors)) echo $email; ?>"/>
                <i class="fa-solid fa-envelope"></i>
                <div class="valid-feedback">valid email</div>
                <div class="invalid-feedback">Email must be valid</div>
                <span class="asterisk">*</span>
            </div>
            <div class="form-group mb-3">
                <div class="input-group">
                    <div class="input-group-prepend phone-icon">
                        <select name="prenumber" id="" class="custom-select">
                            <option value="+213">Algeria +213</option>
                            <option value="+1">USA +1</option>
                        </select>
                    </div>
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="number" placeholder="Enter you phone number" id="" class="form-control" pattern="[0-9]{6,10}" value="<?php if(!empty($formErrors)) echo $_POST['number']; ?>"/>
                    <div class="invalid-feedback">Enter a valid number</div>
                </div>
            </div>
            <div class="form-group mb-3">
                <textarea name="message" placeholder="Enter your messade" class="form-control" id="contact-message"><?php if(!empty($formErrors)) echo $msg; ?></textarea>
                <div class="invalid-feed text-danger"></div>
                <span class="asterisk">*</span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info btn-block text-capitalize"><i class="fa-solid fa-paper-plane"></i> send message</button>
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
    <script src="js/popper.min.js"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>