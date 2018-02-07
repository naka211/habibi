<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-9">
                <div class="main_right">
                    <div class="mymessages clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 class="text-uppercase">Skab shoutouts</h3>
                            </div>
                            <div class="col-lg-6">
                                <a class="btn btnBlack pull-right btn_lg mt15 mb15" href="javascript:history.back();"><i class="fa_arrow">«</i> TILBAGE</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo form_open(site_url('user/saveShoutout'), array('id'=>'createShoutoutForm', 'class'=>'frm_create_shoutout', 'role'=>'form', 'method'=>'POST'))?>
                                    <div class="form-group">
                                        <textarea name="content" placeholder="Indtast dit shoutout her" maxlength="300"></textarea>
                                    </div>
                                    <div class="form-group">
                                        Max er 300 tegn
                                    </div>
                                    <button type="submit" class="btn btnSave">GEM</button>
                                <?php echo form_close();?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>