<?php

namespace App\Providers;

use App\Database\Database;
use App\Entities\MedievalTrade;
use SimpleXLSX;
//new Database();


class MedievalTradeProvider {
    private $trade;
    private $tradeDesc;
    private $tradeUrl;
    private $json;


    public function __construct(){
        $this->trade = [];
        $this->tradeDesc = [];
        $this->tradeUrl = [];
        $this->json = [];
    }

    public function loadDataFromExcel()
    {

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

                        array_push($this->tradeUrl, $input);
                        array_push($this->tradeDesc, $array[$tradeIndex + 1][0]);
                        array_push($this->trade, $array[$tradeIndex][0]);
                        $tradeIndex= $tradeIndex + 2;
                    }
                    else {
                        $input = unaccent($array[$tradeIndex][0]);
            
                        array_push($this->tradeUrl, $input);
                        array_push($this->tradeDesc, $array[$tradeIndex + 1][0]);
                        array_push($this->trade, $array[$tradeIndex][0]);
                        $mustBreaks = true;
                    }
                }
                if($mustBreaks === true) {
                    break;
                }
                    
        }

        //ddx($tradeUrl);
    } 
    else 
    { 
        echo SimpleXLSX::parseError();
    }

    }


    public function FillDatabaseWithData(Type $var = null)
    {
        foreach($this->trade as $key => $value) {
            $medievalTrade = new MedievalTrade();
            $medievalTrade->name = $value;
            $medievalTrade->description = $this->tradeDesc[$key];
            $medievalTrade->url = $this->tradeUrl[$key];
            $medievalTrade->imageUrl = null;
            $medievalTrade->save();
        }
    }

    public function serializeDataToJson(Type $var = null)
    {
        $this->loadDataFromExcel();

        foreach($this->trade as $key => $value) {
            $this->json[$key]["name"] = $value;
            $this->json[$key]["tradeDesc"] = $this->tradeDesc[$key];
            $this->json[$key]["tradeUrl"] = $this->tradeUrl[$key];
            $this->json[$key]["imageUrl"] = null;
        }

        $json_data = json_encode($this->json, JSON_PRETTY_PRINT);
        file_put_contents(__DIR__ . '/medievalTrades.json', $json_data);
    }
}

