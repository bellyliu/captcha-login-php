<html>
<head>
<title>Contact Form</title>
<link rel="stylesheet" href="style.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<div class="contact-form">
<h2>CONTACT US</h2>
<form method="post" action="">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="text" name="phone" placeholder="Phone No" required>
    <input type="email" name="email" placeholder="Your Email" required>
    <textarea name="message" placeholder="Your Message" required></textarea>

    <div class="g-recaptcha" data-sitekey="6LfuWLEUAAAAANWNKdH0nA7NOiG0h-eItyb8fwRl"></div>

    <input type="submit" name="submit" value="Send Message" class="submit-btn">
</form>

<div class="status">
<?php 

if(isset($_POST['submit'])){
    $User_name = $_POST['name'];
    $phone = $_POST['phone'];
    $user_email = $_POST['email'];
    $user_message = $_POST['message'];

    $email_from = "dekribellyliu@navitaorigo.co.id";
    $email_subject = "New Form Submission";
    $email_body = "Name: $User_name.\n".
                  "Phone Number: $phone.\n". 
                  "Email Address: $user_email.\n".
                  "User Message: $user_message.\n";
    
    $to_email = "dekribellyliu@navitaorigo.co.id";
    $headers = "From: $email_from \r\n";
    $headers .= "Reply-To: $user_email\r\n";

    $secretKey = "6LfuWLEUAAAAAHUnA4ygT8d7wnAEBGSKb7eRCFQA";
    $responseKey = $_POST['g-recaptcha-response'];
    $UserIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?
    secret=$secretKey&response=$responseKey&remoteip=$UserIP";

    $response = file_get_contents($url);
    $response = json_decode($response);

    if ($response->success) //in dev env the response always fail, due to the google recaptcha need to send verification result to the $UserIP . In dev env, the user ip cant be reach by google.
    {                       // Response will be success in production env
        mail($to_email,$email_subject,$email_body,$headers);
        echo "Message Sent Successfully";
    } else {
        mail($user_email,$email_subject,$email_body,$headers);
        echo "<span>Invalid captcha, Please try again!</span>";
    }

}

?>


</div>

</body>
</html>