        <!-- ******Login Section****** --> 
        <section class="login-section access-section section">
            <div class="container">
                <div class="row">
                    <div class="form-box col-md-8 col-sm-12 col-xs-12 col-md-offset-2 col-sm-offset-0 xs-offset-0">     
                        <div class="form-box-inner">
                            <h2 class="title text-center">Log in to Kuklos</h2>                 
                            <div class="row">
                                <div class="form-container col-md-5 col-sm-12 col-xs-12">
                                    <form class="login-form" method="post" action="<?php echo current_url(); ?>">
                                    	<?php echo validation_errors(); ?>
                                        <div class="form-group email">
                                            <label class="sr-only" for="login-email">Email or username</label>
                                            <input id="login-email" type="email" class="form-control login-email" placeholder="Email" name="email">
                                        </div><!--//form-group-->
                                        <div class="form-group password">
                                            <label class="sr-only" for="login-password">Password</label>
                                            <input id="login-password" type="password" class="form-control login-password" placeholder="Password" name="password">
                                            <p class="forgot-password"><a href="<?php echo base_url('user/forgot'); ?>">Forgot password?</a></p>
                                        </div><!--//form-group-->
                                        <button type="submit" class="btn btn-block btn-cta-primary">Log in</button>
                                        <p class="lead">Don't have a Kuklos account yet? <br /><a class="signup-link" href="<?php echo base_url('user/signup'); ?>">Create your account now</a></p>  
                                    </form>
                                </div><!--//form-container-->
                                <div class="social-btns col-md-5 col-sm-12 col-xs-12 col-md-offset-1 col-sm-offset-0 col-sm-offset-0">  
                                    <div class="divider"><span>Or</span></div>                      
                                    <ul class="list-unstyled social-login">
                                        <li><a class="facebook-btn btn" href="<?php echo base_url('user/connect/facebook'); ?>"><i class="fa fa-facebook"></i>Login with Facebook</a></li>
                                        <li><a class="github-btn btn" href="<?php echo base_url('user/connect/github'); ?>"><i class="fa fa-github-alt"></i>Login with Github</a></li>
                                        <li><a class="google-btn btn" href="<?php echo base_url('user/connect/google'); ?>"><i class="fa fa-google-plus"></i>Login with Google</a></li>
                                    </ul>
                                </div><!--//social-btns-->
                            </div><!--//row-->
                        </div><!--//form-box-inner-->
                    </div><!--//form-box-->
                </div><!--//row-->
            </div><!--//container-->
        </section><!--//login-section-->