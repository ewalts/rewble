<?PHP

class read_to_arrays extends rewble {

    public function __parse_statement($task_name,$statement){
	
	###>  This function receives the complete yaml line from the dom document, and creates array including, the task name
	###>   leading space value, paramater name, original value
	###>  We will substitute common vars if we have them on file, gcp_cred_file etc.
		
        switch ($str) {  ###>  Input to

            case(preg_match('/^Example/',$str)?true:false):
                break;    ###> Drop this line
            case(preg_match('/-\ name:/',$str)?true:false):  ### >  This is the primary title of the task
		
                $p=explode(':',$str);
                $title=trim($p[1]);
                $this->play_info_array($p[1],1,$p[0],$p[1]);
                return "This found - name\n";
                break;
            case(preg_match('/\{\{/',$str)?true:false):
                $unchanged.=$str[$i]."\n";
                $ov=explode('{{',$str[$i]);
                $orig_var=str_replace('}}','',$ov[1]);
        
                return ;
                break;
        //                        $ov=explode('{{',$str);
        //                      $orig_var=str_replace('}}',$ov[1]);
        }

    }

} 

?>
