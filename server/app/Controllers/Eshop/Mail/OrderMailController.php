<?php


namespace App\Controllers\Eshop\Mail;

use App\Controllers\RestController;
use PHPMailer\PHPMailer\PHPMailer;

class OrderMailController extends RestController
{

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
        $this->setSubject("Objednávka");

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

    /**
     * Build the message.
     *
     * @param \stdClass $data
     * @return void
     */
    public function sendOrder()
    {
        $name = parent::getJSON()->name;
        $surname = parent::getJSON()->surname;
        $email = parent::getJSON()->email;
        $telephone = parent::getJSON()->telephone;
        $postalCode = parent::getJSON()->postalCode;
        $city = parent::getJSON()->city;
        $address = parent::getJSON()->address;
        $totalPrice =  parent::getJSON()->totalPrice;
        $products[] =   parent::getJSON()->products;

        $mail = new PHPMailer();
        try {

            $mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
            $mail->Host = 'smtp.gmail.com';  // zadáme adresu SMTP serveru
            $mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = getenv("MAIL_ENCRYPTION'"); // secure transfer enabled REQUIRED for Gmail
            $mail->SMTPAuth = true;               // nastavíme true v případě, že server vyžaduje SMTP autentizaci
            $mail->Username = getenv("MAIL_USERNAME");  // uživatelské jméno pro SMTP autentizaci
            $mail->Password = getenv("MAIL_PASSWORD");            // heslo pro SMTP autentizaci
            $mail->From = getenv("MAIL_FROM_ADDRESS");   // adresa odesílatele skriptu
            $mail->FromName = $name; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
            $mail->Port =  getenv("MAIL_PORT"); // or 587

            $mail->AddAddress(getenv("MAIL_TO"));  // přidáme příjemce
            //$mail->AddAddress("frantisek.petko7@seznam.cz ", "Jméno druhého příjemce");  // a klidně i druhého, včetně jména
            $mail->AddAddress($email);  // přidáme příjemce

            $productHTML = "</hr>";
            /*
            foreach ($products as $key => $value) {
                $productHTML .= "<div>$key</div>";
                $productHTML .= "<div>$value</div>";
                $productHTML .= "</hr>";
            }
            */
            $mail->Subject = $this->getSubject();    // nastavíme předmět e-mailu

            $template = file_get_contents(__DIR__ . "/../../../../templates/emails/Order.html");
            //$mail->Body = "Ahoj ahoj!\n\n Posílám ti první svůj první e-mail přes PHPMailer.";  // nastavíme tělo e-mailu
            $template = str_replace('%name%', $name, $template);
            $template = str_replace('%email%', $email, $template);
            $template = str_replace('%surname%', $surname, $template);
            $template = str_replace('%totalPrice%', $totalPrice, $template);
            $template = str_replace('%products%', $productHTML, $template);
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
            //ddx("E=> " . $mail->ErrorInfo);
        }
    }
}