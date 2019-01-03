var onClass = 'btn-success';
var offClass = 'btn-danger';

$(".yesno-radio").click(function() {
    var btns = $(this).find('.btn');
    btns.toggleClass('btn-secondary');
    $(btns.get(0)).toggleClass(onClass);
    $(btns.get(1)).toggleClass(offClass);
});

$('[data-toggle="button"].redgreen-toggle').click(function() {
    var t = $(this);
    if (!t.hasClass(onClass)) {
        t.removeClass(offClass).addClass(onClass);
    } else {
        t.removeClass(onClass).addClass(offClass);
    }
});

$('.btn').click(function() {
    var t = this;
    setTimeout(function() {
        $(t).removeClass('focus');
        t.blur();
    });
});

$('#new_exit_weight').change(updateNewCalcs);
$('#new_canopy_size').change(updateNewCalcs);

$('.num-canopy-container button').click(function() {
    var t = $(this);
    var n = t.parent().find('input');

    if (t.hasClass(onClass)) {
        n.val(1);
    } else {
        n.val(0);
    }
});

$('.num-canopy-container input').change(function() {
    var t = $(this);
    var n = t.val();

    var b = t.parent().find('button');
    
    if (n > 0) {
        b.addClass(onClass).removeClass(offClass).addClass('active');
    } else {
        b.addClass(offClass).removeClass(offClass).removeClass('active');
    }
});

function updateNewCalcs() {
    var weight = $('#new_exit_weight').val();
    var cur_size = $('#new_canopy_size').val();
    var cur_load = Calcs.loading(weight, cur_size);
    $('#new_calc_loading').val(Calcs.dec(cur_load, 3));

    var size = Calcs.lightningSize(weight, 1.34);
    $('#new_pd_size').text(size);

    $('#new_canopy_min').text(Calcs.containerMin(size));
    $('#new_canopy_max').text(Calcs.containerMax(size));
}

$('#mid_exit_weight').change(updateMidCalcs);
$('#mid_canopy_size').change(updateMidCalcs);

function updateMidCalcs() {
    var weight = $('#mid_exit_weight').val();
    var cur_size = $('#mid_canopy_size').val();
    var cur_load = Calcs.loading(weight, cur_size);
    $('#mid_calc_loading').val(Calcs.dec(cur_load, 3));

    var size = Calcs.lightningSize(weight, 1.35);
    $('#mid_pd_size').text(size);

    $('#mid_canopy_min').text(Calcs.containerMin(size));
    $('#mid_canopy_max').text(Calcs.containerMax(size));
}

var accordions = $('.accordion-panel');

accordions.on('hide.bs.collapse', function() {
    $(this).find('button.acc-toggle').removeClass(onClass).addClass(offClass);
});

accordions.on('show.bs.collapse', function() {
    $(this).find('button.acc-toggle').removeClass(offClass).addClass(onClass);
});

$('#checkout').click(function() {
    //alert('REGISTER');
});

$(function() {

    $('ul.jumps').sortable({
        connectWith: 'ul.jumps',
        items: 'li:not(.sort-note)'
    });

    $('ul.training').sortable({
        connectWith: 'ul.training',
        items: 'li:not(.sort-note)'
    });

    $('ul.coaching').sortable({
        connectWith: 'ul.coaching',
        items: 'li:not(.sort-note)'
    });

    $('ul.crw-sort').disableSelection();
});