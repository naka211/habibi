<!DOCTYPE html>
<html>
<?php $this->load->view('html/header') ?>
<body>
    <div id="loader"></div>
    <?php if(!$this->session->userdata('isAdmin')){redirect(base_url());}?>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php $this->load->view('html/top') ?>
    <?php $this->load->view('html/left') ?>
    <!-- Page -->
    <div class="page animsition">
    <div class="page-content padding-top-10 container-fluid">
        <div class="panel">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        <?php if(!empty($message)){
                            echo '<div class="alert alert-danger alert-dismissible" role="alert"><i class="icon wb-help" aria-hidden="true"></i> '.$message.'</div>';
                        }if($this->session->flashdata('message')){
                            echo '<div class="alert alert-success alert-dismissible" role="alert"><i class="icon wb-check" aria-hidden="true"></i> '.$this->session->flashdata('message').'</div>';
                        }if($this->session->flashdata('error')){
                            echo '<div class="alert alert-danger alert-dismissible" role="alert"><i class="icon wb-alert" aria-hidden="true"></i> '.$this->session->flashdata('error').'</div>';
                        }if($this->session->flashdata('notes')){
                            echo '<div class="alert alert-primary alert-dismissible" role="alert"><i class="icon wb-info" aria-hidden="true"></i> '.$this->session->flashdata('notes').'</div>';
                        }if(!empty($title)){
                            echo '<div class="padding-left-20"><h3 class="margin-top-10"><i class="icon wb-heart" aria-hidden="true"></i> '.$title.'</h3></div>';
                        }?>
                    </div>
                    <div class="col-sm-6">
                      <div class="pull-right margin-top-10 margin-right-20 margin-left-10">
                        <?php if(!empty($add)){?>
                        <a title="<?php echo lang('admin.add')?>" href="<?php echo site_url($add);?>" class="btn btn-primary margin-bottom-5">
                            <i class="icon wb-plus-circle" aria-hidden="true"></i> <?php echo lang('admin.add')?>
                        </a>
                        <?php }?>
                        <?php if(!empty($export)){?>
                        <a title="<?php echo lang('admin.export')?>" href="<?php echo site_url($export);?>" class="btn btn-success margin-bottom-5"> 
                            <i class="icon wb-envelope-open" aria-hidden="true"></i> <?php echo lang('admin.export')?>
                        </a>
                        <?php }?>
                        <a title="<?php echo lang('admin.back')?>" href="javascript:history.back()" class="btn btn-info margin-bottom-5">
                            <i class="icon wb-dropleft" aria-hidden="true"></i> <?php echo lang('admin.back')?>
                        </a>
                      </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <?php $this->load->view($page) ?>
        </div>
    </div>
    </div>
    <!-- End Page -->
    <?php $this->load->view('html/footer') ?>
</body>
</html>