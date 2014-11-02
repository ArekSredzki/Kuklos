<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  
<head> 

    <?php echo $template['partials']['header']; ?>

</head>

<body class="blog-page blog-page-single">    
    <div class="wrapper">
        <!-- ******HEADER****** --> 
        <header class="header navbar-fixed-top">  
            <div class="container">       
                <h1 class="logo">
                    <a href="<?php echo base_url(); ?>">Kuklos <span class="sub">Web</span></a>
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
                            <li class="nav-item"><a href="<?php echo base_url('about'); ?>">About Us</a></li>
                            <li class="nav-item nav-item-main-site last"><a href="<?php echo base_url('user/logout'); ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                        </ul><!--//nav-->
                        
                        <div class="searchbox-container">
                            <form class="searchbox" id="search-form">
                                <label class="sr-only" for="search-form">Search</label>
                                <input id="search-form-input" class="form-control searchbox-input" placeholder="Search Kuklos..." type="search" value="" name="search">
                                <input class="searchbox-submit" type="submit" value="GO">
                                <i class="fa fa-search searchbox-icon"></i>
                            </form>
                        </div><!--//searchbox-container--> 
                        
                    </div><!--//navabr-collapse-->
                </nav><!--//main-nav-->
            </div><!--//container-->
        </header><!--//header-->

        <!-- ******BLOG****** -->         
        <div class="blog-entry-wrapper"> 
            <!--
            <div class="blog-headline-bg">
            </div><!--//blog-headline-bg-->
            <div class="blog-entry">

                <?php echo $template['body'] ?>

            </div><!--//blog-entry-->
        </div><!--//blog-entry-wrapper-->  
    </div><!--//wrapper-->
    
    <?php echo $template['partials']['footer']; ?>  

</body>
</html>