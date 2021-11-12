<?php
include 'configvoid.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title> TEXT TO SPEECH</title>
    <style>
    label {
        font-size: 20px;
        font-weight: 700;
        font-family: fangsong;
    }

    .audio {}

    select {
        color: currentcolor !important;
    }
    </style>
</head>

<body>
    <div class="container col-md-5">
        <form onsubmit="return false" style="padding: 2rem;">
            <div class="form-group">
                <label for="exampleInput">Text</label>
                <textarea class="form-control" id="textinput" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="exampleSelect1">Voice</label>
                <select class="form-control btn-outline-light" id="voice" required>
                </select>
            </div>
            <button type="submit" class="btn btn-light" name="submit" style="width: 100%; margin-bottom: 3rem;">
                <span id="submit" class="btn-outline-info d-flex justify-content-center"
                    style="font-family: monospace;font-size: x-large;"> SUBMIT </span>
            </button>
        </form>
        <div class="audio d-flex justify-content-center">
        </div>
    </div>

    <script>
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {
            method: "viewnamevoid"
        },
        cache: false,
        success: function(data) {
            $('#voice').html(data);
        }
    })
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {
            method: "languageCode"
        },
        cache: false,
        success: function(data) {
            $('#language').html(data);
        }
    })
    </script>
</body>
<script>
$(document).ajaxStart(function() {
    swal.showLoading();
});
$(document).ajaxComplete(function() {
    swal.close();
});

function showaudio(e) {
    $('.audio').html(
        '<audio id="audio" controls class="audio d-flex justify-content-center" autoplay="autoplay"><source id="audiosource" src="audio/' +
        e + '" type="audio/mp3"></audio>'
    );
}
$(document).on('click', '#submit', function(e) {
    $('#audio').remove();

    text = $('#textinput').val();
    namevoid = $('#voice').val();
    languageCode = namevoid.substring(0, 10);
    languageCode = languageCode.substring(0, languageCode.lastIndexOf("-"));
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: {
            method: "showaudio",
            text,
            namevoid,
            languageCode
        },
        cache: false,
        dataType: 'JSON',
        success: function(data) {
            var url = './audio/' + data.filename;
            if (data.isaudio) {
                $.get(url).done(function() {
                    showaudio(data.filename);
                }).fail(function() {
                    console.log('error')
                })
            }
        }
    })
})
</script>

</html>