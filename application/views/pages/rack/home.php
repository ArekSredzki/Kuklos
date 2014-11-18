
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

                                <h4>Favourite this bike rack!</h4>
                                <!--//favourite&unfavourite php functions-->
                                <!--<div class="fb-share-button" data-href="<?php echo $rack_url; ?>" data-layout="icon_link"></div>-->
                                <br>
<!--                                  TODO: fix this 
                                <p>
                                	 <a href="<?php echo base_url("rack/".rack_data['id']."/thumbs_up"); ?>">Thumbs UP </a>
                                	 <a href="<?php echo base_url("rack/".rack_data['id']."/thumbs_down"); ?>">Thumbs DOWN </a>
                                	 <h3> Rating: <h3> <?php echo $rating; ?>

                                </p> -->
                               

                                <p>
																<h2>Leave a comment</h2>
																<?php echo validation_errors(); ?>
																<?php echo form_open('rack/'.$rack_data['rack_id'].'') ?>
																	<textarea name="text" rows="5" cols="50"></textarea> <br>
																	<input type="submit" name="submit" value="Submit"/>
																</form>
																<br>
																
																<?php foreach ($comments as $comments_item): ?>
																		<div class="main" id="<?php echo $comments_item['comment_id'] ?>">
																				<b><?php echo $comments_item['email'] ?></b> <br>
																				<?php echo $comments_item['text'] ?> <br>
																				<font size="2"><?php echo date("F d, Y - h:ia", $comments_item['timestamp']) ?></font>
																				<?php $rack_url = base_url()."rack/".$rack_data['rack_id']."#".$comments_item['comment_id']; ?>
																				<div class="fb-share-button" data-href="<?php echo $rack_url; ?>" data-layout="icon_link"></div>
																		</div> <br>
																<?php endforeach ?>							
																</p>
                            </div><!--//blog-entry-content-->
                        </div><!--//row-->
                    </div><!--//container-->                                               
                </article><!--//post-->
