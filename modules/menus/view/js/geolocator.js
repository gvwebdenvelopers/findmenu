$(document).ready(start);
function start() {
    $.post(amigable("?module=menus&function=maploader"), {value: {send: true}},
    function (response) {
        //console.log(response);
        if (response.success) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(mostrarUbicacion);
                cargarmap(response.menus);
                cargarofertas(response.menus);
            } else {
                alert("¡Error! Este navegador no soporta la Geolocalización.");
            }
        } else {
            if (response.error == 503)
                window.location.href = amigable("?module=main&funcion=menus&param=503");
        }
    }, "json").fail(function (xhr, textStatus, errorThrown) {
        //console.log(xhr.responseText);
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

function mostrarUbicacion(position) {
    var times = position.timestamp;
    var latitud = position.coords.latitude;
    var longitud = position.coords.longitude;
    var altitud = position.coords.altitude;
    var exactitud = position.coords.accuracy;

    //setCookie("lat", latitud, 14);
    //setCookie("lon", longitud, 14);
    Tools.createCookie("lat", latitud, 1);
    Tools.createCookie("lon", longitud, 1);
}

function refrescarUbicacion() {
    navigator.geolocation.watchPosition(mostrarUbicacion);
}

function cargarofertas(of) {
    for (var i = 0; i < of.length; i++) {
        var content ='<div class="me" style="display: block;">'+
                        '<div >'+
                            '<div class="inline"><img src="' + of[i].foto + '"></div>'+
                            '<div class="inline"><h3>' + of[i].nombre + '</h3><div> ' + of[i].poblacion + '</div><div >Menú: ' + of[i].precio_menu + ' €</div>  </div>'+
                            '<div class="inline"><img class="stars" src="/modules/menus/view/img/estrellas-' + of[i].valoracion + '.png"></div>'+       
                        '</div>'+
                    '</div>';
        $('.menus').append(content);
    }
}

function marcar(map, menu) {
    var latlon = new google.maps.LatLng(menu.latitud, menu.longitud);
    var image = {
    url: '/modules/menus/view/img/findMenu_icono_png.png',
    // This marker is 20 pixels wide by 32 pixels high.
    size: new google.maps.Size(60, 60),
    // The origin for this image is (0, 0).
    origin: new google.maps.Point(0, 0),
    // The anchor for this image is the base of the flagpole at (0, 32).
    anchor: new google.maps.Point(0, 32)
  };
    var marker = new google.maps.Marker({position: latlon, map: map, title: menu.precio_menu+" €",icon : image, animation: google.maps.Animation.BOUNCE});

    var infowindow = new google.maps.InfoWindow({
        content: '<div class="me" style="display: block;">'+
                        '<div class="map">'+
                            '<div><h3>' + menu.nombre + '</h3><div> ' + menu.poblacion + '</div><div >Menú: ' + menu.precio_menu + ' €</div>  </div>'+
                            '<div><img src="' + menu.foto_menu + '"></div>'+  
                            '<div><img class="stars" src="/modules/menus/view/img/estrellas-' + menu.valoracion + '.png"></div>'+       
                        '</div>'+
                '</div>'
                    
    });
    
    google.maps.event.addListener(marker, 'click', function () {
        infowindow.open(map, marker);
        
        //acceder al dom del InfoWindow para mejorar su aspecto
        google.maps.event.addListener(infowindow, 'domready', function () {
            var iwOuter = $('.gm-style-iw');
            var iwCloser = iwOuter.next();
            var iwBackground = iwOuter.prev();

            iwBackground.children(':nth-child(2)').css({'display': 'none'});
            iwBackground.children(':nth-child(4)').css({'display': 'none'});
            iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                return s + 'left: 76px !important;'
            });
            iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                return s + 'left: 76px !important;'
            });
            iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px', 'background-color': '#f5f5f5', 'z-index': '1'});

            iwCloser.css({
                opacity: '1',
                right: '18px', top: '3px',
                'border-radius': '13px', // circular effect
                'box-shadow': '0 0 5px #3990B9' // 3D effect to highlight the button
            });
            
            iwCloser.mouseout(function () {
                $(this).css({opacity: '1'});
            });
        });
    });
}

function cargarmap(arrArguments) {
    //en este div pondremos el error
    var x = document.getElementById("error");
    navigator.geolocation.getCurrentPosition(showPosition, showError);
    
    function showPosition(position){
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        var latlon = new google.maps.LatLng(lat, lon);
        var mapholder = document.getElementById('mapholder');
        //mapholder.style.height = '550px';
        //mapholder.style.width = '900px';
        var myOptions = {
            center: latlon, zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP, 
            mapTypeControl: true,
            streetViewControl: true
            
        };
        var map = new google.maps.Map(document.getElementById("mapholder"), myOptions);
        // var marker = new google.maps.Marker({position: latlon, map: map, title: "You are here!"});
        
        for (var i = 0; i < arrArguments.length; i++)
            marcar(map, arrArguments[i]);
    }
    function showError(error){
        x.style.display="block";
        switch (error.code){
            case error.PERMISSION_DENIED:
                x.innerHTML = "Denegada la peticion de Geolocalización en el navegador.";
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "La información de la localización no esta disponible.";
                break;
            case error.TIMEOUT:
                x.innerHTML = "El tiempo de petición ha expirado.";
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "Ha ocurrido un error desconocido.";
                break;
        }
    }}
