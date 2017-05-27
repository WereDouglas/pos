
         <?php require_once(APPPATH . 'views/header-page.php'); ?>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        
           <!--\\\\\\\ contentpanel start\\\\\\-->
            <div id="page-wrapper" class="page-wrapper-cls">
                        <script language="javascript" type="typeext/javascript">
                            function resizeIframe(obj) {
                                obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
                                // obj.style.width = obj.contentWindow.document.body.scrollHeight + 'px';
                            }
                        </script>
                        <iframe id="frame" name="frame" frameborder="no" border="0" onload="resizeIframe(this)" scrolling="no"  style="padding: 10px; min-height:1000px;" width="100%" class="span12" src="<?php echo base_url() . "index.php/welcome/start"; ?>"> </iframe>         


    
        </div>
    <?php require_once(APPPATH . 'views/footer-page.php'); ?>