<?php


namespace App\Providers;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class AnimalProvider
{

    private $result;
    private $client;
    private $arrayImgUrl;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getGoogleRealURL($search_query)
    {
        $googleRealURL = "http://images.google.com/images?as_q=".urlencode($search_query)."&hl=com&imgtbs=z&btnG=Cerca+con+Google&as_epq=&as_oq=&as_eq=&imgtype=&imgsz=m&imgw=&imgh=&imgar=&as_filetype=&imgc=&as_sitesearch=&as_rights=&safe=images&as_st=y";
        return $googleRealURL;
    }

    public function getImagesCollectionForAnimal($search)
    {
        //$crawler = $this->client->request('GET', $this->getGoogleRealURL($search));
        //ddx($crawler);
        //ddx($web_page);
        $search_query = urlencode( $search );
        $ch = curl_init( $this->getGoogleRealURL($search_query));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux i686; rv:20.0) Gecko/20121230 Firefox/20.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $google = curl_exec($ch);
        $array_imghtml = explode("\"ou\":\"", $google); //the big url is inside JSON snippet "ou":"big url"

        $maxImg = 5;
        $counter = 0;
        foreach($array_imghtml as $key => $value){
            if ($counter <= $maxImg) {
                if ($key > 0) {
                    $array_imghtml_2 = explode("\",\"", $value);
                    $this->arrayImgUrl[] = $array_imghtml_2[0];
                }
            }
            else{
                break;
            }

            $counter++;
        }

        return $this->arrayImgUrl;
    }

    public function searchAnimalData()
    {
        $crawler = $this->client->request('GET', 'https://en.wikipedia.org/wiki/List_of_animal_names');
        $page = $crawler->filter('.wikitable')->last();


        $this->result = $page->filter('tr td:first-child a:first-child')
            ->each(function ($node, $order) {
                $latinName = $node->attr("title");
                $search =  $latinName; //change this

                $uri = $node->link()->getUri();

                if (strpos($uri, 'https://en.wikipedia.org/wiki/List') !== 0)
                {
                    //print $order .". " .  $uri->getUri()."<br>";
                    return [
                        "latinName" => $node->attr("title"),
                        "wikiUrl" => $uri,
                        "images" => $this->getImagesCollectionForAnimal($latinName)
                    ];

                }


            });
    }

    public function getAnimalData()
    {
        $this->searchAnimalData();
        return $this->result;
    }

    public function makeJson()
    {
        $json_data = json_encode($this->getAnimalData(), JSON_PRETTY_PRINT);
        file_put_contents(__DIR__ . '/animals.json', $json_data);
    }


}
