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
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-migrate-1.2.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script> 
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/bootstrap-hover-dropdown.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/back-to-top.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-placeholder/jquery.placeholder.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/plugins/flexslider/jquery.flexslider-min.js'); ?>"></script>     
    <script type="text/javascript" src="<?php echo base_url('assets/js/main.js'); ?>"></script>


    <?php if (isset($page_name)) { ?>

        <?php if ($page_name == 'rack-page') { 
            if (isset($map)) {
                echo $map['js'];
            }
        } else if ($page_name == 'map-page') { ?>
            <?php echo $map['js']; ?>

            <script type="text/javascript" src="<?php echo base_url('assets/plugins/geoPosition.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/map_view.js'); ?>"></script>

        <?php } else if ($page_name == 'table-page') { ?>

            <script type="text/javascript" src="<?php echo base_url('assets/plugins/geoPosition.js'); ?>"></script>

            <script type="text/javascript">
                var gotPosition = <?php echo ($gotPosition ? 'true' : 'false'); ?>;
            </script>

            <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/380cb78f450/integration/bootstrap/3/dataTables.bootstrap.css">   
            <script type="text/javascript" src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="//cdn.datatables.net/plug-ins/380cb78f450/integration/bootstrap/3/dataTables.bootstrap.js"></script>
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
            <script type="text/javascript" src="<?php echo base_url('assets/js/table_view.js'); ?>"></script>
        <?php }
    } ?>