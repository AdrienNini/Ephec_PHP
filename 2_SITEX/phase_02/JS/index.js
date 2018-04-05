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

    // Add section#gestion after div#global
    $('#global').after('<section id="gestion"></section>');
    $('#gestion').append('<aside id="error"></aside>')
                .append('<aside id="message"></aside>')
                .append('<aside id="debug"></aside>')
                .append('<aside id="jsonError"></aside>')
                .append('<aside id="kint"></aside>');
    $('#gestion aside').hide();


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

    // Hide aside#error on doubble click
    $('#gestion aside').dblclick(function() {
        $(this).fadeOut(500);
    })


});


function appelAjax(elem) {
    var request = $(elem).attr('href').split(".html")[0];
    $.get("index.php?rq=" + request, gereRetour);

}

function gereRetour(retour) {
    retour = testeJson(retour);
    for (var action in retour) {
        switch (action) {
            case 'display':
                $('#contenu').html(retour[action]);
                break;

            case 'error':
                $('#' + action).html(retour[action]).fadeIn(1200);
                break;

            case 'makeTable':
                var table = makeTable(retour[action]);
                $('#contenu').html(table).fadeIn(1200);
                break;

            case 'jsonError':
                var html = '<b>Error : </b><br>'
                        + retour[action].error
                        + '<hr><b>Json : </b><br>'
                        + retour[action].json;
                $('#' + action).html(html).fadeIn(1200);
                break;

            default:
                console.log('Action inconnue : ' + action);
                console.log(retour[action]);
                break;
        }
    }
}

function testeJson(json) {
    var parsed;
    try {
        parsed = JSON.parse(json);
    } catch(e) {
        parsed = {"jsonError": {'error': e, 'json': json}};
    }

    return parsed;
}

function makeTableFromObject(tab) {
    var firstElement = tab[Object.keys(tab)[0]];
    var elementType = firstElement.constructor.name;
    var fonction = 'makeThead' + elementType;
    var out = '<table class="myTab ' + elementType +  '">'
            + window[fonction](firstElement, elementType)
            + makeTbody(tab, 'Object')
            + '</table>';

    return out;
}

function makeTableFromArray(tab) {
    var firstElement = tab[Object.keys(tab)[0]];
    var elementType = firstElement.constructor.name;
    var fonction = 'makeThead' + elementType;
    var out = '<table class="myTab ' + elementType + '">'
        + window[fonction](firstElement, elementType)
        + makeTbody(tab, 'Array')
        + '</table>';

    return out;
}

function makeTheadObject(el, type='Array') {
    var out = '<thead>\t<tr>\n\t\t<th>' + (type == 'Array' ? 'index' : 'clé') + '</th>'
            + Object.keys(el).map(function(x) {return '\t\n<th>' + x + '</th>'}).join('\n')
            +'\t</tr>\n</thead>\n';

    return out;
}

function makeTheadArray(el, type='Array') {
    var out = '<thead>\t<tr>\n\t\t<th>' + (type == 'Array' ? 'index' : 'clé') + '</th>'
        + Object.keys(el).map(function(x) {return '\t\n<th>col_' + x + '</th>'}).join('\n')
        +'\t</tr>\n</thead>\n';

    return out;
}

function makeTbody(tab, type='Array') {
    var out = '<tbody>'
            + Object.keys(tab)
                    .map(function (k) { return '\t<tr id=' + (type == 'Array' ? 'lig_': '') + k + '>\n\t\t<td>' + k + '</td>\n'
                                                + Object.keys(tab[k])
                                                        .map(function(x) {return '\t\t<td>' + tab[k][x] + '</td>';}).join('\n')
                                                + '\t</tr>';
                    }).join('\n');
            + '</tbody>';

    return out;
}

function makeTable(tab) {
    var fonction = 'makeTableFrom' + tab.constructor.name;
    var out = window[fonction](tab);
    return out;
}

