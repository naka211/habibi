 <?php

 function CometChatCloudAPI($route) {
 	global $client, $cms, $userid, $login_url, $logout_url, $dm, $sdk, $mobileapp, $protocol, $guestsMode, $currentversion;
 	if($route == 'app_login') {
 		$siteLoginLogoutURLs = array(
 			'socialengine' 		=> array('login' => '/login/', 'logout' => '/logout/'),
 			'socialenginecloud' => array('login' => '/sign-in/','logout' => '/sign-out/'),
 			'forumsnet' 		=> array( 'login' => '/login', 'logout' => '/logout'),
 			'vanilla' 			=> array('login' => '/entry/signin/','logout' => '/entry/signout/'),
 			'ning' 				=> array('login' => '/main/authorization/signIn?target=/my/profile','logout' => '/main/authorization/signOut'),
 			'dolphin' 			=> array('login' => '/member.php','logout' => '/logout.php?action=member_logout'),
 			'sharetribe' 		=> array('login' => '/login/','logout' => '/logout/'),
 			'wordpress' 		=> array('login' => '/wp-login.php','logout' => '/wp-login.php?loggedout=true'),
 			'drupal'			=> array('login' => '/user/login/','logout' => '/user/logout/'),
 			'phpfox-neutron' 	=> array('login' => '/user/login/','logout' => '/user/logout/'),
 			'coldfusion' 		=> array('login' => '/members/login.cfm','logout' => '/members/logout.cfm'),
 			'datingscript' 		=> array('login' => '/users/login','logout' => '/users/logout'),
 			'pgdatingpro' 		=> array('login' => '/users/login_form','logout' => '/users/logout')
			 );

 		if(empty($login_url) && !empty($siteLoginLogoutURLs[$cms])){
 			$login_url = CC_SITE_URL.$siteLoginLogoutURLs[$cms]['login'];
 		}
 		if(empty($logout_url) && !empty($siteLoginLogoutURLs[$cms])){
 			$logout_url  = CC_SITE_URL.$siteLoginLogoutURLs[$cms]['logout'];
 		}

 		if(isset($_POST['platform'])) {
 			if(!empty($_POST['platform']) && ($_POST['platform'] == 'brandedapp' || $_POST['platform'] == 'brandeddm' || $_POST['platform'] == 'whitelabeledapp' || $_POST['platform'] == 'whitelabeleddm')) {
 				if($_POST['platform'] == 'whitelabeledapp') {
 					if($mobileapp != 1) {
 						$api_response['failed'] = array("cod" => "-2","message" => "Your subscription does not support mobileapp.");
 					}
 				}
 				if($_POST['platform'] == 'whitelabeleddm') {
 					if($dm != 1) {
 						$api_response['failed'] = array("cod" => "-2","message" => "Your subscription for Desktop Messenger isn't active. Please check the same. If you think this is a mistake please contact us at support@cometchat.com");
 					}
 				}
 			}else {
 				$api_response['failed'] = array("message" => "Access denied.");
 			}
 			if(empty($api_response)){
 				if(!empty($login_url)) {
 					$api_response['success'] = array("redirect_url" => $login_url, "signout_url" => $logout_url, "type_protocol" => $protocol, "use_ccauth" => USE_CCAUTH, "guest_mode" => $guestsMode, "version" => $currentversion);
 				}else{
 					$api_response['failed'] = array("error_code" => "2", "error_message" => "Please contact support@cometchat.com for more information.");
 				}
 			}
 		}else {
 			header('Location: //'.$login_url);
 		}
 	}else {
 		$apikey_header = cometchat_getApi();
 		$apikey = $client."x".md5($client.'dcnoammeetdcnhoattemoc');
 		if($apikey_header == $apikey) {
 			if(!empty($route)){
 				if(isset($_POST['platform'])) {
 					if(!empty($_POST['platform'])) {
 						if($_POST['platform'] == 'a' || $_POST['platform'] == 'i') {
 							if($sdk != 1) {
 								$api_response['failed'] = array("cod" => "-2","message" => "Your subscription does not support sdk.");
 							}
 						}else {
 							$api_response['failed'] = array("message" => "Access denied.");
 						}
 					}else {
 						$api_response['failed'] = array("message" => "Access denied.");
 					}
 					if(!empty($api_response)){
 						echo json_encode($api_response);
 						exit;
 					}
 				}
 				$api_response = array();
 				$failed_id = array();
 				$username = $newpass = $password =  $avatar = $link = $displayname = $uid = NULL;

 				switch ($route) {

					case 'createUser':
									$dataArray = array();
									/*
									$UID : Primary Id Of User
									@integer/@alphanumeric
									* Mandetory
									*/
									$dataArray['UID']			= !empty($_POST['UID']) ? sql_real_escape_string(trim($_POST['UID'])) : false;

									/*
									$name : User Name or User Display Name
									@String
									*/
									$dataArray['name'] 			= !empty($_POST['name']) ? sql_real_escape_string(trim($_POST['name'])) : NULL;

									/*
									$avatarURL : User Avatar URL
									@String
									*/
									$dataArray['avatarURL'] 	= !empty($_POST['avatarURL']) ? sql_real_escape_string(trim($_POST['avatarURL'])) : NULL;

									/*
									$profileURL : User Profile URL
									@String
									*/
									$dataArray['profileURL'] 	= !empty($_POST['profileURL']) ? sql_real_escape_string(trim($_POST['profileURL'])) : NULL;

									/*
									$role : User Role
									@String
									*/
									$dataArray['role'] 			= !empty($_POST['role']) ? sql_real_escape_string(trim($_POST['role'])) : "default";
									$api_response 				= createUser($dataArray);
									break;

					case 'updateUser':
										$dataArray = array();
										/*
										$UID : Primary Id Of User
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['UID'] 			= !empty($_POST['UID']) ? sql_real_escape_string(trim($_POST['UID'])) : false;

										/*
										$name : User Name or User Display Name
										@String
										*/
										$dataArray['name'] 			= !empty($_POST['name']) ? sql_real_escape_string(trim($_POST['name'])) : NULL;

										/*
										$avatarURL : User Avatar URL
										@String
										*/
										$dataArray['avatarURL'] 	= !empty($_POST['avatarURL']) ? sql_real_escape_string(trim($_POST['avatarURL'])) : NULL;

										/*
										$profileURL : User Profile URL
										@String
										*/
										$dataArray['profileURL']	= !empty($_POST['profileURL']) ? sql_real_escape_string(trim($_POST['profileURL'])) : NULL;

										/*
										$role : User Role
										@String
										*/
										$dataArray['role'] 			= !empty($_POST['role']) ? sql_real_escape_string(trim($_POST['role'])) : "default";
										$api_response 				= updateUser($dataArray);

									break;

					case 'deleteUser':
										$dataArray = array();
										/*
										$UID : Primary Id Of User
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['UID'] 		= !empty($_POST['UID']) ? sql_real_escape_string(trim($_POST['UID'])) : false;
										$api_response 			= deleteUser($dataArray);
									break;

					case 'addFriends':
										$dataArray = array();
										/*
										$UID : Primary Id Of User
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['UID'] 			= !empty($_POST['UID']) ? sql_real_escape_string(trim($_POST['UID'])) : false;

										/*
										$friendsUID : Primary Id Of Users
										@integer/@alphanumeric, Comma Separated Values
										* Mandetory
										* Comma Separated Values (Example : $friendsUID = '1,2,3,4,5')
										*/
										$dataArray['friendsUID'] 	= !empty($_POST['friendsUID']) ? sql_real_escape_string(trim($_POST['friendsUID'])) : false;;

										/*
										$clearExisting : 1 or 0
										@boolean
										*/
										$dataArray['clearExisting'] 	= !empty($_POST['clearExisting']) ? sql_real_escape_string(trim($_POST['clearExisting'])) : 0;
										$api_response 	= addFriends($dataArray);
									break;

					case 'deleteFriends':
										$dataArray = array();
										/*
										$UID : Primary Id Of User
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['UID'] 			= !empty($_POST['UID']) ? sql_real_escape_string(trim($_POST['UID'])) : false;

										/*
										$friendsUID : Firends Id
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['friendsUID'] 	= !empty($_POST['friendsUID']) ? sql_real_escape_string(trim($_POST['friendsUID'])) : false;
										$api_response 	= deleteFriends($dataArray);
									break;

					case 'listUsers':
										$dataArray = array();
										/*
										$offset : Page No
										@integer/@alphanumeric
										*/
										$dataArray['offset'] 		= !empty($_POST['offset']) ? sql_real_escape_string(trim($_POST['offset'])) : 1;

										/*
										$limit : Record Limit
										@integer/@alphanumeric
										*/
										$dataArray['limit'] 		= !empty($_POST['limit']) && $_POST['limit'] > 100 ? sql_real_escape_string(trim($_POST['limit'])) : 100;
										$api_response 	= listUsers($dataArray);
									break;

					case 'blockUser':
										$dataArray = array();
										/*
										$senderUID : Primary Id Of User (Sender)
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['senderUID'] 	= !empty($_POST['senderUID']) ? sql_real_escape_string(trim($_POST['senderUID'])) : false;

										/*
										$receiverUID : Primary Id Of User (Receiver)
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['receiverUID'] 	= !empty($_POST['receiverUID']) ? sql_real_escape_string(trim($_POST['receiverUID'])) : false;
										$api_response 				= blockUser($dataArray);
									break;

					case 'unblockUser':
										$dataArray = array();
										/*
										$senderUID : Primary Id Of User (Sender)
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['senderUID'] 	= !empty($_POST['senderUID']) ? sql_real_escape_string(trim($_POST['senderUID'])) : false;

										/*
										$receiverUID : Primary Id Of User (Receiver)
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['receiverUID'] 	= !empty($_POST['receiverUID']) ? sql_real_escape_string(trim($_POST['receiverUID'])) : false;
										$api_response 				= unblockUser($dataArray);

									break;
						case 'updateCredits':
										$dataArray = array();
										/*
										UID : Primary Id Of User
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['UID'] 			= !empty($_POST['UID']) ? sql_real_escape_string(trim($_POST['UID'])) : false;
										/*
										credits : Credit Points Assign to user
										@integer
										* Mandetory
										*/
										$dataArray['credits'] 		= !empty($_POST['credits']) ? sql_real_escape_string(trim($_POST['credits'])) : false;
										$api_response 				= updateCredit($dataArray);

									break;

						case 'getCredits':
											$dataArray = array();
										/*
										UID : Primary Id Of User
										@integer/@alphanumeric
										* Mandetory
										*/
										$dataArray['UID'] 			= !empty($_POST['UID']) ? sql_real_escape_string(trim($_POST['UID'])) : false;
										$api_response 				= getCredit($dataArray);
									break;

						}
					}
				}else {
					$api_response['failed'] = array('status' => '1010','message' => 'Invalid API KEY');
				}
			}
			if(!empty($api_response)){
				header('Content-Type: application/json');
				echo json_encode($api_response);
				exit();
			}
		}

		if(!empty($route)) {
			CometChatCloudAPI($route);
		}
		exit;
		?>
