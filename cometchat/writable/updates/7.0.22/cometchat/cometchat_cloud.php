<?php

/**
 * getCometChatCloudDockedLayoutCode
 * Return cloud docked layout html code
 * @param (type) no param
 * @return (string) footer code
*/
function getCometChatCloudDockedLayoutCode() {
	global $cc_clientid;
	global $cc_base;


	if(!empty($cc_base)) {
		/* FUTURE: Add footer code in footer section just before </body> tag  */
		add_action( 'wp_footer', wp_enqueue_script( 'cc_base', plugin_dir_url( __DIR__ ).'js/scripttag.js' ), 1 );
   		wp_add_inline_script( 'cc_base', 'var cc_base = '.$cc_base.';' );
	}

	wp_enqueue_style("cc_corecss", "//fast.cometondemand.net/".$cc_clientid."x_x".substr(md5($cc_clientid),0,5).".css");
	wp_enqueue_script("cc_corejs", "//fast.cometondemand.net/".$cc_clientid."x_x".substr(md5($cc_clientid),0,5).".js");

}

/**
 * getCometChatShortCode
 * @param mixed $atts = width, height, layout, groupid, groupsonly
 * @return shortcode
 */
function getCometChatShortCode($atts){
	global $cc_clientid
;	global $cc_base;

    extract(shortcode_atts(
    	array(
		    'width' => 400,
		    'height' => 420,
		    'layout' => 'embedded',
		    'groupid' => 0,
		    'groupsonly' => 0
    	), $atts)
	);

    $site_url = get_site_url();
    $cc_dir_name = getCometChatDirectoryName();

    if(!empty($groupsonly)){
        $groupsonly = 1;
    }

    if($layout == 'docked'){
    	wp_enqueue_style("cc_corecss", "//fast.cometondemand.net/".$cc_clientid."x_x".substr(md5($cc_clientid),0,5).".css");
		wp_enqueue_script("cc_corejs", "//fast.cometondemand.net/".$cc_clientid."x_x".substr(md5($cc_clientid),0,6).".js");
		/** Force enabled CometChat Docked Layout (6) in cc_corejs **/
    } else{

    	wp_enqueue_script( 'cc_shortcodejs', '//fast.cometondemand.net/'.$cc_clientid."x_x".substr(md5($cc_clientid),0,5).'x_xcorex_xembedcode.js' );

    	wp_enqueue_script( 'cc_shortcode', plugin_dir_url( __DIR__ ).'js/scripttag.js' );
   		wp_add_inline_script( 'cc_shortcode', 'var iframeObj = {};iframeObj.module="synergy";iframeObj.style="min-height:420px;min-width:350px;";iframeObj.width="'.$width.'px";iframeObj.height="'.$height.'px";iframeObj.src="//'.$cc_clientid.'.cometondemand.net/cometchat_embedded.php?crid='.$groupid.'&chatroomsonly='.$groupsonly.'";if(typeof(addEmbedIframe)=="function"){addEmbedIframe(iframeObj);}' );

        return '
	        <div id="cometchat_embed_synergy_container" style="width:'.$width.'px;height:'.$height.'px;max-width:100%;border:1px solid #CCCCCC;border-radius:5px;overflow:hidden;"</div>';
    }
}

/**
 * cometchatUserDetails
 * Return cc_base for user login
 * @param (type) no param
*/
/**
 * cometchatUserDetails
 * Return cc_base for user login
 * @param (type) no param
*/
function cometchatUserDetails() {
	global $cc_base;
	global $current_user;
	global $role,$user_info;

	$link = $avatar = $user_id = $user_name = $userRole = $friends = '';

	if(is_user_logged_in()) {
		$user_id = $current_user->ID;
		$user_name = $current_user->user_login;
		$display_name = $current_user->display_name;
		$role = wp_get_current_user()->roles[0];

		preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', get_avatar($user_id), $matches);
		$avatar = $matches[1];
		if(function_exists('bp_loggedin_user_domain')) {
			$link = bp_loggedin_user_domain();
		}else {
			$link = get_edit_user_link($user_id);
		}
		$user_info = array(
			"id"	=> $user_id,
			"n"		=> $user_name,
			"dn"	=> $display_name,
			"a"		=> $avatar,
			"l"		=> $link,
			'role'	=> $role
		);
		$cc_base = json_encode($user_info);
	}
}

/**
 * addCometChatFriends
 * Return add friends to cometchat table
 * @param (type) no param
*/
function addCometChatFriends() {
	global $cc_clientid;
	global $current_user;
	$user_id = $current_user->ID;

	if(function_exists('bp_get_friend_ids')) {

		$friends = bp_get_friend_ids($user_id);
		$friends_data = array("id"=>$user_id,"f"=>$friends);
		$friends_ids = json_encode($friends_data);
		$site_url = get_site_url();
		$protocol = parse_url($site_url);
		$request_url  = $protocol['scheme'].'://'.$cc_clientid.'.cometondemand.net/cometchat_update.php';

		if(function_exists('curl_init')){
            $result = wp_remote_post($request_url, array(
                    'method' => 'POST',
                    'body' => 'userinfo='.$friends_ids
                )
            );
		}
	}
}

/**
 * createGroupInCometChat
 * Return create group
 * @param (type) no param
*/
function createGroupInCometChat() {
	global $cc_clientid;
	global $current_user;
	$user_id = $current_user->ID;

	if(bp_is_active( 'groups' )) {
		$group_ids =  groups_get_user_groups( bp_loggedin_user_id() );

		if(!empty($_REQUEST['group_id'])){
			$groupid = $_REQUEST['group_id'];
		}
		foreach( $group_ids["groups"] as $id ) {
			$group = groups_get_group( array( 'group_id' => $id) );
			if($_REQUEST['group_id'] == $group->id){
				$groupname = $group->name;
			}
		}
		$groupDetails = array(
			"userid"		=> $user_id,
			"groupid"		=> $groupid,
			"groupname"		=> $groupname,
			"action"		=> 'creategroup'
		);
		$groupInfo = json_encode($groupDetails);
		$site_url = get_site_url();
		$protocol = parse_url($site_url);
		$request_url  = $protocol['scheme'].'://'.$cc_clientid.'.cometondemand.net/cometchat_update.php';

		if(function_exists('curl_init')){
            $result = wp_remote_post($request_url, array(
                    'method' => 'POST',
                    'body' => 'groupinfo='.$groupInfo
                )
            );
		}
	}
}

/**
 * deleteGroupFromCometChat
 * Return delete group
 * @param (type) no param
*/
function deleteGroupFromCometChat() {
	global $cc_clientid;
	global $current_user;
	$user_id = $current_user->ID;

	if(bp_is_active( 'groups' )) {

		if(!empty($_REQUEST['group-id'])){
			$groupid = $_REQUEST['group-id'];
		}
		$groupDetails = array(
			"userid"		=> $user_id,
			"groupid"	=> $groupid,
			"action"	=> 'deletegroup'
		);
		$groupInfo = json_encode($groupDetails);
		$site_url = get_site_url();
		$protocol = parse_url($site_url);
		$request_url  = $protocol['scheme'].'://'.$cc_clientid.'.cometondemand.net/cometchat_update.php';

		if(function_exists('curl_init')){
            $result = wp_remote_post($request_url, array(
                    'method' => 'POST',
                    'body' => 'groupinfo='.$groupInfo
                )
            );
		}
	}
}

add_action('wp_head', 'getCometChatCloudDockedLayoutCode');
add_action('init','cometchatUserDetails');
add_shortcode('cometchat', 'getCometChatShortCode');

if(function_exists('bp_is_active')) {
	add_action('init','addCometChatFriends');
	add_action( 'groups_group_create_complete',  'createGroupInCometChat' );
	add_action( 'groups_delete_group',  'deleteGroupFromCometChat' );
}

?>
