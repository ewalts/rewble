<?PHP


class rewbin_mailer extends rewbin{

    public function ewmailer ($mail_to, $CC_Addr, $subject, $from_name, $reply_address, $text_message, $html_insert, $attachments){

        $eol="\n";
        $MIMEboundary=md5(time()).rand(1000,9999);

        $headers.="MIME-Version: 1.0".$eol;
        $headers.= "From: $from_name <$reply_address>".$eol;
        $headers.= "Reply-to:  $from_name <$reply_address>".$eol;
        $headers.= "Return-Path: $from_name <$reply_address>".$eol;
      /*  if($mail_to=''){
                die('email address was empty');
        }else{
                die("$mail_to");
        }
*/
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
