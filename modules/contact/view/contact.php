

<script src="<?php echo CONTACT_LIB_PATH; ?>jquery.validate.min.js"></script>
<script src="<?php echo CONTACT_LIB_PATH; ?>jquery.validate.extended.js"></script>
<script src="<?php echo CONTACT_JS_PATH; ?>contact.js"></script>

<div class="contact">
        <form id="contact_form" name="contact_form" class="details-holder">
            <div class="modal-header">
                <h1><C>CONTACT US</C></h1>
            </div>
            <div class="modal-body">
                <div>
                    <input class="text" type="text" id="inputName" name="inputName" placeholder="Name" class="input-block-level" dir="auto" maxlength="100">
                </div>
                <div>
                    <input class="text" type="text" id="inputEmail" name="inputEmail" placeholder="Email *" class="input-block-level" maxlength="100">
                </div>
                <div>
                    <label class="subject" for="sel1">Subject:</label>
                    <select class="select" id="inputSubject" name="inputSubject" title="Choose subject">
                <option value="compra">Info relativa a tu compra</option>
                <option value="evento">Celebra un evento con nosotros</option>
                <option value="programacion">Contacta con nuestro dpto de programación</option>
                <option value="Trabaja">Trabaja con nosotros</option>
                <option value="proyectos">Deseas proponernos proyectos</option>
                <option value="sugerencias">Haznos sugerencias</option>
                <option value="reclamaciones">Atendemos tus reclamaciones</option>
                <option value="club">Club FindMenu</option>
                <option value="sociales">Proyectos sociales</option>
                <option value="novedades">Te avisamos de nuestras novedades</option>
                <option value="diferente">Algo diferente</option>
            </select>
                </div>
                <div>
                    <textarea class="text" rows="4" name="inputMessage" placeholder="Message *" style="max-width: 100%;" dir="auto"></textarea>
                </div>
                <input class="btn-read-more" type="submit" name="submit" id="submitBtn" disabled="disabled" value="send" />
                <img src="<?php echo CONTACT_IMG_PATH; ?>ajax-loader.gif" alt="ajax loader icon" class="ajaxLoader" /><br/><br/>
                <div id="resultMessage" class='alert alert-success' style="display: none;"></div>
            </div>
        </form>
    </div>
