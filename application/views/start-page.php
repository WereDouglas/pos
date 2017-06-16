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

$jan_e = 0;
$feb_e = 0;
$mar_e = 0;
$apr_e = 0;
$may_e = 0;
$jun_e = 0;
$jul_e = 0;
$aug_e = 0;
$sept_e = 0;
$oct_e = 0;
$nov_e = 0;
$dec_e = 0;
//var_dump($payments_year);
if (is_array($payments_year) && count($payments_year)) {
    foreach ($payments_year as $loop) {

        if (date("m", strtotime($loop->created)) == "1") {
            $jan = $jan + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "2") {
            $feb = $feb + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "3") {
            $mar = $mar + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "4") {
            $apr = $apr + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "5") {
            $may = $may + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "6") {
            $jun = $jun + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "7") {
            $jul = $jul + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "8") {
            $aug = $aug + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "9") {
            $sep = $sep + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "10") {
            $oct = $oct + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "11") {
            $nov = $jan + $loop->amount;
        }
        if (date("m", strtotime($loop->created)) == "12") {
            $dec = $dec + $loop->amount;
        }
    }

    if (is_array($expenses_year) && count($expenses_year)) {
        foreach ($expenses_year as $loop) {

            if (date("m", strtotime($loop->date)) == "1") {
                $jan_e = $jan_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "2") {
                $feb_e = $feb_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "3") {
                $mar_e = $mar_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "4") {
                $apr_e = $apr_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "5") {
                $may_e = $may_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "6") {
                $jun_e = $jun_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "7") {
                $jul_e = $jul_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "8") {
                $aug_e = $aug_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "9") {
                $sep_e = $sep_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "10") {
                $oct_e = $oct_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "11") {
                $nov_e = $jan_e + $loop->total;
            }
            if (date("m", strtotime($loop->date)) == "12") {
                $dec_e = $de_e + $loop->total;
            }
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
                        name: 'payments',
                        data: [<?php echo $jan; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $apr; ?>, <?php echo $may; ?>,<?php echo $jun; ?>,<?php echo $jul; ?>, <?php echo $aug; ?>,<?php echo $sept; ?>, <?php echo $oct; ?>,<?php echo $nov; ?>, <?php echo $dec; ?>]
                    }, {
                        name: 'expenses',
                        data: [<?php echo $jan_e; ?>, <?php echo $feb_e; ?>, <?php echo $mar_e; ?>, <?php echo $apr_e; ?>, <?php echo $may_e; ?>,<?php echo $jun_e; ?>,<?php echo $jul_e; ?>, <?php echo $aug_e; ?>,<?php echo $sept_e; ?>, <?php echo $oct_e; ?>,<?php echo $nov_e; ?>, <?php echo $dec_e; ?>]

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
                    text: 'Activity Distribution'
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
                        name: 'Transaction Distribution',
                        data: [
                            ['Sales', <?php echo count($sales); ?>],
                            ['Purchase', 26.8],
                            {
                                name: 'Billing',
                                y: 12.8,
                                sliced: true,
                                selected: true
                            },
                            ['Expenses',<?php echo count($expenses); ?>],
                            ['Invoices', 6.2],
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
                    <?php $this->session->userdata('username'); ?>
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
                                <i class="icon-shopping-cart"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number"><?php echo count($sales); ?></span>
                                <div class="infobox-content">Sales</div>
                            </div>
                            <div class="stat stat-success">8%</div>
                        </div>

                        <div class="infobox infobox-blue  ">
                            <div class="infobox-icon">
                                <i class="icon-credit-card"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number"><?php echo count($payments_today); ?></span>
                                <div class="infobox-content">Payments today</div>
                            </div>

                            <div class="badge badge-success">
                                <?php echo count($sum_today); ?>
                                <i class="icon-arrow-up"></i>
                            </div>
                        </div>

                        <div class="infobox infobox-pink  ">
                            <div class="infobox-icon">
                                <i class="icon-table"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number"><?php echo count($bills); ?></span>
                                <div class="infobox-content">Invoices</div>
                            </div>
                            <div class="stat stat-important">+4%</div>
                        </div>

                        <div class="infobox infobox-red  ">
                            <div class="infobox-icon">
                                <i class="icon-barcode"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number"><?php echo count($expenses); ?></span>
                                <div class="infobox-content">Expenses</div>
                            </div>
                        </div>

                        <div class="infobox infobox-orange2  ">
                            <div class="infobox-chart">
                                <i class="icon-chart"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number"><?php echo count($items); ?></span>
                                <div class="infobox-content">Inventory</div>
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
        <div class="span6">
            <div id="container" style="min-width: 210px; height: 400px; margin: 0 auto">

            </div>

        </div>
        <div class="span6">
            <div id="container2" style="min-width: 210px; height: 400px; margin: 0 auto">

            </div>

        </div>
    </div>

</body>
</html>