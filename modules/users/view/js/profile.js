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

    $('#submitBtn').click(function () {
        validate_user();
    });

    $("#input_name, #birth_date, #last_name , #user_email, #user,#password").keyup(function () {
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

    $("#user").keyup(function () {
        if ($(this).val().length >= 3) {
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

    $("#provincia").empty();
    $("#provincia").append('<option value="" selected="selected">Selecciona una Provincia</option>');
    $("#provincia").prop('disabled', true);
    $("#poblacion").empty();
    $("#poblacion").append('<option value="" selected="selected">Selecciona una Poblacion</option>');
    $("#poblacion").prop('disabled', true);

    $("#pais").change(function () {
        var pais = $(this).val();
        var provincia = $("#provincia");
        var poblacion = $("#poblacion");

        if (pais !== 'ES') {
            provincia.prop('disabled', true);
            poblacion.prop('disabled', true);
            $("#provincia").empty();
            $("#poblacion").empty();
        } else {
            provincia.prop('disabled', false);
            poblacion.prop('disabled', false);
            load_provincias_v1("");
        }
    });

    $("#provincia").change(function () {
        var prov = $(this).val();
        if (prov > 0) {
            load_poblaciones_v1(prov, "");
        } else {
            $("#poblacion").prop('disabled', false);
        }
    });

    var user = Tools.readCookie("user");
    if (user) {
        user = user.split("|");
        console.log(user[0]);
        $.post(amigable('?module=users&function=profile_filler'), {user: user[0]},
        function (response) {
            console.log(response);
            if (response.success) {
                fill(response.user);
                load_countries_v1(response.user['pais']);
                if (response.user['pais'] === "ES") {
                    $("#provincia").prop('disabled', false);
                    $("#poblacion").prop('disabled', false);
                    load_provincias_v1(response.user['provincia']);
                    load_poblaciones_v1(response.user['provincia'], response.user['poblacion']);
                }
            } else {
                window.location.href = response.redirect;
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
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
    var apellidos = $("#last_name").val();
    var date_birthday = $("#birth_date").val();
    var email = $("#user_email").val();
    var usuario = $("#user").val();
    var password = $("#password").val();
    var password2 = $("#conf_password").val();
    var tipo = $("#inputType").val();


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
    } else if ($("#user").val() === "" || !nomreg.test($("#user").val())) {
        $("#user").focus().after("<span class='error'>Usuario no válido</span>");
        result = false;
    } else if ($("#user").val().length < 3) {
        $("#user").focus().after("<span class='error'>Mínimo 3 carácteres para el usuario</span>");
        result = false;
    } else if ($("#password").val() === "") {
        $("#password").focus().after("<span class='error'>Ingrese su contraseña</span>");
        result = false;
    } else if ($("#password").val().length < 6) {
        $("#password").focus().after("<span class='error'>Mínimo 6 carácteres para la contraseña</span>");
        result = false;
    } else if ($("#conf_password").val() !== $("#conf_password").val()) {
        $("#conf_password").focus().after("<span class='error'>Debe coincidir con la contraseña</span>");
        result = false;

    if (result) {
        var data = {"name": name, "last_name": lastname, "date_birthday": date_birthday, "user_email": email,
            "user": usuario, "password": password, "password2": password2, "tipo": tipo};
        var data_users_JSON = JSON.stringify(data);
        $.post(friendly("?module=user&function=signup_user"), {signup_user_json: data_users_JSON},
        function (response) {
            if (response.success) {
                window.location.href = response.redirect;
            } else {
                if (response.typeErr === "Name") {
                    $("#inputUser").focus().after("<span class='error'>" + response.error + "</span>");
                } else if (response.typeErr === "Email") {
                    $("#inputEmail").focus().after("<span class='error'>" + response.error + "</span>");
                } else {
                    if (response["data"]["name"] !== undefined && response["data"]["name"] !== null) {
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
                    if (response["data"]["user"] !== undefined && response["data"]["user"] !== null) {
                        $("#user").focus().after("<span class='error'>" + response["data"]["user"] + "</span>");
                    }

                    if (response["data"]["password"] !== undefined && response["data"]["password"] !== null) {
                        $("#password").focus().after("<span class='error'>" + response.error.password + "</span>");
                    }
                }
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            //console.log(xhr);
            //console.log(xhr.responseJSON);
            //console.log(xhr.responseText);
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
}
