<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-6">
                <div class="main_right">
                    <ul class="breadcrumb">
                        <li><a href="invitation.php">Invitationer</a>
                        </li>
                        <li class="active">Invitere VIP</li>
                    </ul>
                    <h3>INVITERE VIP</h3>
                    <?php echo form_open('invitationer/invitervip', array('id'=>'frm_invitationer'));?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Opret en VIP invitation op til 5 personer</label>
                                </div>
                                <div class="col-xs-7 col-sm-5">
                                    <a href="javascript:void(0)" onclick="listUser(1)">
                                        <img src="<?php echo base_url();?>templates/img/btn_favorites_list.png" alt="" class="img-responsive"/>
                                    </a>
                                </div>
                                <div class="col-xs-5 col-sm-7 pad0">
                                    <!--<a href="javascript:void(0)" onclick="listUser(0)">-->
                                    <a href="<?php echo site_url('user/browsing/0/3');?>">
                                        <img src="<?php echo base_url();?>templates/img/btn_find_invite.png" alt="" class="img-responsive"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php if($numUser){echo $numUser." personer";}?>
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
                        <div class="form-group col-sm-offset-right-4">
                            <label for=""> Vælg venligst en værdibevis</label>
                            <select name="order_item" class="form-control">
                                <?php if($orderitem){foreach($orderitem as $row){?>
                                <option value="<?php echo $row->id;?>"><?php echo $row->product?>: <?php echo $row->codes;?></option>
                                <?php }}?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-12">
                                    <a class="btnSubmit" href="javascript:void(0)" data-toggle="modal" data-target="#PUinvatation">
                                        <img src="<?php echo base_url();?>templates/img/btnCreateInvatation2.png" alt="" class="img-responsive"/>
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