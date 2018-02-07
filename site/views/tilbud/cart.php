<section class="breadcrumb-custom">
<div class="container">
  <div class="row">
    <ul class="breadcrumb">
      <li><a href="<?php echo base_url();?>">Forside</a></li>
      <li class="active">Indkøbs kurv</a></li>
    </ul>
  </div>
</div>
</section>
<section class="forget-pass">
<div class="container">
  <div class="row mt30 mb30">
    <div class="col-md-12">
      <ul class="steps">
        <li class="active">TRIN 1</li>
        <li>TRIN 2</li>
        <li>TRIN 3</li>
      </ul>
      <div class="clearfix"></div>
      <h2>Indkøbs kurv</h2>
      <div class="table-responsive table-cart1">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Tilbud</th>
              <th>Pris</th>
            </tr>
          </thead>
          <tbody>
            <?php if($list){foreach($list as $row){?>
            <tr>
              <td>
                <div class="col-xs-3">
                  <img class="img-responsive" src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/product/<?php echo $row->image;?>&w=310&h=135&q=100" alt=""/>
                </div>
                <div class="col-xs-9">
                  <h3 class="name_deal"><?php echo $row->name;?></h3>
                  <div class="title-cart"><?php echo $row->description;?></div>
                </div>
              </td>
              <td><?php echo priceFormat($row->price);?> <a class="btnClose" href="<?php echo site_url('tilbud/update/'.$row->rowid.'/'.$row->id);?>"><i class="fa fa-times-circle"></i></a></td>
            </tr>
            <?php }}else{?>
            <tr>
              <td>
                <div class="col-xs-9">
                  <p>Din Indkøbsvogn er tom</p>
                </div>
              </td>
              <td></td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="2">
                <p class="total-price pull-right"><span class="total-price-title">Pris ialt:</span> <span><?php echo priceFormat($total);?></span></p>
              </td>
            </tr>
            <tr>
              <td colspan="2"><a class="pull-right" href="<?php if($total){echo site_url('tilbud/checkout');}else{ echo 'javascript:void(0)';}?>"><img src="<?php echo base_url();?>templates/img/btnBook.png" alt=""/></a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</section>
<script>
$(document).ready(function(){
    $('#menu_tilbud').addClass('active');
});
</script>