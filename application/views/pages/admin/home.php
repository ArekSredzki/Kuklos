
                <article class="post">

                    <div class="container">
                        <div class="row">
                            <div class="blog-entry-content col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">

                                <h3 class="section-heading">Admin Panel</h3>

                                <p>Welcome, please choose one of the following options:</p>

                                <form action="<?php echo base_url('admin/load_xls'); ?>" method="post">
                                    <div class="input-group">
                                        <span class="input-group-addon">ftp://webftp.vancouver.ca</span>
                                        <input type="text" class="form-control" placeholder="Path to XLS Rack file" name="url">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">Process Rack XLS</button>
                                        </span>
                                    </div><!-- /input-group -->
                                </form>
                            </div><!--//blog-entry-content-->
                        </div><!--//row-->
                    </div><!--//container-->                                               
                </article><!--//post-->