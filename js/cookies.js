// COOOOOKIEEES

function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (3600*1000)); // 1hr
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function deleteCookie(cname) {
    var d = new Date();
    d.setTime(d.getTime() - 1); // Previous date => delete
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=;" + expires +";path=/;";
}