<?php


namespace App\Controllers\Eshop\Auth;


use App\Controllers\RestController;
use App\Entities\Admin;
use App\Services\SecurityService;
use App\Controllers\Eshop\Mail\BaseMailController;

class AdminController extends RestController
{

    public function login( $email = null, $password = null)
    {

        try{
            if($email === null && $password === null){
                $email =  parent::getJSON()->email;
                $password =  parent::getJSON()->password;
            }

            $auth = Admin::where('email', $email)->first();


            if ($auth !== null) {
                if (SecurityService::verify( $password , $auth->password)){
                    $this->sendSuccessLoginResponse($auth);
                }
                else{
                    $this->sendFailedLoginResponse();
                }
            }
            else {
                $this->sendFailedLoginResponse();
            }


        }
        catch (\Exception $e){
            $this->sendFailedLoginResponse($e);
        }


    }

    public function sendSuccessLoginResponse($auth){
        session_start();
        $_SESSION["role"] = "admin";
        //return  $this->sendData([], 200);
        //echo $_SESSION['adminsrc'];
    }

    public function sendFailedLoginResponse($e = "Error is occured.")
    {
        parent::sendJSON(["err" => $e], 500);
    }


    public function register()
    {
        $admin = new Admin();
        $admin->name =  parent::getJSON()->name;
        $admin->email =  parent::getJSON()->email;
        $admin->password = SecurityService::encryptToArgon(parent::getJSON()->password);
        $admin->url_hash = SecurityService::encryptToArgon(parent::getJSON()->email) ;
        $admin->auth_status =  parent::getJSON()->auth_status;
        $admin->banned_at =  "";
        $admin->save();

        $mailer = new BaseMailController();
        $mailer->send();


        parent::sendJSON(["individual" => [
            "admin" => $admin
        ]], 201);
        //return $this->login(  parent::getJSON()->name,  parent::getJSON()->password);
    }

    public function logout()
    {
        session_start();
        session_destroy();
    }

    public function auth()
    {
        session_start();
        if (!empty($_SESSION['role']))
        {
            $role = $_SESSION["role"];
            return parent::sendJSON(["auth" => $role], 200);
        }

        return parent::sendJSON(["auth" => null], 403);

    }

}