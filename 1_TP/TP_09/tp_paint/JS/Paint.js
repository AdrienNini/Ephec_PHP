var canvas;
var context;
var thicknessCanvas;
var thicknessContext;
var imageObj = new Image();

window.onload = initCanvas;

function initCanvas() {
    // Get the canvas and the drawing context.
    canvas = document.getElementById("drawingCanvas");
    canvas.width = 500;
    canvas.height = 500;
    context = canvas.getContext("2d");

    // Attach the events that you need for drawing.
    canvas.onmousedown = startDrawing;
    canvas.onmouseup = stopDrawing;
    canvas.onmouseout = stopDrawing;
    canvas.onmousemove = draw;
    imageObj.onload = function () {
        context.drawImage(imageObj, 0, 0, imageObj.width, imageObj.height);
    };

    // Thickness Canvas
    thicknessCanvas = $('#thicknessCanvas')[0];
    thicknessContext = thicknessCanvas.getContext('2d');
    drawThickness(3);
}

var isDrawing = false;

function startDrawing(e) {
    // Start drawing.
    isDrawing = true;

    // Create a new path (with the current stroke color and stroke thickness).
    context.beginPath();

    // Put the pen down where the mouse is positioned.
    context.moveTo(e.pageX - canvas.offsetLeft, e.pageY - canvas.offsetTop);
}

function stopDrawing() {
    isDrawing = false;
}

function draw(e) {
    if (isDrawing == true) {
        // Find the new position of the mouse.
        var x = e.pageX - canvas.offsetLeft;
        var y = e.pageY - canvas.offsetTop;

        // Draw a line to the new position.
        context.lineTo(x, y);
        context.stroke();
    }
}

function changeColor(color) {
    // Change the current drawing color.
    context.strokeStyle = color;

    thicknessContext.strokeStyle = color;
    thicknessContext.fillStyle = color;
    drawThickness($('#thicknessSize').slider('value'));

}

function changeThickness(thickness) {
    // Change the current drawing thickness.
    context.lineWidth = thickness;
}


function clearCanvas() {
    context.clearRect(0, 0, canvas.width, canvas.height);
}

function saveCanvas() {
    // Find the <img> element.
    var imageCopy = document.getElementById("savedImageCopy");

    // Show the canvas data in the image.
    imageCopy.src = canvas.toDataURL();

    // Unhide the <div> that holds the <img>, so the picture is now visible.
    var imageContainer = document.getElementById("savedCopyContainer");
    imageContainer.style.display = "block";
}

function resize(img) {
    if (img.width > canvas.width) {
        let ratio = canvas.width / img.width;
        img.height *= ratio;
        img.width = canvas.width;
    }

    if (img.height > canvas.height) {
        let ratio = canvas.height / img.height;
        img.height = canvas.height;
        img.width *= ratio;
    }
}

function handleImage(e) {
    var reader = new FileReader();
    reader.onload = function (event) {
        var img = new Image();
        img.onload = function () {
            resize(img);
            context.drawImage(img, 0, 0, img.width, img.height);
        };
        img.src = event.target.result;
    };
    reader.readAsDataURL(e.target.files[0]);
}

function callAjax(dataUrl) {
    var request = new XMLHttpRequest();
    request.open('GET', dataUrl, true);
    request.onreadystatechange = function () {
        // Makes sure the document is ready to parse.
        if (request.readyState == 4) {
            // Makes sure it's found the file.
            if (request.status == 200) {
                imageObj.src = request.responseText;
                resize(imageObj);
            }
        }
    };
    request.send(null);
}

function drawThickness(size) {
    thicknessContext.clearRect(0, 0, thicknessCanvas.width, thicknessCanvas.height);
    thicknessContext.beginPath();
    thicknessContext.arc(thicknessCanvas.width / 2, thicknessCanvas.height / 2, size / 2, 0, 2 * Math.PI);
    thicknessContext.fill();
    thicknessContext.stroke();
    changeThickness(size)
}


$(document).ready(function () {
    initCanvas();

    $('.accordeon').accordion({
        animate: 250,
        heightStyle: "content"
    });
    $('#menuUpload').dialog({
        position: {
            my: "left top",
            at: "center bottom",
            of: "body div:first"
        },
        closeOnEscape: true,
        autoOpen: false,
        show: {effect: "slide", direction: "up", duration: 250},
        hide: {effect: "drop", duration: 500}
    });
    $('body div:first').click(function (evt) {
        evt.preventDefault();
        $('#menuUpload').dialog('open');
    }).css({cursor: 'pointer'});
    $('#formWeb').submit(function (evt) {
        evt.preventDefault();
        imageObj.src = $(this)[0].iWeb.value;
        resize(imageObj);
        $('#menuUpload').dialog('close');
    });
    $('#formAjax').submit(function (evt) {
        evt.preventDefault();
        //callAjax($(this)[0].iAjax.value);
        $.get($(this)[0].iAjax.value, function (data) {
            imageObj.src = data;
            resize(imageObj);
        });
        $('#menuUpload').dialog('close');
    });
    $('#imageLoader').change(function (evt) {
        handleImage(evt);
        $('#menuUpload').dialog('close');
    });
    $(".colorpicker").mouseover(function () {
        changeColor($('.colorpicker_new_color').css('background-color'));
    });
    $('#thicknessSize').slider({
        min: 1,
        max: 10,
        step: 1,
        value: 3,
        create: function (event, ui) {
            //$('#custom-handle').text($(this).slider("value"));
            changeColor($('.colorpicker_new_color').css('background-color'));
        },
        slide: function (event, ui) {
            //$('#custom-handle').text(ui.value);
            drawThickness(ui.value);
        }
    });
    $('#canvasSize').click(function (evt) {
        evt.preventDefault();
        canvas.width = $(this).val();
        canvas.height = $(this).val();
    })
});