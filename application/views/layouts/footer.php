    <!-- ******FOOTER****** --> 
    <footer class="footer">
        <div class="footer-content">
            <div class="container">
            </div><!--//container-->
        </div><!--//footer-content-->
        <div class="bottom-bar">
            <div class="container">
                <small class="copyright">Copyright <i class="fa fa-bicycle"></i> 2014 <a href="<?php echo base_url(); ?>" target="_blank">Kuklos</a></small>                
            </div><!--//container-->
        </div><!--//bottom-bar-->
    </footer><!--//footer-->
    
    <!-- Javascript -->          
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-1.11.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-migrate-1.2.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/bootstrap-hover-dropdown.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/back-to-top.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-placeholder/jquery.placeholder.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/FitVids/jquery.fitvids.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/flexslider/jquery.flexslider-min.js'); ?>"></script>     
    <script type="text/javascript" src="<?php echo base_url('assets/js/main.js'); ?>"></script>


    <?php if (isset($page_name) && $page_name == 'map-page') { ?>

    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/gmaps/gmaps.js'); ?>"></script>

    <script type="text/javascript">
        var map;
        jQuery(document).ready(function(){

            map = new GMaps({
                div: '#map',
                lat: 49.281161,
                lng:  -123.121322,
            });
            <?php echo $map_elements; ?>

        });
    </script>

    <?php } ?>