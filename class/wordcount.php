<?php
class Wordcount {

 
    public $result=0,
           $_Database,
           $wordArray = array(); 

    public function __construct() {
           $this->_Database = Database::getInstance();
    }
    
    public function getUniqueWords( $fileName ) {

        if (get_http_response_code(__DIR__ . '/../assets/'.$fileName) == "200"){

            $text = trim( file_get_contents(__DIR__ . '/../assets/'.$fileName) );
            $this->wordArray = $array_unique( explode(" ", $text));
        }else{
               
            $this->wordArray = array();
        }
        return $this->wordArray ;
    }

    public function addToTable( $words, $fileName ) {

        $input = array("words"=> $words, "fileName" => $fileName);
    	if(!$this->_Database->insert('watchList', $input)) {
            throw new Exception('Sorry, Data could not be added to table.');
        }
        return true;
    }

    public function getList($fileName) {

    	 $this->_Database->get('watchList', array("fileName = '$fileName'"));
         $result = $this->_Database->results();
    	 $count = $this->_Database->count();
    	 return array("data" => $result, "count"=> $count);
    }

}