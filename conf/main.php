<?PHP
################################################################################################
###> New x php -> conf/main.php  -> Richard Eric Walts as eric ---> 2023-07-24_10:39:20 init <<<
################################################################################################
//$__confdir__ = getcwd();

require_once ($__dir__ . '/inc/vars.php');  ###>  This file includes other variable containing files: [/vars/*_vars.php]
 ###>
  require_once ($__dir__ . '/inc/rewbin_utils.php');  ###>  Rewbin utils class contains utility functions log handeling, email notifications, etc.
   ###>
    require_once ($__dir__ . '/inc/class_rewble.php');   ###>  Load the class 
     ###>

$rewble = new rewble();

$rewble->_set_vars_from_array_($_my_vars_array);

$rewble->_fetch_collection_index_($rewble->collection_index_url);

require_once ($__dir__ . '/inc/switch_argvar_proc.php');   ###>  Load the 
if(!$_debug){  error_reporting(E_ALL ^ E_WARNING); }  ###>  If the debug flag is still false we won't display standard PHP error messages.

$rewble->_message_handler_('I',"Begin logging >>> $_rewbin_log_file","DEBUG: Logging started, primary log file is $_rewbin_log_file");   ###> 
$rewble->_message_handler_('I',"Value of __dir__=[".$__dir__."]","DEBUG: Value of __dir__=[".$__dir__."]");   ###>

/*$dir=array('vars','data','logs','conf');
foreach($dir as $key => $value){
	if(!is_dir($__dir__ . "/". $value."/" )){
		$rewble->_message_handler_('E',"Dir $value not found.","DEBUG: Dir ../$value unable to be verified.");
	}
}
*/
/*
if(preg_match('/\//',$file_executed))                                   ###>  Was the file executed in cwd?
{ $pwd_local=false;  $path_sec=explode('/',$file_executed);  }else      ###>  Determine directory depth, this is actually unknown.
{ $pwd_local=true; }                                                    ###>  Define currently in location with executed file.
$sec_count=count($path_sec);                                            ###> Determine directory dept   
*/

?>
