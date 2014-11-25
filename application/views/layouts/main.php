<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  
<head> 

    <?php echo $template['partials']['header']; ?>

</head>
<body class="<?php echo $page_name; ?>">
    <?php if ($page_name !='home-page') echo '<div class="wrapper">'; ?>
    <!-- ******HEADER****** --> 
    <header id="header" class="header">  
        <div class="container">
            <h1 class="logo">
                <a href="<?php echo base_url(); ?>"><span class="text">Kuklos</span></a>
            </h1><!--//logo-->
            <nav class="main-nav navbar-right" role="navigation">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button><!--//nav-toggle-->
                </div><!--//navbar-header-->
                <div id="navbar-collapse" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                    <?php if ($page_name == 'about-page') : ?>
                        <li class="nav-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="active nav-item"><a href="<?php echo base_url('about'); ?>">About Us</a></li>
                    <?php else : ?>
                        <li class="active nav-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="nav-item"><a href="<?php echo base_url('about'); ?>">About Us</a></li>
                    <?php endif ?>
                    <?php if ($this->user_model->is_logged_in()) : ?>
                        <li class="nav-item"><a href="<?php echo base_url('user/logout'); ?>">Logout</a></li>
                        <?php if ($this->user_model->is_admin($this->session->userdata('email'))) echo '<li class="nav-item nav-item-cta last"><a class="btn btn-cta btn-cta-secondary" href="'.base_url('admin').'">Sign Up Free</a></li>'; ?>
                    <?php else : ?>
                        <li class="nav-item"><a href="<?php echo base_url('user/login'); ?>">Log in</a></li>
                        <li class="nav-item nav-item-cta last"><a class="btn btn-cta btn-cta-secondary" href="<?php echo base_url('user/signup'); ?>">Sign Up Free</a></li>
                    <?php endif ?>
                    </ul><!--//nav-->
                </div><!--//navabr-collapse-->
            </nav><!--//main-nav-->                     
        </div><!--//container-->
    </header><!--//header-->

    <?php echo $template['body'] ?>

    <?php if ($page_name !='home-page') echo '</div><!--//wrapper-->'; ?>

    <?php echo $template['partials']['footer']; ?>  

</body>
</html>