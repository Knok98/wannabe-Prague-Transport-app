<?php

require "configFile.php";







class SPOJ
{
    private static $idSpojeCounter;
    public $IdSpoje;
    private $newDiv = false;
    private $url = "";
    private $content = "";
    private $lastOccurence = 0;
    private $result;
    public $resultArr = [];
    public $timeStamp;

    private $info;
    function __construct($adresa, $info, $idSpoje = 0)
    {
        if ($idSpoje == 0) {
            $_SESSION["ticket"]++;
            $this->IdSpoje = $_SESSION["ticket"];
            $this->newDiv = true;
            $this->info = $info;
        } else {
            $this->IdSpoje = $idSpoje;
        }

        //ziskani url daneho spoje
        $this->url = $adresa;
        $this->content = file_get_contents($this->url);
    }

    private function readData()
    {

        //cas se vypisuje hned po <p> proto zjistime delku target class a pricteme ho k jejimu indexu  ve stringu stranky

        $index = strpos($this->content, TARGET, $this->lastOccurence) + TARGETLENGTH;
        // ciselny format ma 5 mist muzeme tedy vytvorit substring  pomoci i
        $this->result = substr($this->content, $index, 5);
        if ($this->result[4] == '<') {
            $this->result = str_replace('<', '', $this->result);
            $this->result = "0" . $this->result;
        }
        $this->lastOccurence = $index;
    }

    private function time()
    {
        $this->result == new \DateTime($this->result, new \DateTimeZone("UTC"));
        $this->timeStamp = $this->result * 1000;
    }

    public function getData()
    {
        if ($this->newDiv) {
            array_push($this->resultArr, $this->createWindow());
        } else {
            array_push($this->resultArr, 0);
        }
        array_push($this->resultArr, $this->IdSpoje);

        for ($i = 0; $i < 3; $i++) {
            $this->readData();
            array_push($this->resultArr, $this->result);
        }
        $jsonTimeSched = json_encode($this->resultArr);
        header('Content-Type: application/json;charset=utf-8');
        echo $jsonTimeSched;
    }

    private function createWindow()
   
    {
        $station=explode(",",$this->info);
        $arr = [
            "<div class='departure' id='departure' ",
            "<h3 contenteditable='true'maxlength=20>".$station[0]."-".$station[1]."</h3>",
            '<div class="departurebody" id="' . $this->IdSpoje . '" value="' . $this->info . '" ></div>'
        ];
        return $arr;
    }
}
