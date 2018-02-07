<section class="min-profile">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="text-uppercase mt0">Rediger profil</h3>
            </div>
            <div class="col-sm-12">
                <div class="b2b_box clearfix">
                    <?php echo form_open_multipart('b2b/update', array('id'=>'b2bUpdateForm'));?>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Navn *</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $info->name;?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Email *</label>
                            <input type="text" class="form-control" name="email" value="<?php echo $info->email;?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Vælg kodeord (min. 6 karakter)</label>
                            <input type="password" class="form-control" name="password" id="password"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Gentag Kodeord</label>
                            <input type="password" class="form-control" name="repassword"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Company *</label>
                            <input type="text" class="form-control" name="company" value="<?php echo $info->company;?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Post nr.</label>
                            <input type="text" class="form-control" name="code" value="<?php echo $info->code;?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Adress</label>
                            <input type="text" class="form-control" name="address" value="<?php echo $info->address;?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label for="">Link</label>
                            <input type="text" class="form-control" name="link" value="<?php echo $info->link;?>" />
                        </div>
                    </div>
                    <div class="col-lg-12 col-xs-12 mb30">
                        <a href="javascript:void(0)" onclick="updateB2B();"><img src="<?php echo base_url();?>/templates/img/btnSave2.png" alt="" class="img-responsive"/></a>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
    $('#menu_minprofil').addClass('active');
});
</script>