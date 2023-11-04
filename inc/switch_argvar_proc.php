<?PHP
##################################################################################################
###> New x php -> .php  -> Richard Eric Walts as eric ---> 2021-03-1_15:53:49 init <<<
##################################################################################################
##########################have-you-seen-rewbin###############################################
###> New x php -> cli_process_switch.php -> Richard Eric Walts as eric ---> 2008-01-10_02:48:17  <<<
##########################have-you-seen-rewbin###############################################
###> Snippet provided by Richard Eric Walts; provide file to be read as argument.

###>	This file processes the request information provided.  It defines the variables that will be passed to search and query functions 
###>	as well as the assembly output and customization functions. 
###>  Some of the variables defined here can be defined elsewhere, but that portion is still being developed while this was created.
###>  Everything is maintained here as well, so it can be used independently, as short script rather than the full version with custom code management.



$HELP='
This is the help information for this funciton
	Type -h or --help to print this help screen.

	If no options are provided default operation runs ####>>>.
	
	-h   --help		Print help
	-i   --inventory	Show local inventory. Requires defining the directory in the configuration.
	-lc  --list collections Lists available collections.   ###>   This is default behavior if no options are provided. <###
	-c   --collection	Collection to search
	-lm  --list-modules	List the modules in a collection, this requires -c||--collection ${COLLECTION}. Default behavior if only -c 
	-m   --module		Module to pull yaml example
	-o   --out-file		File to write yaml, if included the vars file will be written along side.
	-q   --quiet		No stdout to terminal.  This excludes warning messages.
	-l   --log-file		Define a log file to log warning messages.
	-v   --verbose		Print success fail information,
	-d   --debug		Print extended messages including settings, defined variables and arrays throughout the run process unless quiet is set. then these messages will held to the end
';
$reqCollText='
This action requires -c --colleciton ${COLLECTION}. 
	Please provide the collection to be searched.
';


if(empty($argv[1])){
	$rewble->list_collections=true;	
	$dMsg="DEBUG: List collections set to true"; $message_D[]=$dMsg; if($rewble->verbose){ echo $dMsg."\n"; }	
}

for($i=0;$i<count($argv);$i++){			###>  echo "DEBUG $argv[$i]\n";    ###>  Testing code;  >>>  Process switches and argument vars
	if(preg_match('/^-/',$argv[$i])){	
		switch ($argv[$i]) {
                        case '-v':
                        case '--verbose':
                                $rewble->verbose=true;                          ##> echo "DEBUG verbose messages true.\n";  ###>Testing code  >>>  Verbose messaging includes additional messages printed and/or logged
                                 $rewble->_message_handler_('I',"verbose flag has been set -v||--verbose","DEBUG: verbose flag has been set -v||--verbose");
                                break;

			case '-h':	
			case '--help':		
				$rewble->print_help=true; 				###>     Define true for var print help, the print help section is below
				break;

			case '-d':
			case '--debug':
				$rewble->debug=true;
				$rewble->_message_handler_('I',"","DEBUG: _debug has been set to true, requested with switch -d||--debug.");
				break;

                        case '-s':
                        case '--silent':
                                $rewble->silent=true;
                                $rewble->require_out_file=true;                          ##> echo "DEBUG in quiet \n";  ###>Testing code  >>>  Out to file has been requested, defining var $out_file
                                $rewble->_=true;                          ###> echo "DEBUG module required mod=[$mod] and out_file=[$out_file]\n";  ###> We actually will ignore this
				echo"\n\n    SILENT MODE REQUESTED with -s|--silent.\n   Required parameters are passed in the command, or in a custom_vars.php file in vars/. Such as vars/my_silent_gcp_instance_vars.php.\n\n";
                                $rewble->_message_handler_('I',"Silent mode has been flagged. This will log messages and information.",
					"DEBUG: Silent mode has been flagged. This will log messages and information. Requested information will be in the outfile.");
				$rewble->require_log_file=true; 
                                break;
			
			case '-c':
			case '--collection':
				$rewble->_message_handler_('I',"Argument switch: request collection value=[".$argv[$i + 1]."]","DEBUG: sending to identify_collection");
				if($rewble->_identify_collection_($argv[$i +1])){	 ###>  Switch for collection received define var $coll
				        $rewble->_message_handler_('I',"Argument switch: collection successfully set to $rewble->collection","DEBUG: collection has been defined as $rewble->collection");
					$rewble->list_collections=false;
				}
				break;

			case '-m':
			case '--module':
				$rewble->_require_collection_();
				if($rewble->_identify_module_($argv[$i +1])){     ###>  echo "DEBUG switch for module received mod=[$mod]\n collection is required var coll=[$coll]\n";  ###>Testing code//   next argument should be module name
					 ###>  Set flag for collection required, this will notify user if it wasn't provided
				        $rewble->_message_handler_('I',"module defined [$rewble->module]","DEBUG: Module request made with -m||--module. Var _module=[$rewble->module] equire collection has been triggered and set to true by module -m|--module");
					$user_module_response=$rewble->module;
					$rewble->list_collection=false;
				}else{
					$rewble->list_collection=true;
				}
				break;

			case '-i':
			case '--inventory': 
				$rewble->view_inventory=true;	
//				$rewble->_require_inventory_dir_();			###> echo "DEBUG in list-modu\n";  ###>Testing code  >> Request to list modules requires collection
                                $rewble->_message_handler_('I',"Call to list inventory","DEBUG: initial request for inventory from main switch.");

				break;

			case '-f':
                        case '--out-file':
				$rewble->out_file=$argv[$i+1];				##> echo "DEBUG in out-file out_file=[$out_file]\n";  ###>Testing code  >>>  Out to file has been requested, defining var $out_file
                                $rewble->require_module=true;				###> echo "DEBUG module required mod=[$mod]\n";  ###>Testing code \\ this will obviously require the module
                                $rewble->_message_handler_('I',"Output to file set, value _out_file=[$rewble->out_file]","Output to file set, value _out_file=[$rewble->out_file]");
				break;

                        case '-v':
                        case '--verbose':
				$rewble->verbose=true;
                                $rewble->require_out_file=true;                          ##> echo "DEBUG in quiet \n";  ###>Testing code  >>>  Out to file has been requested, defining var $out_file
                                $rewble->require_module=true;                          ###> echo "DEBUG module required mod=[$mod] and out_file=[$out_file]\n";  ###> We actually will ignore this
                                //$rewble->_message_handler_('I',"",""; 
                                break;

			case '-lc':
			case '--list-collections':
				$rewble->list_collections=true;
                                $rewble->_message_handler_('I',"","DEBUG: List collections set to true");
				break;

                        case '-l':
                        case '--log-file':
                                $rewble->log_messages=true;
                                $rewble->log_file=$argv[$i+1];                          ##> echo "DEBUG in quiet \n";  ###>Testing code  >>>  Out to file has been requested, defining var $out_file
                                //$rewble->require_module=true;                          ###> echo "DEBUG module required mod=[$mod] and out_file=[$out_file]\n";  ###> We actually will ignore this
                                $rewble->_message_handler_('I',"log-messages has been set to true","DEBUG: log-messages has been set to true, log file has been provided and set to $rewble->log_file");
                                break;

			default:
				$rewble->list_collections=true;
				break;

		}
	}
}


/*
if($rewble->require_collection){	###> echo "DEBUG inside require collection\n";  ###>Testing code//	If collection has been required for the task requested, determine it was supplied
	if(!$coll){	###> echo "DEBUG inside colleciton not defined\n";  ###>Testing code//		Check that collection was provided and var $coll was defined for process
		$rewble->print_help=true;								###>	Flag the help information to be printed as well
		echo $reqCollText;								###>	Print the text pointing out that a collection was required for this command.
	}else{
								echo "DEBUG in else rom coll false\n";    ###>Testing code//	
								echo "DEBUG coll=[$coll]";    ###>Testing code//	
	}
}
*/
if($rewble->print_help){						
	die($HELP);
}


?>
