/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/* global base_url */

var url = '';

function addTab(title, url) {
    if ($('#main-tab').tabs('exists', title)) {
        $('#main-tab').tabs('select', title);
    } else {
        $('#main-tab').tabs('add', {
            title: title,
            href: base_url + url,
            closable: true,
            fit: true,
            cache: true,
            tabHeight: 20
        });
    }
}

function myFormatDate(_date, row) {
    if (_date !== null) {
        var ss = (_date.split('-'));
        var y = parseInt(ss[0], 10);
        var m = parseInt(ss[1], 10);
        var d = parseInt(ss[2], 10);
        return (d < 10 ? ('0' + d) : d) + '-' + (m < 10 ? ('0' + m) : m) + '-' + y;
    } else {
        return '';
    }
}
function myformatter(date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
}
function myparser(s) {
    if (!s)
        return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0], 10);
    var m = parseInt(ss[1], 10);
    var d = parseInt(ss[2], 10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
        return new Date(y, m - 1, d);
    } else {
        return new Date();
    }
}

function formatPrice(num, row) {
    if (num !== null && num !== undefined) {
        var x = '' + num;
        var parts = x.toString().split(".");
        return parts[0].replace(/\B(?=(\d{3})+(?=$))/g, ",") + (parts[1] ? "." + parts[1] : ".00");
    } else {
        return "";
    }
}
//document.write('<script type="text/javascript" src="js/vendor.js"></script>');
//document.write('<script type="text/javascript" src="js/customer.js"></script>');
//document.write('<script type="text/javascript" src="js/client.js"></script>');
//document.write('<script type="text/javascript" src="js/proformainvoice.js"></script>');
document.write('<script type="text/javascript" src="js/fabric.js"></script>');
document.write('<script type="text/javascript" src="js/color.js"></script>');
//document.write('<script type="text/javascript" src="js/product_type.js"></script>');
//document.write('<script type="text/javascript" src="js/product_group.js"></script>');
//document.write('<script type="text/javascript" src="js/materials.js"></script>');
//document.write('<script type="text/javascript" src="js/accessories.js"></script>');
//document.write('<script type="text/javascript" src="js/currency.js"></script>');
//document.write('<script type="text/javascript" src="js/unit.js"></script>');
//document.write('<script type="text/javascript" src="js/finishing.js"></script>');
//document.write('<script type="text/javascript" src="js/country.js"></script>');
//document.write('<script type="text/javascript" src="js/warehouse.js"></script>');
//document.write('<script type="text/javascript" src="js/products.js"></script>');
//document.write('<script type="text/javascript" src="js/purchaseorder.js"></script>');
//document.write('<script type="text/javascript" src="js/purchaseordereditorial.js"></script>');
//document.write('<script type="text/javascript" src="js/po_editorial.js"></script>');
//document.write('<script type="text/javascript" src="js/productiontracking.js"></script>');
//document.write('<script type="text/javascript" src="js/commercial.invoice.js"></script>');
document.write('<script type="text/javascript" src="js/users.js"></script>');



$.fn.serializeObject = function ()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

open_target = function (method, url, data, target) {
    var form = document.createElement("form");
    form.action = url;
    form.method = method;
    form.target = target || "_self";
    if (data) {
        for (var key in data) {
            var input = document.createElement("textarea");
            input.name = key;
            input.value = typeof data[key] === "object" ? JSON.stringify(data[key]) : data[key];
            form.appendChild(input);
        }
    }
    form.style.display = 'none';
    document.body.appendChild(form);
    form.submit();
};


$.extend($.fn.validatebox.defaults.rules, {
    minLength: {
        validator: function (value, param) {
            return value.length >= param[0];
        },
        message: 'Please enter at least {0} characters.'
    }
});

$.extend($.fn.validatebox.defaults.rules, {
    maxLength: {
        validator: function (value, param) {
            return value.length <= param[0];
        },
        message: 'Please enter at least {0} characters.'
    }
});

function logout() {
    window.location.href = base_url + 'home/logout';
}
function isNullOrEmpty(str) {
    return str === null || str === undefined || str.trim() === '';
}


