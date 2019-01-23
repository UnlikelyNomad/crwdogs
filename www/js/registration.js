var Reg = (function() {

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
    var numButton = t.hasClass('num-button');

    if (!t.hasClass(onClass)) {
        t.removeClass(offClass).addClass(onClass);

        if (numButton) {
            $(t.parents('.num-button-group').get(0)).find('input.num-button').val(1);
        }
    } else {
        t.removeClass(onClass).addClass(offClass);

        if (numButton) {
            $(t.parents('.num-button-group').get(0)).find('input.num-button').val(0);
        }
    }
});

$('.btn').click(function() {
    var t = this;
    setTimeout(function() {
        $(t).removeClass('focus');
        t.blur();
    });
});

$('input.num-button').change(function() {
    var t = $(this);
    var n = Number(t.val());

    var b = t.parents('.num-button-group').find('button');
    
    if (n > 0) {
        b.addClass(onClass).removeClass(offClass).addClass('active');
    } else {
        b.addClass(offClass).removeClass(onClass).removeClass('active');
    }
});

var Reg = function() {

}

Reg.formatCost = function(cost) {
    return '$' + Number.parseFloat(cost).toFixed(2);
}

Reg.getYesNoBoolVal = function(sel) {
    var e = sel;

    if (typeof sel == 'string') {
        e = $(sel);
    }

    if (e.length == 0) {
        return undefined;
    }

    return e.find('label:first').hasClass('btn-success'); //if first item has class then radio value is true
}

Reg.getButtonVal = function(sel) {
    var e = sel;

    if (typeof sel == 'string') {
        e = $(sel);
    }

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

Reg.setButtonVal = function(sel, val) {
    var e = sel;

    if (typeof sel == 'string') {
        e = $(sel);
    }

    if (val) {
        e.removeClass(offClass).addClass(onClass);
    } else {
        e.removeClass(onClass).addClass(offClass);
    }
}

Reg.getSortListVal = function(sel) {
    var e = sel;

    if (typeof sel == 'string') {
        e = $(sel);
    }

    if (e.length == 0) {
        return undefined;
    }

    var c = e.find('li');
    return $.map(c, function(val) {
        return $(val).text();
    }).toString();
}

Reg.getInputVal = function(sel) {
    var e = sel;

    if (typeof sel == 'string') {
        e = $(sel);
    }

    return e.val();
}

Reg.qidSel = function(qid) {
    return '[data-qid="' + qid + '"]';
}

return Reg;

})();