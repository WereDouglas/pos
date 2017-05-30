<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>vugaPOS</title>
        <link href="<?= base_url(); ?>sprint/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url(); ?>sprint/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= base_url(); ?>sprint/css/prettyPhoto.css" rel="stylesheet">
        <link href="<?= base_url(); ?>sprint/css/main.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="<?= base_url(); ?>sprint/images/vugapos.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url(); ?>sprint/images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url(); ?>sprint/images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url(); ?>sprint/images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?= base_url(); ?>sprint/images/ico/apple-touch-icon-57-precomposed.png">
    </head><!--/head-->

    <body data-spy="scroll" data-target="#navbar" data-offset="0">
        <header id="header" role="banner">
            <div class="container">
                <div id="navbar" class="navbar navbar-default">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo base_url() . "index.php/login"; ?>"></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#main-slider"><i class="icon-home"></i></a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#portfolio">Features</a></li>
                            <!--                        <li><a href="#pricing">Pricing</a></li>-->
                            <li><a href="#about-us">About Us</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li> <a href="<?php echo base_url() . "index.php/login"; ?>">Login</a></li>

                        </ul>                    
                    </div>                
                </div>
            </div>
        </header><!--/#header-->

        <section id="main-slider" class="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="container">
                        <div class="carousel-content">
                            <h1><span class="red">vuga</span><span class="white">POS</span></h1>
                            <p class="lead"> Point of Sale software, inventory management.Serving independent retailers.</p>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item">
                    <div class="container">
                        <div class="carousel-content">
                            <h1>Go Mobile Anytime</h1>
                            <p class="lead"> Payments, Purchases, Bills And Track Inventory <br>Our Retailer software and hardware package provides you with powerful functionality for your specific retail industry including point of sale, powerful business intelligence</p>
                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
            <a class="prev" href="#main-slider" data-slide="prev"><i class="icon-angle-left"></i></a>
            <a class="next" href="#main-slider" data-slide="next"><i class="icon-angle-right"></i></a>
        </section><!--/#main-slider-->

        <section id="services">
            <div class="container">
                <div class="box first">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="center">
                                <i class="icon-windows icon-md icon-color4"></i>
                                <h4>Desktop application (Windows)</h4>
                                <p>Save time by having your data automatically synchronised with the Desktop software. Automatic record  reconciliation.</p>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-6">
                            <div class="center">
                                <i class="icon-android icon-md icon-color2"></i>
                                <h4>Android application</h4>
                                <p>Our innovative software design delivers the reliability and speed of premise-based systems with all conveniences of the cloud..</p>
                            </div>
                        </div><!--/.col-md-4-->

                        <div class="col-md-4 col-sm-6">
                            <div class="center">
                                <i class="icon-html5 icon-md icon-color1"></i>
                                <h4>Cloud based management and record keeping</h4>
                                <p> Take care of business from anywhere in the world.</p>
                            </div>
                        </div><!--/.col-md-4-->

                    </div><!--/.row-->
                </div><!--/.box-->
            </div><!--/.container-->
        </section><!--/#services-->

        <section id="portfolio">
            <div class="container">
                <div class="box">
                    <div class="center gap">
                        <h2>Features</h2>
                        <p class="lead">Our industry-leading automation saves you countless bookkeeping hours and puts all your data in accounting – where it belongs.</div><!--/.center-->
                    <ul class="portfolio-filter">
                        <li><a class="btn btn-primary active" href="#" data-filter="*">All</a></li>
                        <li><a class="btn btn-primary" href="#" data-filter=".bootstrap">Inventory management</a></li>
                        <li><a class="btn btn-primary" href="#" data-filter=".html">Point of sale</a></li>
                        <li><a class="btn btn-primary" href="#" data-filter=".wordpress">Purchase and sale registers</a></li>
                    </ul><!--/#portfolio-filter-->
                    <ul class="portfolio-items col-4">
                        <li class="portfolio-item apps">
                            <div class="item-inner">
                                <div class="portfolio-image">
                                    <img height="185px" width="185px" src="<?= base_url(); ?>sprint/images/pos.JPG" alt="">

                                </div>
                                <h5>Desktop application
                                </h5>
                            </div>
                        </li><!--/.portfolio-item-->
                        <li class="portfolio-item joomla bootstrap">
                            <div class="item-inner">
                                <div class="portfolio-image">
                                    <img height="185px" width="185px" src="<?= base_url(); ?>sprint/images/graph.JPG" alt="">

                                </div> 
                                <h5>Web Dashboard</h5>         
                            </div>
                        </li><!--/.portfolio-item-->
                        <li class="portfolio-item bootstrap wordpress">
                            <div class="item-inner">
                                <div class="portfolio-image">
                                    <img src="<?= base_url(); ?>sprint/images/download.jpg" alt="">

                                </div>
                                <h5>Mobile application</h5>          
                            </div>           
                        </li><!--/.portfolio-item-->
                        <li class="portfolio-item joomla wordpress apps">
                            <div class="item-inner">
                                <div class="portfolio-image">
                                    <img height="185px" width="185px" src="<?= base_url(); ?>sprint/images/pos.JPG" alt="">

                                </div>
                                <h5>Sale && Purchases</h5>        
                            </div>           
                        </li><!--/.portfolio-item-->
                        <li class="portfolio-item joomla html">
                            <div class="item-inner">
                                <div class="portfolio-image">
                                    <img height="185px" width="185px" src="<?= base_url(); ?>sprint/images/scanner.jpg" alt="">

                                </div>
                                <h5>Mobile hand held scanneres</h5>  
                            </div>       
                        </li><!--/.portfolio-item-->
                        <li class="portfolio-item wordpress html">
                            <div class="item-inner">
                                <div class="portfolio-image">
                                    <img height="185px" width="185px" src="<?= base_url(); ?>sprint/images/stock.JPG" alt="">

                                </div>
                                <h5>Stock taking and inventory management</h5>         
                            </div>           
                        </li><!--/.portfolio-item-->
                        <li class="portfolio-item joomla html">
                            <div class="item-inner">
                                <div class="portfolio-image">
                                    <img height="185px" width="185px" src="<?= base_url(); ?>sprint/images/printer.jpg" alt="">

                                </div>
                                <h5>Light weight printers</h5>  
                            </div>       
                        </li><!--/.portfolio-item-->
                        <li class="portfolio-item wordpress html">
                            <div class="item-inner">
                                <div class="portfolio-image">
                                    <img height="185px" width="185px" src="<?= base_url(); ?>sprint/images/graph.jpg" alt="">

                                </div>
                                <h5>Reporting</h5>        
                            </div>         
                        </li><!--/.portfolio-item-->
                    </ul>   
                </div><!--/.box-->
            </div><!--/.container-->
        </section><!--/#portfolio-->

<!--    <section id="pricing">
        <div class="container">
            <div class="box">
                <div class="center">
                    <h2>See our Pricings</h2>
                    <p class="lead">Pellentesque habitant morbi tristique senectus et netus et <br>malesuada fames ac turpis egestas.</p>
                </div>/.center   
                <div class="big-gap"></div>
                <div id="pricing-table" class="row">
                    <div class="col-sm-4">
                        <ul class="plan">
                            <li class="plan-name">Basic</li>
                            <li class="plan-price">$29</li>
                            <li>5GB Storage</li>
                            <li>1GB RAM</li>
                            <li>400GB Bandwidth</li>
                            <li>10 Email Address</li>
                            <li>Forum Support</li>
                            <li class="plan-action"><a href="#" class="btn btn-primary btn-lg">Signup</a></li>
                        </ul>
                    </div>/.col-sm-4
                    <div class="col-sm-4">
                        <ul class="plan featured">
                            <li class="plan-name">Standard</li>
                            <li class="plan-price">$49</li>
                            <li>10GB Storage</li>
                            <li>2GB RAM</li>
                            <li>1TB Bandwidth</li>
                            <li>100 Email Address</li>
                            <li>Forum Support</li>
                            <li class="plan-action"><a href="#" class="btn btn-primary btn-lg">Signup</a></li>
                        </ul>
                    </div>/.col-sm-4
                    <div class="col-sm-4">
                        <ul class="plan">
                            <li class="plan-name">Advanced</li>
                            <li class="plan-price">$199</li>
                            <li>30GB Storage</li>
                            <li>5GB RAM</li>
                            <li>5TB Bandwidth</li>
                            <li>1000 Email Address</li>
                            <li>Forum Support</li>
                            <li class="plan-action"><a href="#" class="btn btn-primary btn-lg">Signup</a></li>
                        </ul>
                    </div>/.col-sm-4
                </div> 
            </div> 
        </div>
    </section>/#pricing-->

        <section id="about-us">
            <div class="container">
                <div class="box">
                    <div class="center">
                        <h2>Meet the Team</h2>
                        <p class="lead">Meet the team<br>.</p>
                    </div>
                    <div class="gap"></div>
                    <div id="team-scroller" class="carousel scale">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="row">
                                    <div >
                                        <div class="member"></div></div>
                                   <div class="col-sm-4">
                                        <div class="member">
                                            <p><img class="img-responsive img-thumbnail img-circle" src="<?= base_url(); ?>sprint/images/douglas.jpg" alt="" ></p>
                                            <h3>Douglas Were<small class="designation">CEO &amp;Lead Software Developer</small></h3>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="member">
                                            <p><img class="img-responsive img-thumbnail img-circle" src="<?= base_url(); ?>sprint/images/jackie.JPG" alt="" ></p>
                                            <h3>Jackline Nakitende<small class="designation">Co-founder:Product manager</small></h3>
                                        </div>
                                    </div>
                                      <div class="col-sm-4">
                                        <div class="member">
                                            <p><img class="img-responsive img-thumbnail img-circle" src="<?= base_url(); ?>sprint/images/temp.png" alt="" ></p>
                                            <h3>Shaune Mayende<small class="designation">UX/UI</small></h3>
                                        </div>
                                    </div>  
                                    
                                    
                                  

                                </div>
                            </div>
<!--                            <div class="item">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="member">
                                            <p><img class="img-responsive img-thumbnail img-circle" src="<?= base_url(); ?>sprint/images/temp.png" alt="" ></p>
                                            <h3>David Robbins<small class="designation">Co-Founder</small></h3>
                                        </div>
                                    </div>   
                                    <div class="col-sm-4">
                                        <div class="member">
                                            <p><img class="img-responsive img-thumbnail img-circle" src="<?= base_url(); ?>sprint/images/team1.jpg" alt="" ></p>
                                            <h3>Philip Mejia<small class="designation">Marketing Manager</small></h3>
                                        </div>
                                    </div>     
                                    <div class="col-sm-4">
                                        <div class="member">
                                            <p><img class="img-responsive img-thumbnail img-circle" src="<?= base_url(); ?>sprint/images/team2.jpg" alt="" ></p>
                                            <h3>Charles Erickson<small class="designation">Support Manager</small></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                        <a class="left-arrow" href="#team-scroller" data-slide="prev">
                            <i class="icon-angle-left icon-4x"></i>
                        </a>
                        <a class="right-arrow" href="#team-scroller" data-slide="next">
                            <i class="icon-angle-right icon-4x"></i>
                        </a>
                    </div><!--/.carousel-->
                </div><!--/.box-->
            </div><!--/.container-->
        </section><!--/#about-us-->

        <section id="contact">
            <div class="container">
                <div class="box last">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1>Contact Form</h1>
                            <p>Please contact us using the form below.</p>
                            <div class="status alert alert-success" style="display: none"></div>
                            <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php" role="form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" required="required" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" required="required" placeholder="Email address">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Message"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger btn-lg">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div><!--/.col-sm-6-->
                        <div class="col-sm-6">
                            <h1>Our Address</h1>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Kampla Uganda.</strong><br>
                                        <br>

                                        <abbr title="Phone">P:</abbr> (256)0770691604
                                        <br>
                                        <abbr title="Phone">P:</abbr> (256)0782481746
                                    </address>
                                </div>
                                <!--                            <div class="col-md-6">
                                                                <address>
                                                                    <strong>Twitter, Inc.</strong><br>
                                                                    795 Folsom Ave, Suite 600<br>
                                                                    San Francisco, CA 94107<br>
                                                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                                                </address>
                                                            </div>-->
                            </div>
                            <!--                        <h1>Connect with us</h1>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <ul class="social">
                                                                <li><a href="#"><i class="icon-facebook icon-social"></i> Facebook</a></li>
                                                                <li><a href="#"><i class="icon-google-plus icon-social"></i> Google Plus</a></li>
                                                                <li><a href="#"><i class="icon-pinterest icon-social"></i> Pinterest</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <ul class="social">
                                                                <li><a href="#"><i class="icon-linkedin icon-social"></i> Linkedin</a></li>
                                                                <li><a href="#"><i class="icon-twitter icon-social"></i> Twitter</a></li>
                                                                <li><a href="#"><i class="icon-youtube icon-social"></i> Youtube</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>-->
                        </div><!--/.col-sm-6-->
                    </div><!--/.row-->
                </div><!--/.box-->
            </div><!--/.container-->
        </section><!--/#contact-->

        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        &copy; <?php echo date('d-m-Y'); ?>  <a target="_blank" href="novariss.com" title="">vugaPOS</a>. All Rights Reserved.
                    </div>
                    <div class="col-sm-6">
                        <img class="pull-right" height="25px" width="200px" src="<?= base_url(); ?>sprint/images/novariss.png" alt="Novariss" title="Novariss">
                    </div>
                </div>
            </div>
        </footer><!--/#footer-->

        <script src="<?= base_url(); ?>sprint/js/jquery.js"></script>
        <script src="<?= base_url(); ?>sprint/js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>sprint/js/jquery.isotope.min.js"></script>
        <script src="<?= base_url(); ?>sprint/js/jquery.prettyPhoto.js"></script>
        <script src="<?= base_url(); ?>sprint/js/main.js"></script>
    </body>
</html>