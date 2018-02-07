<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu">
                    <li class="dropdown site-menu-item has-sub">
                        <a class="dropdown-toggle" href="javascript:void(0)" data-dropdown-toggle="false">
                            <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                            <span class="site-menu-title"><?php echo lang('menu.manage'); ?></span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="site-menu-scroll-wrap is-list">
                                <div>
                                    <div>
                                        <ul class="site-menu-sub site-menu-normal-list">
                                            <?php if ($this->check->check('view', 'mod_access', 'admin')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_access/admin'); ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.user.list'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_access', 'group')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_access/group'); ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.user.group'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_access', 'module')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_access/module'); ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.user.module'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_access', 'permission')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_access/permissio'); ?>n"><span
                                                                class="site-menu-title"><?php echo lang('menu.user.permission'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown site-menu-item has-sub">
                        <a class="dropdown-toggle" href="javascript:void(0)" data-dropdown-toggle="false">
                            <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                            <span class="site-menu-title"><?php echo lang('menu.content.manage'); ?></span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="site-menu-scroll-wrap is-list">
                                <div>
                                    <div>
                                        <ul class="site-menu-sub site-menu-normal-list">
                                            <?php if ($this->check->check('view', 'mod_content', 'category')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_content/category') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.content.category'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_content', 'content')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_content/content') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.content.content'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_content_static', 'content_static')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_content_static/content_static') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.content.static'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown site-menu-item has-sub">
                        <a class="dropdown-toggle" href="javascript:void(0)" data-dropdown-toggle="false">
                            <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                            <span class="site-menu-title"><?php echo lang('menu.image.manage'); ?></span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="site-menu-scroll-wrap is-list">
                                <div>
                                    <div>
                                        <ul class="site-menu-sub site-menu-normal-list">
                                            <?php if ($this->check->check('view', 'mod_banner', 'category')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_banner/category') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.banner.category'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_banner', 'banner')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_banner/banner') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.banner.banner'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_banner', 'gallery')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_banner/gallery') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.banner.gallery'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown site-menu-item has-sub">
                        <a class="dropdown-toggle" href="javascript:void(0)" data-dropdown-toggle="false">
                            <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                            <span class="site-menu-title"><?php echo lang('menu.user.manage'); ?></span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="site-menu-scroll-wrap is-list">
                                <div>
                                    <div>
                                        <ul class="site-menu-sub site-menu-normal-list">
                                            <?php if ($this->check->check('view', 'mod_user', 'user')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_user/user') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.user.user'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_user', 'b2b')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_user/b2b') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.user.b2b'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_contact', 'contact')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_contact/contact') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.user.contact'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_shoutouts', 'shoutouts')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_shoutouts/shoutouts') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.user.shoutouts'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_payments', 'payments')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_payments/payments') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.user.payments'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown site-menu-item has-sub">
                        <a class="dropdown-toggle" href="javascript:void(0)" data-dropdown-toggle="false">
                            <i class="site-menu-icon md-view-compact" aria-hidden="true"></i>
                            <span class="site-menu-title"><?php echo lang('menu.product.manage'); ?></span>
                            <span class="site-menu-arrow"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="site-menu-scroll-wrap is-list">
                                <div>
                                    <div>
                                        <ul class="site-menu-sub site-menu-normal-list">
                                            <?php if ($this->check->check('view', 'mod_product', 'category')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_product/category') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.product.category'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_product', 'product')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_product/product') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.product.product'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($this->check->check('view', 'mod_product', 'order')) { ?>
                                                <li class="site-menu-item"><a class="animsition-link"
                                                                              href="<?php echo site_url('mod_product/order') ?>"><span
                                                                class="site-menu-title"><?php echo lang('menu.product.order'); ?></span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>


                </ul>
            </div>
        </div>
    </div>
</div>