#!/usr/bin/php
<?PHP
##################################################################################################
###> New x php -> var_rewrite.php  -> Richard Eric Walts as eric ---> 2023-08-12_15:53:49 init <<<
##################################################################################################
##########################have-you-seen-rewbin###############################################
###> New x php -> $this->read(); -> Richard Eric Walts as eric ---> 2008-01-10_02:48:17  <<<
##########################have-you-seen-rewbin###############################################
###> Snippet provided by Richard Eric Walts; provide file to be read as argument.

$file= $argv[1];
$handle = fopen($file,'r');
while(($line = fgets($handle, 4096)) !== false) {
	$line=trim($line);
	if (($line != '')&&(!preg_match('/^\#/',$line))){
                $array_[]=$line;
		if(preg_match('/\$_/',$line)){   ###> identify var to change to array
			$array_line=str_replace ('"', '', $line);
			$array_line= str_replace ('\'', '', $array_line);
			$split=explode('=',$array_line);
//			$array_line= str_replace ('=', '"  =>  "', $array_line);

			$one=str_replace('$_','',$split[0]);

			$two=str_replace(';','',$split[1]);


			
			echo '     "'.$one.'"  =>  "'.$split[0].'",'."\n";


		}
        }
}
//	print_r($array_);

fclose($handle);
?>
