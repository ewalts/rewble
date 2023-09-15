<?PHP

function count_leading_spaces($str) {  ###> Using this to count yaml statement leading spaces.
    if(mb_ereg('^\p{Zs}+', $str, $out)===false) ###> if this does not 
        return 0;
    return mb_strlen($out[0]);
}

function determine_line_content($full_line_from_web){
	if(!$leading_spaces=count_leading_spaces($full_line_from_web)){	
		$leading_spaces=0;
	} 
	$l=$full_line_from_web  ###>  Full individual line no processing before now
	if(trim($l)==''){  ###> is this a blank line
		$blank_line=true;   ###>
		$play.=$l;   ###> keep the blank line
	}else{
		$blank_line=false;  
		switch: 
		if(preg_match('/\:/', $l)){
			$p=explode(':',$l);

		}
	
	        if(preg_match('/\{\{/',$p[1])){
                	$ov=explode('{{',$l);
	                $orig_var=str_replace('}}',$ov[1]);
        	}
	        if(preg_match('/^Example/', $l)){
        	}elseif(preg_match('/-\ name:/', $l)){
                	$play.=$l."\n";
	        }elseif(preg_match('/-\ /', $l)){
        	        $play.=$p[0].":\n";
	        }elseif(preg_match('/\:/', $l)){
        	        $p=explode(':',$l);
                	if($p[1]!=''){

			}
		}
	}
}
function is_common_var($before_colon_str){  ###>  This function is going to see if this is a standard parameter.
	
}
function var_value($after_colon_str){
	$tail=$after_colon_str;
	$new_var="$vpfx".trim(str_replace('- ','',$p[0]));
                        if(!in_array($new_var,$V)){
                                $vars.=$new_var.': '.$p[1]."\n";
                                $play.=$p[0].": {{ $new_var }} \n";
                                $V[]=$new_var;
                        }else{
                                $new_var=$new_var.'_'.str_replace(' ','',$p[1]);
                                $vars.=$new_var.': '.str_replace(' ','',$p[1])."\n";
                                $play.=$p[0].": {{ $new_var }} \n";
                                $V[]=$new_var;
                        }
                }else{
                        $play.=$p[0].":\n";
                }

        }else{
                $play.=$l."\n";
        }
}

}
function manage_vars($after_colon_str){

}
?>
