<?
$d = new yaml_play();
if(!$argv[1]){
        $modules_url="https://docs.ansible.com/ansible/latest/collections/google/cloud/index.html#plugin-index"; ###> Index page with the list of available examples.

        //echo $d->parse_dom_output($argv[1]);
        $m=explode("\n", $modules);     ###> The ouput is several lines which we need to parse individually. Turning the block into an array of lines.
        for($i=0;$i<count($m);$i++){    ###>  Loop through the array
                if(preg_match('/^gcp_/', $m[$i])){      ###> Find the modules names
                        $mods[]=$m[$i];  ###> Create a new array of only the module lines
                }
        }
}else{
        $gcp_module=$argv[1];
}
$example_url="https://docs.ansible.com/ansible/latest/collections/google/cloud/".$gcp_module."_module.html#examples";

$example_code = $d->curl_example($example_url);
for


#########################################################################################################
//                        $play.=$l."\n";
//                }elseif(preg_match('/-\ /', $l)){
//                        $play.=$p[0].":\n";
//                }elseif(preg_match('/\:/', $l)){
//                        $p=explode(':',$l);
//                        if($p[1]!=''){
#####################################################################################################
?>
