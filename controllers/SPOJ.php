<?php

require "configFile.php";








class SPOJ
{   public static $idSpoje=0;
    private $url = "";
    private $content = "";
    private $lastOccurence = 0;
    private $result;
    public $resultArr = [];
    public $timeStamp;
    function __construct($adresa)
    {
        SPOJ::$idSpoje++;
        //ziskani url daneho spoje
        $this->url = $adresa;
        $this->content = file_get_contents($this->url);
    }

    private function readData()
    {

        //cas se vypisuje hned po <p> proto zjistime delku target class a pricteme ho k jejimu indexu  ve stringu stranky

        $index = strpos($this->content, TARGET,$this->lastOccurence) + TARGETLENGTH ;
        // ciselny format ma 5 mist muzeme tedy vytvorit substring  pomoci i
        $this->result = substr($this->content, $index, 5);
        if($this->result[4]=='<'){
            $this->result=str_replace('<','',$this->result);
        }
        $this->lastOccurence = $index;
    }

    private function time(){
        $this->result==new \DateTime($this->result, new \DateTimeZone("UTC"));
        $this->timeStamp=$this->result* 1000;
    }

    public function getData()
    { 
        for ($i = 0; $i < 3; $i++) {
            if ($this->readData())
                echo "Něco se pokazilo, žádná hodnota nebyla nalezena";
            array_push($this->resultArr,$this->result);
        }
        $jsonTimeSched=json_encode($this->resultArr);
        header('Content-Type: application/json');
        echo $jsonTimeSched;


            

    }

    public function createWindow(){
        
        echo "<div class='departure' id='departure' ";
        echo "<h3 contenteditable='true'maxlength=20>poznámka ke spoji</h3>";
        echo '<div class="url" id="'.SPOJ::$idSpoje.'" value="'.$this->url.'" ></div>';
        echo "<div id='departurebody' ></div>";
        echo "</div>";
    }

}
