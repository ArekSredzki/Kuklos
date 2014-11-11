
                <article class="post">

                    <div class="container">
                        <div class="row">
                            <div class="blog-entry-content col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">

                                <h3 class="section-heading">Rack - <?php echo $rack_data['address']; ?> <small><a href="<?php echo base_url(); ?>">Go Home</a></small></h3>

                                <div class="rack-page-wrapper">
                                    <?php echo $map['html']; ?><!--//map-->
                                </div><!--//gmap-wrapper-->
                                <br>

                                <p>
																<?php foreach ($comments as $comments_item): ?>
																		<div class="main">
																				<i><?php echo $comments_item['timestamp'] ?></i> <br>
																				<?php echo $comments_item['text'] ?> <br><br>
																		</div>
																<?php endforeach ?>

																<h2>Leave a comment</h2>
																<?php echo validation_errors(); ?>
																<?php echo form_open('rack/home') ?>
																	<textarea name="text"></textarea> <br>
																	<input type="submit" name="submit" value="Submit"/>
																</form>
																</p>

                            </div><!--//blog-entry-content-->
                        </div><!--//row-->
                    </div><!--//container-->                                               
                </article><!--//post-->