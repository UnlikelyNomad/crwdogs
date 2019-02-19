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

    if (e.length == 0) {
        return undefined;
    } else if (e.length == 1) {
        return e.hasClass('btn-success');
    } else {
        return $.map(e, function(val) {
            return $(val).hasClass('btn-success');
        });
    }
}

function getSortListVal(sel) {
    var e = $(sel);
    if (e.length == 0) {
        return undefined;
    }

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

function doPayment(reg_id) {
    /*var cart = new PaypalCart({
        business: 'crw@texascrwd.com',
        ipn_url: 'https://crwdogs.com/paypal/ipn.php',
        ret_url: 'https://crwdogs.com/springfling/success.php',
        invoice: '' + reg_id,
        sandbox: false
    });

    cart.setBuyer(
        $('#first_name').val(),
        $('#last_name').val(),
        $('#email').val()
    );

    cart.addItem('Registration', 75, 1);

    cart.submit();*/


}

function regSuccess(resp) {
    var res = JSON.parse(resp);
    if (res.result == 'success') {
        doPayment(res.reg_id);
    } else {
        console.log(resp);
        alert('There was an error with saving the registration: ' + res.msg);
    }
}

function regFail(resp) {
    console.log('fail');
    console.log(resp);
    alert('There was a problem submitting the registration, please try again in a minute.');
}

function setFormVal(name, value) {
    $('#reg_form [name="' + name + '"]').val(value);
}

function getFormVal(name) {
    return $('#reg_form [name="' + name + '"]').val();
}

$('#checkout').click(function() {
    //alert('REGISTER');

    setFormVal('event_id', 1); // hardcoded event id for Spring Fling 2019

    //registrant info
    setFormVal('first_name', $('#first_name').val());
    if (getFormVal('first_name') == '') {
        $('#first_name')[0].focus();
        alert('You must enter your name before submitting.');
        return;
    }

    setFormVal('last_name', $('#last_name').val());
    if (getFormVal('last_name') == '') {
        $('#last_name')[0].focus();
        alert('You must enter your name before submitting.');
        return;
    }

    setFormVal('email', $('#email').val());
    if (getFormVal('email') == '') {
        $('#email')[0].focus();
        alert('You must enter your email before submitting.');
        return;
    }

    var email2 = $('#email2').val();
    if (email2 == '') {
        $('#email2')[0].focus();
        alert('You must enter your email before submitting.');
        return;
    }

    if (getFormVal('email') != email2) {
        $('#email')[0].focus();
        alert('Email addresses do not match.');
        return;
    }

    setFormVal('phone', $('#phone').val());
    if (getFormVal('phone') == '') {
        $('#phone')[0].focus();
        alert('You must enter your phone before submitting.');
        return;
    }

    //universal questions
    setFormVal('qid1', getYesNoBoolVal(qidSel(1))); //night jumps
    setFormVal('qid2', getYesNoBoolVal(qidSel(2))); //beach jumps

    var att = getButtonVal(qidSel(3)); //attendance selections
    var dates = [];
    for (var i = 0; i < att.length; ++i) {
        if (att[i]) {
            dates.push(i + 9);
        }
    }

    var qid3 = dates.toString();
    setFormVal('qid3', qid3);

    if (qid3 == '') {
        $(qidSel(3))[0].focus();
        alert('You must select at least one attendance day.');
        return;
    }

    //experience selection
    var expArr = getButtonVal(qidSel(4));
    var e = '';
    if (expArr[0]) {
        e = 'new';
    } else if (expArr[1]) {
        e = 'pup';
    } else if (expArr[2]) {
        e = 'exp';
    } else {
        alert('You must select an experience level.');
        return;
    }

    setFormVal('qid4', e);

    setFormVal('qid5', getYesNoBoolVal(expSel(e, 5))); //has gear
    setFormVal('qid6', getInputVal(expSel(e, 6))); //# sport jumps
    setFormVal('qid7', getInputVal(expSel(e, 7))); //# crw jumps
    setFormVal('qid8', getInputVal(expSel(e, 8))); //crw jumps when
    setFormVal('qid9', getInputVal(expSel(e, 9))); //exit weight
    setFormVal('qid10', getInputVal(expSel(e, 10))); //sport canopy size
    setFormVal('qid11', getInputVal(expSel(e, 11))); //wing loading
    setFormVal('qid12', getInputVal(expSel(e, 12))); //sport canopy type
    setFormVal('qid13', getYesNoBoolVal(expSel(e, 13))); //lightning avail
    setFormVal('qid14', getYesNoBoolVal(expSel(e, 14))); //sized rig
    setFormVal('qid15', getInputVal(expSel(e, 15))); //reserve handle
    setFormVal('qid16', getYesNoBoolVal(expSel(e, 16))); //CRW at home
    setFormVal('qid17', getYesNoBoolVal(expSel(e, 17))); //acq at boogie
    setFormVal('qid18', getInputVal(expSel(e, 18))); //pup jumps with

    //experienced questionaire
    if (e == 'exp') {
        var sizeArr = getButtonVal(expSel(e, 19)); // jumping sizes
        var sizes = [];
        for (var i = 0; i < sizeArr.length; ++i) {
            if (sizeArr[i]) {
                sizes.push(Calcs.sizes[i]);
            }
        }
        setFormVal('qid19', sizes.toString());

        setFormVal('qid20', getSortListVal(expSel(e, 20))); //preferred jumps
        setFormVal('qid21', getSortListVal(expSel(e, 21))); //undesired jumps
        setFormVal('qid22', getSortListVal(expSel(e, 22))); //train skills
        setFormVal('qid23', getInputVal(expSel(e, 23))); //bring 113s
        setFormVal('qid24', getInputVal(expSel(e, 24))); //bring 126s
        setFormVal('qid25', getInputVal(expSel(e, 25))); //bring 143s
        setFormVal('qid26', getInputVal(expSel(e, 26))); //bring 160s
        setFormVal('qid27', getInputVal(expSel(e, 27))); //bring 176s
        setFormVal('qid28', getInputVal(expSel(e, 28))); //bring 193s
        setFormVal('qid29', getInputVal(expSel(e, 29))); //bring 218s
        setFormVal('qid30', getButtonVal(expSel(e, 30))); //fly camera
        setFormVal('qid31', getButtonVal(expSel(e, 31))); //loan camera
    }

    if (e == 'new' || e == 'pup') {
        if (getFormVal('qid6') == '') {
            $(expSel(e, 6))[0].focus();
            alert('You must fill in number of sport jumps.');
            return;
        }

        if (getFormVal('qid9') == '') {
            $(expSel(e, 9))[0].focus();
            alert('You must fill in exit weight.');
            return;
        }

        if (getFormVal('qid10') == '') {
            $(expSel(e, 10))[0].focus();
            alert('You must fill in current sport canopy size.');
            return;
        }

        if (getFormVal('qid12') == '') {
            $(expSel(e, 12))[0].focus();
            alert('You must fill in sport canopy type.');
            return;
        }

        if (e == 'pup') {
            if (getFormVal('qid8') == '') {
                $(expSel(e, 8))[0].focus();
                alert('You must fill in when you\'ve done CRW.');
                return;
            }

            if (getFormVal('qid18') == '') {
                $(expSel(e, 18))[0].focus();
                alert('You must fill in who you\'ve jumped with.');
                return;
            }
        }
    } else if (e == 'exp') {
        if (getFormVal('qid19') == '') {
            $(expSel(e, 19))[0].focus();
            alert('You must select at least one canopy size that you will be jumping.');
            return;
        }
    }

    $('#reg_form').submit();
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