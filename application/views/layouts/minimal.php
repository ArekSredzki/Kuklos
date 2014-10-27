<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  
<head> 

    {$template.partial.header}

</head>
<body class="{$page_name} access-page has-full-screen-bg"> 
    <div class="upper-wrapper">
        <!-- ******HEADER****** --> 
        <header class="header">
            <div class="container">       
                <h1 class="logo">
                    <a href="{base_url()}"><span class="logo-icon"></span><span class="text">Kuklos</span></a>
                </h1><!--//logo-->
                                     
            </div><!--//container-->
        </header><!--//header-->

        {$template.body}

    </div><!--//upper-wrapper-->

    {$template.partial.footer}

</body>
</html>