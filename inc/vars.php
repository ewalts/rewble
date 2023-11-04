<?PHP
################################################################################################
###> New x php -> inc/vars.php  -> Richard Eric Walts as eric ---> 2022-02-24_09:39:20 init <<<
################################################################################################
#
  ###>  Do not modify vars in this section  --------------------------------------------------------------------------------------------------------------------------------------
$_execute_path=$_SERVER['PHP_SELF'];
 $_list_collections=true;   ###> default false
  $_collection=false;   ###>  default false 
   $_module=false;    ###> default false, this becomes the name of the module to be fetched 
    $_verbose=false;    ###> default false 
    $_print_help=false;   ###>  default false
   $_require_collection=false;    ###> default false
  $_inc_dir = getcwd();
   $_rewble_dirs=array('vars','conf','data','logs','inc');
    $_collection_index_url='https://docs.ansible.com/ansible/latest/collections/index.html';  ###> Primary file, to list available collections and the url to their module index pages
   $_module_index_url_prefix="https://docs.ansible.com/ansible/latest/collections/";
  $_my_vars_dir= $__dir__ . '/vars';
 $_rewbin_home=$__dir__;
$_rewbin_logs=$__dir__ .'/logs';
  ###> --^ Do not modify vars above ^---------------------------------------------------------------------------------------------------------------------------------------------
############################################################################################################
  ###>  CUSTOM VARS - Vars in this section can be customized  ###############################################
#############################################################################################################
$_admin_email='eric.walts@richardwalts.com';
 $_var_prefix='rew_';   ###>  This is your customized variable prefix.  
  $_local_inventory_dir="~/wrk/dev-ops/ansible/rewbin/playbooks";
   $_log_messages=false;   ###>  default false
    $_silent=false;  ###>  Silent is unattended.  All variables for collection and module are required. Standard logging is default, debug logging can be included. 
    $_debug=false;  ###>  This value can be set here default is False
   $_log_file= 'rewble.log';
  $_debug_log='rewble_debug.log';
 $_collection_index_url='https://docs.ansible.com/ansible/latest/collections/index.html';  ###> Primary file, to list available collections and the url to their module index pages
$_module_index_url_prefix="https://docs.ansible.com/ansible/latest/collections/";
#
  ###>  End Custom vars ----------------------------------------------------------------------------------------------------------------------------------------------------------
#
$_rewbin_log_file=$_rewbin_logs.'/'.$_log_file;
$REWBIN_HOME=$_rewbin_home;
$ADMIN_EMAIL=$_admin_email;
#
  ###>  Do not modify the array directly. ----------------------------------------------------------------------------------------------------------------------------------------
$_rewble_dirs=array('vars','conf','data','logs','inc');
$_my_vars_array= array (
     "execute_path"  =>  "$_execute_path",
     "list_collections"  =>  "$_list_collections",
     "local_inventory_dir" => "$_local_inventory_dir",
     "collection"  =>  "$_collection",
     "module"  =>  "$_module",
     "verbose"  =>  "$_verbose",
     "print_help"  =>  "$_print_help",
     "require_collection"  =>  "$_require_collection",
     "inc_dir "  =>  "$_inc_dir ",
     "collection_index_url"  =>  "$_collection_index_url",
     "module_index_url_prefix"  =>  "$_module_index_url_prefix",
     "my_vars_dir"  =>  "$_my_vars_dir",
     "rewbin_home"  =>  "$_rewbin_home",
     "rewbin_logs"  =>  "$_rewbin_logs",
     "rewbin_log_file"  =>  "$_rewbin_log_file",
     "admin_email"  =>  "$_admin_email",
     "var_prefix"  =>  "$_var_prefix",
     "log_messages"  =>  "$_log_messages",
     "silent"  =>  "$_silent",
     "debug"  =>  "$_debug",
     "log_file"  =>  "$_log_file",
     "debug_log"  =>  "$_debug_log",
     "collection_index_url"  =>  "$_collection_index_url",
     "module_index_url_prefix"  =>  "$_module_index_url_prefix",
     "REWBIN_HOME"  =>  "$REWBIN_HOME",
     "ADMIN_EMAIL"  =>  "$ADMIN_EMAIL"

);
//print_r($_my_vars_array);






###>  NOTE:  Any variables defined in the vars directory overwrite any variables in this file.  
###>  Command configurations, inline switches, etc, overwrite previously defined variables as well.

###>	This was the original load process.  
###>    This approach required the _vars.php file to be in the form a valid PHP array to work properly.  
###>	The new strategy takes the PHP code out of the picture and reads a simple .csv file.
###>
###>	foreach(glob($__dir__ . '/vars/*_vars.php') as $inc_file){
###>		include_once($inc_file);
###>	}  

?>
