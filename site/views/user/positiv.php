<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index', $user->id); ?>

            <div class="col-md-9">
                <div class="main_right">
                    <?php
                    if (!empty($userList)) {
                        foreach ($userList as $item) {
                            ?>
                            <div class="row positive_item">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                    <div class="avatar_positive">
                                        <a href="<?php echo site_url('user/profile/' . $item->id . '/' . seoUrl($item->name)) ?>">
                                            <?php echo modules::run('left/left/avatar', (object)$item, 163, 163); ?>
                                        </a>
                                    </div>
                                    <p class="name">
                                        <a href="<?php echo site_url('user/profile/' . $item->id . '/' . seoUrl($item->name)) ?>">
                                            <?php echo $item->name; ?>
                                        </a>
                                    </p>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <?php if ($item->sentKissStatus === false) { ?>
                                                <a href="#PUKissesLog" data-toggle="modal" class="btn btnPositive2 btnKiss" value="<?php echo $item->id;?>"><span class="btnPositive_content">Har sendt dig et kys</span></a>
                                            <?php } else { ?>
                                                <a class="btn btnPositive2 btnKiss active" value="<?php echo $item->id;?>">
                                                    <span class="btnPositive_content">Har sendt dig et kys <span
                                                                class="timer"><?php echo date("d.m.Y", $item->sentKissTime) ?>
                                                            Kl.<?php echo date("H:i", $item->sentKissTime) ?></span></span>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <?php if ($item->acceptedStatus === false) { ?>
                                                <a href="<?php echo site_url('user/approvedInvitation/' . $item->id . '/' . seoUrl($item->name)) ?>" class="btn btnPositive2"><span class="btnPositive_content">Har sagt ja</span></a>
                                            <?php } else { ?>
                                                <a href="<?php echo site_url('user/approvedInvitation/' . $item->id . '/' . seoUrl($item->name)) ?>" class="btn btnPositive2 active">
                                                    <span class="btnPositive_content">Har sagt ja <i
                                                                class="icon_lips"></i><span class="timer"><?php echo date("d.m.Y", $item->acceptedTime) ?> Kl.<?php echo date("H:i", $item->acceptedTime) ?></span></span>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <?php if ($item->addedToFavoriteStatus === false) { ?>
                                                <a href="<?php echo site_url('user/profile/' . $item->id . '/' . seoUrl($item->name)) ?>" class="btn btnPositive2"><span class="btnPositive_content">Har som favorit</span></a>
                                            <?php } else { ?>
                                                <a href="<?php echo site_url('user/profile/' . $item->id . '/' . seoUrl($item->name)) ?>" class="btn btnPositive2 active">
                                                    <span class="btnPositive_content">Har som favorit <span class="timer"><?php echo date("d.m.Y", $item->addedToFavoriteTime) ?> Kl.<?php echo date("H:i", $item->addedToFavoriteTime) ?></span></span>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <?php if ($item->sentInvitationStatus === false) { ?>
                                                <a href="<?php echo site_url('user/sentInvitation/' . $item->id . '/' . seoUrl($item->name)) ?>" class="btn btnPositive2"><span class="btnPositive_content">Har sendt invitation</span></a>
                                            <?php } else { ?>
                                                <a href="<?php echo site_url('user/sentInvitation/' . $item->id . '/' . seoUrl($item->name)) ?>" class="btn btnPositive2 active">
                                                    <span class="btnPositive_content">Har sendt invitation <span class="timer"><?php echo date("d.m.Y", $item->invitedTime) ?> Kl.<?php echo date("H:i", $item->invitedTime) ?></span></span>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <a href="<?php echo site_url('user/redirectToProfile/' . $item->id . '/' . seoUrl($item->name)) ?>" class="btn btnPositive2 <?php if ($item->seeMore3TimesStatus != false) echo 'active';?>"><span class="btnPositive_content">Har set din profil 3+ gange <?php if($item->lastSeeTime){?><span class="timer">Sidste set tid: <?php echo date("d.m.Y", $item->lastSeeTime) ?> Kl.<?php echo date("H:i", $item->lastSeeTime) ?></span><?php }?></span></a>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <a href="<?php echo site_url('user/messages/' . $item->id . '/' . seoUrl($item->name)); ?>" class="btn btnPositive2 <?php if ($item->sentUnreadMessageStatus !== false) echo "active";?>">
                                                    <span class="btnPositive_content">Har sendt en besked <?php if($item->lastMessageTime){?><span class="timer"><?php echo date("d.m.Y", $item->lastMessageTime) ?> Kl.<?php echo date("H:i", $item->lastMessageTime) ?></span><?php }?></span>
                                                </a>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb15">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pl0">
                                                <a href="javascript:void(0);" class="btn btn-block blockUserConfirm" value="<?php echo $item->id;?>" from="1">
                                                    Bloker
                                                </a>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pr0">
                                                <a href="javascript:void(0);" class="btn btn-block deleteUserConfirm" value="<?php echo $item->id;?>">
                                                    Slet
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    &nbsp;
                                </div>
                                <div class="col-md-6">
                                    <ul class="pagination pagination-sm pull-right">
                                        <?php echo $pagination; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <p>Der er ingen data!</p>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#menu_positiv').addClass('active');

        $('.btnKiss').click(function () {
            var friendId = $(this).attr('value');
            $('#loader').show();
            $(this).removeClass('active');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url();?>ajax/getKissesLog",
                data: { friendId: friendId, csrf_site_name:token_value }
            }).done(function( html ) {
                $('#loader').fadeOut();
                $('#PUKissesLog .modal-body').html(html);
                $('#PUKissesLog').modal('show');
            });
        })
        
        $('#PUKissesLog .modal-body').on('click', '.btn_Delete1', function () {
            var id = $(this).attr('value');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url();?>ajax/deleteKissLog",
                data: { id: id, csrf_site_name:token_value }
            }).done(function( status ) {
                if(status == 1){
                    $('#kiss'+id).fadeOut(500);
                } else {
                    alert('Noget gik galt');
                }
            });
        });
    });
</script>
<div id="PUKissesLog" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <p>Har sendt kys</p>
            </div>
            <div class="modal-body pt10">

            </div>
        </div>
    </div>
</div>

<div id="PUdeleteUserConfirm" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row mb15">
                    <div class="col-md-2 pad0 i_warning">
                        <img src="<?php echo base_url();?>/templates/img/i_warning.png" alt="" class="img-responsive">
                    </div>
                    <div class="col-md-9 text-center pad0">
                        <p class="f19">Er du sikker på, at du vil fjerne denne bruger?</p>
                    </div>
                </div>
                <div class="row mb30">
                    <div class="col-xs-6 text-center">
                        <a href="" class="btn btnUpgrade" id="deleteUserBtn">JA</a>
                    </div>
                    <div class="col-xs-6 text-center">
                        <a href="javascript:void(0)" class="btn btnUpgrade" data-dismiss="modal">NEJ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>