<?php


namespace App\Controllers\Eshop\Mail;

use App\Services\SecurityService;
use PHPMailer\PHPMailer\PHPMailer;
use App\Controllers\RestApi;

class BaseMailController
{
    use RestApi;
    private $name;
    private $email;
    private $password;
    private $url;
    private $subject;
    private $fromName;

    /**
     * @return mixed
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param mixed $fromName
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
    }
    public function __construct()
    {
        $this->setFromName("E-shop Sweetheart Support - No Reply");
        $this->setSubject("E-shop Sweetheart Support - No Reply");

    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
/*
    public function mail(){



        $to = "frantisek.petko7@seznam.cz";
        $subject = "HTML email";

        $message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
        $headers .= 'From: <webmaster@example.com>' . "\r\n";
        $headers .= 'Cc: myboss@example.com' . "\r\n";

        mail($to,$subject,$message,$headers);
    }


    public function mailFromGithub(){
        ini_set("SMTP","smtp.gmail.com");

// Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
        ini_set("smtp_port","8889");


        $mail = new PHPMailer;
//Tell PHPMailer to use SMTP
        $mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
        $mail->SMTPDebug = 2;
//Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
        $mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = getenv("MAIL_USERNAME");
//Password to use for SMTP authentication
        $mail->Password = getenv("MAIL_PASSWORD");
//Set who the message is to be sent from
        $mail->setFrom(getenv("MAIL_USERNAME"), 'First Last');
//Set an alternative reply-to address
        $mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
        $mail->addAddress("oristgrey@gmail.com", 'John Doe');
//Set the subject line
        $mail->Subject = 'PHPMailer GMail SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->msgHTML("<h1>wdaawdawd</h1>", __DIR__);

        //file_get_contents(__DIR__¨. 'contents.html');
//Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';
//Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . ddx($mail->ErrorInfo);
        } else {
            echo "Message sent!";
            ddx($mail->ErrorInfo);
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            #if (save_mail($mail)) {
            #    echo "Message saved!";
            #}
        }
    }
*/
    /**
     * Build the message.
     *
     * @return $this
     */
    public function send()
    {
        try {
            $this->setName($this->getJSON()->name);
            $this->setEmail($this->getJSON()->email);
            $this->setUrl(
                sprintf("%s/admin/%s",
                    getenv("APP_URL"),
                    SecurityService::encryptToArgon($this->getEmail())
                )
            );
            $this->setPassword($this->getJSON()->password);

            $mail = new PHPMailer();
            $mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
            $mail->Host = 'smtp.gmail.com';  // zadáme adresu SMTP serveru
            $mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = getenv("MAIL_ENCRYPTION'"); // secure transfer enabled REQUIRED for Gmail
            $mail->SMTPAuth = true;               // nastavíme true v případě, že server vyžaduje SMTP autentizaci
            $mail->Username = getenv("MAIL_USERNAME");  // uživatelské jméno pro SMTP autentizaci
            $mail->Password = getenv("MAIL_PASSWORD");            // heslo pro SMTP autentizaci
            $mail->From = getenv("MAIL_FROM_ADDRESS");   // adresa odesílatele skriptu
            $mail->FromName = $this->getFromName(); // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
            $mail->Port =  getenv("MAIL_PORT"); // or 587

            $mail->AddAddress(getenv("MAIL_TO"));  // přidáme příjemce
            //$mail->AddAddress("frantisek.petko7@seznam.cz ", "Jméno druhého příjemce");  // a klidně i druhého, včetně jména
            $mail->AddAddress($this->getJSON()->email);  // přidáme příjemce


            $mail->Subject = $this->getSubject();    // nastavíme předmět e-mailu

            $template = file_get_contents(__DIR__ . "/../../../../templates/emails/AdminRegistration.html");
            //$mail->Body = "Ahoj ahoj!\n\n Posílám ti první svůj první e-mail přes PHPMailer.";  // nastavíme tělo e-mailu
            $template = str_replace('%name%', $this->name, $template);
            $template = str_replace('%email%', $this->email, $template);
            $template = str_replace('%password%', $this->password, $template);
            $template = str_replace('%url%', $this->url, $template);
            $mail->AddEmbeddedImage( __DIR__ .  '/../../../../templates/emails/logo.png', 'logo_sh2u');

            $mail->msgHTML($template);
            $mail->WordWrap = 50;   // je vhodné taky nastavit zalomení (po 50 znacích)
            $mail->CharSet = "utf-8";   // nastavíme kódování, ve kterém odesíláme e-mail

            if(!$mail->Send()) {  // odešleme e-mail
                $this->sendJSON(["message" => 'Došlo k chybě při odeslání e-mailu.\nChybová hláška: ' . $mail->ErrorInfo]);
            }
            else
            {
                $this->sendJSON(["message" => 'E-mail byl v pořádku odeslán.']);
            }
        }catch (\Exception $e) {
            ddx("E=> " . $mail->ErrorInfo);
        }
    }
}