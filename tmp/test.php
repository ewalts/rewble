<?php
$__dir__=getcwd();

require_once $__dir__ . '/inc/class_rewble.php';
require_once $__dir__ . '/inc/vars.php';
$d = new yaml_play();  ###> Create new rewbin play object.

$col=$d -> __curl_collection_index($collection_index_url);
echo $d -> __format_index_list($col);
//print_r($col);
?>
