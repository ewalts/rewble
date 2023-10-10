<?PHP

class create extends rewbin {

###> Playbook output
    public function _new_playbook_(){
	$this->_message_handler_('I',"Invoke _new_playbook_","DEBUG: Invoke _new_playboook_");
	if(!$this->playbook_name){
	    $role_response= readline("Type a name for the new playbook: ");
	    $dir_response= readline("Location of playbook_home default=[$this->playbooks_home] Enter or type new location: ");
	    if($dir_rsponse!=''){
		if(is_dir($dir_response)){
		    $this->playbook_home=$dir_response;
		}else{
		    
		}
	    }
	}
    }
###>  Identify roles related to active collection
    public function _roles_in_inventory_(){
	
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



###>  Create role will assist with role creation and the addition to an existing play.
    public function _creat_role_(){
	$role_response= readline("Type a name for the role: "); 
	$cmd="ansible-role init $role_response";
		
    }
   
}
