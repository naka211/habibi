<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

function themeslist() {
	$themes = array();

	if ($handle = opendir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'layouts')) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && is_dir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.$file) && file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'cometchat.css')) {
				$themes[] = $file;
			}
		}
		closedir($handle);
	}


	return $themes;
}

function configeditor ($config) {
	global $dbh;
	global $client;
	global $writable;
	$insertvalues = '';
	$key_type;
    if (!empty($client)) {
        $bad_keys = array('DEV_MODE','ERROR_LOGGING','CROSS_DOMAIN','enablecustomphp');
        $config = array_diff_key($config,array_flip($bad_keys));
    }
	foreach ($config as $name => $value) {
        if($name == strtoupper($name)){
			$key_type = 0;
		}else if(!is_array($value)){
			$key_type = 1;
		}else{
			$key_type = 2;
			$value = serialize($value);
		}
		$insertvalues .= ("('".mysqli_real_escape_string($dbh,$name)."', '".mysqli_real_escape_string($dbh,$value)."', {$key_type}),");
	}
	$insertvalues = rtrim($insertvalues,',');
	if(!empty($insertvalues)){
		$sql = ("replace into `cometchat_settings` (`setting_key`,`value`, `key_type`) values ".$insertvalues);
		$query = mysqli_query($dbh,$sql);
	}
	removeCachedSettings($client.'settings');
	if (is_dir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.$writable)){
		clearcache(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.$writable);
	}
	if(function_exists('purgecache')) {
		purgecache($client);
	}
}

function cc_mail( $to, $subject, $message, $headers, $attachments = array() ) {
    if ( ! is_array( $attachments ) ) {
        $attachments = explode( "\n", str_replace( "\r\n", "\n", $attachments ) );
    }
    global $phpmailer;

    if ( ! ( $phpmailer instanceof PHPMailer ) ) {
        if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."mail".DIRECTORY_SEPARATOR."class-phpmailer.php")){
            include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."mail".DIRECTORY_SEPARATOR."class-phpmailer.php");
            include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR."mail".DIRECTORY_SEPARATOR."class-smtp.php");
        }
        $phpmailer = new PHPMailer( true );
    }
    $cc = $bcc = $reply_to = array();
    if ( empty( $headers ) ) {
        $headers = array();
    } else {
        if ( !is_array( $headers ) ) {
            $tempheaders = explode( "\n", str_replace( "\r\n", "\n", $headers ) );
        } else {
            $tempheaders = $headers;
        }
        $headers = array();
        if ( !empty( $tempheaders ) ) {
            foreach ( (array) $tempheaders as $header ) {
                if ( strpos($header, ':') === false ) {
                    if ( false !== stripos( $header, 'boundary=' ) ) {
                        $parts = preg_split('/boundary=/i', trim( $header ) );
                        $boundary = trim( str_replace( array( "'", '"' ), '', $parts[1] ) );
                    }
                    continue;
                }
                list( $name, $content ) = explode( ':', trim( $header ), 2 );
                $name    = trim( $name    );
                $content = trim( $content );

                switch ( strtolower( $name ) ) {
                    case 'from':
                    $bracket_pos = strpos( $content, '<' );
                    if ( $bracket_pos !== false ) {
                        if ( $bracket_pos > 0 ) {
                            $from_name = substr( $content, 0, $bracket_pos - 1 );
                            $from_name = str_replace( '"', '', $from_name );
                            $from_name = trim( $from_name );
                        }

                        $from_email = substr( $content, $bracket_pos + 1 );
                        $from_email = str_replace( '>', '', $from_email );
                        $from_email = trim( $from_email );
                    } elseif ( '' !== trim( $content ) ) {
                        $from_email = trim( $content );
                    }
                    break;
                    case 'content-type':
                    if ( strpos( $content, ';' ) !== false ) {
                        list( $type, $charset_content ) = explode( ';', $content );
                        $content_type = trim( $type );
                        if ( false !== stripos( $charset_content, 'charset=' ) ) {
                            $charset = trim( str_replace( array( 'charset=', '"' ), '', $charset_content ) );
                        } elseif ( false !== stripos( $charset_content, 'boundary=' ) ) {
                            $boundary = trim( str_replace( array( 'BOUNDARY=', 'boundary=', '"' ), '', $charset_content ) );
                            $charset = '';
                        }

                    } elseif ( '' !== trim( $content ) ) {
                        $content_type = trim( $content );
                    }
                    break;
                    case 'cc':
                    $cc = array_merge( (array) $cc, explode( ',', $content ) );
                    break;
                    case 'bcc':
                    $bcc = array_merge( (array) $bcc, explode( ',', $content ) );
                    break;
                    case 'reply-to':
                    $reply_to = array_merge( (array) $reply_to, explode( ',', $content ) );
                    break;
                    default:
                    $headers[trim( $name )] = trim( $content );
                    break;
                }
            }
        }
    }

    $phpmailer->ClearAllRecipients();
    $phpmailer->ClearAttachments();
    $phpmailer->ClearCustomHeaders();
    $phpmailer->ClearReplyTos();

    if ( !isset( $from_name ) )
        $from_name = 'bounce ';

    $phpmailer->setFrom( $from_email, $from_name, false );
    if ( !is_array( $to ) )
        $to = explode( ',', $to );
    $phpmailer->Subject = $subject;
    $phpmailer->Body    = $message;
    $address_headers = compact( 'to', 'cc', 'bcc', 'reply_to' );
    foreach ( $address_headers as $address_header => $addresses ) {
        if ( empty( $addresses ) ) {
            continue;
        }

        foreach ( (array) $addresses as $address ) {
            try {
                $recipient_name = '';
                if ( preg_match( '/(.*)<(.+)>/', $address, $matches ) ) {
                    if ( count( $matches ) == 3 ) {
                        $recipient_name = $matches[1];
                        $address        = $matches[2];
                    }
                }

                switch ( $address_header ) {
                    case 'to':
                    $phpmailer->addAddress( $address, $recipient_name );
                    break;
                    case 'cc':
                    $phpmailer->addCc( $address, $recipient_name );
                    break;
                    case 'bcc':
                    $phpmailer->addBcc( $address, $recipient_name );
                    break;
                    case 'reply_to':
                    $phpmailer->addReplyTo( $address, $recipient_name );
                    break;
                }
            } catch ( phpmailerException $e ) {
                continue;
            }
        }
    }

    $phpmailer->IsMail();

    if ( !isset( $content_type ) )
        $content_type = 'text/plain';

    $phpmailer->ContentType = $content_type;

    if ( 'text/html' == $content_type )
        $phpmailer->IsHTML( true );

    if ( !empty( $headers ) ) {
        foreach ( (array) $headers as $name => $content ) {
            $phpmailer->AddCustomHeader( sprintf( '%1$s: %2$s', $name, $content ) );
        }

        if ( false !== stripos( $content_type, 'multipart' ) && ! empty($boundary) )
            $phpmailer->AddCustomHeader( sprintf( "Content-Type: %s;\n\t boundary=\"%s\"", $content_type, $boundary ) );
    }

    if ( !empty( $attachments ) ) {
        foreach ( $attachments as $attachment ) {
            try {
                $phpmailer->AddAttachment($attachment);
            } catch ( phpmailerException $e ) {
                continue;
            }
        }
    }

    try {
        return $phpmailer->Send();
    } catch ( phpmailerException $e ) {
        $mail_error_data = compact( 'to', 'subject', 'message', 'headers', 'attachments' );
        $mail_error_data['phpmailer_exception_code'] = $e->getCode();
        return false;
    }
}
function languageeditor($lang){
	global $dbh;
	global $client;
	global $writable;
	if(empty($lang['lang_key']) || empty($lang['name']) || empty($lang['code']) || empty($lang['type'])){
		return 0;
	}
	$sql = ("insert into `cometchat_languages` set `lang_key` = '".mysqli_real_escape_string($dbh,$lang['lang_key'])."', `lang_text` = '".mysqli_real_escape_string($dbh,$lang['lang_text'])."', `code` = '".mysqli_real_escape_string($dbh,$lang['code'])."', `type` = '".mysqli_real_escape_string($dbh,$lang['type'])."', `name` = '".mysqli_real_escape_string($dbh,$lang['name'])."' on duplicate key update `lang_key` = '".mysqli_real_escape_string($dbh,$lang['lang_key'])."', `lang_text` = '".mysqli_real_escape_string($dbh,$lang['lang_text'])."', `code` = '".mysqli_real_escape_string($dbh,$lang['code'])."', `type` = '".mysqli_real_escape_string($dbh,$lang['type'])."', `name` = '".mysqli_real_escape_string($dbh,$lang['name'])."'");
	$query = mysqli_query($dbh,$sql);
	removeCachedSettings($client.'cometchat_language');
	if (is_dir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.$writable)){
		clearcache(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.$writable);
	}
}

function coloreditor($data,$color_name){
	global $dbh;
	global $client;
	global $writable;
	$insertvalues = '';
	foreach ($data as $name => $value) {
		$insertvalues .= ("('".mysqli_real_escape_string($dbh,$name)."', '".mysqli_real_escape_string($dbh,$value)."', '".mysqli_real_escape_string($dbh,$color_name)."'),");
	}
	$insertvalues = rtrim($insertvalues,',');
	if(!empty($insertvalues)){
		$sql = ("replace into `cometchat_colors` (`color_key`,`color_value`, `color`) values ".$insertvalues);
		$query = mysqli_query($dbh,$sql);
	}
	removeCachedSettings($client.'cometchat_color');
	if (is_dir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.$writable)){
		clearcache(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.$writable);
	}
}

function createslug($title,$rand = false) {
	$slug = preg_replace("/[^a-zA-Z0-9]/", "", $title);
	if ($rand) { $slug .= rand(0,9999); }
	return strtolower($slug);
}

function extension($filename) {
	return pathinfo($filename, PATHINFO_EXTENSION);
}

function deletedirectory($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!deleteDirectory($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!deleteDirectory($dir . "/" . $item)) return false;
            };
        }
    return rmdir($dir);
}

function pushMobileAnnouncement($zero,$sent,$message,$isAnnouncement = '0',$insertedid){
	global $userid;
	global $lang;

	if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."extensions".DIRECTORY_SEPARATOR."mobileapp".DIRECTORY_SEPARATOR."FireBasePushNotification.php")){
		include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."extensions".DIRECTORY_SEPARATOR."mobileapp".DIRECTORY_SEPARATOR."FireBasePushNotification.php");
		include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."extensions".DIRECTORY_SEPARATOR."mobileapp".DIRECTORY_SEPARATOR."config.php");

		$announcementpushchannel = '';

		if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR."announcements".DIRECTORY_SEPARATOR."config.php")){
			include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR."announcements".DIRECTORY_SEPARATOR."config.php");
			include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR."announcements".DIRECTORY_SEPARATOR."lang.php");
		}

		if(!empty($isAnnouncement)){
			$rawMessage = array("m" => $announcements_language['announces'].": ".$message, "sent" => $sent, "id" => $insertedid);
		}

		$pushnotifier = new FireBasePushNotification($firebaseauthserverkey,array('app_title' => $app_title));
		$pushnotifier->sendNotification($announcementpushchannel, $rawMessage, 0, 1);
	}
}

function datify($ts) {
	if(!ctype_digit($ts)) {
		$ts = strtotime($ts);
	}
	$diff = time() - $ts;
	$date = date('l, F j, Y',$ts).' at '.date('g:ia',$ts);
	if($diff == 0) {
		return array ('now',$date);
	} elseif($diff > 0) {
		$day_diff = floor($diff / 86400);
		if($day_diff == 0) {
			if($diff < 60) return array('just now',$date);
			if($diff < 120) return array ('1 minute ago',$date);
			if($diff < 3600) return array (floor($diff / 60) . ' minutes ago',$date);
			if($diff < 7200) return array ('1 hour ago',$date);
			if($diff < 86400) return array (floor($diff / 3600) . ' hours ago',$date);
		}
		if($day_diff == 1) { return array ('Yesterday at '.date('g:ia',$ts),$date); }

		if (date('Y') == date('Y',$ts)) {
			return array (date('F jS',$ts).' at '.date('g:ia',$ts),$date);
		} else {
			return array (date('F jS, Y',$ts).' at '.date('g:ia',$ts),$date);
		}
	} else {
	return array (date('F jS, Y',$ts).' at '.date('g:ia',$ts),$date);
	}
}
function deleteFolderContent($path,$exclude = array(),$emptyfolder = 0) {
    $exclude = array_merge($exclude,array('.', '..'));
    if ( is_dir($path) === true ){
        $files = @array_diff(@scandir($path), $exclude);
        foreach ($files as $file){
            deleteFolderContent(realpath($path) . DIRECTORY_SEPARATOR . $file,array(),1);
        }
        if($emptyfolder) {
            return @rmdir($path);
        }
    } else if ( is_file($path) === true ){
        return @unlink($path);
    } else {
        return false;
    }
}

function clearcachejscss($directory, $recursive = true, $listDirs = false, $listFiles = true, $exclude = '') {
    global $writable;
    $path = dirname(dirname(__FILE__)).'/writable/'.$writable;
    deleteFolderContent($path,array("index.html"),0);
}

function cc_version_compare($new, $old){
  $p = '#(\.0+)+($|-|\s)#';
  $new = preg_replace($p, '', $new);
  $old = preg_replace($p, '', $old);
  return version_compare($new, $old);
}
?>
