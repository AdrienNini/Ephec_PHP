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

    // Set the first element of the menu to selected
    $('#menu a:first').addClass('selected');


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
    $('.menu a').click(function (event) {
        event.preventDefault();
        $('.menu a').removeClass('selected');
        $(this).toggleClass('selected');
        appelAjax(this);
    });


});


function appelAjax(elem) {
    var request = $(elem).attr('href').split(".html")[0];
    $.get("index.php?rq=" + request, gereRetour);

}

function gereRetour(retour) {
    retour = testeJson(retour);
    $('#contenu').html(retour);
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