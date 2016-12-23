    <link href= "/modules/home/view/home.css" rel="stylesheet">
<div id="alertbanner"></div>
<!--banner-->
    
        <div id="alertbanner"></div>
        <div >
            <div class="navbar" >
                <nav>
              <ul>               
                <li class="logotipo">
                  <img src="/view/img/findmenu_2.png" alt="logo findmenu"/>
                </li>
                <li class= <?php if($_SESSION['module'] == "users"){ echo "active";}else{ echo "";} ?>>
                    <a href="/modules/users/view/modal.html"
                     data-toggle="modal" id="Login" data-target="#modalLog">Acceder</a>
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
                </nav>
            </div>
        </div>
    
    <div id="LoginModal"></div>
    <!-- / banner -->