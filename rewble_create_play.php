#!/usr/bin/php
<?PHP
#########################################################################################################
###> New x php -> rewble_create_play.php  -> Richard Eric Walts as eric ---> 2023-07-22_17:28:16 init <<<
#########################################################################################################
###>  Primary executing file
###>  Command example:	./rewble_create_play.php -h => Will list options
###>  		- 	./rewble_create_play.php -d -v    
###>  This script calls the main configuration file.  Other files are included there.

$__dir__ = __dir__;

require_once ($__dir__ . '/conf/main.php');  ###>  This file includes other files: [/inc/class_rewble.php, /inc/switch_argvars_proc.php].
if($rewble->view_inventory){
    if($rewble->local_inventory_dir){  ###> Search local inventory, custom plays
	    if((is_dir($rewble->local_inventory_dir))===false){
		    $rewble->_missing_local_inventory_fix_();
	    }else{
		    $rewble->inventory_dir_handle=opendir($rewble->local_inventory_dir);
	    }
    }	
}elseif($rewble->collection){  ###> If a collection has been provided and validated, ...
	$rewble->_message_handler_('I',"rewble collection has been set to $rewble->collection", "DEBUG: rewble->collectio");
	if($rewble->module){  ###>  look for a module, if a module has been provided, ...
		$rewble->_message_handler_('I',"rewble module has been selected as $rewble->module", "DEBUG: CHANGE THIS DEBUG MESSAGE");
		if($rewble->_identify_module_($_module)){   ###>  identify/verify validity of module information passed, if valid, name will be defined ->module.
			//$rewble->module=$_module;
			$rewble->list_collections=false;    //  	die("we aren't ready to get modules\n");		
		}
	}else{
		$rewble->_message_handler_('I',"rewble module has not been selected, calling _list_collection_modules_($rewble->collection)", "DEBUG: rewble will list modules of the active collection [$rewble->collection].");
                $rewble->_list_collection_modules_($rewble->collection);
	        $user_module_response= readline("Type the number of the module to get the yaml displayed.[1-$rewble->mc]: ");  ###> Request input from the user, the numerical array key, integer should be returned.
	        if(preg_match('/q/',$user_module_response)) die("   Quit requested!\n");  ###>  End current process.
		

        }

}else{   ###> We show all module collections from docs.ansible

	$rewble->_show_collection_index_(); 
	$cc=count($rewble->ansible_collections);  ###> Number of collections discovered

	echo "\n Ansible docs currently listing $cc collections.  All $cc collections will be numerically listed in a moment.\n\n";  ###> Print a message to terminal.

	echo " Choose the collection to list modules.\n";
	echo $rewble->print_collections;  ###> numbered list 
	echo "\n\n";     

	$user_collection_response= readline("Type the number of the collection you want to browse.[1-$cc]. Or [q] to quit: ");  ###> Request input from the user, the numerical key in the collections array.
	if(preg_match('/q/',$user_collection_response)) die("   Quit requested!\n");

	if($rewble->_identify_collection_($user_collection_response)){    ###> input validation, correlate to the correct collection if possible 

	}else{
		$rewble->_show_collection_index_();   ###> or show the collection index listing 
	}		
	if($rewble->collection){
		echo "\n\n";  	###> additional space
		$rewble->_message_handler_('I',"collection_href=[".$rewble->collection_links[$rewble->collection_number]['href']."]","DEBUG: collection_href=[".$rewble->collection_links[$rewble->collection_number]['href']."]"); 

		###>  Listing collection module index contents -----------------------------------------------------------------------------
		$rewble->_fetch_collection_modules_($rewble->collection_number);
        }
}
if($rewble->modules_list){
        $rewble->_message_handler_('null',"null",  "DEBUG: __curl_module_index:modules=[$rewble->modules_list]");
	echo "\nAnsible docs currently listing $rewble->mc modlues for $rewble->collection. All $rewble->mc modules will be numerically listed in a moment.\n\n";  ###> Print a message to terminal.
	sleep(2);       ###>  Give someone a chance to see the message.
	$rewble->_message_handler_('I',"Requested collection rewble->collection=[".$rewble->collection."]", "DEBUG: rewble->collection=[".$rewble->collection."]");   ###>  
	$rewble->_message_handler_('null', "null", "DEBUG: rewble->collection_modules=[" /*. print_r($rewble->collection_modules[$rewble->collection])*/ );  
	$rewble->_format_module_list_($rewble->collection);	
	echo "\n\n";
	$user_module_response= readline("Type the number of the module to get the yaml displayed.[1-$rewble->mc]: ");  ###> Request input from the user, the numerical array key, integer should be returned.
	if(preg_match('/q/',$user_module_response)) die("   Quit requested!\n");
}

if(($user_module_response)&&($rewble->collection)){
	if($rewble->_identify_module_($user_module_response)){
     
		$module_url=$rewble->_format_module_url_();
		$rewble->_fetch_module_example_($module_url);
		echo "\n\n";
		echo "\n    Pulling module [".$rewble->module."].\n  From ansible collection: ".$rewble->collection;
		echo "\n\n";

		$rewble->_parse_yaml_example_($rewble->module_yaml_example);  ###> Extract information from site. 
		echo $rewble->module_yaml_example;
		echo $rewble->unchanged;
		echo "\n\n";
		echo $rewble->task;
	}else{
       	        $rewble->_show_collection_index_();
       	}
}else{
		$rewble->_show_collection_index_();
}
require_once ($__dir__ . '/conf/cleanup.php');

?>
