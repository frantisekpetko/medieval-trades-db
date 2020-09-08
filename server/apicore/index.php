<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Services\DebugService;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
include "../app/Utils/utils.php";

use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');
Debug::enable();
ErrorHandler::register();
DebugService::register();
use App\Providers\AnimalProvider;

$provider = new AnimalProvider();
ddx($provider->getImagesCollectionForAnimal("Aardvark"));


/*
use App\Database\Database;
new Database();
use App\Entities\MedievalTrade;

use SimpleXLSX;

$trade= [];
$tradeDesc = [];
$tradeUrl = [];

if ( $xlsx = SimpleXLSX::parse('trades-to-db.xlsx') ) {
    //ddx($xlsx->rows() );
    $array = $xlsx->rows();
    $tradeIndex = 0;
   
    $mustBreaks = false;
    for($a = 1; $a < count($array); $a++) {

        if($a === 1) {
            $trade[$a - 1] = $array[$a - 1][0];

            $input = unaccent( $array[$a - 1][0]);
            $tradeUrl[$a - 1] = $input;

            $tradeDesc[$a - 1] = $array[$a][0];
            $tradeIndex= $tradeIndex + 2;
        }
        else{
                if(count($array) !== $tradeIndex + 2) {
                    //echo "true<br>{$tradeIndex}";
                    $input = unaccent( $array[$tradeIndex][0]);

                    array_push($tradeUrl, $input);
                    array_push($tradeDesc, $array[$tradeIndex + 1][0]);
                    array_push($trade, $array[$tradeIndex][0]);
                    $tradeIndex= $tradeIndex + 2;
                }
                else {
                    $input = unaccent($array[$tradeIndex][0]);
        
                    array_push($tradeUrl, $input);
                    array_push($tradeDesc, $array[$tradeIndex + 1][0]);
                    array_push($trade, $array[$tradeIndex][0]);
                    $mustBreaks = true;
                }
            }
            if($mustBreaks === true) {
                break;
            }
                
    }

    //ddx($tradeUrl);
} else {
	echo SimpleXLSX::parseError();
}

foreach($trade as $key => $value) {
    $medievalTrade = new MedievalTrade();
    $medievalTrade->name = $value;
    $medievalTrade->description = $tradeDesc[$key];
    $medievalTrade->url = $tradeUrl[$key];
    $medievalTrade->imageUrl = null;
    $medievalTrade->save();
}
*/


//phpinfo();
/*
use \App\Controllers\Eshop\Mail\OrderMailController;

$data = [
    "name" => "dawdwa",
    "surname" => "huwadhu",
    "email" => "frantisek.petko7@seznam.cz",
    "telephone" => "wadnwdajnwad",
    "postalCode" => "udawhuadw",
    "city" => "hdwabhdwa",
    "address" => "udawjawdn",
    "totalPrice" => "uhadwuhwad",
    "products" => ["name" => "dwadwa", "price"=> "wdaijiwad"]
];


$mail = new OrderMailController();
$mail->sendOrder((object) $data);
*/
/*
use App\Database\DB;


DB::table("server_exceptions")->create([
    "type" => DebugService::ERRTYPE,
    "message" => "udawhdwa",
    "class" => "class",
    "current" => 5,
    "total" => 10,
])->createWithByOppositeForeignKey("unsafe_exception_id")->finish();
//$id = DB::table("client_errors")->getLatestID();
ddx(DB::schema()->getErrorMessage());
*/



