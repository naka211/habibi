<nav class="site-navbar navbar navbar-inverse navbar-fixed-top navbar-mega navbar-inverse" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided"
                data-toggle="menubar">
            <span class="sr-only">Toggle navigation</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-collapse"
                data-toggle="collapse">
            <i class="icon md-more" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
            <a href="<?php echo base_url(); ?>">
                <img class="navbar-brand-logo navbar-brand-logo-normal"
                     src="<?php echo base_url(); ?>templates/assets/images/logo.png"
                     title="Administrator"/>
                <!--img class="navbar-brand-logo navbar-brand-logo-special" src="<?php echo base_url(); ?>templates/assets/images/logo-blue.png"
            title="Administrator"/-->
            </a>
            <span class="navbar-brand-text hidden-xs"> Admin</span>
        </div>
        <button type="button" class="navbar-toggle collapsed" data-target="#site-navbar-search" data-toggle="collapse">
            <span class="sr-only">Toggle Search</span>
            <i class="icon md-search" aria-hidden="true"></i>
        </button>
    </div>
    <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <!-- Navbar Toolbar -->
            <ul class="nav navbar-toolbar">
                <li class="hidden-float" id="toggleMenubar">
                    <a data-toggle="menubar" href="#" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                            <span class="sr-only">Toggle menubar</span>
                            <span class="hamburger-bar"></span>
                        </i>
                    </a>
                </li>
                <li class="hidden-xs" id="toggleFullscreen">
                    <a class="icon icon-fullscreen" data-toggle="fullscreen" href="javascript:void(0)" role="button">
                        <span class="sr-only">Toggle fullscreen</span>
                    </a>
                </li>
                <li class="hidden-float">
                    <a class="icon md-search" data-toggle="collapse" href="javascript:void(0)"
                       data-target="#site-navbar-search" role="button">
                        <span class="sr-only">Toggle Search</span>
                    </a>
                </li>
                <li class="dropdown dropdown-fw dropdown-mega">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
                       data-animation="fade" role="button"><?php echo lang('menu.setting'); ?> <i
                                class="icon md-chevron-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation">
                            <div class="mega-content">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h5><?php echo lang('menu.setting'); ?></h5>
                                        <ul class="blocks-2">
                                            <li class="mega-menu margin-0">
                                                <ul class="list-icons">
                                                    <li><i class="md-chevron-right" aria-hidden="true"></i>
                                                        <a target="_blank" href="<?php echo base_url_site(); ?>">View
                                                            site</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu margin-0">
                                                <ul class="list-icons">
                                                    <?php if ($this->check->check('view', 'mod_seo', 'seo')) { ?>
                                                        <li>
                                                            <i class="md-chevron-right" aria-hidden="true"></i>
                                                            <a class="animsition-link"
                                                               href="<?php echo site_url('mod_seo/seo'); ?>"><span
                                                                        class="site-menu-title"><?php echo lang('menu.seopage'); ?></span></a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($this->check->check('view', 'mod_email', 'email')) { ?>
                                                        <li>
                                                            <i class="md-chevron-right" aria-hidden="true"></i>
                                                            <a class="animsition-link"
                                                               href="<?php echo site_url('mod_email/email'); ?>"><span
                                                                        class="site-menu-title"><?php echo lang('menu.email.template'); ?></span></a>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($this->check->check('view', 'mod_language', 'language')) { ?>
                                                        <li>
                                                            <i class="md-chevron-right" aria-hidden="true"></i>
                                                            <a class="animsition-link"
                                                               href="<?php echo site_url('mod_language/language'); ?>"><span
                                                                        class="site-menu-title"><?php echo lang('menu.language'); ?></span></a>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-4">
                                        <h5>Images
                                            <span class="badge badge-success">4</span>
                                        </h5>
                                        <ul class="blocks-3">
                                            <li>
                                                <a class="thumbnail margin-0" href="javascript:void(0)">
                                                    <img class="width-full"
                                                         src="<?php echo base_url(); ?>templates/global/photos/placeholder.png"
                                                         alt="..."/>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-4">
                                        <h5 class="margin-bottom-0">About us</h5>
                                        <!-- Accordion -->
                                        <div class="panel-group panel-group-simple" id="siteMegaAccordion"
                                             aria-multiselectable="true" role="tablist">
                                            <div class="panel">
                                                <div class="panel-heading" id="siteMegaAccordionHeadingOne" role="tab">
                                                    <a class="panel-title" data-toggle="collapse"
                                                       href="#siteMegaCollapseOne" data-parent="#siteMegaAccordion"
                                                       aria-expanded="false" aria-controls="siteMegaCollapseOne">
                                                        LDC Team
                                                    </a>
                                                </div>
                                                <div class="panel-collapse collapse" id="siteMegaCollapseOne"
                                                     aria-labelledby="siteMegaAccordionHeadingOne" role="tabpanel">
                                                    <div class="panel-body">
                                                        Please contact us: info@cms.com
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Accordion -->
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- End Navbar Toolbar -->

            <!-- Navbar Toolbar Right -->
            <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"
                       data-animation="scale-up" aria-expanded="false" role="button">
                        <span class="flag-icon flag-icon-<?php echo $this->lang->lang(); ?>"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation">
                            <a href="<?php echo base_url() . $this->lang->switch_uri('dk'); ?>" role="menuitem">
                                <span class="flag-icon flag-icon-dk"></span> <?php echo lang('menu.danish'); ?></a>
                        </li>
                        <li role="presentation">
                            <a href="<?php echo base_url() . $this->lang->switch_uri('en'); ?>" role="menuitem">
                                <span class="flag-icon flag-icon-gb"></span> <?php echo lang('menu.english'); ?></a>
                        </li>

                    </ul>
                </li>
                <li class="dropdown">
                    <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"
                       aria-expanded="false" data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                <img src="<?php echo base_url(); ?>templates/assets/images/logo-vi.png" alt="Administrator"/>
                <i></i>
              </span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation">
                            <a href="javascript:void(0)" role="menuitem"><i class="icon md-account"
                                                                            aria-hidden="true"></i> <?php echo lang('menu.setting'); ?>
                            </a>
                        </li>
                        <?php if ($this->check->check('view', 'mod_access', 'changepassword')) { ?>
                            <li role="presentation">
                                <a href="<?php echo site_url('mod_access/changepassword'); ?>" role="menuitem"><i
                                            class="icon md-card"
                                            aria-hidden="true"></i> <?php echo lang('menu.user.changepassword'); ?></a>
                            </li>
                        <?php } ?>
                        <li class="divider" role="presentation"></li>
                        <li role="presentation">
                            <a href="<?php echo site_url('login/logout') ?>" role="menuitem"><i class="icon md-power"
                                                                                                aria-hidden="true"></i> <?php echo lang('menu.user.logout'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" href="javascript:void(0)" title="Notifications" aria-expanded="false"
                       data-animation="scale-up" role="button">
                        <i class="icon md-notifications" aria-hidden="true"></i>
                        <span class="badge badge-danger up">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                        <li class="dropdown-menu-header" role="presentation">
                            <h5><?php echo lang('menu.message'); ?></h5>
                            <span class="label label-round label-danger">New 0</span>
                        </li>
                        <li class="list-group" role="presentation">
                            <div data-role="container">
                                <div data-role="content">

                                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="media-left padding-right-10">
                                                <i class="icon md-receipt bg-red-600 white icon-circle"
                                                   aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Message 1</h6>
                                                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">5h</time>
                                            </div>
                                        </div>
                                    </a>


                                </div>
                            </div>
                        </li>
                        <li class="dropdown-menu-footer" role="presentation">
                            <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                                <i class="icon md-settings" aria-hidden="true"></i>
                            </a>
                            <a href="javascript:void(0)" role="menuitem">
                                <?php echo lang('menu.viewall'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" href="javascript:void(0)" title="Messages" aria-expanded="false"
                       data-animation="scale-up" role="button">
                        <i class="icon md-email" aria-hidden="true"></i>
                        <span class="badge badge-info up">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                        <li class="dropdown-menu-header" role="presentation">
                            <h5><?php echo lang('menu.news'); ?></h5>
                            <span class="label label-round label-info">New 0</span>
                        </li>
                        <li class="list-group" role="presentation">
                            <div data-role="container">
                                <div data-role="content">

                                    <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="media-left padding-right-10">
                          <span class="avatar avatar-sm avatar-online">
                            <img src="<?php echo base_url(); ?>templates/assets/images/logo-vi.png" alt="..."/>
                            <i></i>
                          </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">Name ...</h6>
                                                <div class="media-meta">
                                                    <time datetime="2015-06-17T20:22:05+08:00">3h</time>
                                                </div>
                                                <div class="media-detail">Hello ...</div>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </li>
                        <li class="dropdown-menu-footer" role="presentation">
                            <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                                <i class="icon md-settings" aria-hidden="true"></i>
                            </a>
                            <a href="javascript:void(0)" role="menuitem">
                                <?php echo lang('menu.viewall'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--li id="toggleChat">
                  <a data-toggle="site-sidebar" href="javascript:void(0)" title="Chat" data-url="site-sidebar.tpl">
                    <i class="icon md-comment" aria-hidden="true"></i>
                  </a>
                </li-->
            </ul>
            <!-- End Navbar Toolbar Right -->
        </div>
        <!-- End Navbar Collapse -->
        <!-- Site Navbar Seach -->
        <div class="collapse navbar-search-overlap" id="site-navbar-search">
            <form role="search">
                <div class="form-group">
                    <div class="input-search">
                        <i class="input-search-icon md-search" aria-hidden="true"></i>
                        <input type="text" class="form-control" name="site-search" placeholder="Search...">
                        <button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search"
                                data-toggle="collapse" aria-label="Close"></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Site Navbar Seach -->
    </div>
</nav>