#!/usr/bin/php
<?PHP
#########################################################################################################
###> New x php -> rewble_create_play.php  -> Richard Eric Walts as eric ---> 2023-07-22_17:28:16 init <<<
#########################################################################################################
###>  Primary executing file
###>  Command example:	./rewble_create_play.php -h => Will list options
###>  		- 	./rewble_create_play.php -d -v    
###>  This script calls the main configuration file.  Other files are included there.

$__dir__ = getcwd(); 

require_once ($__dir__ . '/conf/main.php');  ###>  This file includes other files: [/inc/class_rewble.php, /inc/switch_argvars_proc.php].

###> If nothing has been provided. We will scrape the collection index page in docs.ansible.com.


if($_module){
	if($rewble->_verify_module_($_module)){
		$rewble->module=$_module;
		$rewble->list_collections=false;    //  	die("we aren't ready to get modules\n");
	}
}

if($rewble->list_collections){
	$rewble->_show_collection_index_();
	$cc=count($rewble->ansible_collections);
	echo "\n Ansible docs currently listing $cc collections.  All $cc collections will be numerically listed in a moment.\n\n";  ###> Print a message to terminal.
	sleep(3); 
	  									    ###>  Give someone a chance to see the message.
	echo " Choose the collection to list contents.\n";
	echo $rewble->print_collections;	
	echo "\n\n";     

	$user_collection_response= readline("Type the number of the collection you want to browse.[1-$cc]. Or [q] to quit: ");  ###> Request input from the user, the numerical key in the collections array.
	if(preg_match('/q/',$user_collection_response)) die("   Quit requested!\n");
//	$rewble->collection_number=$user_collection_response;  ###> test var until identify_collection data validation is functional


	if($rewble->_identify_collection_($user_collection_response)){    ###> input validation, correlate to the correct collection if possible 
		$rewble->collection_number=$user_collection_response;
	}else{
		$rewble->_show_collection_index_();   ###> or show the collection index listing 
	}		

	echo "\n\n";  	###> additional space
	$rewble->_message_handler_('I',"collection_href=[".$rewble->collection_links[$rewble->collection_number]['href']."]","DEBUG: collection_href=[".$rewble->collection_links[$rewble->collection_number]['href']."]"); 

		###>  Listing collection module index contents -----------------------------------------------------------------------------

	$rewble->modules_list=$rewble->_fetch_module_index_($rewble->collection_number);
        $rewble->_message_handler_('null',"null",  "DEBUG: __curl_module_index:modules=[$rewble->modules_list]");
	echo "\nAnsible docs currently listing $rewble->mc modlues for $rewble->collection. All $rewble->mc modules will be numerically listed in a moment.\n\n";  ###> Print a message to terminal.
	sleep(3);       ###>  Give someone a chance to see the message.

	$rewble->_message_handler_('I',"Requested collection rewble->collection=[".$rewble->collection."]", "DEBUG: rewble->collection=[".$rewble->collection."]");   ###>  
	$rewble->_message_handler_('null', "null", "DEBUG: rewble->collection_modules=[" /*. print_r($rewble->collection_modules[$rewble->collection])*/ );  


       $pad=0;
        foreach( $rewble->collection_modules[$rewble->collection] as $key => $module){
		if(is_int($key / 2)){ 
		$nums[]=$key;
                    if(strlen($module) > $pad){    ###> if the active anchor length is longer than the current pad value,  
                        $pad=strlen("#[$key] - $module");   ###>  the pad value becomes the active anchor length
                    }
		}
	}
	$cmc=0;
        foreach( $rewble->collection_modules[$rewble->collection] as $key => $module){         ###>  Print the array with key value to be selected later.
                $cmc++;  $up2=false;  //if($cmc==2){  $cmc=0;  $up2="\n";  }
                if(($key<100)&&($key>9)){ $add=1; }elseif($key<10){ $add=2; }else{ $add=0; }
                echo "#[".($key + 1)."] - ".str_pad($module, $pad + $add);
                if($cmc==2){  $cmc=0; echo "\n";  }
        }


/*
 
	$cmc=0;
        $pad=0;
        foreach( $rewble->collection_modules[$rewble->collection] as $key => $module){
                if(strlen("#[$key] - $module") > $pad){    ###> if the active anchor length is longer than the current pad value,  
                        $pad=strlen("#[$key] - $module");   ###>  the pad value becomes the active anchor length
                }

	foreach( $rewble->collection_modules[$rewble->collection] as $key => $module){         ###>  Print the array with key value to be selected later.
		$cmc++;  $up2=false;  if($cmc==2){  $cmc=0;  $up2="\n";  }
        	echo "#[$key] - $module   ".$up2;
	}


*/



	echo "\n\n";

	$user_module_response= readline("Type the number of the module to get the yaml displayed.[1-$rewble->mc]: ");  ###> Request input from the user, the numerical array key, integer should be returned.
	if(preg_match('/q/',$user_module_response)) die("   Quit requested!\n");

//$rewble->module_number=$user_module_response;  ###> test var until identify_module data validation is functional
//	die("user_module_response=[$user_module_response]\n");
//	if (is_int($user_module_response)){
	if($rewble->_identify_module_($user_module_response)){
//			$rewble->module_number=$user_module_response;
//		}
	}else{
		$rewble->_show_collection_index_();
	}
     

		###>  On the module page the the yaml presented is formated with css, the element is named examples 

	$module_url=$rewble->_format_module_url_();
	$rewble->_fetch_module_example_($module_url);
	echo "\n\n";
	echo "\n    ".$rewble->module."\n  From ansible collection: ".$rewble->collection;
	echo "\n\n";
	$rewble->_parse_yaml_example_($rewble->module_yaml_example);
	echo $rewble->module_yaml_example;
	echo $rewble->unchanged;
	echo "\n\n";
	echo $rewble->task;

}else{
	echo "we didn't find list_collections to be defined";
}
//require_once ($__dir__ . '/conf/cleanup.php');
?>
