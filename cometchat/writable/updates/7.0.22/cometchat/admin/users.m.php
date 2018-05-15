<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) {echo 'NO DICE';exit;}

function index()
{
	global $body;
	$BASE_URL = BASE_URL;
	$ts = time();

	$query = sql_query('admin_users_count');
	$result = sql_fetch_assoc($query);
	$userscount = $result['total'];
	$range = 5;
	$limit = 100;
	$total_pages = ceil($userscount / $limit);
	$page  = empty($_GET["page"]) ? 1 : $_GET["page"];
	$page  = ($page > $total_pages) ? $total_pages : $page;
	$startlimit = ($page-1) * $limit;

	if($total_pages > $range){
        $start = ($page <= $range)?1:($page - $range);
        $end   = ($total_pages - $page >= $range)?($page+$range): $total_pages;
    }else{
        $start = 1;
        $end   = $total_pages;
    }

	$pagination = '<div class="pagination"><a href="?module=users&page='.($page-1).'">&laquo;</a>';
	for($i = $start; $i <= $end; $i++){
		$active = ($page == $i) ? 'class="active"' : '';
		$pagination .= '<a '.$active.' href="?module=users&page='.$i.'">'.$i.'</a>';
	}
	$pagination .= '<a href="?module=users&page='.($page+1).'">&raquo;</a></div>';
	if ($userscount<$limit) {
		$pagination = "";
	}
	$query = sql_query('admin_getUsers',array('start'=>$startlimit,'limit'=>$limit));
	if (defined('DEV_MODE') && DEV_MODE == '1') {
		echo sql_error($GLOBALS['dbh']);
	}

	$userlist = '';

	while ($users = sql_fetch_assoc($query)) {
		$username 	= $users['username'];
		$userid 	= $users['userid'];
		$uid 		= $users['uid'];
		$friends	= $users['friends'];
		$avatar		= empty($users['avatar']) ? BASE_URL."/admin/images/pixel.png" : $users['avatar'];

		$extra = '<td><a class="mamp-friend" data-toggle="modal" friends="'.$friends.'" id="add_friends_'.$userid.'" href="javascript:void();" data-target="#myModal" title="Map friends" style="color:black;"><i class="fa fa-lg fa-code"></i></a></td><td><a class="red" data-toggle="tooltip" title="" href="?module=users&action=deleteuser&userid='.$userid.'&ts='.$ts.'" data-original-title="Delete User"><i class="fa fa-lg fa-minus-circle"></i></a></td>';

		$userslist .= '<tr><td class="capitalize">'.$userid.'</td><td><img class="cometchat_avatarimage" src="'.$avatar.'"></td><td class="capitalize">'.$username.'</td><td>'.$uid.'<td><a class="edit-user"  id="edit_user_'.$userid.'" data-toggle="modal" href="javascript:void();" data-target="#editModal" title="Edit" style="color:black;"><i class="fa fa-lg fa-edit"></i></a></td>'.$extra.'</tr>';
	}

	$errormessage = '';
	if (!$userslist) {
		$errormessage = '<tr><td colspan="6">There are no users at the moment!</td></tr>';
	}

$body .= <<<EOD
<div class="row">
  <div class="col-sm-9 col-lg-9">
    <div class="card">
      <div class="card-header">
        Users
      </div>
      <div class="card-block">
		<table class="table" style="overflow: auto;">
		  <thead>
		    <tr>
		      <th width="10%">ID</th>
		      <th width="10%">Image</th>
		      <th width="30%">Name</th>
		      <th width="20%">UID</th>
		      <th width="5%">&nbsp;</th>
		      <th width="5%">&nbsp;</th>
		      <th width="5%">&nbsp;</th>
		    </tr>
		  </thead>
		  <tbody>
		    {$errormessage} {$userslist}
		  </tbody>
		</table>
		$pagination
    </div>
    </div>
  </div>
	<div class="col-sm-3 col-lg-3">
		<div class="row">
	  	 <div class="col-sm-12 col-lg-12">
		    <div class="card">
		      <div class="card-header">
		        Add New User
		         <h4><small>You can manually add a user to CometChat, or you can sync your existing user database using our <a href="https://docs.cometchat.com/web-sdk/user-management/" target="_blank" title="https://docs.cometchat.com/web-sdk/user-management/" rel="noreferrer noopener" class="josSif">On-the-fly User Creation</a> method or <a href="https://docs.cometchat.com/restful-api/user-management/" target="_blank" title="https://docs.cometchat.com/restful-api/user-management/" rel="noreferrer noopener" class="josSif">Restful APIs</a>.</small></h4>
		      </div>
		      <div class="card-block">
		        <form action="?module=users&action=addnewuser&ts={$ts}" method="post" >
		          <div class="form-group row">
		            <div class="col-md-12">
		              <label class="">Username <span style="color:red;font-size:15px;">*</span></label>
		              <input class="form-control" type="text" required="true" id="username" name="username" placeholder="Enter username">
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-12">
		              <label class="">Password <span style="color:red;font-size:15px;">*</span></label>
		              <input class="form-control" required="true" type="password" id="password" name="password" placeholder="Enter password">
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-12">
		              <label class="">Display Name &nbsp;&nbsp;&nbsp;<a style="color:black;" data-toggle="tooltip" title="If Display Name is empty, we will use the Username instead." href="javascript:void(0)"><i class="fa fa-question-circle"></i></a></label>
		              <input class="form-control" type="text" id="displayname" name="displayname" placeholder="Enter display name">
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-12">
		              <label class="">UID &nbsp;&nbsp;&nbsp;<a style="color:black;" data-toggle="tooltip" title="This field can be used to track the user's ID in your database." href="javascript:void(0)"><i class="fa fa-question-circle"></i></a></label>
		              <input class="form-control" type="text" id="uid" name="uid" placeholder="Enter UID">
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-12">
		              <label class="">Avatar Image URL</label>
		              <input class="form-control" type="text" id="avatar" name="avatar" placeholder="Enter avatar image url">
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-12">
		              <label class="">Profile Page URL</label>
		              <input class="form-control" type="text" id="link" name="link" placeholder="Enter profile page url">
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-12">
		              <label class="">User Role</label>
		              <input class="form-control" type="text" id="role" name="role" placeholder="Enter user role">
		            </div>
		          </div>

		          <div class="form-actions">
		            <input type="submit" value="Create User" class="btn btn-primary">
		          </div>
		        </form>
		      </div>
		    </div>
		  </div>
	</div>
	</div>
</div>
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Map Friends</h4>
        </div>
        <div class="modal-body col-sm-12">

		<div class="modal-body col-sm-12">
			<div class="row">
				<table class="table">
					<thead>
						<tr>
							<th width="10%">Friends</th>
							<th width="10%">Action</th>
						</tr>
					</thead>
					<tbody id="friendslist">
					</tbody>
				</table>
			</div>
			<div class="row">
				<div class="form-group row">
					<div class="col-md-12">
						<label for="company">Add friend:</label>
						<input onkeyup="ccAutoComplete(this)" type="text" class="form-control" userid="" id="susername" name="susername" required="true" autocomplete="off" placeholder="Search username">
						<div id="suggestions"></div>
					</div>
				</div>
				<div class="form-actions"></div>
			</div>
		</div>

        </div>
        <div class="modal-footer">
        </div>
      </div>

    </div>
  </div>
<!-- Modal -->
<!-- Modal -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit User</h4>
        </div>
        <div class="modal-body col-sm-12">

		<div class="modal-body col-sm-12">
			<div class="row" id="edit-interface">
				Hello Hi Testing.....
			</div>
		</div>

        </div>
        <div class="modal-footer">
        </div>
      </div>

    </div>
  </div>
<!-- Modal -->
<script type="text/javascript">
	function ccAutoComplete(inputbox){
		var ajax;
		var moderator = '';
		var userslist = '';
		$('#suggestions').html('');
		var userid = $("#susername").attr('userid');
		if(inputbox.value.trim().length > 1){
			if(ajax && ajax.readystate != 4){
	            ajax.abort();
	        }
	        ajax = $.ajax({
				type: "POST",
				url: "?module=users&action=ccautocomplete&ts={$ts}",
				data: {suggest: inputbox.value},
				success: function(data) {
					var h = 0;
					data.forEach(function(entry) {
						h = h + 35;
						addfriend = '<a style="font-size:16px;font-weight:bold;float:right;color:green;" data-toggle="tooltip" title="Add friend" href="?module=users&amp;action=addfriends&amp;friendid='+entry.userid+'&amp;userid='+userid+'&amp;ts={$ts}&amp;autosuggest=1"><i class="fa fa-lg fa-plus"></i></a>';
		                userslist += '<li class="suggestion_list"><span style="font-size:13px;float:left;margin-top:2px;margin-left:5px;">'+entry.username+'</span>'+addfriend+'<div style="clear:both"></div></li>';
					});
					if(h > 400){h = 400;}else {	h = h + 20;	}
					$('#suggestions').append(userslist).css("height",h+"px");
					$('[data-toggle="tooltip"]').tooltip();
	            },
				dataType: 'json'
			});
		}
	}

	function showFriends(userid,friends){
		if(userid != "" && friends != ""){
	       	$.ajax({
				type: "POST",
				url: "?module=users&action=getfriendsdetails&ts={$ts}",
				data: {friends: friends},
				success: function(data) {
					var UI = "";
					data.forEach(function(entry) {
						UI += '<tr><td class="capitalize">'+entry.username+'</td><td><a style="font-size:16px;font-weight:bold;float:left;color:red;" data-toggle="tooltip" title="Remove" href="?module=users&action=removefriend&friendid='+entry.userid+'&userid='+userid+'"><i class="fa fa-lg fa-minus-circle"></i></a></td></tr>';

					});
					if(UI == ''){
						UI = '<tr><td colspan="2">There are no friends!</td></tr>';
					}
					$('#friendslist').html(UI);
	            }
			});
		}else{
			$('#friendslist').html('<tr><td colspan="2">There are no friends!</td></tr>');
		}
	}

	$(function(){
		$(this).click(function(){
			$('#suggestions').html('').css("height","0px");;
		});
		$(".mamp-friend").click(function(){
			var id = $(this).attr("id");
			var friends = $(this).attr("friends");
			var res = id.split("_");
			var userid = res[res.length-1];
			$("#susername").val('');
			$("#susername").attr('userid',userid);
			showFriends(userid,friends);
		});

		$(".edit-user").click(function(){
			var id = $(this).attr("id");
			var friends = $(this).attr("edit");
			var res = id.split("_");
			var userid = res[res.length-1];
			if(userid != ''){
		       	$.ajax({
					type: "POST",
					url: "?module=users&action=edituser&ts={$ts}",
					data: {userid: userid},
					success: function(data) {
						$('#edit-interface').html(data);
		            }
				});
			}
		});

	});
</script>
EOD;
	template();
}

function edituser(){
	global $ts, $usertable_userid, $usertable_username, $usertable, $body;
	$userid 		= $_REQUEST['userid'];
	$query 			= sql_query('get_user_deatils_with_id',array('userid'=>$userid));
	$userDetails 	= sql_fetch_assoc($query);
	$username 		= $userDetails['username'];
	$displayname 	= $userDetails['displayname'];
	$avatar 		= $userDetails['avatar'];
	$link 			= $userDetails['link'];
	$role 			= $userDetails['role'];
echo <<<EOD
		<form action="?module=users&action=updateuser&ts={$ts}" method="post" enctype="multipart/form-data">
          <div class="form-group row">
            <div class="col-md-12">
              <label class="">Username</label>
              <input class="form-control" readonly type="text" required="true"id="username" name="username" value="$username" placeholder="Enter username name">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <label class="">Display Name</label>
              <input class="form-control" type="text" id="displayname" name="displayname" value="$displayname"  placeholder="Enter display name">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <label class="">New Password</label>
              <input class="form-control" type="password" id="newpassword" name="newpassword" value=""  placeholder="Enter new password">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <label class="">Avatar Image URL</label>
              <input class="form-control" type="text" id="avatar" name="avatar" value="$avatar" placeholder="Enter avatar image url">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <label class="">Profile Page URL</label>
              <input class="form-control" type="text" id="link" name="link" value="$link" placeholder="Enter profile page url">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-12">
              <label class="">User Role</label>
              <input class="form-control" type="text" id="role" name="role" value="$role" placeholder="Enter user role">
            </div>
          </div>
          <input type="hidden" value="$userid" name="userid" id="userid"/>
          <input type="hidden" value="1" name="admin" id="admin"/>
          <div class="form-actions">
            <input type="submit" value="Update" class="btn btn-primary">
          </div>
        </form>
EOD;
	exit();
}

function searchuser()
{
	global $ts, $usertable_userid, $usertable_username, $usertable, $body, $moderatorUserIDs;
	$username = $_REQUEST['susername'];
	$userslist = '<div style="height:500px;overflow:auto;overflow-x:hidden;"><table class="table"><thead><tr><th width="40%">Name</th><th>ID</th><th>&nbsp;</th></tr></thead><tbody>';

	if (empty($username)) {
		$username = 'Q293YXJkaWNlIGFza3MgdGhlIHF1ZXN0aW9uIC0gaXMgaXQgc2FmZT8NCkV4cGVkaWVuY3kgYXNrcyB0aGUgcXVlc3Rpb24gLSBpcyBpdCBwb2xpdGljPw0KVmFuaXR5IGFza3MgdGhlIHF1ZXN0aW9uIC0gaXMgaXQgcG9wdWxhcj8NCkJ1dCBjb25zY2llbmNlIGFza3MgdGhlIHF1ZXN0aW9uIC0gaXMgaXQgcmlnaHQ/DQpBbmQgdGhlcmUgY29tZXMgYSB0aW1lIHdoZW4gb25lIG11c3QgdGFrZSBhIHBvc2l0aW9uDQp0aGF0IGlzIG5laXRoZXIgc2FmZSwgbm9yIHBvbGl0aWMsIG5vciBwb3B1bGFyOw0KYnV0IG9uZSBtdXN0IHRha2UgaXQgYmVjYXVzZSBpdCBpcyByaWdodC4=';
	}
	$query = sql_query('admin_searchgrouplogs',array('username'=>sanitize_core($username), 'usertable_userid'=>$usertable_userid, 'usertable_username'=>$usertable_username, 'usertable'=>$usertable));

	while ($user = sql_fetch_assoc($query)) {
		if (function_exists('processName')) {
			$user['username'] = processName($user['username']);
		}
		$moderator = '<a style="font-size:16px;font-weight:bold;float:right;color:green;" data-toggle="tooltip" title="Make Moderator" href="?module=groups&amp;action=makemoderatorprocess&amp;susername='.$username.'&amp;moderatorid='.$user['id'].'&amp;ts={$ts}&amp;autosuggest=1"><i class="fa fa-plus"></i></a>';
		if (in_array($user['id'], $moderatorUserIDs)) {
			$moderator = '<a style="font-size:16px;font-weight:bold;float:right;color:red;" data-toggle="tooltip" title="Remove Moderator" href="?module=groups&amp;action=removemoderatorprocess&amp;susername='.$username.'&amp;moderatorid='.$user['id'].'&amp;ts={$ts}&amp;autosuggest=1"><i class="fa fa-close"></i></a>';
		}
		$userslist .= '<tr><td class="capitalize">'.$user['username'].'</td><td>'.$user['id'].'</td><td>'.$moderator.'</td></tr>';
	}
	$userslist .= '</tbody></table></div>';

echo $body = <<<EOD
	$userslist
EOD;

}

function ccautocomplete()
{
	global $ts, $usertable_userid, $usertable_username, $usertable, $navigation, $body, $moderatorUserIDs;
	$suggestions = array();

	if (!empty($_REQUEST['suggest'])) {
		$username = $_REQUEST['suggest'];
		$query = sql_query('admin_users',array('username'=>sanitize_core($username)));

		while ($user = sql_fetch_assoc($query)) {
			array_push($suggestions, $user);
		}
	}
	echo json_encode($suggestions);
}

function getfriendsdetails()
{
	global $ts, $usertable_userid, $usertable_username, $usertable, $body;
	$friends = $_REQUEST['friends'];
	$response = array();

	if (!empty($friends)) {
		$friends_array = explode(',', $friends);
		foreach ($friends_array as $key => $value) {
			$query = sql_query('get_user_deatils',array('uid'=>$value));
			$userDetails = sql_fetch_assoc($query);
			$userFriend = array('userid' => $userDetails['userid'],'username' => $userDetails['username']);
			$response[] = $userFriend;
		}
	}
	header('Content-Type: application/json');
	if (!empty($_GET['callback'])){
		echo $_GET['callback'].'('.json_encode($response).')';
	} else {
		echo json_encode($response);
	}
	exit();
}


function deleteuser()
{
	global $ts,$apikey;

	$url = "http:".BASE_URL."api/removeuser";
	if(isSecure()){
		$url = "https:".BASE_URL."api/removeuser";
	}
	$fields = array('userid' => $_GET['userid']);
	$fields_string = "";
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.($value).'&'; }
	$fields_string = rtrim($fields_string, '&');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
	curl_setopt($ch, CURLOPT_HTTPHEADER,array('api-key: '.$apikey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	$result = curl_exec($ch);
	if (empty($result)) {
	    die(curl_error($ch));
	}
	curl_close ($ch);
	$response = json_decode($result,true);

	if (array_key_exists("success", $response)) {
		$_SESSION['cometchat']['error'] = $response['success']['message'];
		header("Location: ?module=users&ts={$ts}");
		exit();
	}
	if (array_key_exists("failed", $response)) {
		$_SESSION['cometchat']['error'] = $response['failed']['message'];
		$_SESSION['cometchat']['type'] = 'alert';
		header("Location: ?module=users&ts={$ts}");
		exit();
	}
	header("Location: ?module=users&ts={$ts}");
}

function addnewuser()
{
	global $ts,$apikey;
	$fields = array(
		'username' 		=> $_REQUEST['username'],
		'displayname' 	=> $_REQUEST['displayname'],
		'password' 		=> $_REQUEST['password'],
		'uid' 			=> $_REQUEST['uid'],
		'avatar' 		=> $_REQUEST['avatar'],
		'link' 			=> $_REQUEST['link'],
		'role' 			=> $_REQUEST['role']
	);
	$url = "http:".BASE_URL."api/createuser";
	if(isSecure()){
		$url = "https:".BASE_URL."api/createuser";
	}
	$fields_string = '';
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.($value).'&'; }
	$fields_string = rtrim($fields_string, '&');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
	curl_setopt($ch,CURLOPT_HTTPHEADER,array('api-key: '.$apikey));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	$result = curl_exec($ch);
	if (empty($result)) {
	    die(curl_error($ch));
	}
	curl_close ($ch);
	$response = json_decode($result,true);
	if (array_key_exists("success", $response)) {
		$_SESSION['cometchat']['error'] = $response['success']['message'];
		header("Location: ?module=users&ts={$ts}");
		exit();
	}
	if (array_key_exists("failed", $response)) {
		$_SESSION['cometchat']['error'] = $response['failed']['message'];
		$_SESSION['cometchat']['type'] = 'alert';
		header("Location: ?module=users&ts={$ts}");
		exit();
	}
}

function updateuser()
{
	global $ts,$apikey;
	$fields = array(
		'username' 		=> $_POST['username'],
		'displayname' 	=> $_POST['displayname'],
		'password' 		=> $_POST['password'],
		'newpassword' 	=> $_POST['newpassword'],
		'userid' 		=> $_POST['userid'],
		'avatar' 		=> $_POST['avatar'],
		'link' 			=> $_POST['link'],
		'role' 			=> $_POST['role'],
		'admin' 		=> 1
	);
	$url = "http:".BASE_URL."api/updateuser";
	if(isSecure()){
		$url = "https:".BASE_URL."api/updateuser";
	}
	$fields_string = '';
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.($value).'&'; }
	$fields_string = rtrim($fields_string, '&');
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
	curl_setopt($ch,CURLOPT_HTTPHEADER,array('api-key: '.$apikey));
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	$result = curl_exec($ch);
	if (empty($result)) {
	    die(curl_error($ch));
	}
	curl_close ($ch);
	$response = json_decode($result,true);
	if (array_key_exists("success", $response)) {
		$_SESSION['cometchat']['error'] = $response['success']['message'];
		header("Location: ?module=users&ts={$ts}");
		exit();
	}
	if (array_key_exists("failed", $response)) {
		$_SESSION['cometchat']['error'] = $response['failed']['message'];
		$_SESSION['cometchat']['type'] = 'alert';
		header("Location: ?module=users&ts={$ts}");
		exit();
	}
}

function removefriend()
{
	global $ts,$apikey;
	$url = "http:".BASE_URL."api/removefriend";
	if(isSecure()){
		$url = "https:".BASE_URL."api/removefriend";
	}
	$fields = array('userid' => $_GET['userid'],'friends' => $_GET['friendid'],'isusersiteid' => 0);
	$fields_string = "";
	if (!empty($_GET['userid'])) {
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.($value).'&'; }
		$fields_string = rtrim($fields_string, '&');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('api-key: '.$apikey));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec($ch);
		if (empty($result)) {
		    die(curl_error($ch));
		}
		curl_close ($ch);
		$response = json_decode($result,true);
		if (array_key_exists("success", $response)) {
			$_SESSION['cometchat']['error'] = $response['success']['message'];
			header("Location: ?module=users&ts={$ts}");
			exit();
		}
		if (array_key_exists("failed", $response)) {
			$_SESSION['cometchat']['error'] = $response['failed']['message'];
			$_SESSION['cometchat']['type'] = 'alert';
			header("Location: ?module=users&ts={$ts}");
			exit();
		}
	}
	header("Location: ?module=users&ts={$ts}");
}

function addfriends(){
	global $ts,$apikey;
	$url = "http:".BASE_URL."api/addfriend";
	if(isSecure()){
		$url = "https:".BASE_URL."api/addfriend";
	}
	$fields = array('userid' => $_GET['userid'],'friends' => $_GET['friendid'],'isusersiteid' => 0);
	$fields_string = "";
	if (!empty($_GET['userid'])) {
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.($value).'&'; }
		$fields_string = rtrim($fields_string, '&');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('api-key: '.$apikey));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec($ch);
		if (empty($result)) {
		    die(curl_error($ch));
		}
		curl_close ($ch);
		$response = json_decode($result,true);
		if (array_key_exists("success", $response)) {
			$_SESSION['cometchat']['error'] = $response['success']['message'];
			header("Location: ?module=users&ts={$ts}");
			exit();
		}
		if (array_key_exists("failed", $response)) {
			$_SESSION['cometchat']['error'] = $response['failed']['message'];
			$_SESSION['cometchat']['type'] = 'alert';
			header("Location: ?module=users&ts={$ts}");
			exit();
		}
	}
	header("Location: ?module=users&ts={$ts}");
}
