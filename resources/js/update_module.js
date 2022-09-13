function start(){
    $.ajax({
        url: 'addonmodules.php?module=arvancdn&action=update.start',
        method: 'post',
        dataType: 'json',
        beforeSend: function(){
            $('.step-upgrade[data-type="start"] > div:last-child').html(`<div class="update_loading"></div>`);
        },
        success: function(json){
            if(json.ok) {
                $('.step-upgrade[data-type="start"] > div:last-child').html(`<div class="update_check"></div>`);
                download();
            } else {
                $('.step-upgrade[data-type="start"] > div:last-child').html(`<div class="update_error"></div>`);
            }
        },
        error: function(error){},
    })
}

function download(){
    $.ajax({
        url: 'addonmodules.php?module=arvancdn&action=update.download',
        method: 'post',
        dataType: 'json',
        beforeSend: function(){
            $('.step-upgrade[data-type="download"] > div:last-child').html(`<div class="update_loading"></div>`);
        },
        success: function(json){
            if(json.ok) {
                $('.step-upgrade[data-type="download"] > div:last-child').html(`<div class="update_check"></div>`);
                extract();
            } else {
                $('.step-upgrade[data-type="download"] > div:last-child').html(`<div class="update_error"></div>`);
            }
        },
        error: function(error){},
    })
}

function extract(){
    $.ajax({
        url: 'addonmodules.php?module=arvancdn&action=update.extract',
        method: 'post',
        dataType: 'json',
        beforeSend: function(){
            $('.step-upgrade[data-type="extract"] > div:last-child').html(`<div class="update_loading"></div>`);
        },
        success: function(json){
            if(json.ok) {
                $('.step-upgrade[data-type="extract"] > div:last-child').html(`<div class="update_check"></div>`);
                finish();
            } else {
                $('.step-upgrade[data-type="extract"] > div:last-child').html(`<div class="update_error"></div>`);
            }
        },
        error: function(error){},
    })
}

function finish(){
    $.ajax({
        url: 'addonmodules.php?module=arvancdn&action=update.finish',
        method: 'post',
        dataType: 'json',
        beforeSend: function(){
            $('.step-upgrade[data-type="finish"] > div:last-child').html(`<div class="update_loading"></div>`);
        },
        success: function(json){
            if(json.ok) {
                $('.step-upgrade[data-type="finish"] > div:last-child').html(`<div class="update_check"></div>`);
            } else {
                $('.step-upgrade[data-type="finish"] > div:last-child').html(`<div class="update_error"></div>`);
            }
        },
        error: function(error){},
    })
}

$(document).ready(function(){
    $(document).on('click', '.update-module-button', function(){
        start()
    })
})