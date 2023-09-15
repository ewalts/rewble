#!/usr/bin/php
<?PHP
############################################################################################################
###> New x php -> yaml_vars_2_php_array.php  -> Richard Eric Walts as eric ---> 2023-07-21_15:24:20 init <<<
#####################################have-you-seen-rewbin###################################################
###> Snippet provided by Richard Eric Walts; provide file to be read as argument.

$file= $argv[1];
$handle = fopen($file,'r');
while(($line = fgets($handle, 4096)) !== false) {
//	try
	if (preg_match('/\:/',$line)){
		$el=explode(':',$line);
		$var_name=$el[0];
		$var_value=$el[1];
		
		echo '"'.$var_name.'"  =>  "'.$var_value.'",';
        }
}
fclose($handle);
?>
