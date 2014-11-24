
                <article class="post">

                    <div class="container">
                        <div class="row">
                            <div class="blog-entry-content col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">

                                <h3 class="section-heading">Rack - <?php echo $rack_data['address']; ?> <small><a href="<?php echo base_url(); ?>">Go Home</a></small></h3>
																<div id="fb-root"></div>
																<script>(function(d, s, id) {
																	var js, fjs = d.getElementsByTagName(s)[0];
																	if (d.getElementById(id)) return;
																	js = d.createElement(s); js.id = id;
																	js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
																	fjs.parentNode.insertBefore(js, fjs);
																}(document, 'script', 'facebook-jssdk'));</script>

                                <div class="rack-page-wrapper">
                                    <?php echo $map['html']; ?><!--//map-->
                                </div><!--//gmap-wrapper-->
                                <br>

                                <p>
                                	<h3>Favourite this bike rack!</h3>
                                	<a href="<?php echo base_url("rack/".$rack_data['rack_id']."/favourite_rack"); ?>">
                                        <?php if ($this->rack_model->is_favourited($rack_data['rack_id'], $this->session->userdata('email'))): ?>
                                			<i class="fa fa-star"></i>
                                		<?php else : ?>
                                			<i class="fa fa-star-o"></i>
                                		<?php endif; ?>
                                	</a>
                               	</p>

                                <p>
                                	 <a href="<?php echo base_url("rack/".$rack_data['rack_id']."/thumbs_up"); ?>"><i class="fa fa-thumbs-up"></i></a>
                                	 <a href="<?php echo base_url("rack/".$rack_data['rack_id']."/thumbs_down"); ?>"><i class="fa fa-thumbs-down"></i></a>
                                	 <h3>Rating: <span class="highlight"><?php echo $rating; ?></span></h3>
                                </p>

                                <p>
									<h3>Leave a comment</h3>
									<?php echo validation_errors(); ?>
									<?php echo form_open('rack/'.$rack_data['rack_id'].'') ?>
										<div class="form-group">
											<textarea class="form-control" name="text" rows="5" cols="50" placeholder="Comment..."></textarea>
										</div>
										<input class="btn btn-primary" type="submit" name="submit" value="Submit"/>
									</form>
									<br>
									
									<?php foreach ($comments as $comments_item): ?>
										<div class="main" id="<?php echo $comments_item['comment_id'] ?>">
											<b><?php echo $comments_item['email'] ?></b> <br>
											<?php echo $comments_item['text'] ?> <br>
											<span style="font-size: .75em;" class="highlight"><?php echo date("F d, Y - h:ia", $comments_item['timestamp']) ?></span>
											<?php $rack_url = base_url()."rack/".$rack_data['rack_id']."#".$comments_item['comment_id']; ?>
											<div class="fb-share-button" data-href="<?php echo $rack_url; ?>" data-layout="icon_link"></div>
										</div> <br>
									<?php endforeach ?>							
								</p>
                            </div><!--//blog-entry-content-->
                        </div><!--//row-->
                    </div><!--//container-->                                               
                </article><!--//post-->
