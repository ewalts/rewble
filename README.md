# rewble
---
Authored by: Richard Eric Walts


 ## Infrastructure/Service Deployment Automation Project PHP/Yaml/Ansible. Written for Linux/Unix systems.


 WARING: NOT COMPLETE - ALPHA - WORK IN PROGRESS


## A tool to quickly search resources from the cli and manage playbooks.



## HELP information for this function


	Type -h or --help to print this help screen.

	If no options are provided default operation runs ####>>>.
	
	-h   --help		Print help
	-lc  --list collections Lists available collections.   ###>   This is default behavior if no options are provided. <###
	-c   --collection	Collection to search
	-lm  --list-modules	List the modules in a collection, this requires -c||--collection ${COLLECTION}. Default behavior if only -c 
	-m   --module		Module to pull yaml example
	-o   --out-file		File to write yaml, if included the vars file will be written along side.
	-q   --quiet		No stdout to terminal.  This excludes warning messages.
	-l   --log-file		Define a log file to log warning messages.
	-v   --verbose		Print success fail information,
	-d   --debug		Print extended messages including settings, defined variables and arrays throughout the run process unless quiet is set. then these messages will held to the end


EXAMPLE: 

    $ sudo ln -s $(PATH)/rewble_create_play.php /usr/bin/rewble_cp

    $ rewble_cp -c awx.awx


Ansible docs currently listing 47 modlues for awx.awx. All 47 modules will be numerically listed in a moment.


```
#[1] - ad_hoc_command              #[2] - ad_hoc_command_cancel       
#[3] - ad_hoc_command_wait         #[4] - application                 
#[5] - bulk_host_create            #[6] - bulk_job_launch             
#[7] - controller_meta             #[8] - credential                  
#[9] - credential_input_source     #[10] - credential_type             
#[11] - execution_environment      #[12] - export                     
#[13] - group                      #[14] - host                       
#[15] - import                     #[16] - instance                   
#[17] - instance_group             #[18] - inventory                  
#[19] - inventory_source           #[20] - inventory_source_update    
#[21] - job_cancel                 #[22] - job_launch                 
#[23] - job_list                   #[24] - job_template               
#[25] - job_wait                   #[26] - label                      
#[27] - license                    #[28] - notification_template      
#[29] - organization               #[30] - project                    
#[31] - project_update             #[32] - role                       
#[33] - schedule                   #[34] - settings                   
#[35] - subscriptions              #[36] - team                       
#[37] - token                      #[38] - user                       
#[39] - workflow_approval          #[40] - workflow_job_template      
#[41] - workflow_job_template_node #[42] - workflow_launch            
#[43] - workflow_node_wait         #[44] - controller inventory       
#[45] - controller_api lookup      #[46] - schedule_rrule lookup      
#[47] - schedule_rruleset lookup   



Type the number of the module to get the yaml displayed.[1-47]: 1



    Pulling module [ad_hoc_command].
  From ansible collection: awx.awx


Examples

    - name: Launch an Ad Hoc Command waiting for it to finish
      ad_hoc_command:
        inventory: Demo Inventory
        credential: Demo Credential
        module_name: command
        module_args: echo I <3 Ansible
        wait: true
```


The menu supports both numerical and text string selections. 

You can jump straight to a collection with [-c|--collection] and [-m|--module].

A collection must be provided for module to function.

---



