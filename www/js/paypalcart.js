var PaypalCart = (function() {

	//constructor function
	function PaypalCart(options) {
		this.business = options.business;
		this.ipn_url = options.ipn_url;
		this.ret_url = options.ret_url;
    this.sandbox = options.sandbox;
    this.invoice = options.invoice;
		
		this.items = [];
	}
	
	function FindItem(items, name) {
		for (var i = 0; i < items.length; ++i) {
			if (items[i].item_name == name) {
				return items[i];
			}
		}
		
		return null;
	}
	
	PaypalCart.prototype.addItem = function(item_name, unit_amt, qty) {
		this.items.push({item_name: item_name, unit_amt: unit_amt, qty: qty, opt: []});
	}
	
	PaypalCart.prototype.setItemOption = function(item_name, opt_name, opt_val) {
		var item = FindItem(this.items, item_name);
		if (item == null) {
			console.error("Couldn't find item " + item_name + " in cart to add option.");
			return;
		}
		
		//check for existing name to change value
		for (var i = 0; i < item.opt.length; ++i) {
			if (item.opt[i].name == opt_name) {
				item.opt[i].value = opt_val;
				return;
			}
		}
		
		item.opt.push({name: opt_name, value: opt_val});
	}
	
	PaypalCart.prototype.setItemQty = function(item_name, qty) {
		var item = FindItem(this.items, item_name);
		if (item == null) {
			console.error("Couldn't find item " + item_name + " in cart to set qty.");
			return;
		}
		
		item.qty = qty;
	}
	
	PaypalCart.prototype.getItem = function(item_name) {
		return FindItem(this.items, item_name);
	}
	
	function CreateForm(action, method) {
		var form = document.createElement('form');
		form.method = method;
		form.action = action;
		
		return form;
	}
	
	function CreateInput(parent, name, value) {
		var elem = document.createElement('input');
		elem.setAttribute('type', 'hidden');
		elem.setAttribute('name', name);
		elem.setAttribute('value', value);
		parent.appendChild(elem);
		
		return elem;
	}
	
	function CreateItemInputs(parent, item, num) {
		CreateInput(parent, 'item_name_' + (num + 1), item.item_name);
		CreateInput(parent, 'amount_' + (num + 1), item.unit_amt);
		CreateInput(parent, 'quantity_' + (num + 1), item.qty);
		
		for (var i = 0; i < item.opt.length; ++i) {
			CreateInput(parent, 'on' + i + '_' + (num + 1), item.opt[i].name);
			CreateInput(parent, 'os' + i + '_' + (num + 1), item.opt[i].value);
		}
	}
  
  function createIfDef(parent, name, value) {
    if (typeof value != 'undefined' && value != null) {
      CreateInput(parent, name, value);
    }
  }
  
  PaypalCart.prototype.setBuyer = function(first, last, email) {
    this.first_name = first;
    this.last_name = last;
    this.email = email;
  }
	
	PaypalCart.prototype.submit = function() {
		//create form to submit
    var url = 'https://www.paypal.com/cgi-bin/webscr';
    
    if (this.sandbox) {
      url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }
    
		var form = CreateForm(url, 'post');
		
		CreateInput(form, 'cmd', '_cart');
		CreateInput(form, 'upload', '1');
		
    var business = this.business;
    
    if (this.sandbox) {
      business = 'crw@texascrwd.com';
    }
    
		CreateInput(form, 'business', business);
		createIfDef(form, 'return', this.ret_url);
		createIfDef(form, 'notify_url', this.ipn_url);
    createIfDef(form, 'invoice', this.invoice);
    
    createIfDef(form, '<first_name>', this.first_name);
    createIfDef(form, '<last_name>', this.last_name);
    createIfDef(form, '<email>', this.email);
		
		for (var i = 0; i < this.items.length; ++i) {
			CreateItemInputs(form, this.items[i], i);
		}
		
		document.body.appendChild(form);
		form.submit();
	}
	
	//return constructor
	return PaypalCart;
})();