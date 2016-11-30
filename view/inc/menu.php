    <!--banner-->
    <section id="banner">
      <div class="bg-color">
        <header id="header">
            <div class="container">
                <div id="mySidenav" class="sidenav">
                  <ul>
                    <li>
                      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    </li>
                    <li class= <?php if($_SESSION['module'] == "home"){ echo "active";}else{ echo "";} ?> >
                      <a href="<?php friendly('?module=home&function=init'); ?>">Inicio</a>
                    </li>
                    <li>
                    <a href="<?php friendly('?module=users&function=create_users'); ?>">Registrarse</a>
                    </li>
                    <li>
                      <a href="<?php friendly('?module=products&function=page_products'); ?>">Restaurantes</a>
                    </li>
                    <li>
                      <a href="<?php friendly('?module=contact&function=view_contact'); ?>">Contact</a>
                    </li>
                  </ul>
                </div>
                <!-- Use any element to open the sidenav -->
                <span onclick="openNav()" class="pull-right menu-icon">☰</span>
            </div>
        </header>
        <div class="container">
        <div class="row">
          <div class="inner text-center">
            <h1 class="logo-name">findMenu</h1>
            <h2>Eslogan findMenu</h2>
            <p>Encuentra los mejores menús cerca de ti</p>
          </div>
        </div>
        </div>
      </div>
    </section>
    <!-- / banner -->
