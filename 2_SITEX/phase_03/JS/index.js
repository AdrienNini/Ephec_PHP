var myData = [];

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
    $.ajaxSetup({processData: false, contentType: false});
    var data = new FormData();
    var request = 'unknownUri';
    switch (true) {
        case Boolean(elem.href):
            request = $(elem).attr('href').split(".html")[0];
            break;

        case Boolean(elem.action):
            request = $(elem).attr('action').split('.html')[0];
            data = new FormData(elem);
            break;
    }
    data.append('senderId', elem.id);
    $.post("?rq=" + request, data, gereRetour);

}

function gereRetour(retour) {
    retour = testeJson(retour);
    var destination = '#contenu';
    if ($(retour['destination']).length > 0) {
        destination = retour['destination'];
        delete (retour['destination']);
    }
    for (var action in retour) {
        switch (action) {
            case 'display':
                $('#contenu').html(retour[action]);
                break;

            case 'debug':
            case 'error':
                $('#' + action).html(retour[action]).fadeIn(1200);
                break;

            case 'makeTable':
                var table = makeTable(retour[action]);
                $(destination).html(table).fadeIn(500);
                break;

            case 'jsonError':
                var html = '<b>Error : </b><br>'
                        + retour[action].error
                        + '<hr><b>Json : </b><br>'
                        + retour[action].json;
                $('#' + action).html(html).fadeIn(1200);
                break;

            case 'formTP05':
                $('#contenu').html(retour[action]);
                $('#formSelect').change(function () {
                    appelAjax(this.parentElement);
                });
                break;

            case 'data':
                myData['allGroups'] = JSON.parse(retour[action]);
                $('#formSelect').html(makeOptions(myData.allGroups, 'nom', 'nom'));
                //$('#debug').html(makeTable(JSON.parse(retour[action]))).fadeIn(1200);
                break;

            case 'cacher':
                $(retour[action]).fadeOut(500);
                break;

            case 'montrer':
                $(retour[action]).fadeIn(500);
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

// [{a:1,b:'bonjour'},{a:2,b:'allez ....'},{a:3,b:'au revoir'}]

function makeOptions(list, value, displayTxt) {
    var option ='';
    list.forEach(function(x) {
        option += '<option value=' + x[value] + '>' + x[displayTxt] + '</option>\n'
    });
    return option;
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
    var out = '<table class="myTab ' + elementType +  '">'
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

