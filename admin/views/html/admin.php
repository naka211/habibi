<div class="row" data-plugin="matchHeight" data-by-row="true">
    <div class="col-lg-3 col-sm-6">
      <!-- Widget Linearea One-->
      <div class="widget widget-shadow" id="widgetLineareaOne">
        <div class="widget-content">
          <div class="padding-20 padding-top-10">
            <div class="clearfix">
              <div class="grey-800 pull-left padding-vertical-10">
                <i class="icon md-account grey-600 font-size-24 vertical-align-bottom margin-right-5"></i> USER
              </div>
              <span class="pull-right grey-700 font-size-30"><?php echo getNumUser();?></span>
            </div>
            <div class="margin-bottom-20 grey-500">
              <i class="icon md-long-arrow-up green-500 font-size-16"></i>
            </div>
            <div class="ct-chart height-50"></div>
          </div>
        </div>
      </div>
      <!-- End Widget Linearea One -->
    </div>
    <div class="col-lg-3 col-sm-6">
      <!-- Widget Linearea Two -->
      <div class="widget widget-shadow" id="widgetLineareaTwo">
        <div class="widget-content">
          <div class="padding-20 padding-top-10">
            <div class="clearfix">
              <div class="grey-800 pull-left padding-vertical-10">
                <i class="icon md-flash grey-600 font-size-24 vertical-align-bottom margin-right-5"></i> CONTENT
              </div>
              <span class="pull-right grey-700 font-size-30"><?php echo getNumContent();?></span>
            </div>
            <div class="margin-bottom-20 grey-500">
              <i class="icon md-long-arrow-up green-500 font-size-16"></i>
            </div>
            <div class="ct-chart height-50"></div>
          </div>
        </div>
      </div>
      <!-- End Widget Linearea Two -->
    </div>
    <div class="col-lg-3 col-sm-6">
      <!-- Widget Linearea Three -->
      <div class="widget widget-shadow" id="widgetLineareaThree">
        <div class="widget-content">
          <div class="padding-20 padding-top-10">
            <div class="clearfix">
              <div class="grey-800 pull-left padding-vertical-10">
                <i class="icon md-chart grey-600 font-size-24 vertical-align-bottom margin-right-5"></i> CONTENT STATIC
              </div>
              <span class="pull-right grey-700 font-size-30"><?php echo getNumContentStatic();?></span>
            </div>
            <div class="margin-bottom-20 grey-500">
              <i class="icon md-long-arrow-up green-500 font-size-16"></i>
            </div>
            <div class="ct-chart height-50"></div>
          </div>
        </div>
      </div>
      <!-- End Widget Linearea Three -->
    </div>
    <div class="col-lg-3 col-sm-6">
      <!-- Widget Linearea Four -->
      <div class="widget widget-shadow" id="widgetLineareaFour">
        <div class="widget-content">
          <div class="padding-20 padding-top-10">
            <div class="clearfix">
              <div class="grey-800 pull-left padding-vertical-10">
                <i class="icon md-view-list grey-600 font-size-24 vertical-align-bottom margin-right-5"></i> PRODUCTS
              </div>
              <span class="pull-right grey-700 font-size-30"><?php echo getNumProduct();?></span>
            </div>
            <div class="margin-bottom-20 grey-500">
              <i class="icon md-long-arrow-up green-500 font-size-16"></i>
            </div>
            <div class="ct-chart height-50"></div>
          </div>
        </div>
      </div>
      <!-- End Widget Linearea Four -->
    </div>
    <div class="clearfix"></div>
    <div class="col-xlg-5 col-md-6">
        <!-- Panel Projects -->
        <div class="panel" id="projects">
        <div class="panel-heading">
          <h3 class="panel-title">Dashboard</h3>
        </div>
        <div class="panel-body">
            <div class="row dashboard">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="<?php echo site_url('');?>">
                        <img src="<?php echo base_url();?>templates/assets/images/header/icon-48-frontpage.png" alt="<?php echo lang('menu.seopage');?>" /><br />
                        <span><?php echo lang('menu.dashboard');?></span>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="<?php echo site_url('');?>">
                        <img src="<?php echo base_url();?>templates/assets/images/header/icon-48-cpanel.png" alt="<?php echo lang('menu.seopage');?>" /><br />
                        <span><?php echo lang('menu.setting');?></span>
                    </a>
                </div>
                <?php if($this->check->check('view','mod_access','changepassword')){ ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="<?php echo site_url('mod_access/changepassword');?>">
                        <img src="<?php echo base_url();?>templates/assets/images/header/icon-48-writemess.png" alt="<?php echo lang('menu.seopage');?>" /><br />
                        <span><?php echo lang('menu.user.changepassword');?></span>
                    </a>
                </div>
                <?php }?>
                <?php if($this->check->check('view','mod_seo','seo')){ ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="<?php echo site_url('mod_seo/seo');?>">
                        <img src="<?php echo base_url();?>templates/assets/images/header/icon-48-config.png" alt="<?php echo lang('menu.seopage');?>" /><br />
                        <span><?php echo lang('menu.seopage');?></span>
                    </a>
                </div>
                <?php }?>
                <?php if($this->check->check('view','mod_content','content')){ ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="<?php echo site_url('mod_content/content');?>">
                        <img src="<?php echo base_url();?>templates/assets/images/header/icon-48-article.png" alt="<?php echo lang('menu.content.content');?>" /><br />
                        <span><?php echo lang('menu.content.content');?></span>
                    </a>
                </div>
                <?php }?>
                <?php if($this->check->check('view','mod_banner','banner')){ ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="<?php echo site_url('mod_banner/banner');?>">
                        <img src="<?php echo base_url();?>templates/assets/images/header/icon-48-banner.png" alt="<?php echo lang('menu.content.content');?>" /><br />
                        <span><?php echo lang('menu.banner.banner');?></span>
                    </a>
                </div>
                <?php }?>
                <?php if($this->check->check('view','mod_product','product')){ ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                    <a href="<?php echo site_url('mod_product/product');?>">
                        <img src="<?php echo base_url();?>templates/assets/images/header/icon-48-themes.png" alt="<?php echo lang('menu.content.content');?>" /><br />
                        <span><?php echo lang('menu.product.product');?></span>
                    </a>
                </div>
                <?php }?>
                
            </div>
        </div>
        </div>
        <!-- End Panel Projects -->
    </div>
    <div class="col-xlg-7 col-md-6">
        <!-- Panel Projects Status -->
        <div class="panel" id="projects-status">
        <div class="panel-heading">
          <h3 class="panel-title">
            Information <span class="badge badge-info">0</span>
          </h3>
        </div>
        <div class="panel-body">
          <h1>Information contact</h1>
          <p><label>Email:</label> admin@zeduuce.com</p>
        </div>
        </div>
        <!-- End Panel Projects Stats -->
    </div>
        
</div>