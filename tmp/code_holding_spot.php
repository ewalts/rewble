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


aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
    public function _require_collection_(){
                if(!$this->collection){
                        $kill;
		}
    }

    function _string_or_int_($value){
	try 
	{
		$a = 10 * $value;
		echo "trying\n";

	} catch (Exeption $e) 	{
		echo "exception caught\n";
		
	}
   }  
		


    public function _identify_collection_($input_str){   ###> Takes input in the form of number relating to the rewble array key, or the collection name. This is provided in the command or as a choice.
        $this->_message_handler_('null',"null","DEBUG: Collection sent to _identify_collection_ value passed=[$input_str]");
        switch ($input_str) {
            case (is_int(intval($input_str - 1 ))):
                if($this->ansible_collections[$input_str]!=''){
                        $this->collection_number=intval($input_str - 1);
                        $this->collection=$this->ansible_collections[$this->collection_number];
                        $this->_message_handler_('I',"Collection identified as [$this->collection].","DEBUG: Collection sent to _identify_collection_ value passed=[$this->collection]");
                }else{
                        $this->collection=false;
                        $this->_message_handler_('E',"Collection not identified value passed=[$input_str].","DEBUG: Collection sent to _identify_collection_ value passed=[$input_str]");
                        $this->_show_collection_index_();
                }
                break;
            case is_string($input_str):
                if(in_array($input_str,$this->ansible_collections)){
                        $this->collection=$input_str;
                        $this->_message_handler_('I',"Collection identified as [$this->collection].","DEBUG: Collection sent to _identify_collection_ value passed=[$this->collection]");
                }else{
                        $this->_message_handler_('E'," The collection provided was not found. Please select from the list.","DEBUG: The collection provided was not found. Please select from the list. collection=[$this->collection");
                        $this->_show_collection_index_();
                }
                break;
        }
    }



################################################################################################################























try {
	$this->collection


#########################################################################################################
//                        $play.=$l."\n";
//                }elseif(preg_match('/-\ /', $l)){
//                        $play.=$p[0].":\n";
//                }elseif(preg_match('/\:/', $l)){
//                        $p=explode(':',$l);
//                        if($p[1]!=''){
#####################################################################################################
?>
