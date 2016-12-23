$(document).ready(function () {
    /////**modal login*///
    var modalbase = '<div class="modal fade" id="modalLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">' +
            '<div class="modal-dialog" role="document">' +
            '<div class="modal-content">' +
            '</div>' +
            '<div class="modal-footer">' +
            '<div class="8u 12u$(medium)">' +
            '<div class="copyright">' +
            '&copy; 2016 findMenu. All rights reserved.' +
            ' </div>' +
            '</div>' +
            '</div>' +
            '</div>';
    $("#LoginModal").append(modalbase);
   
    ////**user menu*///
    var user = Tools.readCookie("user");
    if (user) {
        //console.log(user); //yomogan|https://projects-alumnes-yomogan.c9users.io/proj_final_login/JoinElderly//media/flowers.png|client|yomogan
        user = user.split("|");
        $("#LogProf").html("<a href=" + amigable('?module=users&function=profile') + "><img id='menuImg' class='icon rounded' src='" + user[1] + "'/>" + user[3] + "</a>");
        $("#LogProf").after("<li><a id='logout' href='#' >Log Out</a></li>");
        if ( (user[2] === "client")  ) {
            $("#LogProf").before("<li><a href=" + amigable('?module=products') + ">Mis ofertas</a></li>")
        } else if (user[2] === "admin") {
            $("#LogProf").before("<li><a href=" + amigable('?module=admin') + ">Administrar</a></li>")
        }
        $("head").append("<script src='https://findmenu.es/modules/users/view/js/logout.js'></script>");
    }

    var url = window.location.href;
    url = url.split("/");
    //console.log("4 " + url[4] + " 5 " + url[5]);
    if (url[4] === "verify" && url[5].substring(0, 3) == "Ver"){
        $("#alertbanner").html("<a href='#alertbanner' class='alertbanner'>Su email ha sido verificado, disfrute de nuestros servicios</div>");
    }else if(url[5]==="503"){
         $("#alertbanner").html("<a href='#alertbanner' class='alertbanner alertbannerErr'>Hay un problema en la base de datos, inténtelo más tarde</div>");
    }else if (url[4] === "init") {
        if (url[5] === "reg"){
            $("#alertbanner").html("<a href='#alertbanner' class='alertbanner'>Se le ha enviado un email para verificar su cuenta</div>");
        }else if (url[5] === "rest"){
            $("#alertbanner").html("<a href='#alertbanner' class='alertbanner'>Se ha cambiado satisfactoriamente su contraseña</div>");
        }
    } else if (url[4] === "profile"){
        if (url[5] === "done")
            $("#alertbanner").html("<a href='#alertbanner' class='alertbanner'>Usuario correctamente actualizado</div>");
    }
});
