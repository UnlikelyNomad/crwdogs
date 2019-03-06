(function() {

var regAmount = $('#reg_amount');
var shirtAmount = $('#shirt_amount');
var dinnerAmount = $('#dinner_amount');
var beerAmount = $('#beer_amount');
var campAmount = $('#camp_amount');
var totalAmount = $('#total_amount');

var regButtonSel = '.reg-button';
var dinnerInputSel = '#dinner_input';
var shirtInputSel = '.shirt-input';
var beerInputSel = '.beer-input';
var campButtonSel = '.camp-button';

var cost = {
    reg: 0,
    dinner: 0,
    shirt: 0,
    beer: 0,
    camp: 0
};

var freeShirt = false;

function updateCosts() {
    regAmount.text(Reg.formatCost(cost.reg));
    shirtAmount.text(Reg.formatCost(cost.shirt));
    dinnerAmount.text(Reg.formatCost(cost.dinner));
    beerAmount.text(Reg.formatCost(cost.beer));
    campAmount.text(Reg.formatCost(cost.camp));
    totalAmount.text(Reg.formatCost(cost.reg + cost.shirt + cost.dinner + cost.beer + cost.camp));
}

function updateReg() {
    var t = this;

    setTimeout(function() {
        var btns = $(regButtonSel);
        var clear = btns.not(t);
        Reg.setButtonVal(clear, false);

        var regs = Reg.getButtonVal(btns);
    
        var regCosts = [100, 85, 60, 30];
    
        cost.reg = 0;
        freeShirt = false;
    
        for (var i = 0; i < 6; ++i) {
            if (regs[i]) {
                cost.reg = regCosts[i];

                if (i < 1) {
                    freeShirt = true;
                }

                break;
            }
        }

        updateShirt();
    });
}

function updateShirt() {
    setTimeout(function() {
        var shirts = $(shirtInputSel);
        var n = 0;
        shirts.each(function(i, el) {
            n += Number($(el).val());
        });

        if (freeShirt && n > 0) {
            n -= 1;
        }

        cost.shirt = n * 20;

        updateCosts();
    });
}

function updateDinner() {
    var dinner = $(dinnerInputSel);
    var n = Number(dinner.val());
    dinner.val(n);
    cost.dinner = n * 20;

    updateCosts();
}

function updateBeer() {
    setTimeout(function() {
        var shirts = $(beerInputSel);
        var n = 0;
        shirts.each(function(i, el) {
            n += Number($(el).val());
        });

        cost.beer = n * 40;

        updateCosts();
    });
}

function updateCamp() {
    setTimeout(function() {
        var camp = Reg.getButtonVal(campButtonSel);

        cost.camp = camp ? 40 : 0;
        updateCosts();
    });
}

function updateCRW() {
    setTimeout(function() {
        var show = Reg.getButtonVal(Reg.qidSel(33));
        var l = $('#lightning_sizes');

        if (show) {
            l.slideDown();
        } else {
            l.slideUp();
        }
    });
}

function updateHP() {
    setTimeout(function() {
        var show = Reg.getButtonVal(Reg.qidSel(37));
        var l = $('#high_perf');

        if (show) {
            l.slideDown();
        } else {
            l.slideUp();
        }
    });
}

$('#checkout').click(function() {
    Reg.setFormVal('event_id', 2); // hardcoded event id

    //registrant info
    Reg.setFormVal('first_name', $('#first_name').val());
    if (Reg.getFormVal('first_name') == '') {
        $('#first_name')[0].focus();
        alert('You must enter your name before submitting.');
        return;
    }

    Reg.setFormVal('last_name', $('#last_name').val());
    if (Reg.getFormVal('last_name') == '') {
        $('#last_name')[0].focus();
        alert('You must enter your name before submitting.');
        return;
    }

    Reg.setFormVal('email', $('#email').val());
    if (Reg.getFormVal('email') == '') {
        $('#email')[0].focus();
        alert('You must enter your email before submitting.');
        return;
    }

    Reg.setFormVal('phone', $('#phone').val());

    Reg.setFormVal('qid32', $('#dob').val());
    if (Reg.getFormVal('qid32') == '') {
        $('#dob')[0].focus();
        alert('You must enter your birthdate before submitting.');
        return;
    }

    Reg.setFormVal('qid33', Reg.getButtonVal(Reg.qidSel(33))); //CRW
    Reg.setFormVal('qid34', Reg.getButtonVal(Reg.qidSel(34))); //WS
    Reg.setFormVal('qid35', Reg.getButtonVal(Reg.qidSel(35))); //RW
    Reg.setFormVal('qid36', Reg.getButtonVal(Reg.qidSel(36))); //FF
    Reg.setFormVal('qid37', Reg.getButtonVal(Reg.qidSel(37))); //HP
    Reg.setFormVal('qid38', Reg.getButtonVal(Reg.qidSel(38))); //XRW

    if (Reg.getFormVal('qid33') == 'true') {
        var sizeArr = Reg.getButtonVal(Reg.qidSel(39)); // lightning sizes
        var sizes = [];
        for (var i = 0; i < sizeArr.length; ++i) {
            if (sizeArr[i]) {
                sizes.push(Calcs.sizes[i]);
            }
        }
        Reg.setFormVal('qid39', sizes.toString());
    } else {
        Reg.setFormVal('qid39', '');
    }
    
    Reg.setFormVal('qid40', Reg.getButtonVal(Reg.qidSel(40))); //Beach w/ Pro
    Reg.setFormVal('qid41', Reg.getButtonVal(Reg.qidSel(41))); //Beach no Pro

    Reg.setFormVal('qid42', Reg.getButtonVal(Reg.qidSel(42))); //Thurs - Jump
    Reg.setFormVal('qid43', Reg.getButtonVal(Reg.qidSel(43))); //Fri
    Reg.setFormVal('qid44', Reg.getButtonVal(Reg.qidSel(44))); //Sat
    Reg.setFormVal('qid45', Reg.getButtonVal(Reg.qidSel(45))); //Sun
    Reg.setFormVal('qid46', Reg.getButtonVal(Reg.qidSel(46))); //Thurs - Event
    Reg.setFormVal('qid47', Reg.getButtonVal(Reg.qidSel(47))); //Fri
    Reg.setFormVal('qid48', Reg.getButtonVal(Reg.qidSel(48))); //Sat
    Reg.setFormVal('qid49', Reg.getButtonVal(Reg.qidSel(49))); //Sun

    var jumpDays = 0;
    if (Reg.getFormVal('qid42') == 'true') jumpDays++;
    if (Reg.getFormVal('qid43') == 'true') jumpDays++;
    if (Reg.getFormVal('qid44') == 'true') jumpDays++;
    if (Reg.getFormVal('qid45') == 'true') jumpDays++;

    if (Reg.getFormVal('qid37') == 'true') {
        Reg.setFormVal('qid50', Reg.getInputVal(Reg.qidSel(50))); // HP Canopy
        Reg.setFormVal('qid51', Reg.getInputVal(Reg.qidSel(51))); // HP Wingloading
    }

    //Registration ticket
    Reg.clearItem(1);
    var btns = $(regButtonSel);
    var regs = Reg.getButtonVal(btns);
    var regOid = [1, 4, 5, 6];
    var regDays = [4, 4, 2, 1];

    var ticketDays = 0;

    var regItemNum = 0;

    for (var i = 0; i < 6; ++i) {
        if (regs[i]) {
            regItemNum = Reg.addItem(1, 1);
            Reg.setItemOption(1, regItemNum, 1, regOid[i]);
            ticketDays = regDays[i];
            break;
        }
    }

    if (ticketDays < jumpDays) {
        $(Reg.qidSel(42))[0].focus();
        alert('You have selected more jump days than the selected ticket covers.');
        return;
    }

    if (regs[0]) {
        var q = 0;
        if (regs[0]) {
            q = 1;
        }

        Reg.setFormVal('iid7-qty', q);
    }

    //Boogie shirts
    Reg.clearItem(2);
    var shirts = $(shirtInputSel);
    var shirtOid = [7, 8, 9, 10, 11];
    var hasShirt = false;
    shirts.each(function(i, el) {
        var qty = Number($(el).val());
        if (qty > 0) {
            hasShirt = true;
            var num = Reg.addItem(2, qty);
            Reg.setItemOption(2, num, 2, shirtOid[i]);
        }
    });

    if (freeShirt && !hasShirt) {
        $('.shirt-buttons')[0].focus();
        alert('You have not selected a free shirt size with your full registration option.');
        return;
    }

    if (!freeShirt && hasShirt && ticketDays == 4) {
        Reg.setItemOption(1, regItemNum, 1, regOid[0]);
        Reg.setFormVal('iid7-qty', 1);
    }

    //Dinner tickets
    //Reg.setFormVal('iid4-qty', Reg.getInputVal('#dinner_input'));

    //Beer shirts
    Reg.clearItem(3);
    var beers = $(beerInputSel);
    var beerOid = [12, 13, 14, 15, 16];
    var hasBeer = false;
    beers.each(function(i, el) {
        var qty = Number($(el).val());
        if (qty > 0) {
            var num = Reg.addItem(3, qty);
            Reg.setItemOption(3, num, 3, beerOid[i]);
            hasBeer = true;
        }
    });

    if (hasBeer) {
        if (Reg.getFormVal('qid32') > '1998-08-18') {
            $('#beer_amount')[0].focus();
            alert('You are not old enough to purchase a commemorative boogie beer shirt.');
            return;
        }
    }

    if (Reg.getButtonVal('.camp-button')) {
        Reg.setFormVal('iid5-qty', 1);
    } else {
        Reg.setFormVal('iid5-qty', 0);
    }

    $('#reg_form').submit();
});

$(regButtonSel).click(updateReg);
$(shirtInputSel).change(updateShirt);
$('.shirt-buttons button').click(updateShirt);
$(dinnerInputSel).change(updateDinner);
$(beerInputSel).change(updateBeer);
$('.beer-buttons button').click(updateBeer);
$(campButtonSel).click(updateCamp);
$(Reg.qidSel(33)).click(updateCRW);
$(Reg.qidSel(37)).click(updateHP);

updateCosts();
})();