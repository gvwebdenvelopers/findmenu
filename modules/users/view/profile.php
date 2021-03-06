<!-- create users -->
<script type="text/javascript" src="<?php echo USERS_JS_PATH ?>profile.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
<link type="text/css" href="<?php echo USERS_CSS_PATH ?>users_style.css" rel="stylesheet">
<link type="text/css" href="<?php echo USERS_CSS_PATH ?>profile.css" rel="stylesheet">
<section id="form_users" class="section-padding">
  <div class="container">
          <h1 class="header-h"> Editar perfil</h1>
          <div class="col-md-8 col-sm-8">
              <div class="col-md-6 col-sm-6 contact-form pad-form">
                  <div class="form-group label-floating is-empty">
                      <input id="input_name" class="form-control" type="text" placeholder="Nombre">
                  </div>
              </div>
              <div class="col-md-6 col-sm-6 contact-form">
                  <div class="form-group label-floating is-empty">
                      <input id="birth_date" class="form-control" type="text" placeholder="Fecha de nacimiento: ">
                  </div>
              </div>
              <div class="col-md-6 col-sm-6 contact-form pad-form">
                  <div class="form-group label-floating is-empty">
                      <input id="last_name" class="form-control" type="text" placeholder="Apellidos">
                  </div>
              </div>
              <div class="col-md-6 col-sm-6 contact-form">
                  <div class="form-group label-floating is-empty">
                      <input id="user_email" class="form-control" type="email" placeholder="Email">
                  </div>
              </div>
              <div class="col-md-6 col-sm-6 contact-form">
                <div class="form-group label-floating is-empty">
                  <p>Tipo de usuario:
                  <select class="form-control" id="inputType" name="Tipo de usuario">
                      <option value="client">Cliente</option>
                      <option value="offeror">Ofertante</option>
                  </select></p>
                </div>
              </div>
              <!--<div id="inputfavoriteMenus" class="col-md-6 col-sm-6 contact-form">
                  <label class="pefil">Menus preferidos:</label>
                  <div class="form-group label-floating is-empty">
                      <input id="favoriteMenus" name="Menus preferidos" readonly></input>
                  </div>
              </div>
              <div id="inputPassword" class="col-md-6 col-sm-6 contact-form">
                  <div class="form-group label-floating is-empty">
                    <label class="pefil">Introduce tu contraseña para modificar tus datos:</label>
                    <input id="password" class="form-control" type="pass" placeholder="Contraseña" required>
                  </div>
              </div>-->
              <div class="col-md-6 col-sm-6 contact-form">
                  <label class="pefil">Pais:</label>
                  <div class="form-group label-floating is-empty">
                      <select id="country" name="pais"></select>

                  </div>
              </div>
              <div class="col-md-6 col-sm-6 contact-form">
                  <label class="pefil">Provincia:</label>
                  <div class="form-group label-floating is-empty">
                      <select id="province" name="provincia"></select>

                  </div>
              </div>
              <div class="col-md-6 col-sm-6 contact-form">
                  <label class="pefil">Poblacion:</label>
                  <div class="form-group label-floating is-empty">
                      <select id="city" name="poblacion"></select>

                  </div>
              </div>
              <br />
              <div class="col-md-12 contact-form">
                <h1 class="form-profile-heading" id="username">Profile Image</h1>
                <img id="avatar_user" src="" />

                <span id="e_avatar" class="styerror" style="color:#FF0000"></span>
                <div class="form-group" id="progress">
                    <div id="bar"></div>
                    <div id="percent">0%</div >
                </div>
                <div class="msg"></div>
                <br/>
                <div id="dropzone" class="dropzone"></div><br/>
                <br/>

              </div>
              <div class="col-md-12 btnpad">
                  <div class="contacts-btn-pad">
                      <button type="button" id ="submit_users" name="submit_users" class="contacts-btn" value="submit">Actualizar perfil</button>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- / create users -->
