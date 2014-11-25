
                <article class="post">

                    <div class="container">
                        <div class="row">
                            <div class="blog-entry-content col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">

                                <h3 class="section-heading">Admin Panel</h3>

                                <p>Welcome, please choose one of the following options:</p>

                                <form action="<?php echo base_url('admin/load_xls'); ?>" method="post">
                                    <div class="input-group">
                                        <span class="input-group-addon">ftp://webftp.vancouver.ca/</span>
                                        <input type="text" class="form-control" placeholder="Path to XLS Rack file" name="url">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">Process Rack XLS</button>
                                        </span>
                                    </div><!-- /input-group -->
                                </form>
                                <br>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="backups" data-toggle="dropdown" aria-expanded="true">
                                        Backups
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="backups">
                                        <li role="presentation" class="dropdown-header">Available Backups</li>
                                        <?php foreach ($backups as $backup): ?>
                                            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url('admin/restore_backup/'.$backup); ?>"><?php echo $backup; ?></a></li>
                                        <?php endforeach ?>
                                    </ul>
                                    <a class="btn btn-default" href="<?php echo base_url('admin/save_backup/'); ?>">Backup Current Database</a>
                                    <?php
                                    if (!empty($restore_result)) {
                                        echo '<br><br>';
                                        echo $restore_result;
                                    }
                                    ?>
                                </div>
                                <br>
                                <a class="btn btn-primary" href="<?php echo base_url('test/Toast_all/'); ?>">Run Unit Tests</a>
                            </div><!--//blog-entry-content-->
                        </div><!--//row-->
                    </div><!--//container-->                                               
                </article><!--//post-->