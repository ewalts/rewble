<?PHP
/*
$__dir__ = getcwd();

require_once ($__dir__ . '/conf/main.php'); 

$rewble= new rewble();

$rewble->_load_my_collection_vars_($_my_vars_dir);

echo $_collection."<<<\n";
if(!$_collection){
	$_collection='google.cloud';
}


foreach ($rewble->my_collection_vars as $key => $value){
	echo "first check value of rewble->collection=[$rewble->collection]\n";
	if($key == $_collection){
		echo "found $key matching $_collection in the array\n";
	}
}
*/

$str='param_24';

if(preg_match('/param_[0-9]/', $str)){
	echo"match\n";
}else{
	echo"no match\n";
}

?>
