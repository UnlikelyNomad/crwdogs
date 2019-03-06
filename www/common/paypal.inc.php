<?php

if (__FILE__ == $_SERVER["SCRIPT_FILENAME"]) {
    http_response_code(404);
    exit();
}

class PayPalCart {

    private $business = '';
    private $return_url = '';
    private $cancel_url = '';
    private $notify_url = '';
    private $bn = '';

    private $sandbox = true;
    private $url = '';

    private $first_name = '';
    private $last_name = '';
    private $email = '';

    private $cart_discount = 0;

    private $items = [];

    function __construct($company_name, $business, $notify_url, $return_url, $cancel_url, $sandbox = true) {
        $this->business = $business;
        $this->return_url = $return_url;
        $this->cancel_url = $cancel_url;
        $this->notify_url = $notify_url;
        $this->bn = $company_name . '_ShoppingCart_WPS_US';
        $this->sandbox = $sandbox;

        $this->url = $sandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
    }

    function setBuyer($first_name, $last_name, $email) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
    }

    /**Adds an item to the cart with a given per item cost and item_number desired */
    function addItem($item_id, $name, $unit_cost, $qty = 1) {
        $num = sizeof($this->items);
        $this->items[] = [
            'item_id' => $item_id,
            'name' => $name,
            'unit_cost' => $unit_cost,
            'qty' => $qty,
            'opt' => []
        ];

        return $num;
    }

    function setCartDiscount($amount) {
        $this->cart_discount = $amount;
    }

    /** Sets a variation value for items that have multiple options associated with them */
    function setItemOption($item_num, $opt_name, $opt_value) {
        $item = $this->items[$item_num];
        
        $opt = $item['opt'];
        $opt[] = [
            'name' => $opt_name,
            'value' => $opt_value
        ];
        $this->items[$item_num]['opt'] = $opt;
    }

    /** finalizes items in cart and generates paypal query parameter and url to redirect client to for purchase */
    function getPayPalCartURL($invoice_id) {
        $data = [];

        $data['cmd'] = '_cart';
        $data['upload'] = '1';
        $data['business'] = $this->business;
        $data['notify_url'] = $this->notify_url;
        $data['return'] = $this->return_url;

        if (!empty($this->cancel_url)) {
            $data['cancel_return'] = $this->cancel_url;
        }
        
        if (!empty($this->first_name)) {
            $data['first_name'] = $this->first_name;
        }

        if (!empty($this->last_name)) {
            $data['last_name'] = $this->last_name;
        }

        if (!empty($this->email)) {
            $data['email'] = $this->email;
        }

        $data['invoice'] = $invoice_id;
        $data['bn'] = $this->bn;

        foreach($this->items as $item_num=>$item) {
            $n = $item_num + 1;
            $data['item_name_' . $n] = $item['name'];
            $data['item_item_number_' . $n] = $item['item_id'];
            $data['quantity_' . $n] = $item['qty'];
            $data['amount_' . $n] = $item['unit_cost'];

            $opt_num = 0;

            foreach($item['opt'] as $opt) {
                $data['on' . $opt_num . '_' . $n] = $opt['name'];
                $data['os' . $opt_num . '_' . $n] = $opt['value'];

                $opt_num++;
            }

            $item_num++;
        }

        if ($this->cart_discount > 0) {
            $data['discount_amount_cart'] = $this->cart_discount;
        }

        $q = http_build_query($data);

        return $this->url . '?' . $q;
    }
}