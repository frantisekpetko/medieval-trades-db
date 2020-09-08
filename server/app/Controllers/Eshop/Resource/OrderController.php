<?php


namespace App\Controllers\Eshop\Resource;


use App\Controllers\RestController;
use App\Controllers\Eshop\Mail\OrderMailController;

class OrderController extends RestController
{

    public function provideOrder()
    {


        $mailer = new OrderMailController();
        $mailer->sendOrder();


    }
    
}