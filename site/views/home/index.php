<section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-xs-12 text-center">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Velkommen til ZEDUUCE!</h1>
                        <p>Danmarks nye invitations Dating site.<br/>
                            Stedet som gør det muligt at komme på DATEN!!</p>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis
                            eros. Nullam malesuada erat ut turpis suspendisse urna nibh.</p>
                    </div>
                </div>
                <div class="row mt20">
                    <div class="col-md-12">
                        <hr class="line-solid"/>
                    </div>
                </div>
                <div class="row mt20">
                    <div class="col-lg-12">
                        <a class="btn btnSignup" href="#f_Newprofile" data-toggle='modal'>Opret gratis medlemskab
                            her</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-xs-5 text-center">
            </div>
        </div>
    </div>
</section>
<section class="dating">
    <div class="container">
        <div class="concept">
            <div class="row">
                <div class="col-md-6">
                    <h2>Koncept beskrivelse</h2>
                    <p>Zeduuce er det sidste nye i en ellers lang række af datingsites, det unikke ved denne side er man
                        ikke længere behøver ugevise lange samtaler for at evt. at komme på date, for derefter at se om
                        det kan udvikle til noget positivt.</p>
                    <p>Zeduuce har sprunget samtalerne over og smider dig direkte på daten.<br/>
                        God fornøjelse.</p>
                </div>
                <div class="col-md-6">
                    <div class="iframe-video">
                        <a href="#"><img class="img-responsive"
                                         src="<?php echo base_url(); ?>templates/img/imgVideo.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="dating-location">
    <div class="container">
        <h2 class="title2">Nyeste profiler</h2>
        <div class="row newest-profiles">
            <div class="col-md-12">
                <div id="newest_profiles" class="owl-carousel">
                    <?php
                    if ($listUser) {
                        foreach ($listUser as $row) {
                            if ($row['birthday']) {
                                $yearold = date('Y', time()) - explode('/', $row['birthday'])[2];
                            } else {
                                $yearold = "";
                            }
                            ?>
                            <div class="item">
                                <div class="item-img">
                                    <a <?php if ($user) { ?> href="<?php echo site_url('user/profile/' . $row['id'] . '/' . seoUrl($row['name'])); ?>" <?php } else { ?> onclick="noLogin()" href="javascript:void(0)" <?php } ?>>
                                        <?php echo modules::run('left/left/avatar',(object)$row, 150, 150);?>
                                        <?php /*if ($row['avatar']) {
                                            if ($row['facebook']) { ?>
                                                <img src="https://graph.facebook.com/<?php echo $row['facebook']; ?>/picture?type=square&w‌​idth=180&height=180"
                                                     alt="" class="img-responsive"/>
                                            <?php } else { ?>
                                                <img src="<?php echo base_url(); ?>thumb/timthumb.php?src=<?php echo base_url(); ?>uploads/photo/<?php echo $row['avatar']; ?>&w=150&h=150&q=100"
                                                     alt="" class="img-responsive"/>
                                            <?php }
                                        } else { ?>
                                            <img src="<?php echo base_url(); ?>templates/img/no-avatar.jpg" alt=""
                                                 class="img-responsive"/>
                                        <?php } */?>
                                    </a>
                                </div>
                                <div class="info">
                                    <a <?php if ($user) { ?> href="<?php echo site_url('user/profile/' . $row['id'] . '/' . seoUrl($row['name'])); ?>" <?php } else { ?> onclick="noLogin()" href="javascript:void(0)" <?php } ?>>
                                        <h3><?php echo $row['name']; ?></h3>
                                    </a>
                                    <p>Age: <?php echo $yearold; ?></p>
                                    <p>Postnr.: <?php echo $row['code'];?></p>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
                <!--<a class="btn prev"><i class="fa fa-chevron-left"></i></a>
                <a class="btn next"><i class="fa fa-chevron-right"></i></a>-->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="border-customer"></div>
            </div>
        </div>
        <div class="row latest-offers">
            <div class="col-lg-12">
                <h2 class="title2">Nyeste tilbud</h2>
                <div id="owl_latest_offers" class="owl-carousel">
                    <?php if ($listPro) {
                        foreach ($listPro as $row) { ?>
                            <div class="item">
                                <div class="item-img">
                                    <img src="<?php echo base_url(); ?>thumb/timthumb.php?src=<?php echo base_url(); ?>uploads/product/<?php echo $row->image; ?>&w=570&h=250&q=100"
                                         alt="" class="img-responsive"/>
                                    <span class="cate"><?php echo $row->company; ?></span>
                                    <div class="item-content clearfix">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h3><?php echo $row->name; ?></h3>
                                                <p><?php echo $row->description; ?></p>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="price">Pris:<?php echo priceFormat($row->price); ?></div>
                                                <a href="<?php echo site_url('tilbud/detail/' . $row->id . '/' . seoUrl($row->name)); ?>" class="btn btnOderNow">Bestil nu</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
                <!--<a class="btn prev2"><i class="fa fa-chevron-left"></i></a>
                <a class="btn next2"><i class="fa fa-chevron-right"></i></a>-->
            </div>
        </div>
    </div>
</section>

<section class="member">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Bliv gratis medlem</h2>
                <ul>
                    <li>Tilføje motto under profilbillede</li>
                    <li>Upload profilbillede</li>
                    <li>Profilbillede synlig for medlemmer/ikke medlemmer</li>
                    <li>Unik personlig log in og kode</li>
                    <a class="btnSeeMore" href="<?php echo site_url('handelsbetingelser'); ?>">SE MERE</a>
                </ul>
                <p class="text-center">
                    <a class="btn btnSignup btnJontNow" href="#f_Newprofile" data-toggle='modal'>OPRET GRATIS NU!</a>
                </p>
            </div>
            <div class="col-md-6">
                <h2>Bliv betalende medlem</h2>
                <ul>
                    <li>Tilføje motto under profilbillede</li>
                    <li>Upload profilbillede</li>
                    <li>Profilbillede synlig for medlemmer/ikke medlemmer</li>
                    <li>Upload fotos til Billedgalleri</li>
                    <li>Opslå Dateopslag</li>
                    <a class="btnSeeMore" href="<?php echo site_url('betingelser'); ?>">SE MERE</a>
                </ul>
                <p class="text-center">
                    <a class="btn btnSignup btnJontNow" href="#f_Newprofile" data-toggle='modal'>OPRET NU!</a>
                </p>
            </div>
        </div>
    </div>
</section>