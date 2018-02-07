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
                            <li class="active">Opret offentlig event</li>
                        </ul>
                        <h3>OPRET OFFENTLIG EVENT <small>(koster kr. 29)</small></h3>
                        <?php echo form_open_multipart(site_url('invitationer/offentligevent'), array('id'=>'frm_invitationer'))?>
                            <div class="form-group col-sm-offset-right-4">
                                <p>(Sendes til alle på browsing-liste)</p>
                                <a href="<?php echo site_url('user/browsing/0/2');?>"><img src="<?php echo base_url();?>templates/img/bnt_setting.png" alt="" class="img-responsive"></a>
                                <?php if($numUser){echo $numUser." personer";}?>
                            </div>
                            <div class="form-group col-sm-offset-right-4">
                                <label for="">Vælg antal timer for accept/afvis</label>
                                <p class="f13">(Den valgte tidsangivelse starter samtidig for samtlige brugere på den offentlig invitation, i modsætning til VIP invitation)</p>
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
                                        <input name="image[]" id="publicEventImage" style="cursor: pointer;" type="file" multiple="true" accept="image/*" class="form-control form-file-input" data-btnlabel="Vælg billede" data-btnclass="btn_select_img2" data-btnposition="left" />
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
                                    <div class="col-xs-12">
                                        <a class="btnSubmit" href="javascript:void(0)" data-toggle="modal" data-target="#PUinvatation">
                                            <img src="<?php echo base_url();?>templates/img/btnCreateEventPay.png" alt="" class="img-responsive"/>
                                        </a>
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