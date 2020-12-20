$(document).ready(function () {


  

    /* Responsive Menu */
    var y = 0;
    $(".r-menu-botton").click(function () {

        if (y == 0) {
            $("#main-menu.sm").fadeOut();
            y++;

        } else {
            $("#main-menu.sm").fadeIn();
            y = 0;
        }
    });

    $('#indicators-container .row > .col-md-3 .block-image').hover(function () {
        $(this).css('background', $(this).parent().find('.block-color').text())
        $('#show-desc').removeClass('hide');
    }, function () {
        $('#show-desc').addClass('hide');
    });

    $('.show-project-name').popover({
        html: true,
        trigger: 'hover',
        container: '#eventsListView',
        placement: 'bottom',
        content: function () {
            var desc_text = $(this).parent().find('.project-title').text();
            return '<div class="box"><div class="bod-body">' + desc_text + '</div></div>';
        }
    });

    $('#indicators-container .row > .col-md-3 .block-image').popover({
        html: true,
        trigger: 'hover',
        container: '#indicators-container',
        placement: 'bottom',
        content: function () {
            var desc_text = $(this).parent().find('.block-complaint-desc').text();
            return '<div class="box"><div class="bod-body">' + desc_text + '</div></div>';
        }
    });
    $('.project-name-pop').popover({
        html: true,
        trigger: 'hover',
        container: '#w0',
        placement: 'bottom',
        content: function () {
            //var desc_text = $(this).parent().find('.block-complaint-desc').text();
            return '<div class="box"><div class="bod-body">asdasdasdasdasdasd</div></div>';
        }
    });
    select_indicator($('#complaint-indicator_id').val());
    $('#indicators-container .row > .col-md-3 ').click(function () {
        var indicator_val = $(this).find('.indicator-val').val();
        select_indicator(indicator_val);
    })
    $('#show-search-bar').click(function (e) {
        e.preventDefault();
        $('#main-menu').addClass('hide');
        $('.second-side').addClass('hide');
        $('#header-search-form-container').removeClass('hide');
        $('#searchsite-keyword').focus();
        return false;
    });
    $('#close-icon-search').click(function (e) {
        e.preventDefault();
        $('#main-menu').removeClass('hide');
        $('.second-side').removeClass('hide');
        $('#header-search-form-container').addClass('hide');
    });
});
/* only for image preview */
$(".image_upload").change(function () {
    var preview = $(this);

    /* html FileRender Api */
    var oFReader = new FileReader();
    oFReader.readAsDataURL(this.files[0]);

    oFReader.onload = function (oFREvent) {
        preview.parent().parent().find('img').attr('src', oFREvent.target.result).fadeIn();
    };

});

function select_indicator(val) {
    $('#indicators-container .checked-complaint').remove();
    if (val === '0') {
        $('#complaint-not_exist_indicator').val(0)
        $('#other-indicator').removeClass('hide');
    } else if (val === '1') {
        $('#complaint-not_exist_indicator').val(1)
        $('#other-indicator').addClass('hide');
    } else {
        $('#complaint-not_exist_indicator').val(1)
        $('#other-indicator').addClass('hide');
    }
    $('#indicator-block-' + val).find('.block-image').append('<div class="checked-complaint"></div>');
    $('#complaint-indicator_id').val(val);
}

function addmarker(lat, lng, map, content, imglink) {

    marker = new google.maps.Marker({
        id: 'marker' + Math.random(),
        map: map,
        icon: imglink,
        position: new google.maps.LatLng(lat, lng),
    });

    gmap0infoWindow = new google.maps.InfoWindow();
    google.maps.event.addListener(marker, 'click', function (event) {
        gmap0infoWindow.setContent(content);
        gmap0infoWindow.open(map, this);
    });
    markers.push(marker);
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setMapOnAll(null);
}

//function after_recommendation(w1_ias) {
//    w1_ias.extension(new IASSpinnerExtension({'html': '<div class=\'ias-spinner\' style=\'text-align: center;\'><img src=\'{src}\'/></div>'}));
//    w1_ias.extension(new IASTriggerExtension({'text': 'المزيد من التوصيات', 'html': '<div class=\'custom-pagination\'><div class=\'btn btn-lg btn-more \'>{text}</div></div>', 'offset': 0}));
//    w1_ias.extension(new IASNoneLeftExtension({'text': '', 'html': ''}));
//    
//
//}

function requestData(form) {

    $.ajax({
        url: '/home/load-charts',
        type: "GET",
        dataType: "json",
        data: form.serialize(),
        success: function (data) {
            var highChart_w1 = new Highcharts.Chart({"exporting": false, "credits": false, "chart": {"type": "pie", "backgroundColor": "transparent", "renderTo": "w1"}, "plotOptions": {"pie": {"allowPointSelect": true, "cursor": "pointer", "dataLabels": false}}, "title": {"text": ""}, "xAxis": {"categories": ["Apples", "Bananas"]}, "yAxis": {"title": {"text": "Fruit eaten"}}, "tooltip": {"valueSuffix": "%"}, "series": [data.range]});
            var highChart_w2 = new Highcharts.Chart({"exporting": false, "credits": false, "chart": {"type": "pie", "backgroundColor": "transparent", "renderTo": "w3"}, "plotOptions": {"pie": {"allowPointSelect": true, "cursor": "pointer", "dataLabels": false}}, "title": {"text": ""}, "xAxis": {"categories": ["Apples", "Bananas"]}, "yAxis": {"title": {"text": "Fruit eaten"}}, "tooltip": {"valueSuffix": "%"}, "series": [data.place]});
            var highChart_w3 = new Highcharts.Chart({"exporting": false, "credits": false, "chart": {"type": "pie", "backgroundColor": "transparent", "renderTo": "w2"}, "plotOptions": {"pie": {"allowPointSelect": true, "cursor": "pointer", "dataLabels": false}}, "title": {"text": ""}, "xAxis": {"categories": ["Apples", "Bananas"]}, "yAxis": {"title": {"text": "Fruit eaten"}}, "tooltip": {"valueSuffix": "%"}, "series": [data.gender]});
            var highChart_w4 = new Highcharts.Chart({"exporting": false, "credits": false, "chart": {"type": "column", "backgroundColor": "transparent", "renderTo": "w4"}, "plotOptions": {"column": {"stacking": "normal"}}, "title": {"text": ""}, "xAxis": {"categories": ["تحت 20", "20 - 29", "30 - 39", "40 - 49", "50 - 59", "60 - 69", "70 - 79"]}, "yAxis": {"title": {"text": "نسبة البلاغات حسب الفئة العمرية"}}, "legend": {"align": "right", "x": -30, "verticalAlign": "top", "y": 25, "floating": true, "backgroundColor": "white", "borderColor": "#CCC", "borderWidth": 1, "shadow": false}, "tooltip": {"valueSuffix": "%"}, "series": data.affected_group});
            var highChart_w5 = new Highcharts.Chart({"exporting": false, "credits": false, "chart": {"type": "column", "backgroundColor": "transparent", "renderTo": "w5"}, "plotOptions": {"column": {"stacking": "normal"}}, "title": {"text": ""}, "xAxis": {"categories": ["تحت 20", "20 - 29", "30 - 39", "40 - 49", "50 - 59", "60 - 69", "70 - 79"]}, "yAxis": {"title": {"text": "نسبة البلاغات حسب الفئة العمرية"}}, "legend": {"align": "right", "x": -30, "verticalAlign": "top", "y": 25, "floating": true, "backgroundColor": "white", "borderColor": "#CCC", "borderWidth": 1, "shadow": false}, "tooltip": {"valueSuffix": "%"}, "series": data.affected_group});

        },
        cache: false
    });
}

$('#carousel').carousel({
    interval: 100000
});

$('.carousel .item').each(function () {
    var next = $(this).next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    if (next.next().length > 0) {
        next.next().children(':first-child').clone().appendTo($(this));
    }
    else {
        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
    }
});

