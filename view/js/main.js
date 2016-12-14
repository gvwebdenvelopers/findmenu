function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
<<<<<<< HEAD
=======
function amigable1(url) {
    var link="";
    url = url.replace("?", "");
    url = url.split("&");

    for (var i=0;i<url.length;i++) {
        var aux = url[i].split("=");
        link +=  "/"+aux[1];
    }
    return link;
}
>>>>>>> oscar_produccion

function amigable(url) {
    var link="";
    url = url.replace("?", "");
    url = url.split("&");

    for (var i=0;i<url.length;i++) {
        var aux = url[i].split("=");
        link +=  "/"+aux[1];
    }
<<<<<<< HEAD
    return "http://findmenu.es/" + link;
    //return "http://findmenu.com/" + link;
    //return "http://www.findmenu.tk/" + link;
}
=======
    //console.log("http://findmenu.com" + link);
    console.log("http://findmenu.com" + link);
    return "http://findmenu.com" + link;
}
>>>>>>> oscar_produccion
