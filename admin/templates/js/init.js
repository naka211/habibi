//Use CKEDITOR
var areditor = Array('content', 'content_en', 'description', 'description_en');
$.each(areditor, function (i, ar) {
    if($('#'+ar).length > 0){
        CKEDITOR.replace(ar,{
            filebrowserBrowseUrl: BASE_URI+'templates/ckfinder/ckfinder.html',
            filebrowserUploadUrl: BASE_URI+'templates/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        });
    }
});
//Use TINYMCE
tinymce.init({
    selector: 'textarea.tinyeditor',
    plugins : 'advlist link image imagetools media code colorpicker paste table textcolor',
    //Add upload images for content
    /*file_browser_callback: function(field, url, type, win) {
        tinyMCE.activeEditor.windowManager.open({
            file: BASE_URI+'templates/ckfinder/ckfinder.html',
            title: 'KCFinder',
            width: 700,
            height: 600,
            inline: true,
            close_previous: false
        }, {
            window: win,
            input: field
        });
        return false;
    }*/
});

function publish(table,field,id,status){
    $("#publish"+id).html('<image src="'+BASE_URI+'templates/images/loading.gif">');
    $.post(BASE_URI+"ajax/publish",{'table':table,'field':field,'id':id,'status':status},function(data){
        $("#publish"+id).html(data);
    });
}
function publishPopup(table,field,id,status){
    $("#publishPopup"+id).html('<image src="'+BASE_URI+'templates/images/loading.gif">');
    $.post(BASE_URI+"ajax/publishPopup",{'table':table,'field':field,'id':id,'status':status},function(data){
        $("#publishPopup"+id).html(data); 
        jQuery("#detail_list_table").bootstrapTable('refresh');                                             
    });
}
//SORT----------------------------------------------------------------------------------------------------
function sortFunctionAjax(formName, action){
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: action,
        data:jQuery("#"+formName).serializeArray(),
        dataType: 'json',
        success: function(data){
            $('#loader').fadeOut();
            if(data.status){
                $('#messageContent').html(data.message);
                $('#messageModal').modal('show');
                jQuery("#list_table").bootstrapTable('refresh');
            }else{
                $('#messageContent').html(data.message);
                $('#messageModal').modal('show');
            }
        }
    });
}
//SEARCH-------------------------------------------------------------------------------------------------
function searchFrm(formName,link){
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: link,
        data:jQuery("#"+formName).serializeArray(),
        dataType: 'json',
        success: function(data){
            $('#loader').fadeOut();
            if(data.status){
                jQuery("#list_table").bootstrapTable('refresh');
            }else{
                $('#messageContent').html(data.message);
                $('#messageModal').modal('show');
            }
        }
    });
}
//DELETE-------------------------------------------------------------------------------------------------
function deleteimage(table,field,id,fielddelete,idremove){
    if(idremove){
        idremove = idremove;
    }else{
        idremove = "image-view";
    }
    $("#"+idremove).html('<image src="'+BASE_URI+'templates/images/loading.gif">');
    $.post(BASE_URI+"ajax/deleteimage",{'table':table,'field':field,'id':id,'fielddelete':fielddelete},function(data){
        if(data){
            $("#"+idremove).remove();
        }                                          
    });
}
function deletedata(table,id,idremove){
    $("#"+idremove).html('<image src="'+BASE_URI+'templates/images/loading.gif">');
    $.post(BASE_URI+"ajax/deletedata",{'table':table,'id':id},function(data){
        if(data){
            $("#"+idremove).remove();
        }                                          
    });
}
function deleteAllItem(link){
    $.confirm({
        text: '<p class="text-center">Are you sure?</p>',
        confirm: function(button){
            var arr = $('#list_table').find('[type="checkbox"]:checked').map(function(){
                return $(this).closest('tr').find('td:nth-child(2)').text();
            }).get();
            $('#loader').show();
            $.ajax({
                type: "POST",
                url: link,
                data: {'id':arr},
                dataType: 'json',
                success: function(data){
                    $('#loader').fadeOut();
                    if(data.status){
                        $('#messageContent').html(data.message);
                        $('#messageModal').modal('show');
                        jQuery("#list_table").bootstrapTable('refresh');
                    }else{
                        $('#messageContent').html(data.message);
                        $('#messageModal').modal('show');
                    }
                }
            });
            return true;
        },
        cancel: function(button){
            return false;
        }
    });
}
function deleteItem(id){
    var link = $('#linkDelete-'+id).val();
    $.confirm({
        text: '<p class="text-center">Are you sure?</p>',
        confirm: function(button){
            $('#loader').show();
            $.ajax({
                type: "POST",
                url: link,
                data: {'id':id},
                dataType: 'json',
                success: function(data){
                    $('#loader').fadeOut();
                    if(data.status){
                        $('#messageContent').html(data.message);
                        $('#messageModal').modal('show');
                        jQuery("#list_table").bootstrapTable('refresh');
                    }else{
                        $('#messageContent').html(data.message);
                        $('#messageModal').modal('show');
                    }
                }
            });
            return true;
        },
        cancel: function(button){
            return false;
        }
    });
}
//CHECK BOX-----------------------------------------------------------------------------------------------
function setCheckboxesRight(frm, num, check){ 
    var form = document.forms[frm];
    for(var i=0;i<num;i++){
        form.elements['fAll_'+i].checked = check;
        for(x in arr_pm_code){
            form.elements['arr_permission['+i+']['+arr_pm_code[x]+']'].checked = check;
        }
    }
    return true; 
}
function setCheckboxesFunction(frm,row,check){
    var form = document.forms[frm];
    for(x in arr_pm_code){
        form.elements['arr_permission['+row+']['+arr_pm_code[x]+']'].checked = check;
    }
    return true; 
}
function checkAllRight(id,num,frm){
    var n = $('#'+id+':checked').val();
	if(n){
        setCheckboxesRight(frm,num, true);
    }	
	else{
        setCheckboxesRight(frm,num, false);
    }
}
function checkAllFunction(id,row,frm){
    var n = $('#'+id+':checked').val();
	if(n){
        setCheckboxesFunction(frm,row, true);
    }	
	else{
        setCheckboxesFunction(frm,row, false);
    }
}
//Delete DIV----------------------------------------------------------------------------------------------
function deleteDIV(id){
    $("#"+id).remove();
}
//Detail content
function viewDetail(id){
    var link = $('#linkDetail-'+id).val();
    $('#loader').show();
    $.ajax({
        type: "POST",
        url: link,
        data: {'id':id},
        dataType: 'html',
        success: function(data){
            $('#loader').fadeOut();
            $('[rel="tooltip"]').blur();
            if(data){
                $('#detailContent').html(data);
                $('#detailModal').modal('show');
                jQuery("#detail_list_table").bootstrapTable();
            }else{
                //
            }
        }
    });
}
/** The end*/