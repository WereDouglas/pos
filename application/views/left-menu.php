<div id="sidebar"  class="nav-collapse ">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu" id="nav-accordion">

        <p class="centered"><a href="profile.html"><img src="<?= base_url(); ?>uploads/<?php echo $this->session->userdata('image'); ?>" class="img-circle" width="60"></a></p>
        <h5 class="centered"><?php echo $this->session->userdata('username'); ?></h5>

        <li class="mt">
            <a class="active" target="frame" href="<?php echo base_url() . "index.php/home/start"; ?>">
                <i class="fa fa-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-print"></i>
                <span>Manage payments</span>
            </a>
            <ul class="sub">
                <li><a  target="frame" href="<?php echo base_url() . "index.php/rent/pay"; ?>">Rent</a></li>
                <li><a  target="frame" href="<?php echo base_url() . "index.php/utility/pay"; ?>">Utilities</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/bank/bank"; ?>">Client banking</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/expense/pay"; ?>">Client expense</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/rent/partial"; ?>">Partial payment</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/damage/"; ?>">Damage</a></li>

            </ul>
        </li>
        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-list"></i>
                <span>Lists</span>
            </a>
            <ul class="sub">
                <li><a  target="frame" href="<?php echo base_url() . "index.php/expense/"; ?>">Expenses</a></li>
                <li><a  target="frame" href="<?php echo base_url() . "index.php/bank/"; ?>">Banking</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/damage"; ?>">Damages</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/rent/partials"; ?>">Partial payments</a></li>

            </ul>
        </li>
        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-anchor"></i>
                <span>Tenant actions</span>
            </a>
            <ul class="sub">
                <li><a  target="frame" href="<?php echo base_url() . "index.php/confiscate/"; ?>">Confiscations</a></li>
                <li><a  target="frame" href="<?php echo base_url() . "index.php/evict/"; ?>">Evictions</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/Penalty"; ?>">Penalty</a></li>

            </ul>
        </li>

        <li >
            <a target="frame" href="<?php echo base_url() . "index.php/client"; ?>" >
                <i class="fa fa-users"></i>
                <span>Clients</span>
            </a>

        </li>
        <li>
            <a target="frame" href="<?php echo base_url() . "index.php/estate"; ?>" >
                <i class="fa fa-home"></i>
                <span>Estates/properties</span>
            </a>

        </li>
        <li>
            <a target="frame" href="<?php echo base_url() . "index.php/tenant"; ?>" >
                <i class="fa fa-group"></i>
                <span>Tenants</span>
            </a>                     
        </li>
        <li>
            <a target="frame" href="<?php echo base_url() . "index.php/room"; ?>" >
                <i class="fa fa-user"></i>
                <span>Units /Rooms</span>
            </a>                     
        </li>
        <li >
            <a target="frame" href="<?php echo base_url() . "index.php/user"; ?>" >
                <i class="fa fa-user"></i>
                <span>Users</span>
            </a>

        </li>
        <li class="sub-menu">
            <a href="javascript:;" >
                <i class=" fa fa-bar-chart-o"></i>
                <span>Reports</span>
            </a>
            <ul class="sub">
                <li><a target="frame" href="<?php echo base_url() . "index.php/rent/report"; ?>
                       ">Rent Report</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/report/tenant_all"; ?>">All tenants</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/report/tenant"; ?>">Active tenants</a></li>
                <li><a target="frame" href="<?php echo base_url() . "index.php/report/property"; ?>">Property list</a></li>
            </ul>
        </li>

    </ul>
    <!-- sidebar menu end-->
</div>