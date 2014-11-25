        <!-- ******Login Section****** --> 
        <section class="login-section access-section section">
            <div class="container">
                <div class="row">
                    <div class="form-box col-md-8 col-sm-12 col-xs-12 col-md-offset-2 col-sm-offset-0 xs-offset-0">     
                        <div class="form-box-inner">
                            <h2 class="title text-center">Password Reset</h2>                 
                            <div class="row">
                                <div class="form-container">
                                    <form class="login-form" method="post" action="<?php echo current_url(); ?>">
                                    	<?php echo validation_errors();
                                        if (!empty($result)) {
                                            echo $result;
                                        } ?> 
                                        <div class="form-group email">
                                            <label class="sr-only" for="login-email">Email or username</label>
                                            <input id="login-email" type="email" class="form-control login-email" placeholder="Email" name="email">
                                        </div><!--//form-group-->
                                        <button type="submit" class="btn btn-block btn-cta-primary">Reset Password</button>
                                        <p class="lead">Remember your password? <br /><a class="signup-link" href="<?php echo base_url('user/login'); ?>">Login Now</a></p>  
                                    </form>
                                </div><!--//form-container-->
                            </div><!--//row-->
                        </div><!--//form-box-inner-->
                    </div><!--//form-box-->
                </div><!--//row-->
            </div><!--//container-->
        </section><!--//login-section-->