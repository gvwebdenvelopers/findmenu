<div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php friendly('?module=home'); ?>"><img src="<?php echo IMG_PATH ?>logo.png" alt="logo"></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="index.php?module=home">Home</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <i class="icon-angle-down"></i></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php friendly('?module=products_fe&function=create_products'); ?>">Create</a></li>
                            <li><a href="<?php friendly('?module=products_fe&function=list_products'); ?>">View</a></li>
                        </ul>
                    </li>
                    <!--
                    <li class= <?php/* if($_GET['module'] == "products"){ echo "active";}else{ echo "";} */?> >
                        <a href="index.php?module=products&view=create_products">Products</a>
                    </li>
                    -->
                    <li>
                        <a href="index.php?module=pricing">Pricing</a>
                    </li>
                    <li>
                        <a href="index.php?module=services">Services</a>
                    </li>
                    <li>
                        <a href="index.php?module=portfolio">Portfolio</a>
                    </li>
                    <li>
                        <a href="index.php?module=contact">Contact</a>
                    </li>

                </ul>
            </div>
        </div>
    </header><!--/header-->
