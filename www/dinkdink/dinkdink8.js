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
    
        console.log(regs);
    
        var regCosts = [100, 75, 45, 85, 60, 30];
    
        cost.reg = 0;
        freeShirt = false;
    
        for (var i = 0; i < 6; ++i) {
            if (regs[i]) {
                cost.reg = regCosts[i];

                if (i < 3) {
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
    var n = Number($(dinnerInputSel).val());
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

$(regButtonSel).click(updateReg);
$(shirtInputSel).change(updateShirt);
$('.shirt-buttons button').click(updateShirt);
$(dinnerInputSel).change(updateDinner);
$(beerInputSel).change(updateBeer);
$('.beer-buttons button').click(updateBeer);
$(campButtonSel).click(updateCamp);
$(Reg.qidSel(33)).click(updateCRW);

updateCosts();
})();