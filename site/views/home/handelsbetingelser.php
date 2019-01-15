<div class="create_profile">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <a class="logo_sub" href="<?php echo base_url();?>"><img src="<?php echo base_url().'templates/';?>images/1x/logo.png" alt="" class="img-respsonsive"></a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="frm_createprofile">
                    <div class="w_login2">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <a class="btnBack" href="javascript:history.back();">« Tilbage</a>
                            </div>
                        </div>
                    </div>
                    <h3><?php echo $item->title;?></h3>
                    <?php echo $item->content;?>
                </div>
            </div>
        </div>
    </div>
</div>