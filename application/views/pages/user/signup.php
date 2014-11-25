        <!-- ******Sign Up Section****** --> 
        <section class="signup-section access-section section">
            <div class="container">
                <div class="row">
                    <div class="form-box col-md-8 col-sm-12 col-xs-12 col-md-offset-2 col-sm-offset-0 xs-offset-0">     
                        <div class="form-box-inner">
                            <h2 class="title text-center">Sign up now</h2>  
                            <p class="intro text-center">It takes under 15 seconds!</p>               
                            <div class="row">
                                <div class="form-container col-md-5 col-sm-12 col-xs-12">
                                    <form class="signup-form" method="post" action="<?php echo current_url(); ?>">
                                    	<?php echo validation_errors(); ?>
                                        <div class="form-group email">
                                            <label class="sr-only" for="signup-email">Your email</label>
                                            <input id="signup-email" type="email" class="form-control login-email" placeholder="Your email" name="email">
                                        </div><!--//form-group-->
                                        <div class="form-group password">
                                            <label class="sr-only" for="signup-password">Your password</label>
                                            <input id="signup-password" type="password" class="form-control login-password" placeholder="Password" name="password">
                                        </div><!--//form-group-->
                                        <button type="submit" class="btn btn-block btn-cta-primary">Sign up</button>
                                        <p class="note">By signing up, you agree to our terms of services and privacy policy.</p>
                                        <p class="lead">Already have an account? <a class="login-link" id="login-link" href="<?php echo base_url('user/login'); ?>">Log in</a></p>  
                                    </form>
                                </div><!--//form-container-->
                                <div class="social-btns col-md-5 col-sm-12 col-xs-12 col-md-offset-1 col-sm-offset-0 col-sm-offset-0">  
                                    <div class="divider"><span>Or</span></div>                      
                                    <ul class="list-unstyled social-login">
                                        <li><a class="facebook-btn btn" href="<?php echo base_url('user/signup/facebook'); ?>"><i class="fa fa-facebook"></i>Sign up with Facebook</a></li>
                                        <li><a class="github-btn btn" href="<?php echo base_url('user/signup/github'); ?>"><i class="fa fa-github-alt"></i>Sign up with Github</a></li>
                                        <li><a class="google-btn btn" href="<?php echo base_url('user/signup/google'); ?>"><i class="fa fa-google-plus"></i>Sign up with Google</a></li>
                                    </ul>
                                    <p class="note">Don't worry, we won't post anything without your permission.</p>
                                </div><!--//social-login -->
                            </div><!--//row-->
                        </div><!--//form-box-inner-->
                    </div><!--//form-box-->
                </div><!--//row-->
            </div><!--//container-->
        </section><!--//signup-section-->