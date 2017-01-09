$(document).ready(function () {
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);

    $("#birth_date").datepicker({
        maxDate: '0',
        changeMonth: true,
        changeYear: true,
        yearRange: "1930:2006"
    });

    $('#submit_users').click(function () {
        validate_user();
    });

    $("#input_name, #birth_date, #last_name , #user_email, #password").keyup(function () {
        if ($(this).val() !== "") {
            $(".error").fadeOut();
            return false;
        }
    });

    $("#input_name").keyup(function () {
        if ($(this).val().length >= 2) {
            $(".error").fadeOut();
            return false;
        }
    });
    $("#last_name").keyup(function () {
        if ($(this).val().length >= 3) {
            $(".error").fadeOut();
            return false;
        }
    });

    $("#user_email").keyup(function () {
        var emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        if ($(this).val() !== "" && emailreg.test($(this).val())) {
            $(".error").fadeOut();
            return false;
        }
    });

    $("#password").keyup(function () {
        if ($(this).val().length >= 6) {
            $(".error").fadeOut();
            return false;
        }
    });
    $("#progress").hide();

    Dropzone.autoDiscover = false;
    $("#dropzone").dropzone({
        url: amigable("?module=users&function=upload_avatar"),
        addRemoveLinks: true,
        maxFileSize: 1000,
        dictResponseError: "Ha ocurrido un error en el server",
        acceptedFiles: 'image/*,.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF,.rar,application/pdf,.psd',
        init: function () {
            this.on("success", function (file, response) {
                $("#progress").show();
                $("#bar").width('100%');
                $("#percent").html('100%');
                $('.msg').text('').removeClass('msg_error');
                $('.msg').text('Success Upload image!!').addClass('msg_ok').animate({'right': '300px'}, 300);
            });
        },
        complete: function (file) {
            //if(file.status == "success"){
            //alert("El archivo se ha subido correctamente: " + file.name);
            //}
        },
        error: function (file) {
            //alert("Error subiendo el archivo " + file.name);
        },
        removedfile: function (file, serverFileName) {
            var name = file.name;
            $.ajax({
                type: "GET",
                url: amigable("?module=user&function=delete_avatar&delete=true"),
                data: {"filename": name},
                success: function (data) {
                    $("#progress").hide();
                    $('.msg').text('').removeClass('msg_ok');
                    $('.msg').text('').removeClass('msg_error');
                    $("#e_avatar").html("");

                    var json = JSON.parse(data);
                    if (json.res === true) {
                        var element;
                        if ((element = file.previewElement) != null) {
                            element.parentNode.removeChild(file.previewElement);
                            //alert("Imagen eliminada: " + name);
                        } else {
                            false;
                        }
                    } else { //json.res == false, elimino la imagen también
                        var element;
                        if ((element = file.previewElement) != null) {
                            element.parentNode.removeChild(file.previewElement);
                        } else {
                            false;
                        }
                    }
                }
            });
        }
    });

    $("#province").empty();
    $("#province").append('<option value="" selected="selected">Selecciona una Provincia</option>');
    $("#province").prop('disabled', true);
    $("#city").empty();
    $("#city").append('<option value="" selected="selected">Selecciona una Poblacion</option>');
    $("#city").prop('disabled', true);

    $("#country").change(function () {
        var pais = $(this).val();
        var provincia = $("#province");
        var poblacion = $("#city");
        console.log( pais );
        if (pais !== 'ES') {
            provincia.prop('disabled', true);
            poblacion.prop('disabled', true);
            $("#province").empty();
            $("#city").empty();
        } else {
            provincia.prop('disabled', false);
            poblacion.prop('disabled', false);
            load_provinces_v1("");
        }
    });

    $("#province").change(function () {
        var prov = $(this).val();
        if (prov > 0) {
            load_cities_v1(prov, "");
        } else {
            $("#city").prop('disabled', false);
        }
    });

    var user = Tools.readCookie("user");
    //console.log( user );
    if (user) {
        user = user.split("|");
        //console.log(user[0]);
        $.post(amigable('?module=users&function=profile_filler'), {user: user[0]},
        function (response) {
            //console.log(response);
            //console.log(response.user);
            //console.log(response.success);
            if (response.success) {
                fill(response.user);
                load_countries_v1(response.user['country']);
                if (response.user['country'] === "ES") {
                    $("#province").prop('disabled', false);
                    $("#city").prop('disabled', false);
                    load_provinces_v1(response.user['province']);
                    load_cities_v1(response.user['province'], response.user['city']);
                }
            } else {
                window.location.href = response.redirect;
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.errorThrown);
            console.log(xhr.textStatus);
            console.log(xhr.responseText);
            if (xhr.status === 0) {
                alert('Not connect: Verify Network.');
            } else if (xhr.status === 404) {
                alert('Requested page not found [404]');
            } else if (xhr.status === 500) {
                alert('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                alert('Time out error.');
            } else if (textStatus === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error: ' + xhr.responseText);
            }
        });
    }else{
        alert('User profile not available');
    }
}); //ready

function validate_user() {
    var result = true;
    var emailreg = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    var nomreg = /^\D{3,30}$/;
    var apelreg = /^(\D{3,30})+$/;
    var name = $("#input_name").val();
    var lastname = $("#last_name").val();
    var date_birthday = $("#birth_date").val();
    var email = $("#user_email").val();
    var password = $("#password").val();
    var tipo = $("#inputType").val();
    var pais = $("#country").val();
    var provincia = $("#province").val();
    var poblacion = $("#city").val();
    var avatar = $("#avatar_user").attr('src');
    var user_id = "";
    var user = Tools.readCookie("user");
    //console.log( user );
    if (user) {
        user = user.split("|");
        user_id = user[0];
    }
    $(".error").remove();
    if ($("#input_name").val() === "" || !nomreg.test($("#input_name").val())) {
        $("#input_name").focus().after("<span class='error'>Introduzca su nombre</span>");
        result = false;
    } else if ($("#input_name").val().length < 2) {
        $("#input_name").focus().after("<span class='error'>Mínimo 2 carácteres para el nombre</span>");
        result = false;
    }else if ($("#last_name").val() === "" || !apelreg.test($("#last_name").val())) {
        $("#last_name").focus().after("<span class='error'>Ingrese sus apellidos</span>");
        result = false;
    } else if ($("#last_name").val().length < 3) {
        $("#last_name").focus().after("<span class='error'>Mínimo 3 carácteres para los apellidos</span>");
        result = false;
    } else if (!emailreg.test($("#user_email").val()) || $("#user_email").val() === "") {
        $("#user_email").focus().after("<span class='error'>Ingrese un email correcto</span>");
        result = false;
    } else if( $("#password").val() == "") {

        //console.log("usuario_facebook");
        password = "usuario_facebook";
    } else if ( $("#password").prop('display') != null ){

        //console.log($("#password").val());
        if( $("#password").val() === "" ) {
            $("#password").focus().after("<span class='error'>Ingrese su contraseña</span>");
            result = false;
        } else if($("#password").val().length < 6 ) {
            $("#password").focus().after("<span class='error'>Mínimo 6 carácteres para la contraseña</span>");
            result = false;
        } else if( $("#password").val() === "usuario_facebook" ) {
            $("#password").focus().after("<span class='error'>Lo sentimos, contraseña invalida en el sistema</span>");
            $("#password").val() === "";
            result = false;
        }
    }
    //console.log(result);
    if (result) {
        if (provincia == null) {
            provincia = '';
        } else if (provincia.length == 0) {
            provincia = '';
        } else if (provincia === 'Selecciona una Provincia') {
            return '';
        }

        if (poblacion == null) {
            poblacion = '';
        } else if (poblacion.length == 0) {
            poblacion = '';
        } else if (poblacion === 'Selecciona una Poblacion') {
            return '';
        }

        var data = {"name": name, "last_name": lastname, "date_birthday": date_birthday, "user_email": email,
            "password": password, "type": tipo, "country": pais, "province": provincia, "city": poblacion,
            "avatar": avatar, "user": user_id};
        var data_users_JSON = JSON.stringify(data);
        //console.log(data_users_JSON);
        $.post(amigable("?module=users&function=modify"), {mod_user_json: data_users_JSON},
        function (response) {
            console.log(response.data);
            //console.log(response.success);
            //console.log(response.arrValue);
            if (response.success) {
                window.location.href = response.redirect;
            } else {
                if (!response.success) {
                    window.location.href = response.redirect;
                } else if (response.typeErr === "Name") {
                    $("#inputUser").focus().after("<span class='error'>" + response.error + "</span>");
                } else if (response.typeErr === "Email") {
                    $("#inputEmail").focus().after("<span class='error'>" + response.error + "</span>");
                } else {
                    /*if (response["data"]["name"] !== undefined && response["data"]["name"] !== null) {
                        $("#input_name").focus().after("<span class='error'>" + response["data"]["name"] + "</span>");
                    }
                    if (response["data"]["last_name"] !== undefined && response["data"]["last_name"] !== null) {
                        $("#inputSurn").focus().after("<span class='error'>" + response["data"]["last_name"] + "</span>");
                    }
                    if (response["data"]["date_birthday"] !== undefined && response["data"]["date_birthday"] !== null) {
                        $("#inputBirth").focus().after("<span class='error'>" + response["data"]["date_birthday"] + "</span>");
                    }
                    if (response["data"]["user_email"] !== undefined && response["data"]["user_email"] !== null) {
                        $("#inputEmail").focus().after("<span class='error'>" + response["data"]["user_email"] + "</span>");
                    }

                    if (response["data"]["password"] !== undefined && response["data"]["password"] !== null) {
                        $("#password").focus().after("<span class='error'>" + response.error.password + "</span>");
                    }*/
                }
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(xhr.responseJSON);
            console.log(xhr.responseText);
            if( (xhr.responseJSON === undefined) || (xhr.responseJSON === null) )
                xhr.responseJSON = JSON.parse(xhr.responseText);
            if (xhr.status === 0) {
                alert('Not connect: Verify Network.');
            } else if (xhr.status === 404) {
                alert('Requested page not found [404]');
            } else if (xhr.status === 500) {
                alert('Internal Server Error [500].');
            } else if (textStatus === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (textStatus === 'timeout') {
                alert('Time out error.');
            } else if (textStatus === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error: ' + xhr.responseText);
            }
        });
    }
}

function fill(user) {
    console.log(user);
    $("#input_name").val(user['name']);
    $("#last_name").val(user['lastname']);
    $("#birth_date").val(user['birthdate']);
    $("#inputPass").val(user['password']);
    $("#inputType").val(user['usertype']);
    //$("#username").html(user['nombre']);
    $("#avatar_user").attr('src', user['avatar']);
    $("#user_email").val(user['email']);
    if (user['email'])
        $("#user_email").attr('disabled', true);
    if (user['usertype'] == 'offeror')
        $("#inputfavoriteMenus").attr('display', 'none');
}


function load_countries_v2(cad, country) {
    console.log(cad);
    $.getJSON( cad, function(data) {
      $("#country").empty();
      if (!country)
            $("#country").append('<option value="" selected="selected">Selecciona un Pais</option>');

        $.each(data, function (i, valor) {
            if (valor.sName.length > 20)
                valor.sName = valor.sName.substring(0, 19);
            if (country == valor.sISOCode)
                $("#country").append("<option value='" + valor.sISOCode + "' selected='selected' >" + valor.sName + "</option>");
            else
                $("#country").append("<option value='" + valor.sISOCode + "'>" + valor.sName + "</option>");
        });
    })
    .fail(function() {
        alert( "error load_countries" );
    });
}

function load_countries_v1(country) {
    //$.get( "modules/products/controller/controller_products.class.php?load_countries=true",
    $.get(amigable("?module=users&function=load_country_user&load_countries=true"),
        function( response ) {
          //console.log( response );
            if(response.match(/error/)){
                //console.log("en error");
                load_countries_v2("resources/ListOfCountryNamesByName.json", country);
            }else{
                //console.log("response succsefully");
                load_countries_v2(amigable("?module=users&function=load_country_user&load_countries=true"), country); //oorsprong.org
            }
    })
    .fail(function(response) {
        //console.log(response);
        load_countries_v2(amigable("?module=users&function=load_country_user&load_countries=true"), country);
    });
}

function load_provinces_v2(prov) {
    $.get("resources/provincesandcityes.xml", function (xml) {
	    $("#province").empty();
	    $("#province").append('<option value="" selected="selected">Select a province</option>');

      $(xml).find("province").each(function () {
          var id = $(this).attr('id');
          var name = $(this).find('name').text();
          if (prov == id)
                $("#province").append("<option value='" + id + "' selected='selected'>" + nombre + "</option>");
            else
                $("#province").append("<option value='" + id + "'>" + nombre + "</option>");
      });
    })
    .fail(function() {
        alert( "error load_provinces" );
    });
}

function load_provinces_v1(prov) { //provincesycityes.xml - xpath
    //$.get( "modules/products/controller/controller_products.class.php?load_provinces=true",
    $.get(amigable("?module=users&function=load_province_user&load_provinces=true"),
        function( response ) {
            $("#province").empty();
	          $("#province").append('<option value="" selected="selected">Select a province</option>');

            //alert(response);
            var json = JSON.parse(response);
    		    var provinces=json.provinces;
    		    //alert(provinces);
    		    //console.log(provinces);

    		    //alert(provinces[0].id);
    		    //alert(provinces[0].name);

            if(provinces === 'error'){
                load_provinces_v2(prov);
            }else{
                for (var i = 0; i < provinces.length; i++) {
                    if (prov == provincias[i].id)
                        $("#province").append("<option value='" + provinces[i].id + "' selected='selected'>" + provinces[i].nombre + "</option>");
                    else
                        $("#province").append("<option value='" + provinces[i].id + "'>" + provinces[i].nombre + "</option>");

                }


    		    }
          }
    })
    .fail(function(response) {
        load_provinces_v2();
    });
}

function load_cities_v2(prov, pobl) {
    $.get("resources/provinciasypoblaciones.xml", function (xml) {
	    $("#city").empty();
      $("#city").append('<option value="" selected="selected">Select a city</option>');

	    $(xml).find('provincia[id=' + prov + ']').each(function(){
    		$(this).find('provincia').each(function(){
           var text = $(this).text();
                if (text.length > 22)
                    text = text.substring(0, 21);
                if (pobl == text)
                    $("#city").append("<option value='" + text + "' selected='selected' >" + text + "</option>");
                else
                    $("#city").append("<option value='" + text + "'>" + text + "</option>");
    		});
      });
	  })
  	.fail(function() {
      //console.log(prov);
      alert( "error load_cities" );
    });
}

function load_cities_v1(prov, pobl) { //provincesycityes.xml - xpath
    var data = { idCity : prov  };
    $.post(amigable("?module=users&function=load_cities_user"), data, function (response) {
	    //$.post("modules/products/controller/controller_products.class.php", data, function(response) {
	    //alert(response);
      var json = JSON.parse(response);
		  var cities=json.cities;

  		$("#city").empty();
	    $("#city").append('<option value="" selected="selected">Select a city</option>');

      if(cities === 'error'){
          load_cities_v2(prov);
      }else{
        for (var i = 0; i < cities.length; i++) {
          if (cities[i].poblacion.length > 22)
              cities[i].poblacion = cities[i].poblacion.substring(0, 21);
          if (pobl == cities[i].poblacion)
              $("#city").append("<option value='" + cities[i].poblacion + "' selected='selected'>" + cities[i].poblacion + "</option>");
          else
              $("#city").append("<option value='" + cities[i].poblacion + "'>" + cities[i].poblacion + "</option>");

    		}

      }
    })
  	.fail(function() {
      load_cities_v2(prov);
    });
}
