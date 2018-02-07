//JavaScript init() Le Duc Cuong. 2016 - phone: +84 0933488924 - skype: lecuong2585
function gotoLink(url){
    location.href = url;
}
$(document).ready(function(){
    $("#email").blur(function(){
		if(!$("#email").val()){
			$("#email").addClass('error');
			return false;
		}
        checkEMAIL($("#email").val());
    });
    // MY PHOTO
    $('#myImage').on('change',function(){
    	$('#frm_uploadPhoto').ajaxForm({
    		//target:'#list_myphoto',
    		beforeSubmit:function(e){
    			$('#loader').show();
    		},
    		success:function(html){
    			$('#loader').hide();
                $('#f_Transfer').modal('hide');
                $('#list_myphoto').append(html);
                $('#frm_uploadPhoto')[0].reset();
    		},
    		error:function(e){
    		}
    	}).submit();
    });

    $('#myProfilePicture').on('change',function(){
        $('#frm_uploadProfilePicture').ajaxForm({
            //target:'#list_myphoto',
            beforeSubmit:function(e){
                $('#loader').show();
            },
            success:function(html){
                $('#loader').hide();
                $('#f_Transfer_Profile_Picture').modal('hide');
                $('#listMyProfilePicture').append(html);
                $('#f_Transfer_Profile_Picture')[0].reset();
            },
            error:function(e){
            }
        }).submit();
    });
    //PHOTO opretetevent
    $('#eventImage').on('change',function(){
        var form = $('#frm_invitationer')[0];
    	var formData = new FormData(form);
        $('#loader').show();
        $.ajax({
            type: "POST",
            url: base_url+"invitationer/opretetevent",
            data: formData,
            dataType: 'html',
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            success: function(html){
                $('#loader').fadeOut();
                if(html){
                    $('#eventImage').val('');
                    $('#list_uploaded').html(html);
                }else{
                    $('#error-content').html('Fejl-system, skal du handling igen!');
                    $('#PUerror').modal('show');
                }
            }
        });
        return false;
    });
    //PHOTO offentligevent
    $('#publicEventImage').on('change',function(){
        var form = $('#frm_invitationer')[0];
    	var formData = new FormData(form);
        $('#loader').show();
        $.ajax({
            type: "POST",
            url: base_url+"invitationer/offentligevent",
            data: formData,
            dataType: 'html',
            mimeType:"multipart/form-data",
            contentType: false,
            cache: false,
            processData:false,
            success: function(html){
                $('#loader').fadeOut();
                if(html){
                    $('#publicEventImage').val('');
                    $('#list_uploaded').html(html);
                }else{
                    $('#error-content').html('Fejl-system, skal du handling igen!');
                    $('#PUerror').modal('show');
                }
            }
        });
        return false;
    });
    
    //Send message
    $('#message').bind("enterKey",function(e){
        $.ajax({
            type: "post",
            url: base_url+"user/sendMessage",
            dataType: 'html',
            data: {message: $("#message").val(),user_to: $("#user_to").val(),'csrf_site_name':token_value}
        }).done(function(html){
            $("#list-messages").prepend(html);
            $("#message").val("");
        });
    });
    $('#message').keyup(function(e){
        if(e.keyCode == 13){
            $(this).trigger("enterKey");
        }
    });
    $('#bntSendmes').bind("click",function(e){$('#message').trigger("enterKey")});
    //
    $(window).scroll(function(){
        $.validator.reposition();
    });

    //Check email field in forgot password page
    $("#forgotForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        }
    });

    $("#createShoutoutForm").validate({
        rules: {
            content: {
                required: true
            }
        }
    });

    // In tilbud page
    $('ul.list-topic li .radio label').click(function() {
        $('ul.list-topic li .radio label').removeClass('bg_active');
        $(this).addClass('bg_active');
    });
    $(document).on("change","#frm_search input[type=radio]",function(){
        $("#frm_search").submit();
    });

    $(document).on("change","#perPage",function(){
        $("#perPageForm").submit();
    });

    /*$(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 50) {
            $(".navbar").addClass("border_white");
        } else {
            $(".navbar").removeClass("border_white");
        }
    });*/

    //Positive list
    $('.deleteUserConfirm').click(function () {
        var friendId = $(this).attr('value');
        var href = base_url+'user/deleteUser/'+friendId;
        $('#deleteUserBtn').attr('href', href);
        $('#PUdeleteUserConfirm').modal('show');
    });
    $('.blockUserConfirm').click(function () {
        var friendId = $(this).attr('value');
        var from = $(this).attr('from');
        var href = base_url+'user/blockUser/'+friendId+'/'+from;
        $('#blockUserBtn').attr('href', href);
        $('#PUblockUserConfirm').modal('show');
    });

    //Set used deal in B2B
    $('.setUsed').click(function () {
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: base_url+"ajax/setUsedDeal",
            data: {'id':id,'csrf_site_name':token_value},
            dataType: 'json',
            success: function(data){
                if(parseInt(data)==1){
                    $('#deal'+id).attr("disabled", true);
                }
            }
        });
    })

    // Checking validation of b2b form
    $("#b2bUpdateForm").validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            repassword: {
                equalTo: "#password"
            },
            company: {
                required: true
            }
        }
    });
});
$(window).load(function(e){
    $('#loader').fadeOut();
})
//START---------------------------------------------------------------------------
function deletedata(table,id,idremove){
    $("#"+idremove).html('<image src="'+base_url+'templates/img/loading01.gif">');
    $.post(base_url+"ajax/deletedata",{'table':table,'id':id,'csrf_site_name':token_value},function(data){
        if(data){
            $("#"+idremove).remove();
        }                                          
    });
}
//USER
function noLogin(){
    $('#Flogin').modal('show');
	return false;
}
function login(){
    $.validator.reposition();
    $("#frm_login").validate_popover({
        onsubmit: true,
        popoverPosition: 'top',
        rules: {
            email:{required:true,email: true},
            password:{required:true},
        },
        messages: {
            email:{required:'',email:''},
            password:{required:''},
        },
        submitHandler: function(form){
             var formData = new FormData(form);
             $('#loader').show();
             $.ajax({
                 type: "POST",
                 url: base_url+"user/login",
                 data: formData,
                 dataType: 'json',
                 mimeType:"multipart/form-data",
                 contentType: false,
                 cache: false,
                 processData:false,
                 success: function(data){console.log(data);
                     $('#loader').fadeOut();
                     if(data.status === true){
                        if(data.b2b === true){
                            location.href = base_url_lang+'b2b/sold';
                        }else{
                            $('#Flogin').modal('hide');
                            location.reload();
                        }
                     }else{
                         $('#error-content').html('E-mail eller adgangskode er forkert, prøv igen!');
                         $('#PUerror').modal('show');
                     }
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     alert(errorThrown);
                 }
            });
            return false;
        }
    });
}
function register(){
    $.validator.reposition();
    $("#frm_register").validate_popover({
        onsubmit: true,
        popoverPosition: 'top',
        rules: {
            name:{required:true},
            email:{required:true,email: true},
            code:{required:true,number: true,maxlength:4},
            password:{required:true,minlength:6},
            repassword:{equalTo: "#password"},
            accepterer:{required:true},
        },
        messages: {
            name:{required:''},
            email:{required:'',email:''},
            code:{required:'',number:'',maxlength:''},
            password:{required:'',minlength:''},
            repassword:{equalTo:''},
            accepterer:{required:''},
        },
        submitHandler: function(form){
             var formData = new FormData(form);
             $('#loader').show();
             $.ajax({
                 type: "POST",
                 url: base_url+"user/register",
                 data: formData,
                 dataType: 'json',
                 mimeType:"multipart/form-data",
                 contentType: false,
                 cache: false,
                 processData:false,
                 success: function(data){
                     $('#loader').fadeOut();
                     if(data.status ==true){
                        if(data.payment == true){
                            location.href = base_url_lang+'payment/user';
                        }else{
                            location.href = base_url_lang+'user/success';
                        }
                     }else{
                         $('#error-content').html('Fejl-system, skal du handling igen!');
                         $('#PUerror').modal('show');
                     }
                 }
            });
            return false;
        }
    });
}
function update(){
    $.validator.reposition();
    $("#frm_update").validate_popover({
        onsubmit: true,
        popoverPosition: 'top',
        rules: {
            name:{required:true},
            //email:{required:true,email: true},
            code:{required:true,number: true,maxlength:4},
            password:{minlength: 6},
            repassword:{equalTo: "#password"},
        },
        messages: {
            name:{required:''},
            //email:{required:'',email:''},
            code:{required:'',number:'',maxlength:''},
            password:{minlength:''},
            repassword:{equalTo:''},
        }
    });
}
function checkEMAIL(email){
    if(email){
        $.ajax({
            type: "POST",
            url: base_url+"user/checkEmail",
            data: {'email':email,'csrf_site_name':token_value},
            dataType: 'json',
            success: function(data){
                if(data.status){
                    $('#error-content').html('E-mail er allerede registeret!');
                    $('#PUerror').modal('show');
                    $('#email').val('');
                }else{
                    //Nothink
                }
            }
        });
    }else{
        //No thing
    }
}

function addWishList(productId){
    $('#loader').show();
    $.ajax({
    	type: 'POST',
    	url: base_url+'tilbud/addWishList',
        data: {productId: productId,'csrf_site_name':token_value},
        dataType: 'json',
    	success:function (data){
            if(data.status==true){
                $("#wishlist_"+productId).addClass("i_favourite_active");
                $("#wishlist_"+productId).removeAttr("onclick");
                $("#wishlist_"+productId).attr("onclick", "removeWishList('"+productId+"')");
            }
    	}			
    });
}

function removeWishList(productId){
    $('#loader').show();
    $.ajax({
        type: 'POST',
        url: base_url+'tilbud/removeWishlist',
        data: {productId: productId,'csrf_site_name':token_value},
        dataType: 'json',
        success:function (data){
            if(data.status==true){
                $("#wishlist_"+productId).removeClass("i_favourite_active");
                $("#wishlist_"+productId).removeAttr("onclick");
                $("#wishlist_"+productId).attr("onclick", "addWishList('"+productId+"')");
            }
        }
    });
}

function addFavorite(user){
    $('#loader').show();
    $.ajax({
         type: "POST",
         url: base_url+"user/addFavorite",
         data: {'user':user,'csrf_site_name':token_value},
         dataType: 'json',
         success: function(data){
             if(data.status==true){
                 location.reload();
             }
         }
    });
}
function removeFavorite(user){
    $('#PUremoveFavouriteConfirm').modal('hide');
    $('#loader').show();
    $.ajax({
         type: "POST",
         url: base_url+"user/removeFavorite",
         data: {'user':user,'csrf_site_name':token_value},
         dataType: 'json',
         success: function(data){
             if(data.status==true){
                location.reload();
             }
         }
    });
}
function removeFavoriteConfirm(userId){
    $('#removeFavoriteBtn').attr('onclick', 'removeFavorite("'+userId+'")');
    $('#PUremoveFavouriteConfirm').modal('show');
}
/**
 *
 * @param user
 */
function sendKiss(user){
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: base_url+"user/sendKiss",
        data: {'user':user,'csrf_site_name':token_value},
        dataType: 'json',
        success: function(data){
            if(data.status==true){
                location.reload();
            }
        }
    });
}
/**
 *
 * @param user
 */
function removeKiss(user){
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: base_url+"user/removeKiss",
        data: {'user':user,'csrf_site_name':token_value},
        dataType: 'json',
        success: function(data){
            if(data.status==true){
                location.reload();
            }
        }
    });
}

//SHOP
function addCart(id){
    var qty = $("#qty_"+id).val();
    var price = $("#price_"+id).val();
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: base_url+"tilbud/insert",
        data: {'id':id, 'qty':qty, 'price':price, 'csrf_site_name':token_value},
        dataType: 'json',
        success: function(data){
            $('#loader').fadeOut();
            if(data.status == true){
                var num = $('#number-cart').html();
                $('#number-cart').html(parseInt(num)+1);
                $('#PUcart').modal('show');
            }else{
                $('#error-content').html('Fejl-system, skal du handling igen!');
                $('#PUerror').modal('show');
            }
        }
    });
}
function checkAcceptShop(){
    if($('#accept').is(':checked')){
        location.href = base_url_lang+'payment/shop';
    }else{
        $('#error-content').html('Klik vores vilkår og handelsbetingelser!');
        $('#PUerror').modal('show');
    	return false;		
    }
}
//CONTACT
function sendContact(){
    $.validator.reposition();
    $("#frm_contact").validate_popover({
        onsubmit: true,
        popoverPosition: 'top',
        rules: {
            name:{required:true},
            phone:{required:true,number:true},
            email:{required:true,email: true},
        },
        messages: {
            name:{required:''},
            phone:{required:'',number:''},
            email:{required:'',email:''},
        },
        submitHandler: function(form){
             var formData = new FormData(form);
             $('#loader').show();
             $.ajax({
                 type: "POST",
                 url: base_url+"kontakt",
                 data: formData,
                 dataType: 'json',
                 mimeType:"multipart/form-data",
                 contentType: false,
                 cache: false,
                 processData:false,
                 success: function(data){
                     $('#loader').fadeOut();
                     if(data.status ==true){
                         $('#error-content').html('Tak for din henvendelse. Jeg vender hurtigst muligt tilbage til dig. Så hold øje med din indbakke. Der er en mail på vej. Det er det hele værd. Du er det hele værd!');
                         $('#PUerror').modal('show');
                         $('#frm_contact')[0].reset();
                     }else{
                         $('#error-content').html('Fejl-system, skal du handling igen!');
                         $('#PUerror').modal('show');
                     }
                 }
            });
            return false;
        }
    });
}

//INVITATION
function listUser(type){
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: base_url+"invitationer/listuser",
        data: {'type':type, 'csrf_site_name':token_value},
        dataType: 'html',
        success: function(data){
            $('#loader').fadeOut();
            $('#PUfindinvite').html(data);
            $('#PUfindinvite').modal('show');
        }
    });
}
function findUser(){
    var name = $('#namesearch').val();
    var type = $('#type').val();
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: base_url+"invitationer/finduser",
        data: {'name':name, 'type':type, 'csrf_site_name':token_value},
        dataType: 'html',
        success: function(data){
            $('#loader').fadeOut();
            $('#list-search-user').html(data);
        }
    });
}
function selectAll(){
    $('.btn_choose').addClass('btn_choose_active');
    $(".listUser").prop("checked", true);
}
function deleteAll(){
    $('.btn_choose').removeClass('btn_choose_active');
    $(".listUser").prop("checked", false);
}
function shooseClick(id){
    if($('#chooseUser_'+id).is(":checked")){
        $('#btn_choose_'+id).removeClass('btn_choose_active');
        $("#chooseUser_"+id).prop("checked", false);
    }else{
        $('#btn_choose_'+id).addClass('btn_choose_active');
        $("#chooseUser_"+id).prop("checked", true);
    }
}
function removeUserChoose(id){
    $('#user_choosed_'+id).remove();
}
function sendUser(){
	$('#frm_chooseUser').ajaxForm({
		//target:'#list_myphoto',
		beforeSubmit:function(e){
			$('#loader').show();
		},
		success:function(html){
			$('#loader').hide();
            $('#PUfindinvite').modal('hide');
            $('#list-user-choose').html(html);
            $('#frm_chooseUser')[0].reset();
		},
		error:function(e){
		}
	}).submit();
}
function sendUserSearch(invita){
    $('#frm_chooseUserSearch').ajaxForm({
		//target:'#list_myphoto',
		beforeSubmit:function(e){
			$('#loader').show();
		},
		success:function(html){
			$('#loader').hide();
            if(invita == '1'){
                location.href = base_url_lang+'invitationer/offentliginvitation';
            }else if(invita == '2'){
                location.href = base_url_lang+'invitationer/offentligevent';
            }else if(invita == '3'){
                location.href = base_url_lang+'invitationer/invitervip';
            }else{
                location.reload();
            }
		},
		error:function(e){
		}
	}).submit();
}
function submitFrm(id){
    $('#'+id).submit();
}
function selectTilbud(id){
    $('#tilbudDelete').val(id);
    $('#PUdeletetilbud').modal('show');
}
function deleteTilbud(){
    var id = $('#tilbudDelete').val();
    $('#PUdeletetilbud').modal('hide');
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: base_url+"invitationer/sletTilbud",
        data: {'id':id, 'csrf_site_name':token_value},
        dataType: 'json',
        success: function(data){
            $('#loader').fadeOut();
            if(data.status ==true){
                location.reload();
            }else{
                $('#error-content').html('Fejl-system, skal du handling igen!');
                $('#PUerror').modal('show');
            }
        }
    });
}
function deleteImages(id){
    $("#"+id).remove();
}
//MY INVITATION
function acceptDating(id){
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: base_url+"user/acceptDating",
        data: {'id':id, 'csrf_site_name':token_value},
        dataType: 'json',
        success: function(data){
            $('#loader').fadeOut();
            if(data.status ==true){
                location.reload();
            }else{
                $('#error-content').html('Fejl-system, skal du handling igen!');
                $('#PUerror').modal('show');
            }
        }
    });
}
/**
 *
 * @param id
 */
function getUserJoin(id){
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: base_url+"user/getUserJoin",
        data: {'id':id, 'csrf_site_name':token_value},
        dataType: 'html',
        success: function(data){
            $('#loader').fadeOut();
            $('#PUattending').html(data);
            $('#PUattending').modal('show');
        }
    });
}

function deleteShoutout(id){
    if (confirm("Vil du virkelig slette denne shoutout?") == true) {
        location.href = base_url+"user/deleteShoutout/"+id;
    } else {
        return false;
    }
}

function updateB2B(){
    $('#b2bUpdateForm').submit();
}

//THE END-----------------------------------------------------------------------------