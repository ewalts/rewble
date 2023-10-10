<?php
$__dir__=getcwd();
/*
require_once $__dir__ . '/inc/class_rewble.php';
require_once $__dir__ . '/inc/vars.php';
$d = new yaml_play();  ###> Create new rewbin play object.

$col=$d -> __curl_collection_index($collection_index_url);
echo $d -> __format_index_list($col);
//print_r($col);



function _require_collection_(){
                if(!$this->collection){
                        $kill;
                }
    }
*/
function _string_or_int_($value){
        try
   {
                 (10 * $value);
                echo "trying a=$a \n";

        } catch (Exception $e)   {
                echo "exception caught $e->getMessage()\n";
                
        } 
	echo "This is final\n";
	
}


_string_or_int_($argv[1]);



?>
