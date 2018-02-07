<?php
if(isGoldMember()){
    $vipInvitationLink = 'href="'.site_url('invitationer/invitervip').'"';
    $publicInvitationLink = 'href="'.site_url('invitationer/offentliginvitation').'"';
    $eventLink = 'href="'.site_url('invitationer/opretetevent').'"';
    $publicEventLink = 'href="'.site_url('invitationer/offentligevent').'"';
    $myInvitationLink = 'href="'.site_url('user/myinvitationer').'"';
    $myJoinInvitationLink = 'href="'.site_url('user/myinvitationerjoin').'"';
} else {
    $vipInvitationLink = $publicInvitationLink = $eventLink = $publicEventLink = $myInvitationLink = $myJoinInvitationLink = 'href="#PUupgrade" data-toggle="modal"';
}
?>
<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index', $user->id); ?>

            <div class="col-md-9">
                <div class="main_right">
                    <div class="invitationer_box">
                        <ul class="breadcrumb">
                            <li class="active">Invitationer</li>
                        </ul>
                        <div class="row mb0">
                            <div class="col-xs-6">
                                <a <?php echo $vipInvitationLink;?> class="btn btnGray"><i class="fa fa-star-o fa-lg" aria-hidden="true"></i> INVITÈR VIP</a>
                            </div>
                            <div class="col-xs-6">
                                <a <?php echo $eventLink;?> class="btn btnGray"><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> OPRET ET EVENT</a>
                            </div>
                            <div class="col-xs-6">
                                <a <?php echo $publicInvitationLink;?>
                                   class="btn btnGray"><i class="fa fa-user-plus fa-lg" aria-hidden="true"></i>
                                    OFFENTLIG INVITATION</a>
                            </div>
                            <div class="col-xs-6">
                                <a <?php echo $publicEventLink;?> class="btn btnGray"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> OPRET OFFENTLIG EVENT</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="<?php echo site_url('invitationer/slet'); ?>" class="btn btnGray"><i class="fa fa-times fa-lg" aria-hidden="true"></i> SLET RESERVATION</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <hr>
                            </div>
                            <div class="col-xs-6">
                                <a <?php echo $myInvitationLink;?> class="btn btnGray btnInvited"><i class="fa fa-address-card-o" aria-hidden="true"></i> Jeg har inviteret</a>
                            </div>
                            <div class="col-xs-6">
                                <a <?php echo $myJoinInvitationLink;?> class="btn btnGray btnInvited"><i class="fa fa-address-card" aria-hidden="true"></i> Jeg er blevet inviteret</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#menu_invitationer').addClass('active');
    });
</script>