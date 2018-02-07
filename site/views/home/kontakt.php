<section class="breadcrumb-custom">
    <div class="container">
      <div class="row">
        <ul class="breadcrumb">
          <li><a href="<?php echo base_url();?>">Forside</a></li>
          <li class="active">Kontakt</a></li>
        </ul>
      </div>
    </div>
</section>
<section class="contact">
    <div class="container">
      <div class="row mt30 mb30">
        <div class="col-md-4">
          <h2>Kontakt</h2>
          <p><strong>Zeduuce.dk</strong></p>
          <p>Her kan I kontakte zeduuce´s kundeservice hvis der er nogle spørgsmål eller problemer. 
          Dog se venligst under FAQ først, da der sandsynligvis vil være en løsning på det pågældende problem. 
          (gå ind på andre sider og få inspiration også med hensyn til FAQ)</p>
          <p>Riviera Ancialuza 1031<br/>
          E 29680 Estepona</p>
          <p>Tlf. +22 422 522<br/>
          Mail: info@zeduuce.dk
          </p>
        </div>
        <div class="col-md-5">
          <div class="frm-contact">
            <h4>Kontakt formular</h4>
            <?php echo form_open('kontakt', array('id'=>'frm_contact'));?>
              <div class="form-group">
                <input type="text" class="form-control" name="name" id="" placeholder="Navn *"/>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="phone" id="" placeholder="Telefon *"/>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="email" id="" placeholder="E-mail *"/>
              </div>
              <div class="form-group">
                <textarea name="besked" id="" class="form-control" placeholder="Besked"></textarea>
              </div>
              <p><i>Felter markeret med * skal udfyldes</i></p>
              <div class="form-group">
                <button type="submit" onclick="sendContact()" class="btn btnSend">Send</button>
                <a class="btn btnFaq" href="<?php echo site_url('faq')?>">
                    <img class="img-responsive" src="<?php echo base_url();?>/templates/img/btn_faq.png" alt=""/>
                </a>
              </div>
            <?php echo form_close();?>
          </div>
        </div>
      </div>
    </div>
</section>
<script>
$(document).ready(function(){
    $('#menu_kontakt').addClass('active');
});
</script>