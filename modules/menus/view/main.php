<!-- <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALz3o_cMEcTa8pzYf5jUhJcBDn48Wlpn8" async defer></script>
<script src="<?php echo MENUS_JS_PATH ?>geolocator.js"></script>
<link href="<?php echo MENUS_CSS_PATH; ?>menus.css" rel="stylesheet"/>
<div class="container">
  <section id="menus" >

          <nav class="options">
              <h2>Menus <span>disponibles cerca de ti</span></h2>
          </nav>

      <div>
              <div id='ubicacion'></div>
              <!-- Se escribe un mapa con la localizacion anterior-->
              <div id="error" style="display:none;"></div><!--muestra mensaje de error si lo hay-->
              <div id="mapholder"></div>
              <div class="menus"></div>
      </div>


  </section>
</div>
