    <!--banner-->
    <header id="header">
        <div id="alertbanner"></div>
        <div class="container_top_nav">
            <div id="myTopnav" class="topnav">
              <ul>
                <li class="menu_logo">
                  <img src="/view/img/FindMenu_favicon.ico" alt="image favicon"/>
                </li>
                <li class="menu_logo">
                  <span>findMenu</span>
                </li>
                <li id="LogProf" >
                    <a href= "<?php friendly('?module=users'); ?>";
                    class="button special" data-toggle="modal" id="Login" data-target="#modalLog">Acceder</a>
                </li>
                <li class= <?php if($_SESSION['module'] == "home"){ echo "active";}else{ echo "";} ?> >
                  <a href="<?php friendly('?module=home'); ?>">Inicio</a>
                </li>
                <li class= <?php if($_SESSION['module'] == "menus"){ echo "active";}else{ echo "";} ?>>
                  <a href="<?php friendly('?module=menus&function=menus_maps'); ?>">Menus</a>
                </li>
                <li class= <?php if($_SESSION['module'] == "products"){ echo "active";}else{ echo "";} ?>>
                  <a href="<?php friendly('?module=products&function=page_products'); ?>">Restaurantes</a>
                </li>
                <li class= <?php if($_SESSION['module'] == "contact"){ echo "active";}else{ echo "";} ?>>
                  <a href="<?php friendly('?module=contact&function=view_contact'); ?>">Contact</a>
                </li>
              </ul>
            </div>
        </div>
    </header>
    <div id="LoginModal"></div>
    <!-- / banner -->
