<?PHP /*
##########################################################################################################################################
###>  This event logging function was created and maintained by Richard>> Eric <<Walts and the rewbin.org project.
#		https://github.com/rewbin.org/utiliy_funks/
#	
###>  If you are experiencing issues check the README.md and define your speciic global vars in $HOME/.rewbin/config.php
#
###>	Contact the updater at support@rewbin.org <<
#
########################################################################################################################################## */

class rewbin  {

    public $ADMIN_EMAIL;   ###>  
    public $REWBIN_HOME;   ###>  
    public $rewbin_home;   ###>  
    public $rewbin_logs;   ###>

  ###>  Message handling vars --------------------------------------------------------------------------------------------

    public $debug;    ###>  These flags default to false, true can be defined in vars or inline, or changed on the inc/vars.php file. 
    public $verbose;  ###>  
    public $silent;    ###>  
    public $log_file;   ###>    default is false flag, file can be defined in vars or inline, define full path, defualt setting is ${exec_dir}/logs/rewbin.log
    public $debug_log;   ###>  


    public function _set_vars_from_array_($_my_vars_array){
	$c=0;
	foreach ($_my_vars_array as $key => $value){
        	$this->$key = $value;
	}
	$this->_message_handler_('I',"","DEBUG:[".__FILE__.":".__LINE__."]  the");

	//if($this->debug){ 
		$debug_array_txt='';
		foreach($_my_vars_array as $key => $val){
			$debug_array_txt.= "array_[key=$key][value=$val] &,this->".$key."= ".$this->$key."\n";
		}
	//}
	$Msg="Calling _set_vars_from_array_ ";
	$dMsg="DEBUG:[".__FILE__.":".__LINE__."]  ".$Msg.$debug_array_txt;	
	$this->_message_handler_('I', $Msg, $dMsg);
    }


    public function _set_message_flags_($_debug,$_silent,$_verbose,$_log_file){ ###> These flags, default: false, will be changed for class if defined in config or inline
        if($_debug){  $this->debug=true;  }else{  $this->debug=false;  }  ###> 
        if($_verbose){  $this->verbose=true;  }else{  $this->verbose=false;  }  ###> 
        if($_silent){  $this->silent=true;  }else{  $this->silent=false;  }  ###>
        if($_log_file){  $this->log_file=$_log_file; $this->rewbin_log_file=$_log_file; }else{  $this->log_file=false; $this->rewbin_log_file;  }   ###> 
    }   ###>  

    public function _kill_($type){   ###> 
	
	$dMsg="DEBUG:[".__FILE__.":".__LINE__."]  process received a terminate request.  This could be because q was pressed to escape from a menu. Or the configuration is missing required information to complete a task.";
	$Msg="Process received a terminate request.";
	$this->_message_handler_( $type,$Msg,$dMsg);
        die("\n\n     PROCESS TERMINATED!!\n\n");
    }

    public function _message_handler_($type,$Msg,$dMsg){
        if($type=='E'){    $Msg="ERROR: ". $Msg;   }else{  $Msg="INFO: ". $Msg;  }
	if($type!='null'){
                $this->_rewbin_logit_( $Msg ,$this->log_file );
        }
	if($this->verbose){ echo $Msg . "\n";} // else{ echo "NOT VERBOSE\n";}
	if($this->debug){ $this->_rewbin_logit_($dMsg, $this->debug_log); if($this->verbose){ echo $dMsg."\n";} }
    }

    public function _count_leading_spaces_($str) {  ###> Using this to count yaml statement leading spaces.
        if(mb_ereg('^\p{Zs}+', $str, $out)===false) ###> if this does not 
                return 0;
        return mb_strlen($out[0]);
    }

    public function _rewbin_logit_ ( $message,$file ) { 		// $message is just text to be logged. you can change the file name.
	if($file==''){ $file = 'rewbin_logit.log';}
        $rewbin_log_file=$this->rewbin_logs."/".$file;
	$date_time=date('Y-m-d H:i:s');
	$message="[$date_time]: $message\n";				// Format the primary message with time and date stamp.
	#
	if(!is_dir($this->rewbin_logs)){
		die( "###############################  >>>\n\n\n <<<<<< NO DIRECTORY FOUND!!!>>>>>>>@@@@@@@@3#######################>>>\n\n\n");
		if(!mkdir($this->rewbin_logs,0700,true)){			// Checking for the log directory at $HOME/.rewbin/logs
			$this->_message_handler_('E',"FAILED to create [$this->rewbin_logs] directory.","DEBUG:[".__FILE__.":".__LINE__."]  The directory was not created for logs.");
		}elseif(is_dir($this->rewbin_logs)){
			$log_file=fopen($rewbin_log_file,'a');                  // the file is present, lets write the event message
	                if(!fwrite($log_file, $message)){                       // if writing should fail send error to stdout
        	                echo "[$date_time]:ERROR: LOGGING FAILED could not create log file! [$rewbin_log_file]\n";
                	        $return=1;
			}

		}
	}else{
	
	#
	###> 								// Attempt to write the event
	#
		if($rewbin_log_file==''){  					// if the log file is not defined send error to stdout
			echo "[$date_time]:ERROR:LOGGING FAILED could not create log file! [$rewbin_log_file]\n";
			echo $message; 						// include the message to stdout
		}else{  
			$log_file=fopen($rewbin_log_file,'a'); 			// the file is present, lets write the event message
			if(!fwrite($log_file, $message)){  			// if writing should fail send error to stdout
				echo "[$date_time]:ERROR: LOGGING FAILED could not create log file! [$rewbin_log_file]\n";
				$return=1;
			}
			fclose($log_file);  				// closing open log file
		}
	}	
    }

    public function ewmailer ($mail_to, $CC_Addr, $subject, $from_name, $reply_address, $text_message, $html_insert, $attachments){

        $eol="\n";
        $MIMEboundary=md5(time()).rand(1000,9999);

        $headers.="MIME-Version: 1.0".$eol;
        $headers.= "From: $from_name <$reply_address>".$eol;
        $headers.= "Reply-to:  $from_name <$reply_address>".$eol;
        $headers.= "Return-Path: $from_name <$reply_address>".$eol;
        if($mail_to=''){
                die('email address was empty');
        }else{
                die("$mail_to");
        }

        if(preg_match('/;/',$mail_to)){
                $mail_to=explode(';',$mail_to);
                for($i=0;$i<count($mail_to);$i++){
                        $headers.="TO: <".$mail_to[$i].">".$eol;
                }
        }else{
                $headers.="TO: <".$mail_to.">".$eol;
        }
        if($CC_Addr!=''){
                if(preg_match('/;/',$CC_Addr)){
                        $CC_Addr=explode(';',$CC_Addr);
                        for($i=0;$i<count($CC_Addr);$i++){
                                $headers.="Cc: <".$CC_Addr[$i].">".$eol;
                        }
                }else{
                        $headers.="Cc: <".$CC_Addr.">".$eol;
                }
        }
       // $headers.= "BCc: $Bcc_Addr".$eol;
        $headers.="X-Mailer: EW-Mailer-2.7 PHP v".phpversion()."$eol";
        $headers.="X-Priority: 3(Normal)$eol";
        $headers.="Importance: Normal$eol";
        $headers.='Content-type: multipart/mixed; boundary="'.$MIMEboundary.'"'.$eol.$eol;
        //$usrMailBody = preg_replace( "/$eol?/", "\n", $text_message );

        $mailBody = "This is a multi-part message in MIME format.".$eol.$eol;
        $MIMEboundaryA=md5(time()).rand(1000,9999);
        $mailBody.="--$MIMEboundary".$eol
        .'Content-type: multipart/alternative; boundary="'.$MIMEboundaryA.'"'.$eol.$eol
        ."--".$MIMEboundaryA.$eol
        ."Content-Type: text/plain; charset=iso-8859-1".$eol
        ."Content-Transfer-Encoding: 8bit".$eol.$eol
        .$text_message.$eol
        ."--".$MIMEboundaryA.$eol
        ."Content-Type: text/html; charset=iso-8859-1".$eol
        ."Content-Transfer-Encoding: 8bit".$eol.$eol
        .'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'
        .'<body><table><tr><td>'
        .$html_insert
       .'</td></tr></table></body></html>'."$eol"
        ."--".$MIMEboundaryA."--".$eol.$eol;
        if($attachments!=''){
        //      $attach=explode(
        }
        $mailBody.="--".$MIMEboundary."--".$eol.$eol;
//      echo $headers.$mailBody;

        mail("", "$subject", "$mailBody", $headers);
    }


}
?>
