<?php

require "./controllers/configFile.php";







class SPOJ
{
 
    private $content;
    public $from;
    public $to;
    private $lastOccurence = 0;
    private $result;

    public $resAr=[];

    public function __construct($from, $to){
        $this->from=$from;
        $this->to=$to;


    }
    private function readData()
    {
        $this->content = file_get_contents($this->createUrl($this->from,$this->to));

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

    

    public function getData()
    {
       $timeArr=[];
        for ($i = 0; $i < 3; $i++) {
            $this->readData();
            array_push($timeArr, $this->result);
        }
       $resAr['times']=$this->createWindow($timeArr);
       $resAr['timeout']=$this->timeWindow($timeArr[0]);
       $this->sendJSON($resAr);

       
    }

    private function createWindow($times):string{
            $elements="<h3>".$this->from."-".$this->to."</h3>";
            foreach($times as $key=>$val){
                $k=$key+1;
                $elements.="<p>".$k.". spoj jede v ".$val.".</p>";
            }
            return $elements;
    }


    private function createUrl($from, $to):string{
        $from = ucfirst(str_replace(" ", "%20", trim($from)));
        $to = ucfirst(str_replace(" ", "%20", trim($to)));

        return "https://idos.idnes.cz/vlakyautobusymhdvse/spojeni/vysledky/?f=" . $from . "&fc=301003&t=" . $to . "&tc=301003";
    }

    private function timeWindow($target){
        $wind=explode(":",$target);
        $reserve=mktime($wind[0],$wind[1],0,date('m'),date('d'),date('Y'))-time();
        return $reserve;
    }


    private function sendJSON($data){
        $res = json_encode($data);
        header('Content-Type: application/json;charset=utf-8');
        echo $res;
    }

}