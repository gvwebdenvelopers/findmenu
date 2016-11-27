    <!--banner-->
    <header id="header">
        <div class="container_top_nav">
            <div id="myTopnav" class="topnav">
              <ul>
                <li class="menu_logo">
                  <img src="/view/img/FindMenu_favicon.ico" alt="image favicon"/>
                </li>
                <li class="menu_logo">
                  <span>findMenu</span>
                </li>
                <li class= <?php if($_SESSION['module'] == "home"){ echo "active";}else{ echo "";} ?> >
                  <a href="<?php friendly('?module=home&function=init'); ?>">Inicio</a>
                </li>
                <li class= <?php if($_SESSION['module'] == "users"){ echo "active";}else{ echo "";} ?>>
                <a href="<?php friendly('?module=users&function=form_users'); ?>">Registrarse</a>
                </li>
                <li class= <?php if($_SESSION['module'] == "menus"){ echo "active";}else{ echo "";} ?>>
                  <a href="<?php friendly('?module=menus&function=list_menus'); ?>">Menus</a>
                </li>
                <li class= <?php if($_SESSION['module'] == "contact"){ echo "active";}else{ echo "";} ?>>
                  <a href="<?php friendly('?module=contact&function=view_contact'); ?>">Contact</a>
                </li>
              </ul>
            </div>
        </div>
    </header>
    <!-- / banner -->
