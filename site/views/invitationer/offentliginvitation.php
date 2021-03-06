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
                            <li class="active">Offentlig invitation</li>
                        </ul>
                        <h3>OFFENTLIG INVITATION</h3>
                        <?php echo form_open('invitationer/offentliginvitation', array('id'=>'frm_invitationer'));?>
                            <div class="form-group col-xs-offset-right-4">
                                <p>(Sendes til alle på browsing-liste)</p>
                                <a href="<?php echo site_url('user/browsing/0/1');?>">
                                    <img src="<?php echo base_url();?>templates/img/bnt_setting.png" alt="" class="img-responsive"/>
                                </a>
                                <?php if($numUser){echo $numUser." personer";}?>
                            </div>
                            <div class="form-group col-xs-offset-right-4">
                                <label for="">Vælg antal timer for accept/afvis</label>
                                <select name="time" class="form-control">
                                    <?php for($i=1;$i<25;$i++){?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?> timer</option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group col-xs-offset-right-4">
                                <label for="">Vælg venligst en værdibevis</label>
                                <select name="order_item" class="form-control">
                                    <?php if($orderitem){foreach($orderitem as $row){?>
                                    <option value="<?php echo $row->id;?>"><?php echo $row->product?>: <?php echo $row->codes;?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a class="btnSubmit" href="javascript:void(0)" data-toggle="modal" data-target="#PUinvatation">
                                            <img src="<?php echo base_url();?>templates/img/btnCreateInvatation2.png" alt="" class="img-responsive"/>
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