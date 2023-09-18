<?PHP
################################rewbin-was-here##############################################################>
###>  This class creates playbook starters based on the examples found on docs.ansible.com
###>  The notion is to create something to quick and easily grab their example, replace the sample 
###>  paramater values with inline variables, generate the 
###>  identify my commonly used variables, i.e., auth_kind, credential files,
###>  Identify which inventory file should be used.
###>  This is version 2.0.  The first version was a simple inline script that pulled the example
###>  and printed printed the yaml to the screen, which I directed how I wanted at runtime.
###>  This OO version, provides options for what were working with AWS, GCP, VMWare, etc.
###>  Looks at their specific module index pages, provides options for selecting the module to grab.

// Anything commented like this "//" are temporary, intended to be removed. Either test ouput, or notes regarding future ideas 

class rewble extends rewbin {

  ###> Static vars --------------------------------------------------------------------------------------------------------

    public $var_prefix;   ###> This value will be added to variables
    public $my_vars_dir;   ###>  This is where your custom variables files are stored. >>>> IT IS NOT WHERE THE DEFAULT CONFIGURATION VARIABLES ARE SET IN THE CLASS NOT WHERE VALUES ARE DEFINED! <<<
    public $my_collection_vars=array();  ###> This array contains your defined collection vars on file.
    public $my_remote_parameter_stores=array();  ###>  This array is for adding parameters that are stored in the cloud.

  ###> Build process vars and arrays --------------------------------------------------------------------------------------- 
    
    public $ansible_collections=array();  ###> Simple array numerical all ansible collections avaialable
    public $collection;  ###> Name of the active collection. 
    public $collection_dom;   ###>  
    public $collection_list;    ###>   The complete string list, still html, curled from the colleciton index url
    public $collection_links=array();  ###>  multi-dimention array toplevel key => array (href, anchor)
    public $collection_modules_list;   ###> this is the 
    public $collection_modules=array();  ###> this multi-dimention array toplevel key is collection name => numerical key each module in that collection, this could hold more than one collection of modules
    public $line_array;   ###> This is the array of each line taken from the yaml example
    public $module;  ###>  the module name if one has been selected or provided in the request
    public $module_dom;   ###> The  
    public $modules_list;  ###>  the active string, list of modules 
    public $modules_url;  ###>  the url for collection module index
    public $page;   ###>  The html5 typically presented to a browswer. 
    public $playbook_output_dir;
    public $print_collections;
    public $task;// = array(); ###>    array contains each line, and information necessary to generate a task in a play.
    public $task_name;  ###>  the name of the active task being assembled
    public $task_yaml;  ###> 
    public $unchanged;   ###>  Original yaml from docs.ansible.com passed into the parser. Some extranious information is stripped, the yaml is unchanged.

  ###> Functions that configure settings --------------------------------------------------------------------------------------------------------------------------

    public function _set_play_info_($t,$exn,$st1,$st2) { ###> this will keep track of common variables, and specifics about the playbook and which statements are in which task
        $a[$t]=array("$exn","$st1","$st2");     ###> This multidimentional array holds all the information for the task.
    }

    public function _load_my_collection_vars_(){   ###>  This function will read vars from custom files in vars/ ending with _vars.php . 
        $dir_handle=opendir($this->my_vars_dir);   ###>  open the directory
        while ($file=readdir($dir_handle)){   ###>  read the directory
                if(preg_match('/_vars.php/',$file)){   ###>  
                        $this->_parse_vars_file_($file);   ###>  
                }
        }
	closedir($dir_handle);
    }

  ###> Functions that read from content from docs.ansible ----------------------------------------------------------------------------------------

    public function _fetch_ansible_docs_element_($url,$element_name){   ###>   This function performs the curl action fetching an element must provide the url and the name of the element in the page
	$dMsg="DEBUG: Input to class function __fetch_ansible_docs_element: url=[$url],element_name=[$element_name]"; 
	$this->_message_handler_('I','',$dMsg);
	
        $el=$element_name;   ###> Name of element shorter var name
        $site_handle=curl_init($url);  ###> Initialize the curl action
        curl_setopt($site_handle, CURLOPT_RETURNTRANSFER, true);	###> Define action attributes
        $this->page=curl_exec($site_handle);   ###> Execute the request
	$dom = new DOMDocument();  ###> Create the document
	@$dom -> loadHTML($this->page);  ###> Load the html to be manipulated
	$this->dom_output = $dom -> getElementById($el) -> nodeValue;   ###> Extract the element to be output
	if($el=='collection-index'){   ###>  
		return	$this->page;  ###>  The collection index process wants the html page output.
	}else{
	        return $this->dom_output;	 ###>  Return the output, this function is generic and used in many places.  So we do not include this output directly into the array here.
	}
    }
    
    public function _show_collection_index_(){
        $this->_message_handler_('I',"collection_index_url=[$this->collection_index_url]","DEBUG: Calling _show_collection_index_ with collection_index_url=[$this->collection_index_url]");   ###> 
 
        if(!is_array($this->collection_links[0])){  ###>  The collection_index_url variable is included from inc/vars.php, the collection_links array is created there as well. 
		$this->_message_handler_('E',"The collection_links array is empty but should have been defined previously. Building again.", "DEBUG: show_collection_index called, and collection_links array is empty. "
			  ."Attempting to build again Variable for collection_index_url=[$this->collection_index_url]. If url var is blank check configuration. If Url is correct check internet access and DNS resolution. Making second attempt"); 
//die($this->collection_index_url);
		$this->_fetch_collection_index_($this->collection_index_url);

		if(!is_array($this->collection_links)){
			$this->_message_handler_('E',"FATAL: Error- fetching docs.ansible information, or the array creation script failed a second time. This process will terminate.","DEBUG:  fetching the collection index from docs.ansible, or the array creation process failed for the second time. This process will terminate.") ;
			$this->_kill_("FATAL: Failed second attempt to fetch collection index.\n Please notify administrator or script creator.\n\n");
		}
	}else{
        	$this->_message_handler_("I","the collection_links array exists sending to format.", "DEBUG: collection_links is array.");  

        	$this->_format_index_list_();   ###>  Formates the cli and >>> currently disabled html<<< output the cli text block is ->print_collections 
	}
    }

    public function _fetch_collection_index_($url){  ###> reading the index of modules page in docs.ansible.com <<
	if($url==''){    ###>  ###> This will be a major error with no url in the fetch function.
		$this->_message_handler_('E','The collection index URL value was empty.',"DEBUG: input to class function __fetch_ansible_docs_element: No url provided to fetch_collection_index on or around line 100 inc/class_rewble.php." 
					." This may mean the configuration is not defined or did not load properly. url=[$url]");   ###>  
	    	###> This will be a major error with no url in the fetch function. 
		$this->_kill_('E');
	}else{   ###>  
	    $this->_message_handler_('I',"The collection index URL value=[$url].","DEBUG: The url provided to fetch the collection index url=[$url]");   ###>
	    $this->_message_handler_('null',"null", "DEBUG: collection_links array build section:");
	    if($this->_fetch_ansible_docs_element_($url,'collection-index')){ ###>  Call the curl function returning the collection index text.
	    	$this->collection_list=$this->page;  		###>  /// $this->_fetch_ansible_docs_element_($url,'collection-index'); ###>  Call the curl function returning the collection index text.
		$this->collection_dom=$this->dom_output;
	    }
            foreach(preg_split("/((\r?\n)|(\r\n?))/", $this->collection_list) as $line){  ###> turn the block into lines
                if(preg_match('/<li><p><a class=\"reference internal\" href/',$line)){  ###> The html lines are seperated into anchor text and href link
                        $l1=explode('href="',$line);  ###> splitting here, second protion contains both the link and anchor text
                        $l2=explode('"',$l1[1]);   ###> splitting here leaves the first part as the href link
			$l3=explode('index', $l2[0]);   ###> we still need to remove able, splitting at index it is included to complete.
		     ###> back to untouched line
                        $l4=explode('std-ref">', $line);  ###> this is the anchor text
                        $l5=explode('</span', $l4[1]);  ###>  removing the last of the html 
                        $ansible_collection_links[]= array ('href' => "$l3[0]", "anchor" => "$l5[0]");  ###> both the anchor name and the href value are included in the array
			$this->ansible_collections[]=$l5[0];    ###> 
                }
            }
	    if(!is_array($ansible_collection_links[0])){ ###>  Has the array been created?

        	$this->_message_handler_('E','The collection_links array was not creaetd properly.', "DEBUG: collection_links array in read");
		return false;  								###>  This may need to spawn the action again in the future
	    }else{
		$this->_message_handler_('I',"The collection_links array has been creaetd properly. It contains ".count($this->collection_links)
			." links.","DEBUG: The collection_links array has been creaetd properly. It contains ".count($this->collection_links)." links.");
		$this->collection_links=$ansible_collection_links;   					###>  This will be printed out by another function, either cli or web
	    }
	}
    }

    public function _format_index_list_(){  ###> Format the output from collection index
	$cls = $this->collection_links;  ###> Shorter in the code
	$pad=0;  ###>  The pad value is will be the length of the longest string to include space padding
	$add=0;  ###>  The add value assists with additional space padding for shorter key length change for numberical changes
	$txt_content='';  $html_content='';  ###> Define variables to loop content additions without undefined var warnings

	for($i=0;$i<count($cls);$i++){  ###>  This loop pre-action counts the leading spaces of each value searching for the longest string.
		if(strlen($cls[$i]['anchor']) > $pad){    ###> if the active anchor length is longer than the current pad value,  
			$pad=strlen($cls[$i]['anchor']);   ###>  the pad value becomes the active anchor length
		}
	}
	$c=0;  ###>  This counter allows three columns, 123, return, 123, return
		//print_r($cls);
	for($i=0;$i<count($cls);$i++){  ###>  This is 
		if(($i<100)&&($i>9)){ $add=1; }elseif($i<10){ $add=2; }else{ $add=0; }  ###>  Justify for diget length 
		$txt_content.="#[".($i + 1)."] - ".str_pad($cls[$i]['anchor'], $pad + $add )." ";  ###>  Add each line to text output

		// $html_content.="&nbsp;[$i] = ".str_pad($ha[$i]['anchor'], $pad + $add, '&nbsp;' )." ";  ###> Add each line to html output
		$add=0;  ###>  This can likely be omitted, but sets the diget justification 
		$c++;
		if($c==3){ $txt_content.="\n";  $c=0; }
	}
	$this->print_collections=$txt_content;
	//$this->html_contnet=$html_content;
    }

    public function _fetch_module_example_($url){
	if($this->_fetch_ansible_docs_element_($url,'examples')){
		$this->module_yaml_example=$this->dom_output;
	//$this->_fetch_ansible_docs_element_($url,'examples');	
	}
    }
 
    public function _fetch_module_index_($collection_number){  ###> reading the index of modules page in docs.ansible.com <<
	$this->collection_number=intval($collection_number);
	$this->collection_modules_url="https://docs.ansible.com/ansible/latest/collections/".$this->collection_links[$collection_number]['href']."index.html#plugin-index"; ###> Index page with the list of available examples.
	$this->_message_handler_("I","modules_url=[$this->collection_modules_url]", "DEBUG: modules_url=[$this->collection_modules_url]");
	$this->collection=$this->collection_links[$collection_number]['anchor'];   ###> Define this->collection from the collection links array value 
	$this->modules_list=$this->_fetch_ansible_docs_element_($this->collection_modules_url,'modules');  			###>  This is the list of modules in text
	$this->_message_handler_('I',"Collection $this->collection = module_list pulled successfully.","DEBUG: _fetch_module_index_ returned module_list=[$this->modules_list]"); ###> 
	$this->_build_collection_modules_array_();  ###>
        return $this->module_list;  ###>
    }

  ###> Utility functions ------------------------------------------------------------------------------------------

    public function _format_module_url_(){
	$this->_message_handler_('null',"null","DEBUG: Inside _format_module_url collection=[$this->collection], module_number=[$this->module_number]");
        $ma=explode(' ', $this->collection_modules[$this->collection][$this->module_number]);
	
        $this->module=$ma[0];
        $module_example_url="https://docs.ansible.com/ansible/latest/collections/".$this->collection_links[$this->collection_number]['href'].$this->module."_module.html#examples";
        return $module_example_url;
    }

    public function _build_collection_modules_array_(){
        $m=explode("\n", $this->modules_list);                             ###> The ouput is several lines which we need to parse individually. Turning the block into an array of lines.
        for($i=0;$i<count($m);$i++){                            ###>  Loop through the array
                if(preg_match('/_/', $m[$i])){                  ###> Find the modules names

                        $this->collection_modules[$this->collection][]=$m[$i];                         ###> Create an array of all modules in the collection. 
                                ###>  TAKE NOTE: The first key in this array is the collection name/anchor, which is a numerical array of modules. That value will usually be needed.
                }
        }
        $this->mc=count($this->collection_modules[$this->collection]);   ###>  
    }

 ##############################################################
    public function _check_my_collection_vars_(){   ###> This function looks for vars that match those being processed. 
	$collection_in_vars=false;
	foreach ($this->my_collection_vars as $key => $value){   ###>  Check if the collection is recognized.  If it isn't, there aren't any variables for this collection.
		if($this->collection == $key){
			$collection_in_vars=true;
			$this->_message_handler_('I',"Collection vars found for collection:[$this->collection]","DEBUG: Collection found in custom vars array =[$this->collection]");
		}
	}
	return $collection_in_vars;
    }

 ##############################################################

    public function _parse_vars_file_($file){   ###>
	$file_handle=fopen($this->my_vars_dir.'/'.$file,'r');   ###>  
	while($lines=fgets($file_handle)){   ###>  
	    $line=strtolower($lines);   ###>  
	    if(preg_match('/collection/',$line)){   ###> 
		$collection=str_replace('collection:','',$line);   ###>  
		$collection=trim($collection);   ###>  
	    }else{
		$var_parts=explode(',',$line);								###> yaml_param is the first part of parameter pair, yaml_param: 
		$this->my_collection_vars[$collection][]=array('yaml_param' => $var_parts[0], 'var_name'=>$var_parts[1],'param_value'=>$var_parts[2]);   ###>   var_name is the second part of parameter pair, yaml_param: {{ var_name }}
	    }												###>  param_value, also var_value, the actual value for the parameter
	}
	fclose($file_handle);										 ###>  value of the parameter/variable is only in the vars file, vars entry var_name: param_value
    }

    public function _parse_yaml_example_($str){ 
	$l=explode("\n",$str);  ###>  We explode the block into lines $l is one line
	$line_count=count($l);  ###> Count the lines
	$task='';
	$unchanged='';   ###> This carries the unchanged yaml, with a little garbage management 
	$new_var=''; ###>  Temporary variable for task variable 
	$this->Vars= array();   ###> Task variables, tracks to insure each variable unique or intentionally duplicated, this is not what was on file.
	$note_count=0;
	$this->param_count=0;
	$var_temp=false;
	for($i=0;$i<count($l);$i++){   ###>  
	    if(preg_match('/^Example/', trim($l[$i]))){   ###>  This is the heading text on the web page
	    }else{
                if(preg_match('/\#/', $l[$i])){   ###>  commented lines are treated as notes regardless of content
			$line_array[$i]['original']=$l[$i];
			$note_count++;   ###>  
			$line_array[$i]['note_'.$note_count]=$l[$i];   ###>  Each note has a different note_[int] key
			$line_array[$i]['leading_space']=$this->_count_leading_spaces_($l[$i]);   ###>
		}elseif(preg_match('/\:/',$l[$i])){
			$line_array[$i]=$this->_yaml_parameter_($l[$i]);
		}
	    }
	}
        return $this->_assemble_play_from_array_($line_array);
    }

###>  The parameter count needs to be passed for the param_$param_count // $line_array[$i]['param_'.$param_count] = array ('name' => trim($param_split[0]),'value' => "var=".trim($new_var));

    public function _yaml_parameter_($line){
	$_was_var=false;    ###>  
	$_original_value=false;   ###>  
	$var_found=false;   ###>  
	$allow_dup=false;
	$line_array['leading_space']=$this->_count_leading_spaces_($line);   ###>
        if(preg_match('/-\ name:/', $line)){   ###> NAME <<<<    The - name: value is treated as a new task
                $line_array['name']=trim($line);   ###> The name is the task title, so the process doesn't change it.  
                return $line_array;
	}else{
		$param_split=explode(':',$line);   ###> Parameters are split
		$param_name=trim($param_split[0]);   ###>  
		$param_dac_value=trim($param_split[0]);    ###>  
		$line_array['yaml_param']=$param_split[0];   ###>  
		if(preg_match('/{{/',$param_dac_value)){   ###>  Found variable brackets
			$_was_var=true;
			$var_temp=str_replace('{{','',$param_dac_value);  ###>  Strip the brackets
			$var_temp=trim(str_replace('}}','',$var_temp));
			$_orig_param_pair=$param_name.': '.$param_dac_value;  
			

		}else{
			$val_temp=trim($param_dac_value);   ###> original parameter value 
			$_orig_param_pair=$param_name.': '.$val_temp;
		}
		if($this->_check_my_collection_vars_($this->collection)){   ###> check to see if the collection exists in custom var files 
			$cvars=$this->my_collection_vars[$this->collection];   ###>  If it does pull the array
	                for($i=0; $i<count($cvars);$i++){   ###>  loop through vars
        	                if($cvars[$i]['yaml_param']==$line_array['param_name']){   ###>  look for matching parameters
/* <<=>> */				$line_array['param_var']=$cvars[$i]['var'].' }}';
                	                $var_found=true;   ###>  If we find a match
					break;
				}
			}
		}
		if(is_array($thevar)){
	        	if($cvars[$i]['param_value']==$new_val){   ###> lets see if the parameter values are the same.  The same is interpreted as common, like auth_type or service account file etc.  
					$this->_message_handler_('I'," Custom var for parameter in array array =[".$cvars[$i]['yaml_param']." = [".$cvars[$i]['param_value']."]","DEBUG: Found custom var in array array =["
					.$cvars[$i]['yaml_param']." = [".$cvars[$i]['param_value']."]");

					$allow_dup=true;   ###>  We allow these to be duplicated.
			    if(!preg_match("'/$this->var_prefix/'",$val_temp)){   ###>  This variable doesn't have the wanted prefix.
						$new_val=$this->var_prefix.$var_temp;   ###>  The prefix is added.
			    }else{
				$new_var=$var_temp;   ###>  
			    }
			}

			if(($allow_dup) || (!in_array($new_var,$this->Vars))){
				$this->Vars[]=$new_var;   ###> The variable is not in Vars yet. These variables were not read from customized vars.  Making sure duplicates are intentional.
			}else{
				$new_var=$this->_rotate_var_($new_var,$this->Vars);
				$this->Vars[]=$new_var;   ###> The variable is not in Vars yet. These variables were not read from customized vars.  Making sure duplicates are intentional.
			}
			$line_array['param_'.$this->param_count] = array ('param_name' => "$param_name",'param_value' => "var=$new_var");
		}else{		
			$line_array['param_'.$this->param_count] = array ('param_name' => "$param_name",'param_value' => "$param_dac_value");
		}
		return $line_array;
	}
    }
    


    public function _assemble_play_from_array_($array){
	$name_defined=false;
	$play=false;
	for($i=0;$i<count($array);$i++){
		
		foreach($array[$i] as $key => $value){
			if($key=='param_name'){
				if($name_defined){
					$play.=$task;
				}
				$task=$array[$i]['leading_space'].$value."\n";  ###>  The name line was not split, but it may have additional lead spacing
				$name_defined=true;
			}elseif(preg_match('/param_[0-9]/', $key)){
				$param_=$array[$i][$key];
				if(preg_match('/var=/',$array[$i][$key]['param_value'])){ 
					$var=str_replace('var=','',$param_['param_value']); 
					$task .= $array[$i]['leading_space'] . $param_['yaml_param'].': {{ '.$var." }}\n";
				}else{
					$task .= $array[$i]['leading_space'] . $param_['yaml_name'].': '.$param_['var_name']."\n";
				}
			}
//			$this->_write_vars_file_($array[$i]['var_name'].': '.$
		}
	}
	$play.=$task;
	$this->rewble_yaml_example=$play;
	return $play;
    }

    public function _write_vars_file_($yaml_str,$_my_vars_file){   ###>  One variable at a time
	
	if(!preg_match("'/$this->my_vars_dir/'",$_my_vars_file)){  ###>
		if(is_dir($this->my_vars_dir)){
			$this->my_vars_file=$this->my_vars_dir.$_my_vars_file; ###> 
		}
		
	}else{
		$this->my_vars_file=$_my_vars_file;
	}
	$write_handle=fopen($this->my_vars_file,'w+');
	if(!fwrite($write_handle,$yaml_str)){
		// error message
		$this->_message_handler_('E',"There was a problem writing vars to the file=[$this->my_vars_file]","DEBUG: There was a problem writing vars to the file=[$this->my_vars_file] error");
	}
	fclose($write_handle);
    }


    public function _rotate_var_($var,$V){
	$c=0;
	while(in_array($var,$V)){
		$var=$var.$c;
		$c++;
	}
	return $var;
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

    public function _identify_module_($mod_value){
//	if($this->_identify_collection_($col_input)){
		$M=$mod_value;
        	switch ($M) {
	            case (is_int(intval($M - 1))):
			$M=intval($M - 1);
			if($this->collection_modules[$M]!=''){
				$this->module_number=intval($M);
				$this->module=$this->collection_modules[$this->module_number];
				$this->collection=$this->ansible_collections[$this->collection_number];
				$this->_message_handler_('I',"Module identified as [$this->module].","DEBUG: Collection sent to _identify_collection_ value passed=[$this->module]");

			}else{
				$this->module=false;
				$this->module_number=false;
				$this->_message_handler_('E',"Module not found in active collection. Please provide the number from the list.", "DEBUG: failed to locate module=[$M] in collection=[$this->collection");
	                        $this->_show_collection_index_();

			}
			break;
        	    case is_string($M):
			if(in_array($M,$this->collection_modules)){
				$this->module_name=$M;
				
			}else{
				$this->module=false;
				$this->module_number=false;
				$this->_message_handler_('E',"Module not found in active collection. Please provide the number from the list.", "DEBUG: failed to locate module=[$M] in collection=[$this->collection");
	                        $this->_show_collection_index_();
			}

			break;
		}
	}
  //  }
}

?>
