        <!-- ******Login Section****** --> 
        <section class="login-section access-section section">
            <div class="container">
                <div class="row">
                    <div class="form-box col-md-8 col-sm-12 col-xs-12 col-md-offset-2 col-sm-offset-0 xs-offset-0">     
                        <div class="form-box-inner">
                            <h2 class="title text-center">Log in to Kuklos</h2>                 
                            <div class="row">
                                <div class="form-container col-md-5 col-sm-12 col-xs-12">
                                    <form class="login-form">              
                                        <div class="form-group email">
                                            <label class="sr-only" for="login-email">Email or username</label>
                                            <input id="login-email" type="email" class="form-control login-email" placeholder="Email or username">
                                        </div><!--//form-group-->
                                        <div class="form-group password">
                                            <label class="sr-only" for="login-password">Password</label>
                                            <input id="login-password" type="password" class="form-control login-password" placeholder="Password">
                                            <p class="forgot-password"><a href="<?php echo base_url('user/forgot'); ?>">Forgot password?</a></p>
                                        </div><!--//form-group-->
                                        <button type="submit" class="btn btn-block btn-cta-primary">Log in</button>
                                         <p class="lead">Don't have a Kuklos account yet? <br /><a class="signup-link" href="<?php echo base_url('user/signup'); ?>">Create your account now</a></p>  
                                    </form>
                                </div><!--//form-container-->
                                <div class="social-btns col-md-5 col-sm-12 col-xs-12 col-md-offset-1 col-sm-offset-0 col-sm-offset-0">  
                                    <div class="divider"><span>Or</span></div>                      
                                    <ul class="list-unstyled social-login">
                                        <li><button class="twitter-btn btn" type="button"><i class="fa fa-twitter"></i>Log in with Twitter</button></li>
                                        <li><button class="facebook-btn btn" type="button"><i class="fa fa-facebook"></i>Log in with Facebook</button></li>
                                        <li><button class="github-btn btn" type="button"><i class="fa fa-github-alt"></i>Log in with Github</button></li>
                                        <li><button class="google-btn btn" type="button"><i class="fa fa-google-plus"></i>Log in with Google</button></li>
                                    </ul>
                                </div><!--//social-btns-->
                            </div><!--//row-->
                        </div><!--//form-box-inner-->
                    </div><!--//form-box-->
                </div><!--//row-->
            </div><!--//container-->
        </section><!--//login-section-->