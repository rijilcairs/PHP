<?php

require_once 'core/initialize.php';
  
$wordcount = new Wordcount();

/* get the array of unique words extract from text in the file */
$getUniqueWords  = $wordcount->getUniqueWords(Config::get('file/smallFiles'));

/* add unique words to the database */
if ($addToTable = $wordcount->addToTable( $getUniqueWords, Config::get('file/smallFiles') )){
	echo "Words from ".Config::get('file/smallFiles')." added to table watchList";

}

/**here is the list **/
$getList = $wordcount->getList(Config::get('file/smallFiles'));
if (is_array($getList) && !empty($getList)) {
    echo "Distinct unique words :".$getList['count']."\n";
    echo "watchList words:\n"
    foreach($getList["data"] as $data)  {

    	echo $data->words."\n";
    }

}

 
?>