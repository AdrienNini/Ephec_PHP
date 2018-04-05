$(document).ready(function() {

    /**
     * Page Initialization
     */


    var credits = $('#credits');
    credits.hide();

    // Set target to blank for all links in #credits
    $('#credits a').each(function() {
        $(this).attr('target', '_blanck');
    });

    $("a[href='index.html']").focus();

    /**
     * Event Managment
     */

    // Show the credits when mouse is over "crédits" word
    $('#auteur + span').mouseover(function() {
        credits.fadeIn();
    });

    // Hide the credits when mouse leaves the footer
    $('#copyright').mouseleave(function() {
        credits.fadeOut();
    });

    // Event managment for AJAX calling function
    $('.menu a').click(appelAjax);


});


function appelAjax(event) {
    event.preventDefault();

    var request = $(this).focus().attr('href').split(".html")[0];
    $.get("/TP/2T/RES/appelAjax.php?rq=" + request, gereRetour);

}

function gereRetour(retour) {
    retour = testeJson(retour);
    $("#contenu").html(retour);
}

function testeJson(json) {
    var parsed;
    try {
        parsed = JSON.parse(json);
        parsed = "C'est bien du JSON dont les clés sont : <hr>"
                + Object.keys(parsed).join(" - ")
                + "<hr>"
                + json;
    } catch(e) {
        parsed = json;
    }

    return parsed;
}