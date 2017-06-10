<?php require_once(APPPATH . 'views/css-page.php'); ?>
<?php
$jan = 0;
$feb = 0;
$mar = 0;
$apr = 0;
$may = 0;
$jun = 0;
$jul = 0;
$aug = 0;
$sept = 0;
$oct = 0;
$nov = 0;
$dec = 0;

if (is_array($payments_year) && count($payments_year)) {
    foreach ($payments_year as $loop) {

        if (date("m", strtotime($loop->date)) == "1") {
            $jan = $jan + 1;
        }
        if (date("m", strtotime($loop->date)) == "2") {
            $feb = $feb + 1;
        }
        if (date("m", strtotime($loop->date)) == "3") {
            $mar = $mar + 1;
        }
        if (date("m", strtotime($loop->date)) == "4") {
            $apr = $apr + 1;
        }
        if (date("m", strtotime($loop->date)) == "5") {
            $may = $may + 1;
        }
        if (date("m", strtotime($loop->date)) == "6") {
            $jun = $jun + 1;
        }
        if (date("m", strtotime($loop->date)) == "7") {
            $jul = $jul + 1;
        }
        if (date("m", strtotime($loop->date)) == "8") {
            $aug = $aug + 1;
        }
        if (date("m", strtotime($loop->date)) == "9") {
            $sep = $sep + 1;
        }
        if (date("m", strtotime($loop->date)) == "10") {
            $oct = $oct + 1;
        }
        if (date("m", strtotime($loop->date)) == "11") {
            $nov = $jan + 1;
        }
        if (date("m", strtotime($loop->date)) == "12") {
            $dec = $dec + 1;
        }
    }
    // echo $march.'<br>';
    //  echo $jan.'<br>';
}
?>  
<head>
    <script type="text/javascript" src="<?= base_url(); ?>js/jquery.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Monthly Transactions'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Amount'
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                        name: '<?php echo $this->session->userdata('company'); ?>',
                        data: [<?php echo $jan; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $apr; ?>, <?php echo $may; ?>,<?php echo $jun; ?>,<?php echo $jul; ?>, <?php echo $aug; ?>,<?php echo $sept; ?>, <?php echo $oct; ?>,<?php echo $nov; ?>, <?php echo $dec; ?>]
                    }, {
                        name: 'sales',
                        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                    }]
            });
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('#container2').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: 'Ticket Sale Count Distribution'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                },
                series: [{
                        type: 'pie',
                        name: 'Browser share',
                        data: [
                            ['Firefox', 45.0],
                            ['IE', 26.8],
                            {
                                name: 'Chrome',
                                y: 12.8,
                                sliced: true,
                                selected: true
                            },
                            ['Safari', 8.5],
                            ['Opera', 6.2],
                            ['Others', 0.7]
                        ]
                    }]
            });
        });
    </script>


</head>
<body>
    <div class="page-content">
     
        <div class="row-fluid">
            <div class="span12">
                <!--PAGE CONTENT BEGINS-->

                <div class="alert alert-block alert-success">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="icon-remove"></i>
                    </button>

                    <i class="icon-ok green"></i>

                   Point of sale
                    <strong class="green">
                        vuga
                        <small>POS</small>
                    </strong>
                   
                </div>

                <div class="space-6"></div>

                <div class="row-fluid">
                    <div class="span12 infobox-container">
                        <div class="infobox infobox-green  ">
                            <div class="infobox-icon">
                                <i class="icon-comments"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">32</span>
                                <div class="infobox-content">comments + 2 reviews</div>
                            </div>
                            <div class="stat stat-success">8%</div>
                        </div>

                        <div class="infobox infobox-blue  ">
                            <div class="infobox-icon">
                                <i class="icon-twitter"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">11</span>
                                <div class="infobox-content">new followers</div>
                            </div>

                            <div class="badge badge-success">
                                +32%
                                <i class="icon-arrow-up"></i>
                            </div>
                        </div>

                        <div class="infobox infobox-pink  ">
                            <div class="infobox-icon">
                                <i class="icon-shopping-cart"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">8</span>
                                <div class="infobox-content">new orders</div>
                            </div>
                            <div class="stat stat-important">+4%</div>
                        </div>

                        <div class="infobox infobox-red  ">
                            <div class="infobox-icon">
                                <i class="icon-beaker"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">7</span>
                                <div class="infobox-content">experiments</div>
                            </div>
                        </div>

                        <div class="infobox infobox-orange2  ">
                            <div class="infobox-chart">
                                <span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">6,251</span>
                                <div class="infobox-content">pageviews</div>
                            </div>

                            <div class="badge badge-success">
                                7.2%
                                <i class="icon-arrow-up"></i>
                            </div>
                        </div>

                      
                        <div class="space-6"></div>

                       
                    </div>

                    <div class="vspace"></div>

                </div><!--/row-->

              
            
                <!--PAGE CONTENT ENDS-->
            </div><!--/.span-->
        </div><!--/.row-fluid-->
    </div><!--/.page-content-->

    <script src="<?= base_url(); ?>js/highcharts.js"></script>
    <script src="<?= base_url(); ?>js/modules/exporting.js"></script>
    <script src="<?= base_url(); ?>js/highcharts-3d.js"></script>
    <div class="row">
        <div class="col-md-6">
            <div id="container" style="min-width: 210px; height: 400px; margin: 0 auto">

            </div>

        </div>
        <div class="col-md-6">
            <div id="container2" style="min-width: 210px; height: 400px; margin: 0 auto">

            </div>

        </div>
    </div>

</body>
</html>