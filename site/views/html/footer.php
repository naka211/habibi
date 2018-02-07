<footer>
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<div class="row app">
						<div class="col-md-5 col-sm-5">
							<div class="row mb20">
								<div class="col-xs-12">
									<a href="javascript:void(0)"><img class="img-responsive" src="<?php echo base_url();?>/templates/img/app-store.png" alt=""/></a>
								</div>
							</div>
							<div class="row mb20">
								<div class="col-xs-12">
									<a href="javascript:void(0)"><img class="img-responsive" src="<?php echo base_url();?>/templates/img/app-store2.png" alt=""/></a>
								</div>
							</div>
						</div>
						<div class="col-md-7 col-sm-7">
							<ul>
								<li><a href="<?php echo site_url('handelsbetingelser');?>">- Online dating udelukkende til Zeduuce.dk</a></li>
								<li><a href="<?php echo site_url('handelsbetingelser');?>">- Internet dating, der fjerner den første forhindring</a></li>
								<li><a href="<?php echo site_url('handelsbetingelser');?>">- En Eksklusiv Dating Website</a></li>
								<li><a href="<?php echo site_url('handelsbetingelser');?>">- Zeduuce.dk er en livsstil</a></li>
								<li><a href="<?php echo site_url('handelsbetingelser');?>">- Tilslutning mennesker gennem eksklusive internet dating</a></li>
								<li><a href="<?php echo site_url('handelsbetingelser');?>">- Zeduuce.dk - Selektiv Online Dating</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="col-md-12">
						<h4><a href="<?php echo site_url('home');?>">Derfor Zeduuce.dk</a></h4>
						<ul class="derfor">
							<li>Danmarks hurtigt voksende datingsite.</li>
							<li>Finder din næste kærlighed, partner eller ven her.</li>
							<li>Nemt at finde det rigtige match.</li>
							<li>Masser af arrangementer, events og gode deals</li>
						</ul>
						<div class="row">
							<div class="col-xs-6">
								<p class="list_social"><strong>Følg os på Facebook og Instagram</strong></p>
							</div>
							<div class="col-xs-6">
								<a class="social bg4e71a8" href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
								<a class="social bg4e7a9c" href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram fa-lg"></i></a>
								<a class="social bg1cb7eb" href="https://twitter.com" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center">
					<p><a href="<?php echo site_url('om')?>">Om Zeeduce</a> - <a href="<?php echo site_url('faq')?>">hjælp / FAQ</a> - <a href="<?php echo site_url('kontakt')?>">Kontakt</a> - Succeshistorier - Karriere - Presse - Onlinedating-apps - iPhone dating app - Android dating app - Følg Zeeduce.</p>
				</div>
			</div>
		</div>
	</div>
</footer>

<!--All popup-->
<div id="Flogin" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Log ind </h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('user/login', array('id'=>'frm_login'))?>
                  <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Indtast din e-mail"/>
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Kodeord"/>
                  </div>
                  <div class="checkbox pull-left">
                    <label><input type="checkbox" checked=""/> Husk mig</label>
                  </div>
                  <p class="pull-right">
                    <a href="<?php echo site_url('user/forgotpass');?>">Glemt kodeord?</a>
                  </p>
                  <div class="clearfix"></div>
                  <div class="form-group">
                    <button class="btnLogin2 hvr-bounce-to-top" type="submit" onclick="login()">Login</button>
                    <button onclick="loginFB()" type="button" class="btnFbLogin hvr-bounce-to-top"> <i class="fa fa-facebook-square fa-lg"></i> <span>Facebook login</span></button>
                  </div>
                <?php echo form_close();?>
            </div>
            <div class="modal-footer">
                <a href="<?php echo site_url('user/register');?>" class="btn btn-primary text-center btnSignup2">Opret gratis medlemskab her</a>
            </div>
        </div>
    </div>
</div>

<div id="f_Newprofile" class="modal fade">
    <div class="modal-dialog modal-490">
        <div class="modal-content bg_white">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Opret ny profil </h4>
            </div>
            <div class="modal-body text-center pt10">
                <h5>Velkommen til ZEDUUCE!</h5>
                <p>Danmarks nye invitations Dating site.<br/>
                Stedet som gør det muligt at komme på DATEN!!<br/>
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis suspendisse urna nibh.</p>
                <p class="mt15"><a href="<?php echo site_url('user/register');?>"><img src="<?php echo base_url();?>templates/img/btn_withoutFB.png" alt="" class="img-responsive btn-inline-block"/></a></p>
            </div>
            <div class="modal-footer text-center bg_gray">
                <h5>Opret dig hurtigt og nemt via din<br/>
                Facebook konto.</h5>
                <p>Vi skriver naturligvis aldrig noget på din væg.</p>
                <p class="mt15"><a href="javascript:void(0);" onclick="loginFB()"><img src="<?php echo base_url();?>templates/img/btn_withFB.png" alt="" class="img-responsive btn-inline-block"/></a></p>
            </div>
        </div>
    </div>
</div>

<div id="PUinvatation" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center">ER DU SIKKERT PÅ AT DU VIL OPRET DENNE <br/>INVITATION?</h4>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="javascript:void(0)" onclick="submitFrm('frm_invitationer')" class="btnGray2 pull-right text-uppercase">JA</a>
                    </div>
                    <div class="col-xs-6">
                        <a href="javascript:void(0)" class="btnBack w50p text-uppercase pull-left" data-dismiss="modal">NEJ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="PUdeletetilbud" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center">ER DU SIKKERT?</h4>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="javascript:void(0)" onclick="deleteTilbud()" class="btnGray2 pull-right text-uppercase">JA</a>
                    </div>
                    <div class="col-xs-6">
                        <a href="javascript:void(0)" class="btnBack w50p text-uppercase pull-left" data-dismiss="modal">NEJ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="PUfindinvite" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">&nbsp;</div>

<div id="PUattending" class="modal fade" tabindex="-1" role="dialog">&nbsp;</div>

<div id="PUattending2" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <p>De resterende 3 personer</p>
            </div>
            <div class="modal-body">
                <div class="row attending_row">
                    <div class="col-md-8">
                        <div class="info_people_attending">
                            <img src="<?php echo base_url();?>/templates/img/img08.jpg" alt="" class="img-responsive">
                            <h4>CamillaT</h4>
                            <p>28 år - 6000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn_Approve" href="#">Godkende</a>
                    </div>
                </div>
                <div class="row attending_row">
                    <div class="col-md-8">
                        <div class="info_people_attending">
                            <img src="<?php echo base_url();?>/templates/img/img09.jpg" alt="" class="img-responsive">
                            <h4>Piamesser</h4>
                            <p>28 år - 6000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn_Approve" href="#">Godkende</a>
                    </div>
                </div>
                <div class="row attending_row">
                    <div class="col-md-8">
                        <div class="info_people_attending">
                            <img src="<?php echo base_url();?>/templates/img/img10.jpg" alt="" class="img-responsive">
                            <h4>lkjhgf</h4>
                            <p>28 år - 6000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn_Approve" href="#">Godkende</a>
                    </div>
                </div>
                <div class="row attending_row">
                    <div class="col-md-8">
                        <div class="info_people_attending">
                            <img src="<?php echo base_url();?>/templates/img/img11.jpg" alt="" class="img-responsive">
                            <h4>MP87</h4>
                            <p>28 år - 6000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn_Approve" href="#">Godkende</a>
                    </div>
                </div>
                <div class="row attending_row">
                    <div class="col-md-8">
                        <div class="info_people_attending">
                            <img src="<?php echo base_url();?>/templates/img/img12.jpg" alt="" class="img-responsive">
                            <h4>Patri</h4>
                            <p>28 år - 6000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn_Approve" href="#">Godkende</a>
                    </div>
                </div>
                <div class="row attending_row">
                    <div class="col-md-8">
                        <div class="info_people_attending">
                            <img src="<?php echo base_url();?>/templates/img/img13.jpg" alt="" class="img-responsive">
                            <h4>amyzhang7657</h4>
                            <p>28 år - 6000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn_Approve" href="#">Godkende</a>
                    </div>
                </div>
                <div class="row attending_row">
                    <div class="col-md-8">
                        <div class="info_people_attending">
                            <img src="<?php echo base_url();?>/templates/img/img14.jpg" alt="" class="img-responsive">
                            <h4>MissBredahl</h4>
                            <p>28 år - 6000</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn_Approve" href="#">Godkende</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="PUupgrade" class="modal fade" tabindex="-1" role="dialog">
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
                    <div class="col-md-8 text-center pad0">
                        <p class="f19">Du skal være guldmedlem til at bruge denne funktion !!</p>
                    </div>
                </div>
                <div class="row mb30">
                    <div class="col-xs-8 text-center">
                        <a href="<?php echo site_url('user/upgrade');?>" class="btn btnUpgrade">Opgradere til guldmedlem</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="javascript:void(0)" class="btnGray2 text-uppercase" data-dismiss="modal">LUK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="PUremoveFavouriteConfirm" class="modal fade" tabindex="-1" role="dialog">
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
                        <a href="javascript:void(0)" class="btn btnUpgrade" id="removeFavoriteBtn">JA</a>
                    </div>
                    <div class="col-xs-6 text-center">
                        <a href="javascript:void(0)" class="btn btnUpgrade" data-dismiss="modal">NEJ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="PUblockUserConfirm" class="modal fade" tabindex="-1" role="dialog">
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
                        <p class="f19">Er du sikker på, at du vil blokere denne bruger?</p>
                    </div>
                </div>
                <div class="row mb30">
                    <div class="col-xs-6 text-center">
                        <a href="" class="btn btnUpgrade" id="blockUserBtn">JA</a>
                    </div>
                    <div class="col-xs-6 text-center">
                        <a href="javascript:void(0)" class="btn btnUpgrade" data-dismiss="modal">NEJ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="PUerror" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row mb15">
                    <div class="col-md-2 pad0 i_warning">
                        <img src="<?php echo base_url();?>/templates/img/i_warning.png" alt="" class="img-responsive">
                    </div>
                    <div class="col-md-10 text-center pad0">
                        <p class="f19" id="error-content">&nbsp;<?php echo $this->session->flashdata('message');?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <a href="javascript:void(0)" class="btnGray2 text-uppercase" data-dismiss="modal">&nbsp;&nbsp;LUK&nbsp;&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="PUcart" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center">TILFØJET TIL INDKØBSKURVEN</h4>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="javascript:void(0)" class="btnGray2 pull-right text-uppercase" data-dismiss="modal">&nbsp;&nbsp;JA&nbsp;&nbsp;</a>
                    </div>
                    <div class="col-xs-6">
                        <a href="<?php echo site_url('tilbud/cart');?>" class="btnBack pull-left text-uppercase">GÅ TIL INDKØBSKURVEN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="fb-root"></div>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/jquery.form.js"></script>
<script src="<?php echo base_url().'templates/';?>js/init.js"></script>
<script src="<?php echo base_url().'templates/';?>js/zeduuce.js"></script>
<script>
    <?php if($this->session->flashdata('message')){?>
    $( document ).ready(function() {
        $('#error-content').html(<?php $this->session->flashdata('message');?>);
        $('#PUerror').modal('show');
    });
    <?php }?>
    <?php if($this->session->flashdata('goldMember')){?>
    $( document ).ready(function() {
        $('#error-content').html(<?php $this->session->flashdata('goldMember');?>);
        $('#PUupgrade').modal('show');
    });
    <?php }?>
    function sendLoginFB(response){
		//console.log(response);
        $.ajax({
             type: "POST",
             url: "<?php echo base_url();?>user/loginFB",
             data: {'response':response,'csrf_site_name':token_value},
             dataType: 'json',
             success: function(data){
                 if(data.status ==true){
					 location.reload();
                 }else{
                    //window.location.href = '<?php echo base_url();?>';
                    $('#error-content').html('Error system, please login agian!.');
                    $('#PUerror').modal('show');
                 }
             }
        });
    }
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '<?php echo $this->config->item('app_id');?>',
            cookie     : true,  // enable cookies to allow the server to access 
            xfbml      : true,
            version    : 'v2.6'
        });
        //Option Canvas FB
        //FB.Canvas.setSize({ height: heightSite });
    };
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/vi_VN/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    function loginFB(){
		FB.login(function(response) {
		if (response.authResponse) {
			FB.api('/me', {fields: 'email, name, gender'},function(response) {
				//console.log(response);
				sendLoginFB(response);
				//$("#status").html(JSON.stringify(response));
			});
		}
		},{scope: 'publish_actions,email', return_scopes: true});
    }
    function logoutFB(){
        FB.logout(function(response) {
            // user is now logged out
        });
    }
</script>