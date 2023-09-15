#!/usr/bin/php
<?PHP
#########################################################################################################
###> New x php -> rewble_create_play.php  -> Richard Eric Walts as eric ---> 2023-07-22_17:28:16 init <<<
#########################################################################################################
$__dir__ = getcwd();
require_once ($__dir__ . '/inc/class_rewble.php');
require_once ($__dir__ . '/inc/vars.php');
require_once ($__dir__ . '/inc/config.php');


$d = new yaml_play();  ###> Create new rewbin play object.

if(!$argv[1]){  ### If nothing has been provided. We will scrape the collection index page in docs.ansible.com.

	$col=$d -> __fetch_collection_index($collection_index_url);  ###>  These variables are included from inc/vars.php
	$cc=count($col);
	echo "\nThe entire list of $cc collections is about to be numerically listed.\n\n";  ###> Print a message to terminal.
	sleep(3);       ###>  Give someone a chance to see the message.
	echo $d -> __format_index_list($col);
	echo "\n\n";
	$collection_number= readline("Provide the number for the collection you want to display[0-$cc]: ");  ###> Request input from the user, the numerical array key.
	echo "\n\n";
	$collection_link_insert=$col[$collection_number]['href'];  ###>  This value is used in the urls for both module index and module example.
	$modules_url="https://docs.ansible.com/ansible/latest/collections/".$col[$collection_number]['href']."index.html#plugin-index"; ###> Index page with the list of available examples.

###>	$modules_url="https://docs.ansible.com/ansible/latest/collections/google/cloud/index.html#plugin-index"; ###> Index page with the list of available examples.
	$modules=$d->__curl_module_index($modules_url);
	// $d->parse_dom_output();

	$m=explode("\n", $modules);     ###> The ouput is several lines which we need to parse individually. Turning the block into an array of lines.





/*NEED TO FIX -> this is looking for gcp only if this is from something else it needs to be different.  
work out what it can be.  already know there are empty spaces, most other lines look to be capital
I think the first word, or at least lowercase letter of the first word of link we save might work.
*/


//print_r($m);
//die();
	for($i=0;$i<count($m);$i++){    ###>  Loop through the array
		if(preg_match('/_/', $m[$i])){      ###> Find the modules names
			$mods[]=$m[$i];  ###> Create a new array of only the module lines
		}
	}

	$mc=count($mods);  ###>  We count how many modules lines were picked up.
	echo "\nThe entire list of $mc modules is about to be numerically listed.\n\n";  ###> Print a message to terminal.
	sleep(2);       ###>  Give someone a chance to see the message.

	foreach($mods as $key => $module){         ###>  Print the array with key value to be selected later.
        	echo $key." - ".$module."\n";
	}
	echo "\n\n";

	$module_number= readline("Provide the number for the module you want to display[0-$mc]: ");  ###> Request input from the user, the numerical array key.
	$ma=explode(' ', $mods[$module_number]);
	$module=$ma[0];
	$module_example="https://docs.ansible.com/ansible/latest/collections/".$collection_link_insert.$module."_module.html#examples";

	###>  On the module page the the yaml presented is formated with css, the element is named examples 


 $mc=count($mods);  ###>  We count how many modules lines were picked up.
 echo "\nThe full module list, including $mc modules, is about to be numerically listed.\n\n";  ###> Print a message to terminal.
 sleep(2);       ###>  Give someone a chance to see the message.

 foreach($mods as $key => $module){         ###>  Print the array with key value to be selected later.
      echo $key." - ".$module."\n";
 }
 echo "\n\n";

 $module_number= readline("Provide the number for the module you want to display[0-$mc]: ");  ###> Request input from the user, the numerical array key.







}else{
	//$_module=$argv[1];
}


$example_url="https://docs.ansible.com/ansible/latest/collections/".$collection_link_insert.$module."_module.html#examples";




?>
