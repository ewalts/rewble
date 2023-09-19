#!/usr/bin/php
<?PHP
##############################################################################################################
###> New x php -> gcp_ansible_doc_scraper.php  -> Richard Eric Walts as eric ---> 2023-07-20_11:21:34 init <<<
##############################################################################################################
###>   This script was written to pull sample plays or "starter templates" directly from docs.ansible.com
###>  I hope you find it helpful

error_reporting(E_ALL ^ E_WARNING);

$error_color='';
$__dir__=getcwd();

if(include_once "../inc/php-cli-colors.inc"){
	$error_color=$red;
}elseif(include_once "$__dir__/inc/php-cli-colors.inc"){
        $error_color=$red;
}else{
	$error_color=false;
}
$vpfix="my_gcp_";
$collection_url=false;

if(($argv[1]!='')&&($argv[2]!='')){   ###>    If the desired module is included it will be run.
	$gcp_module=$argv[1];
	$gcp_collection=str_replace('.','/',$argv[2]);
	$collection_url="https://docs.ansible.com/ansible/latest/collections/$gcp_collection/index.html#plugin-index"; ###> Index page with the list of available examples.
	
}else{			###> If a module is not provided it reads the index page.

	#$gcp_module='gcp_compute_instance';   ###> Testing var
	#$gcp_module=$argv[1];		###> Testing var

	$collection_url="https://docs.ansible.com/ansible/latest/collections/google/cloud/index.html#plugin-index"; ###> Index page with the list of available examples.
}
if($collection_url){	###> Load and read module index
	$_url=$collection_url;
	$site=curl_init($_url);     ###>  Create the curl request
	curl_setopt($site, CURLOPT_RETURNTRANSFER, true);  ###> Set options 
	if(!$target=curl_exec($site)){	  ###> Attempt to execute the request
		die("");
	$dom = new DOMDocument();	###> Create the Dom
	@$dom -> loadHTML($target);	###> Load the html to be manipulated
	$modules = $dom -> getElementById('modules') -> nodeValue; ###>  Extract the element
	$m=explode("\n", $modules);	###> The ouput is several lines which we need to parse individually. Turning the block into an array of lines.
	
	for($i=0;$i<count($m);$i++){	###>  Loop through the array
		if(preg_match('/^gcp_/', $m[$i])){	###> Find the modules names
			$mods[]=$m[$i];  ###> Create a new array of only the module lines
		}
	}	

}
$mc=count($mods);  ###>  We count how many modules lines were picked up.
echo "\nThe entire list of $mc modules is about to be numerically listed.\n\n";  ###> Print a message to terminal.
sleep(3);	###>  Give someone a chance to see the message.
foreach($mods as $key => $var){		###>  Print the array with key value to be selected later.
	echo $key." - ".$var."\n";
}
echo "\n\n";

$module_number= readline("Provide the number for the module you want to display[0-$mc]: ");  ###> Request input from the user, the numerical array key.

$ma=explode(' ', $mods[$module_number]);
$gcp_module=$ma[0];
$module_example="https://docs.ansible.com/ansible/latest/collections/google/cloud/".$gcp_module."_module.html#examples";



###>  On the module page the the yaml presented is formated with css, the element is named examples 

###> Load and read module example play yaml
$site=curl_init($module_example); ###>  Create the curl request
curl_setopt($site, CURLOPT_RETURNTRANSFER, true);  ###> Curl options
$target=curl_exec($site);  ###> Execute the request to pull the examples element
$dom=new DOMDocument(); ###> New dom doc
@$dom -> loadHTML($target);  ###>  Loading the HTML 
$title = $dom -> getElementById('examples') -> nodeValue; ###> extract the element examples
$unchange='';
//echo $title;	###>  We'll print the unmodified element text
echo "\n\n";
$play='';  ###>  Start creating the play, where we will replace bogus values with variable
$vars_file='';  ###>  Start creating the var_files file.  The original values will be included.  If the original value is what you want, You don't have to change it, it should be called with the rest of the customized vars.
$V = array('$vpfxauth_kind','$vpfxregion','$vpfxservice_account_file');  ###>  This array tracks variable names to insure we don't duplicate unintentionally
$l=explode("\n",$title);  ###>  We explode each line as before, this time
for($i=0;$i<count($l);$i++){
	if(preg_match('/^Example/', $l[$i])){

	}elseif(preg_match('/\{\{/',$l[$i])){
		$unchanged.=$l[$i]."\n";
		$ov=explode('{{',$l[$i]);
		$orig_var=str_replace('}}','',$ov[1]);
	}

	if(preg_match('/^Example/', $l[$i])){
	}elseif(preg_match('/-\ name:/', $l[$i])){
		$unchanged.=$l[$i]."\n";
		$play.=$l[$i]."\n";
	}elseif(preg_match('/-\ /', $l[$i])){
		$unchanged.=$l[$i]."\n";
		$play.=$p[0].":\n";
	}elseif(preg_match('/\:/', $l[$i])){
		$unchanged.=$l[$i]."\n";
		$p=explode(':',$l[$i]);
		if($p[1]!=''){


			$new_var="$vpfx".trim(str_replace('- ','',$p[0]));
			if(!in_array($new_var,$V)){
				$vars_file.=$new_var.': '.$p[1]."\n";
				$play.=$p[0].": {{ $new_var }} \n";
				$V[]=$new_var;
			}else{
				$new_var=$new_var.'_'.str_replace(' ','',$p[1]);
				$vars_file.=$new_var.': '.str_replace(' ','',$p[1])."\n";
				$play.=$p[0].": {{ $new_var }} \n";
				$V[]=$new_var;
			}
		}else{
			$play.=$p[0].":\n";
		}
		
	}else{
		$unchanged.=$l[$i]."\n";
		$play.=$l[$i]."\n";
	}
}
echo $unchanged;  ###>  We'll print the unmodified element text

echo "\nVar substitution!\n\n";
echo $play;
echo "\nVars for vars file\n\n";
echo $vars_file;
//echo $title;
?>
