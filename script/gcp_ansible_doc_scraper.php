#!/usr/bin/php
<?PHP
##############################################################################################################
###> New x php -> gcp_ansible_doc_scraper.php  -> Richard Eric Walts as eric ---> 2023-07-20_11:21:34 init <<<
##############################################################################################################
###>   This script was written to pull sample plays or "starter templates" directly from docs.ansible.com
###>  I hope you find it helpful
error_reporting(E_ALL ^ E_WARNING);

if($argsv[1]!=''){   ###>    If the desired module is included it will be run.
	$gcp_module=$argsv[1];
}else{

	#$gcp_module='gcp_compute_instance';   ###> Testing var
	#$gcp_module=$argv[1];		###> Testing var

	$modules_url="https://docs.ansible.com/ansible/latest/collections/google/cloud/index.html#plugin-index";
							###> Load and read module index
	$site = curl_init($modules_url);	
	curl_setopt($site, CURLOPT_RETURNTRANSFER, true);
	$target = curl_exec($site);
	$dom = new DOMDocument();
	@$dom -> loadHTML($target);
	$modules = $dom -> getElementById('modules') -> nodeValue;
	echo $modules;
}

$read_this_test="https://docs.ansible.com/ansible/latest/collections/google/cloud/".$gcp_module."_module.html#examples";

###>  On the module page the Examples section is a span LOOK for THIS <div class="highlight">
###>  This will require the css included as well to parse and turn to text
###>  an example in this directory ./highlight-div-example.txt
###> Load and read module example play yaml
$site = curl_init($read_this_test);
curl_setopt($site, CURLOPT_RETURNTRANSFER, true);
$target = curl_exec($site);
$dom = new DOMDocument();
@$dom -> loadHTML($target);
$title = $dom -> getElementById('examples') -> nodeValue;

echo $title;



?>
