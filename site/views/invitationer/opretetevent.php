<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-6">
                <div class="main_right">
                    <div class="invitationer_box">
                        <ul class="breadcrumb">
                            <li><a href="<?php echo site_url('invitationer/index')?>">Invitationer</a>
                            </li>
                            <li class="active">Opret et event</li>
                        </ul>
                        <h3>OPRET ET EVENT <small>(koster kr. 29)</small></h3>
                        <?php echo form_open_multipart(site_url('invitationer/opretetevent'), array('id'=>'frm_invitationer'))?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="">Opret en VIP invitation op til 5 personer</label>
                                    </div>
                                    <div class="col-xs-7 col-sm-5">
                                        <a href="javascript:void(0)" onclick="listUser(1)">
                                            <img src="<?php echo base_url();?>templates/img/btn_favorites_list.png" alt="" class="img-responsive"/>
                                        </a>
                                    </div>
                                    <div class="col-xs-5 col-sm-7 pad0">
                                        <a href="javascript:void(0)" onclick="listUser(0)">
                                            <img src="<?php echo base_url();?>templates/img/btn_find_invite.png" alt="" class="img-responsive"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row" id="list-user-choose">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="form-group col-sm-offset-right-4">
                                <label for="">Vælg antal timer for accept/afvis</label>
                                <select name="time" class="form-control">
                                    <?php for($i=1;$i<25;$i++){?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?> timer</option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <label class="label_upload" for="">Upload billede (max. 5 billeder) PNG, JPG, JPEG</label>
                                        <input name="image[]" id="eventImage" style="cursor: pointer;" type="file" multiple="true" accept="image/*" class="form-control form-file-input" data-btnlabel="Vælg billede" data-btnclass="btn_select_img2" data-btnposition="left" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="list_uploaded" id="list_uploaded">
                                            &nbsp;
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-offset-right-4">
                                <label for="">Titel</label>
                                <input name="title" type="text" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="">Beskrivelse</label>
                                <textarea name="content" class="form-control" rows="8"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a class="btnSubmit" href="javascript:void(0)" data-toggle="modal" data-target="#PUinvatation">
                                            <img src="<?php echo base_url();?>templates/img/btnCreateEventPay.png" alt="" class="img-responsive"/>
                                        </a>
                                    </div>
                                    <div class="col-xs-6">
                                        <!-- <a href="#" class="btnBack pull-right">Annullér</a> -->
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
    $('#menu_invitationer').addClass('active');
});
</script>