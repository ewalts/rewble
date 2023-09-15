<?PHP

	$pad=0;
	foreach( $rewble->collection_modules[$rewble->collection] as $key => $module){
		if(strlen($module) > $pad){    ###> if the active anchor length is longer than the current pad value,  
                        $pad=strlen("#[$key] - $module");   ###>  the pad value becomes the active anchor length
                }


	foreach( $rewble->collection_modules[$rewble->collection] as $key => $module){         ###>  Print the array with key value to be selected later.
		
                $cmc++;  $up2=false;  //if($cmc==2){  $cmc=0;  $up2="\n";  }

		if(($key<100)&&($key>9)){ $add=1; }elseif($key<10){ $add=2; }else{ $add=0; }

                echo "#[$key] - ".str_pad($module $pad + $add);

		if($cmc==2){  $cmc=0; echo "\n";  }

        }


       for($i=0;$i<count($cls);$i++){  ###>  This loop pre-action counts the leading spaces of each value searching for the longest string.
                if(strlen($cls[$i]['anchor']) > $pad){    ###> if the active anchor length is longer than the current pad value,  
                        $pad=strlen($cls[$i]['anchor']);   ###>  the pad value becomes the active anchor length
                }
        }
        $c=0;  ###>  This counter allows three columns, 123, return, 123, return
                //print_r($cls);
        for($i=0;$i<count($cls);$i++){  ###>  This is 
                if(($i<100)&&($i>9)){ $add=1; }elseif($i<10){ $add=2; }else{ $add=0; }  ###>  Justify for diget length 
                $txt_content.="#[$i] - ".str_pad($cls[$i]['anchor'], $pad + $add )." ";  ###>  Add each line to text output

                // $html_content.="&nbsp;[$i] = ".str_pad($ha[$i]['anchor'], $pad + $add, '&nbsp;' )." ";  ###> Add each line to html output
                $add=0;  ###>  This can likely be omitted, but sets the diget justification 
                $c++;
                if($c==3){ $txt_content.="\n";  $c=0; }
        }

?>
