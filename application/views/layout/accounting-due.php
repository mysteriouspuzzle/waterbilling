<!-- Left Panel -->

<aside id="left-panel" class="left-panel">
<nav class="navbar navbar-expand-sm navbar-default">

    <?php $this->load->view('layout/title'); ?>

    <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li>
                <a href="accounting/"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
            </li>
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>Sales</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><a href="accounting/walkinsales">Walk-In Sales</a></li>
                    <li><a href="accounting/onlinesales">Online Sales</a></li>
                    <li><a href="accounting/sales">Total Sales</a></li>
                </ul>
            </li>
            <li class="active">
                <a href="accounting/due"> <i class="menu-icon fa fa-calendar"></i>Due Date</a>
            </li>
            <li>
                <a href="accounting/disco"> <i class="menu-icon fa fa-unlink"></i>Disconnection</a>
            </li>
            <li>
                <a href="accounting/recon"> <i class="menu-icon fa fa-link"></i>Reconnection</a>
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>
</aside><!-- /#left-panel -->

<!-- Left Panel -->
