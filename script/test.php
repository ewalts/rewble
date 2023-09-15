#!/usr/bin/php
<?PHP
##############################################################################################################
###> New x php -> gcp_ansible_doc_scraper.php  -> Richard Eric Walts as eric ---> 2023-07-20_11:21:34 init <<<
##############################################################################################################
###>   This script was written to pull sample plays or "starter templates" directly from docs.ansible.com
###>  I hope you find it helpful
error_reporting(E_ALL ^ E_WARNING);

require_once( $__dir__ . "inc/vars.php");


/*if($argsv[1]!=''){   ###>    If the desired module is included it will be run.
	$gcp_module=$argsv[1];
}else{


<span class="std std-ref">wti.remote</span></a></p></li>



*/
	#$gcp_module='gcp_compute_instance';   ###> Testing var
	#$gcp_module=$argv[1];		###> Testing var

							###> Load and read module index
	$site = curl_init($collection_index_url);	
	curl_setopt($site, CURLOPT_RETURNTRANSFER, true);
	$target = curl_exec($site);
	foreach(preg_split("/((\r?\n)|(\r\n?))/", $target) as $line){ 
		if(preg_match('/<li><p><a class=\"reference internal\" href/',$line)){
			$collections=$line;
			$l=explode('href="',$line);
			$t=explode('"',$l[1]);
			$href=$t[0];
			$a=explode('std-ref">', $line);
			$b=explode('</span', $a[1]);
			$anchor=$b[0];

			$lines[]=array ('href'=>"$href","anchor"=>"$anchor");
		}
	}


//	echo $collections;
//}

/*/$read_this_test="https://docs.ansible.com/ansible/latest/collections/google/cloud/".$gcp_module."_module.html#examples";

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
*/


?>
