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
    var n = Number(t.val());

    var b = t.parent().find('button');
    
    if (n > 0) {
        b.addClass(onClass).removeClass(offClass).addClass('active');
    } else {
        b.addClass(offClass).removeClass(onClass).removeClass('active');
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

$('#pup_exit_weight').change(updatePupCalcs);
$('#pup_canopy_size').change(updatePupCalcs);

function updatePupCalcs() {
    var weight = $('#pup_exit_weight').val();
    var cur_size = $('#pup_canopy_size').val();
    var cur_load = Calcs.loading(weight, cur_size);
    $('#pup_calc_loading').val(Calcs.dec(cur_load, 3));

    var size = Calcs.lightningSize(weight, 1.35);
    $('#pup_pd_size').text(size);

    $('#pup_canopy_min').text(Calcs.containerMin(size));
    $('#pup_canopy_max').text(Calcs.containerMax(size));
}

var accordions = $('.accordion-panel');

accordions.on('hide.bs.collapse', function() {
    $(this).find('button.acc-toggle').removeClass(onClass).addClass(offClass);
});

accordions.on('show.bs.collapse', function() {
    $(this).find('button.acc-toggle').removeClass(offClass).addClass(onClass);
});

function getYesNoBoolVal(sel) {
    var e = $(sel);
    if (e.length == 0) {
        return undefined;
    }

    return e.find('label:first').hasClass('btn-success'); //if first item has class then radio value is true
}

function getButtonVal(sel) {
    var e = $(sel);

    if (e.length == 1) {
        return e.hasClass('btn-success');
    } else {
        return $.map(e, function(val) {
            return $(val).hasClass('btn-success');
        });
    }
}

function getSortListVal(sel) {
    var e = $(sel);
    var c = e.find('li');
    return $.map(c, function(val) {
        return $(val).text();
    }).toString();
}

function getInputVal(sel) {
    var e = $(sel);
    return e.val();
}

function expSel(exp, qid) {
    return '#collapse-' + exp + ' [data-qid="' + qid + '"]';
}

function qidSel(qid) {
    return '[data-qid="' + qid + '"]';
}

$('#checkout').click(function() {
    //alert('REGISTER');

    //first gather up all the data
    var reg = {};

    //registrant info
    reg['first_name'] = $('#first_name').val();
    if (reg['first_name'] == '') {
        $('#first_name')[0].focus();
        alert('You must enter your name before submitting.');
        return;
    }

    reg['last_name'] = $('#last_name').val();
    if (reg['last_name'] == '') {
        $('#last_name')[0].focus();
        alert('You must enter your name before submitting.');
        return;
    }

    reg['email'] = $('#email').val();
    if (reg['email'] == '') {
        $('#email')[0].focus();
        alert('You must enter your email before submitting.');
        return;
    }

    reg['email2'] = $('#email2').val();
    if (reg['email2'] == '') {
        $('#email2')[0].focus();
        alert('You must enter your email before submitting.');
        return;
    }

    if (reg['email'] != reg['email2']) {
        $('#email')[0].focus();
        alert('Email addresses do not match.');
        return;
    }

    reg['phone'] = $('#phone').val();
    if (reg['phone'] == '') {
        $('#phone')[0].focus();
        alert('You must enter your phone before submitting.');
        return;
    }

    //collection for question responses
    var q = reg['questions'] = {};

    //universal questions
    q[1] = getYesNoBoolVal(qidSel(1)); //night jumps
    q[2] = getYesNoBoolVal(qidSel(2)); //beach jumps

    var att = getButtonVal(qidSel(3)); //attendance selections
    var dates = [];
    for (var i = 0; i < att.length; ++i) {
        if (att[i]) {
            dates.push(i + 9);
        }
    }
    q[3] = dates.toString();

    //experience selection
    var expArr = getButtonVal(qidSel(4));
    if (expArr[0]) {
        q[4] = 'new';
    } else if (expArr[1]) {
        q[4] = 'pup';
    } else if (expArr[2]) {
        q[4] = 'exp';
    } else {
        alert('You must select an experience level.');
        return;
    }

    var e = q[4];

    q[5] = getYesNoBoolVal(expSel(e, 5)); //has gear
    q[6] = getInputVal(expSel(e, 6)); //# sport jumps
    q[7] = getInputVal(expSel(e, 7)); //# crw jumps
    q[8] = getInputVal(expSel(e, 8)); //crw jumps when
    q[9] = getInputVal(expSel(e, 9)); //exit weight
    q[10] = getInputVal(expSel(e, 10)); //sport canopy size
    q[11] = getInputVal(expSel(e, 11)); //wing loading
    q[12] = getInputVal(expSel(e, 12)); //sport canopy type
    q[13] = getYesNoBoolVal(expSel(e, 13)); //lightning avail
    q[14] = getYesNoBoolVal(expSel(e, 14)); //sized rig
    q[15] = getInputVal(expSel(e, 15)); //reserve handle
    q[16] = getYesNoBoolVal(expSel(e, 16)); //CRW at home
    q[17] = getYesNoBoolVal(expSel(e, 17)); //acq at boogie
    q[18] = getInputVal(expSel(e, 18)); //pup jumps with

    //experienced questionaire

    var sizeArr = getButtonVal(expSel(e, 19)); // jumping sizes
    var sizes = [];
    for (var i = 0; i < sizeArr.length; ++i) {
        if (sizeArr[i]) {
            sizes.push(Calcs.sizes);
        }
    }
    q[19] = sizes.toString();

    q[20] = getSortListVal(expSel(e, 20)); //preferred jumps
    q[21] = getSortListVal(expSel(e, 21)); //undesired jumps
    q[22] = getSortListVal(expSel(e, 22)); //train skills
    q[23] = getInputVal(expSel(e, 23)); //bring 113s
    q[24] = getInputVal(expSel(e, 24)); //bring 126s
    q[25] = getInputVal(expSel(e, 25)); //bring 143s
    q[26] = getInputVal(expSel(e, 26)); //bring 160s
    q[27] = getInputVal(expSel(e, 27)); //bring 176s
    q[28] = getInputVal(expSel(e, 28)); //bring 193s
    q[29] = getInputVal(expSel(e, 29)); //bring 218s
    q[30] = getButtonVal(expSel(e, 30)); //fly camera
    q[31] = getButtonVal(expSel(e, 31)); //loan camera

    if (e == 'new' || e == 'pup') {
        if (q[6] == '') {
            $(expSel(e, 6))[0].focus();
            alert('You must fill in number of sport jumps.');
            return;
        }

        if (q[9] == '') {
            $(expSel(e, 9))[0].focus();
            alert('You must fill in exit weight.');
            return;
        }

        if (q[10] == '') {
            $(expSel(e, 10))[0].focus();
            alert('You must fill in current sport canopy size.');
            return;
        }

        if (q[12] == '') {
            $(expSel(e, 12))[0].focus();
            alert('You must fill in sport canopy type.');
            return;
        }

        if (e == 'pup') {
            if (q[8] == '') {
                $(expSel(e, 8))[0].focus();
                alert('You must fill in when you\'ve done CRW.');
                return;
            }

            if (q[18] == '') {
                $(expSel(e, 18))[0].focus();
                alert('You must fill in who you\'ve jumped with.');
                return;
            }
        }
    } else if (e == 'exp') {
        if (q[19] == '') {
            $(expSel(e, 19))[0].focus();
            alert('You must select at least one canopy size that you will be jumping.');
            return;
        }
    }
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