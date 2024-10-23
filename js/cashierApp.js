var posApp = angular.module('posApp', []);
posApp.service('OrderService', function () {
    var orders = [];
    var indexCurrentOrder = 0;
    // model
    function item() {
        this.id = "";
        this.barcode = "";
        this.name = "";
        this.price = 0;
        this.trading_price = 0;
        this.cost = 0;
        this.uom = "";
        this.discount = 0;
//		this.discount_nominal = 0;
        this.initialDiscount = 0;
        this.is_discount_percentage = true;
        this.discountUpdatedBy = "";
        this.ppn = 0;
        this.totalPrice = "";
        this.discountPerItem = 0;
        this.quantity = 1;
        this.setTotalPrice = function () {
            var discount_total = 0;
//			if(this.is_discount_percentage == "true" || this.is_discount_percentage == true){
//				discount_total = (parseFloat(this.quantity) * parseFloat(this.price) * parseFloat(this.discount)/100);
//			}else{
            discount_total = this.discount;
//			}
            this.totalPrice = (parseFloat(this.quantity) * parseFloat(this.price)) - discount_total;
        };

        this.setQuantity = function (quantity) {
            this.quantity = quantity;
            this.setTotalPrice();
        };
        this.setDiscount = function (newDiscount) {
            //record initial discount for audit
            if (this.is_discount_percentage == "true" || this.is_discount_percentage == true) {
//				if(this.initialDiscount == "" || this.initialDiscount == undefined){
//					this.initialDiscount = angular.copy(this.discount);
//				}
                var discount_total = 0;
                var newDisc = newDiscount || 0;
                discount_total = (parseFloat(this.quantity) * parseFloat(this.price) * parseFloat(newDisc) / 100);
                this.discount = discount_total;
            } else {
//				this.discount_nominal = newDiscount;
//				if(this.initialDiscount == "" || this.initialDiscount == undefined){
//					this.initialDiscount = angular.copy(this.discount_nominal);
//				}
                this.discount = newDiscount;
            }
            this.setTotalPrice();
        };
        this.setIsDiscountPercentage = function (is_discount_percentage_) {
            this.is_discount_percentage = is_discount_percentage_;
        };

    }
    function customer() {
        this.id = "";
        this.barcode = "";
        this.name = "";
        this.address = "";
        this.discount = 0;
        this.customertype = "";
    }

    function payment() {
        this.id = "";
        this.totalQuantity = "";
        this.totalPrice = "";
        this.totalCash = "";
        this.amountPayByCash = "";
        this.changeCash = "";
        this.creditCardNumber = "";
        this.amountPayByCreditCard = "";
        this.creditCardType = "";
        this.debitCardNumber = "";
        this.debitCardType = "";
        this.amountPayByDebitCard = "";
        this.voucherNumber = "";
        this.amountPayByVoucher = "";
    }
    function order() {
        this.customer = {};
        this.items = [];
        this.payment = {};
    }
    // non static function
    function generateNewItem(newDataItem) {
        var newItem = new item();
        angular.forEach(newDataItem, function (value, key) {
            if (this.hasOwnProperty(key))
                this[key] = value;
        }, newItem);
        console.log("it", newItem);
        return newItem;
    }
    this.generateNewCustomer = function (newDataCustomer) {
        var newCustomer = new customer();
        angular.forEach(newDataCustomer, function (value, key) {
            if (this.hasOwnProperty(key))
                this[key] = value;
        }, newCustomer);
        console.log("cust.detail", newCustomer);
        return newCustomer;
    }

//	this.resetCustomer = function (ignoreFields) {
//		angular.forEach(ignoreFields, function(value, key) {
//			if (!this.hasOwnProperty(key))
//				this[key] = "";
//		}, newCustomer);
//		console.log("reset Customer", newCustomer);
//		return newCustomer;
//	}

    function generateNewPayment(newDataPayment) {
        var newPayment = new payment();
        angular.forEach(newDataPayment, function (value, key) {
            if (this.hasOwnProperty(key))
                this[key] = value;
        }, newPayment);
        console.log("payment", newPayment);
        return newPayment;
    }
    this.generateNewOrder = function () {
        var newOrder = new order();
        newOrder.customer = this.generateNewCustomer("");
        newOrder.payment = generateNewPayment("");

        orders = [];

        orders.push(newOrder);
        if (orders.length > 0) {
            indexCurrentOrder = orders.length - 1;
        }
    }

    this.resetOrderBaseOnNewCustomer = function () {
        var order = orders[indexCurrentOrder];
        order.items = [];
        order.payment = {};
    }

    // static function
    this.addItem = function (dataItem) {
        var existedItem = this.getExistedItem(dataItem);
        if (null != existedItem && "" != existedItem && parseInt(existedItem) > -1) {
            this.addExistingItem(dataItem);
        } else {
            var newItem = generateNewItem(dataItem);
            newItem.setTotalPrice();
            this.getCurrentOrder().items.push(newItem);
        }
    };
    this.getExistedItem = function (dataItem) {
        var items = this.getCurrentOrder().items;
        var it = $.grep(Object.keys(items), function (itm) {
            return items[itm].barcode == dataItem.barcode;
        });
        return it;
    }

    this.setCustomerToActiveOrder = function (newCustomer) {
        console.log("setCustomerToActiveOrder: ", newCustomer);
        this.getCurrentOrder().customer = newCustomer;
        console.log("this.getCurrentOrder().customer: ", this.getCurrentOrder().customer);
    }

    this.getOrders = function () {
        return orders;
    }

    this.getItems = function () {
        return this.getCurrentOrder().items;
    };

    this.addPayment = function (dataPayment) {
        var newPayment = generateNewPayment(dataPayment);
        this.getCurrentOrder().payment = newPayment;
    }
    this.getPayment = function () {
        return this.getCurrentOrder().payment;
    };

    this.getCurrentOrder = function () {
        return orders[indexCurrentOrder];
    }

    this.getCurrentCustomer = function () {
        var order = orders[indexCurrentOrder];
        return order.customer;
    }

    this.getIndexCurrentOrder = function () {
        return indexCurrentOrder;
    }
    this.setIndexCurrentOrder = function (index) {
        indexCurrentOrder = index;
    }

    this.addExistingItem = function (existingDataItem) {
        var items = this.getCurrentOrder().items;
        var it = $.grep(Object.keys(items), function (itm) {
            return items[itm].barcode == existingDataItem.barcode;
        });
        var quantity = items[it].quantity;
        console.log("items[it]", items[it]);
        this.getCurrentOrder().items[it].setQuantity(parseInt(quantity) + 1);
    }

    // initialize Order
    this.initializeOrder = function () {
        this.generateNewOrder();

    }
});

posApp.controller('posCtrl', function ($scope, $http, $element, OrderService) {
    // 1.initialize order
    OrderService.initializeOrder();

    console.log("getIndexCurrentOrder",
            OrderService.getIndexCurrentOrder());
    console.log("getCurrentOrder",
            OrderService.getCurrentOrder());

    $scope.order = OrderService.getCurrentOrder();
    $scope.customer = $scope.order.customer;
//		$scope.customer = OrderService.getCurrentCustomer();
    $scope.selectedTable = 1;
    $scope.selectedRow = 0;
    $scope.selectedHeaderRow = 0;
    $scope.selectedHeaderCell = 0;
    $scope.searchKeyFocus = true;
    $scope.isQuantityEditMode = false;
    $scope.newDiscount = 0;
    $scope.listSearchedData = [];
    $scope.searchCustomerKeyFocus = false;
    $scope.searchItemKeyFocus = false;
    $scope.selectedSearchCustomerRow = -1;
    $scope.selectedSearchItemRow = -1;
    $scope.onlyNumbers = "/^\d+$/";
    $scope.templateCustomerList = "";
    $scope.listSearchedCustomer = [];
    $scope.listDebitCardType = [];
    $scope.listCreditCardType = [];
    $scope.discountOptions = [{name: 'Percent', value: 'true'}, {name: 'Price', value: 'false'}];
    $scope.searchCustomerKey = "";

    $scope.selectedItem = function () {
        return $scope.order.items[$scope.selectedRow];
    }

    $scope.setFirstInputOfHeaderToFocus = function () {
        $scope.isFirstElementOfHeaderFocus = !$scope.isFirstElementOfHeaderFocus;
        $scope.$apply();
        console.log("setFirstInputOfHeaderToFocus");
    }

    $scope.setClickedRow = function (index) {
        $scope.selectedRow = index;
    }

    $scope.$watch('selectedRow', function () {
    });

    /*Customer Section*/
    $scope.fetchCustomerDisplayTemplate = function () {
        console.log("fetchCustomerDisplayTemplate");
//			$scope.templateCustomerList = "fetchCustomerDisplayTemplate";
        $http({
            method: 'POST',
            url: rootUrl + "/cashier/template/customer_list_template",
            data: [],
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .success(function (data, status, headers, config) {
                    console.log("fetchCustomerDisplayTemplate:");
                    if (data != null || data.length > 0) {
                        $scope.templateCustomerList = data;
                    }
                }
                ).error(function (data, status, headers, config) {
            console.log(status);
            return false;
        });
    }

    //reset customer if cannot find customer
    $scope.resetCustomer = function () {
        var customer = OrderService.generateNewCustomer("");
        OrderService.setCustomerToActiveOrder(customer);
    }

    $scope.setCustomer = function (customerData) {
        console.log("setCustomer customerData : ", customerData);
        var customer = OrderService.generateNewCustomer(customerData);
        console.log("setCustomer customer : ", customer);
        OrderService.setCustomerToActiveOrder(customer);
        console.log("reset order after set customer");
        $scope.resetOrderBaseOnNewCustomer();
    }

    // get Customer Datas from DB
    $scope.fetchCustomer = function (searchCustomerKey) {
        var param = $.param({"searchCustomerKey": searchCustomerKey});
        $http({
            method: 'POST',
            url: rootUrl + "/cashier/Sales/getCustomer",
            data: param,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .success(function (data, status, headers, config) {
                    console.log("dataCustomer:", data);
                    if (data == null || data.length < 1 || data == 'null') {
                        console.log("showPopUpPickCustomer: ");
                        $scope.resetCustomer();
                        console.log("searchCustomerKey:", searchCustomerKey);
                        $scope.showPopUpPickCustomer(searchCustomerKey);
                        return false;
                    }
                    if (angular.isArray(data)) {
                        $scope.setCustomer(data[0]);
                    } else {
                        $scope.setCustomer(data);
                    }
                    return true;
                }
                ).error(function (data, status, headers, config) {
            console.log(status);
            return false;
        });
    }

    $scope.fetchListCustomer = function (searchCustomerKey) {
        var param = $.param({"searchCustomerKey": searchCustomerKey});
        $http({
            method: 'POST',
            url: rootUrl + "/cashier/Sales/getCustomers",
            data: param,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .success(function (data, status, headers, config) {
                    if (data != null && data != undefined && data != "null") {
                        $scope.listSearchedCustomer = data;
                        $scope.searchCustomerKey = searchCustomerKey;
                    }
                }
                ).error(function (data, status, headers, config) {
            console.log(status);
            return false;
        });
    }

    $scope.searchCustomer = function (searchCustomerKey) {
        $scope.fetchListCustomer(searchCustomerKey);
        $scope.selectedSearchCustomerRow = -1;
    }

    $scope.showPopUpPickCustomer = function (searchCustomerKey) {
        $scope.fetchListCustomer(searchCustomerKey);
//			if($scope.templateCustomerList == ""){
//			$scope.selectedTable = 5;
//			if($('#searchCustomerModal').length < 1){
//				$scope.fetchCustomerDisplayTemplate();
//			}else{
//				$scope.selectedTable = 5;
//				$('#searchCustomerModal').modal({'show':true, backdrop: 'static', keyboard: true});
//			}
//			
        $('#searchCustomerModal').modal({'show': true, backdrop: 'static', keyboard: true});
        $scope.selectedTable = 5;
        $("#searchCustomerKey").focus();
        $("#searchCustomerKey").select();

//			}
        //binding data to template

//			var element = $scope.templateCustomerList;
//			$compile(element)($scope.fetchListCustomer());

        //append template
//			$('#customer_popup_container').html($scope.templateCustomerList);
//			$('#customer_popup_container #searchCustomerModal').modal({'show':true, backdrop: 'static', keyboard: true});

//			$scope.selectedTable = 4;
//			$scope.searchItem(searchKey);
    }

    $scope.setQuantityToEditMode = function () {
        $scope.isQuantityEditMode = !$scope.isQuantityEditMode;
        if ($scope.isQuantityEditMode == false) {
            $scope.isSearchKeyFocus = !$scope.isSearchKeyFocus;
        }
        $scope.$apply();
    }

    $scope.isShowQuantityInput = function (index) {
        return index == $scope.selectedRow && $scope.isQuantityEditMode == true;
    }

    $scope.setSearchCustomerKeyTofocus = function () {
        $scope.isSearchCustomerKeyFocus = !$scope.isSearchCustomerKeyFocus;
    }

    $scope.setSearchKeyTofocus = function () {
        $scope.isSearchKeyFocus = !$scope.isSearchKeyFocus;
    }

    $scope.setSearchItemKeyTofocus = function () {
        $scope.isSearchItemKeyFocus = !$scope.isSearchItemKeyFocus;
    }

    $scope.setPaymentInputToFocus = function () {
        $scope.isPaymentInputFocus = !$scope.isPaymentInputFocus;
    }

    // get item from DB
    $scope.fetchItem = function (searchKey) {
        console.log("searchKey", searchKey);
        var param = $.param({"searchKey": searchKey});
        $http({
            method: 'POST',
            url: rootUrl + "/cashier/sales/getItem",
            data: param,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .success(function (data, status, headers, config) {
                    console.log("datadatadatadata: ", data);
                    console.log("data.length", data.length);

                    if (data == null || data.length < 1) {
                        console.log("showPopUpPickItem: ");
                        $scope.showPopUpPickItem(searchKey);
                        return false;
                    }
                    console.log("fetchItem ", data[0]);
                    $scope.addItemToActiveOrder(data[0]);
                    $scope.selectLastRowItem();
                    return true;
                }
                ).error(function (data, status, headers, config) {
            console.log(status);
            return false;
        });
    }

    $scope.addItemToActiveOrder = function (newItem) {
        console.log("CUSTOMER: ", $scope.order.customer);
        //console.log("newItem: ", newItem);
        if ($scope.order.customer != null && $scope.order.customer != "undefined") {
            if ($scope.order.customer.customertype == "B2B") {
                newItem.price = newItem.trading_price;
                newItem.discount = 0;
            } else if ($scope.order.customer.customertype == "FAMILY") {
                var discountFamily = $scope.order.customer.discount;
                if (newItem.taxed === 't') {
                    var new_cost = parseFloat(newItem.cost * 1.1);
                    var retail_price = parseFloat((new_cost * 100) / (100 - discountFamily));
                    retail_price = Math.ceil(retail_price / 100) * 100;
                    newItem.price = retail_price;
                } else {
                    var new_cost = newItem.cost;
                    var retail_price = parseFloat((new_cost * 100) / (100 - discountFamily));
                    retail_price = Math.ceil(retail_price / 100) * 100;
                    newItem.price = retail_price;
//                    var discountFamily = $scope.order.customer.discount;
//                    var cost = newItem.cost;
//                    var familyPrice = parseFloat(cost) + parseFloat(cost * (discountFamily / 100));
//                    newItem.price = familyPrice;
//                    newItem.discount = 0;
                }

            }
            console.log("customertype: ", $scope.order.customer.customertype);
        }
        OrderService.addItem(newItem);
        $scope.selectLastRowItem();
    }

    $scope.showPopUpPickItem = function (searchKey) {
        $('.search-item-pos-modal-lg').modal({'show': true, backdrop: 'static', keyboard: true});
        $scope.searchItemKey = searchKey;
        $("#code").focus();
        $scope.selectedTable = 4;
        $scope.searchItem(searchKey);
    }

    $scope.hidePopUpPickItem = function () {
        $('.search-item-pos-modal-lg').modal('hide');
        $scope.goToHome();
    }

    $scope.hidePopUpPickCustomer = function () {
        $('.search-customer-pos-modal-lg').modal('hide');
        $scope.goToHome();
    }

    //search item in DB
    $scope.searchItem = function (searchKey) {
        console.log("searchKey", searchKey);
        var param = $.param({"searchKey": searchKey});
        $http({
            method: 'POST',
            url: rootUrl + "/cashier/sales/getItems",
            data: param,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .success(function (data, status, headers, config) {
                    $scope.listSearchedData = data;
                    console.log("searced Data: ", data);
                }).error(function (data, status, headers, config) {
            console.log(status);
            return false;
        });
    }

    // pick/search item by input barcode in local or fetch from db if not exist
    $scope.pickItem = function (searchKey) {
        console.log("searchKey", searchKey);
        var it = $.grep(Object.keys($scope.order.items), function (itm) {
            console.log(itm);
            return $scope.order.items[itm].barcode == searchKey
        });
        console.log("pick item:", it);
        console.log("pick item =:", $scope.order.items[it]);
        var item = $scope.order.items[it];
        console.log("$scope.order.items[it]", $scope.order.items[it])
        if (item != null || item != undefined) {
            $scope.addExistingItem(item);
            $scope.searchKey = '';
            // scroll to barcode input and focus
            $('.table').parent().animate({
                scrollTop: $('.table').scrollTop() + ($('.table tr:last').offset().top)
            }, 300);
            $scope.selectLastRowItem();
        } else {
            var result = $scope.fetchItem(searchKey);
            console.log('fetch data result:', result);
            if (result == true) {
                // show popup
            }
        }
    }

    $scope.addExistingItem = function (item) {
        OrderService.addExistingItem(item);
        console.log("after add existing:", $scope.order.items);
    }

    $scope.deleteSelectedItem = function () {
        console.log("$scope.selectedRow", $scope.selectedRow);
        $scope.order.items.splice($scope.selectedRow, 1);
    }

    $scope.selectLastRowItem = function () {
        if ($scope.order.items.length > 0) {
            $scope.selectedRow = $scope.order.items.length - 1;
        }
        $scope.searchKey = "";
    }

    $scope.deleteSelectedItemConfirmed = function () {
        $scope.deleteSelectedItem();
        $('.delete-item-confirm-modal-lg').modal('hide');
        $scope.setSearchKeyTofocus();
        console.log("$scope.order.items.lenght", $scope.order.items.length);
        $scope.selectLastRowItem();
        $scope.$apply();
        console.log("item success deleted");
    }

    //calculate Price Total
    $scope.calculatePriceTotal = function () {
        var i = 0, sum = 0;
        for (; i < $scope.order.items.length; i++) {
            sum += parseInt($scope.order.items[i].totalPrice, 10);
        }

//            var customer = $scope.order.customer;
//            if(customer !== null && customer !== 'undefined'){
//            	if(customer.customertype == "FAMILY"){
//            		var total_discount_customer = 0;
//            		var discount = customer.discount;
//            		if(discount > 0){
//            			total_discount_customer = (sum * discount) / 100;
//            			sum = sum + total_discount_customer;
//            		}
//            	}
//            }

        return sum;
    };

    $scope.calculateSubTotalPrice = function (quantity, price) {
        discount = $scope.order.customer.discount;
        var subTotal = 0;
        if (discount == undefined) {
            discount = 0;
        }
        if (quantity != undefined && price != undefined && discount != undefined) {
            subTotal = ((quantity * price) + ((quantity * price) * discount / 100));
        }

        return subTotal;
    };

    $scope.showPopUpLoginToUpdateDiscount = function () {
        var link = rootUrl + "/accounts/accounts/custom_login";
        fetchRemoteContentPopUp({elementTarget: "#login_discount_content", link: link,
            onSuccess: function () {
                $('.login-discount-modal-md').modal({'show': true, backdrop: 'static', keyboard: true});
            }
        }
        );
    }

    $scope.checkPermissionToChangeDiscount = function () {
        $http({
            method: 'GET',
            url: rootUrl + "/cashier/sales/checkUserPermissionToUpdateDiscount",
        })
                .success(function (data, status, headers, config) {
//				console.log("suksessss:", data);
//				console.log("suksessss2:", data['success']);
                    if (data.success) {
                        $('.edit-discount-item-modal-lg').modal({'show': true, backdrop: 'static', keyboard: true});
                        console.log('show modal dicount');
                    } else {
                        $scope.showPopUpLoginToUpdateDiscount();
                    }
                }
                ).error(function (data, status, headers, config) {
            console.log(status);
            return false;
        });
    }

    $scope.closePopUpLoginDiscount = function () {
        $("#login_discount_content").html("");
        $('.login-discount-modal-md').modal('hide');
    }

    $scope.showPopUpDiscount = function () {
        var discount = 0; //$scope.selectedItem().discount;
        if (discount == undefined || discount < 1) {
            discount = "";
        }
        $scope.newDiscount = discount;
//			$scope.newDiscount = $scope.selectedItem().discount_nominal;
        $scope.checkPermissionToChangeDiscount();
    }

    $scope.setDiscountKeyTofocus = function () {
        $scope.isDiscountKeyFocus = !$scope.isDsicountKeyFocus;
    }

    $scope.updateIsDiscountPercentage = function (is_discount_percentage) {
        $scope.order.items[$scope.selectedRow].setIsDiscountPercentage(is_discount_percentage);
    }

    $scope.updateDiscountSelectedItem = function (newDiscount) {
        console.log("newDiscount", newDiscount);
        console.log("$scope.selectedRow", $scope.selectedRow);

//			if($scope.is_discount_percentage == true || $scope.is_discount_percentage == "true"){
//				$scope.order.items[$scope.selectedRow].setDiscountFromPercentage(newDiscount);
//			}else{
        $scope.order.items[$scope.selectedRow].setDiscount(newDiscount);
//			}

        $('.edit-discount-item-modal-lg').modal('hide');
//			$scope.goToHome();

        $scope.setSearchKeyTofocus();
        $scope.selectedTable = 1;
        $scope.searchKey = "";
    }

    $scope.goToHome = function () {
        $scope.setSearchKeyTofocus();
        $scope.selectedTable = 1;
        $scope.searchKey = "";
        $scope.$apply();
    }

    $scope.generateNewOrder = function () {
        OrderService.generateNewOrder();
//			$scope.order = OrderService.getCurrentOrder();
        $scope.$apply();
    }

    $scope.resetOrderBaseOnNewCustomer = function () {
        OrderService.resetOrderBaseOnNewCustomer();
        $scope.$apply();
    }

    $scope.switchToOrder = function (index) {
        OrderService.setIndexCurrentOrder(index);
        $scope.order = OrderService.getCurrentOrder();
        $scope.$apply();
    }
    $scope.getAllOrder = function () {
        return angular.toJson(OrderService.getOrders(), 1);
    }

    //show payment
    $scope.showPopUpPayment = function () {
        $('.payment-pos-modal-md').modal({'show': true, backdrop: 'static', keyboard: true});
        $scope.calculatePayment();
        $scope.setPaymentInputToFocus();
        $scope.selectedTable = 3;
    }

    $scope.isShowPaymentCash = true;
    $scope.isShowPaymentDebitCard = false;
    $scope.isShowPaymentCreditCard = false;
    $scope.isShowPaymentVoucher = false;

    $scope.resetVoucher = function () {
        $scope.voucherNumber = "";
        $scope.amountPayByVoucher = "";
        $scope.voucherNote = "";
    }
    $scope.resetDebitCard = function () {
        $scope.debitCardNumber = "";
        $scope.amountPayByDebitCard = "";
        $scope.debitCardType = "";
        $scope.debitCardHolderName = "";
    }
    $scope.resetCreditCard = function () {
        $scope.creditCardNumber = "";
        $scope.amountPayByCreditCard = "";
        $scope.creditCardType = "";
        $scope.creditCardHolderName = "";
    }
    $scope.resetCash = function () {
        $scope.totalCash = "";
        $scope.amountPayByCash = "";
        $scope.changeCash = "";
    }

    //show peyment
    $scope.togglePaymentCash = function () {
        $scope.resetCash();
        $scope.isShowPaymentCash = !$scope.isShowPaymentCash;
        $scope.calculatePayment();
    }
    $scope.togglePaymentCreditCard = function () {
        $scope.resetCreditCard();
        $scope.isShowPaymentCreditCard = !$scope.isShowPaymentCreditCard;
        $scope.fetchCreditCardType();
        $scope.calculatePayment();
    }
    $scope.togglePaymentDebitCard = function () {
        $scope.resetDebitCard();
        $scope.isShowPaymentDebitCard = !$scope.isShowPaymentDebitCard;
        $scope.fetchDebitCardType();
        $scope.calculatePayment();
    }
    $scope.togglePaymentVoucher = function () {
        $scope.resetVoucher();
        $scope.isShowPaymentVoucher = !$scope.isShowPaymentVoucher;
        $scope.calculatePayment();
    }

    $scope.fetchDebitCardType = function () {
        console.log("$scope.listDebitCardType", $scope.listDebitCardType);

        if ($scope.listDebitCardType == undefined || $scope.listDebitCardType.length < 1) {
            console.log("start fetch debit type");
            $http({
                method: 'POST',
                url: rootUrl + "/master/Card_type/get_debit_card_type",
                data: [],
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                    .success(function (data, status, headers, config) {
                        $scope.listDebitCardType = data;
                    }
                    ).error(function (data, status, headers, config) {
                console.log(status);
                return false;
            });
        } else {
            console.log("fetch debit type error");
        }
    }

    $scope.fetchCreditCardType = function () {
        if ($scope.listCreditCardType == undefined || $scope.listCreditCardType.length < 1) {
            console.log("start fetch credit type");
            $http({
                method: 'POST',
                url: rootUrl + "/master/Card_type/get_credit_card_type",
                data: [],
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
                    .success(function (data, status, headers, config) {
                        $scope.listCreditCardType = data;
                    }
                    ).error(function (data, status, headers, config) {
                console.log(status);
                return false;
            });
        } else {
            console.log("fetch credt type gagal");
        }
    }

    //calculate payment
    $scope.totalPrice = 0;
    $scope.totalPaymentAllMethod = 0;
    $scope.totalPandingPayment = $scope.totalPrice;

    $scope.totalCash = "";
    $scope.amountPayByCash = "";
    $scope.changeCash = "";

    $scope.amountPayByCreditCard = "";
    $scope.amountPayByDebitCard = "";
    $scope.amountPayByVoucher = "";
    $scope.voucherNote = "";
    $scope.isCheckOutButtonDisabled = false;

    $scope.infoPayment = "";

    $scope.resetPayment = function () {
        $scope.totalPrice = "";
        $scope.totalPaymentAllMethod = "";
        $scope.totalPandingPayment = $scope.totalPrice;
        $scope.totalCash = "";//cashl
        $scope.amountPayByCash = "";
        $scope.changeCash = "";
        $scope.voucherNumber = "";//voucher
        $scope.amountPayByVoucher = "";
        $scope.voucherNote = "";
        $scope.debitCardNumber = "";//debit
        $scope.amountPayByDebitCard = "";
        $scope.debitCardType = "";
        $scope.debitCardHolderName = "";
        $scope.creditCardNumber = "";//cc
        $scope.amountPayByCreditCard = "";
        $scope.creditCardType = "";
        $scope.creditCardHolderName = "";
    }

    $scope.calculatePaymentCash = function () {
        var outStandingPayment = $scope.totalPrice - $scope.totalPaymentAllMethod;
        var totalCash = parseFloat($scope.totalCash) || 0;
        if (totalCash > outStandingPayment) {
            $scope.totalPaymentAllMethod += parseFloat(outStandingPayment) || 0;
            $scope.infoPayment = "ok, ambil kembaliannya";
            $scope.changeCash = parseFloat($scope.changeCash) + parseFloat($scope.totalCash - outStandingPayment) || 0;
            $scope.amountPayByCash = $scope.totalCash - $scope.changeCash;
        } else if (totalCash == outStandingPayment) {
            $scope.totalPaymentAllMethod += parseFloat($scope.totalCash) || 0;
            $scope.infoPayment = "ok";
            $scope.changeCash = parseFloat($scope.changeCash) + parseFloat($scope.totalCash - outStandingPayment) || 0;
            $scope.amountPayByCash = $scope.totalCash - $scope.changeCash;
        } else if (totalCash < outStandingPayment) {
            $scope.infoPayment = "Cash tidak cukup";
            $scope.changeCash = 0;
        }
    }

    $scope.calculatePaymentDebitCard = function () {
        var totalCash = $scope.changeCash || 0;
        var outStandingPayment = $scope.totalPrice - $scope.totalPaymentAllMethod;
        if ($scope.amountPayByDebitCard > outStandingPayment) {
            $scope.totalPaymentAllMethod += parseFloat(outStandingPayment) || 0;
            $scope.changeCash = totalCash + parseFloat($scope.amountPayByDebitCard - outStandingPayment);
            $scope.infoPayment = "";
        } else if ($scope.amountPayByDebitCard < outStandingPayment && outStandingPayment > 0) {
            $scope.totalPaymentAllMethod += parseFloat($scope.amountPayByDebitCard) || 0;
            $scope.infoPayment = "Payment tidak cukup, butuh bayar via Cash";
            $scope.changeCash = 0;
        } else if ($scope.amountPayByDebitCard == outStandingPayment && outStandingPayment > 0) {
            $scope.totalPaymentAllMethod += parseFloat($scope.amountPayByDebitCard) || 0;
            $scope.infoPayment = "Payment Cukup";
            $scope.changeCash = 0;
        }
    }
    $scope.calculatePaymentCreditCard = function () {
        var totalCash = $scope.changeCash || 0;
        var outStandingPayment = $scope.totalPrice - $scope.totalPaymentAllMethod;
        if ($scope.amountPayByCreditCard > outStandingPayment) {
            $scope.totalPaymentAllMethod += parseFloat(outStandingPayment) || 0;
            $scope.changeCash = totalCash + parseFloat($scope.amountPayByCreditCard - outStandingPayment);
            $scope.infoPayment = "";
        } else if ($scope.amountPayByCreditCard < outStandingPayment) {
            $scope.totalPaymentAllMethod += parseFloat($scope.amountPayByCreditCard) || 0;
            $scope.infoPayment = "Payment tidak cukup, butuh bayar via Cash";
            $scope.changeCash = 0;
        } else if ($scope.amountPayByCreditCard == outStandingPayment && outStandingPayment > 0) {
            $scope.totalPaymentAllMethod += parseFloat($scope.amountPayByCreditCard) || 0;
            $scope.infoPayment = "Payment Cukup";
            $scope.changeCash = 0;
        }
    }
    $scope.calculatePaymentVoucher = function () {
        //note:jika voucher lebih, maka hangus
        var outStandingPayment = $scope.totalPrice - $scope.totalPaymentAllMethod;
        if ($scope.amountPayByVoucher > outStandingPayment) {
            $scope.totalPaymentAllMethod += parseFloat(outStandingPayment) || 0;
            $scope.voucherNote = "Voucher anda lebih dan sisanya akan hangus";
            $scope.infoPayment = "";
        } else if ($scope.amountPayByVoucher < outStandingPayment) {
            $scope.totalPaymentAllMethod += parseFloat($scope.amountPayByVoucher) || 0;
            $scope.infoPayment = "Voucher tidak cukup, butuh bayar via Cash";
            $scope.voucherNote = "";
        } else if ($scope.amountPayByVoucher == outStandingPayment && outStandingPayment > 0) {
            $scope.totalPaymentAllMethod = parseFloat($scope.amountPayByVoucher) || 0;
            $scope.infoPayment = "Voucher Cukup";
        }
    }

    $scope.calculatePayment = function () {
        $scope.totalPrice = parseFloat($scope.calculatePriceTotal());
        $scope.totalPaymentAllMethod = 0;
        $scope.changeCash = 0;
        //calculate Voucher
        if ($scope.amountPayByVoucher != "" && $scope.amountPayByVoucher > 0) {
            $scope.calculatePaymentVoucher();
        }
        //calculate debit card, CC and voucher
        if ($scope.amountPayByDebitCard != "" && $scope.amountPayByDebitCard > 0) {
            $scope.calculatePaymentDebitCard();
        }
        //calculate credit card, CC and voucher
        if ($scope.amountPayByCreditCard != "" && $scope.amountPayByCreditCard > 0) {
            $scope.calculatePaymentCreditCard();
        }
        //calculate cash
        if ($scope.totalCash != "" || $scope.totalCash > 0) {
            $scope.calculatePaymentCash();
        }

        if ($scope.totalPaymentAllMethod < $scope.totalPrice) {
            $scope.totalPandingPayment = $scope.totalPrice - $scope.totalPaymentAllMethod;
        } else {
            $scope.totalPandingPayment = 0;
        }

    }

    $scope.generatePayment = function () {
        var payment = {
            totalQuantity: 0,
            totalPrice: $scope.totalPrice,
            totalCash: $scope.totalCash,
            amountPayByCash: $scope.amountPayByCash,
            changeCash: $scope.changeCash,
            creditCardNumber: $scope.creditCardNumber,
            amountPayByCreditCard: $scope.amountPayByCreditCard,
            creditCardType: $scope.creditCardType,
            debitCardNumber: $scope.debitCardNumber,
            debitCardType: $scope.debitCardType,
            amountPayByDebitCard: $scope.amountPayByDebitCard,
            voucherNumber: $scope.voucherNumber,
            amountPayByVoucher: $scope.amountPayByVoucher
        }
        OrderService.addPayment(payment);
    }

    //print order
    $scope.getOrder = function () {
        return angular.toJson($scope.order, 1);
    }
    $scope.currencyFormatDefault = function (num) {
        num = parseFloat(num) || 0;
        return num.toFixed(0) // always two decimal digits
                .replace(".", ",") // replace decimal point character with ,
                .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // use . as a separator
    }

    $scope.currencyFormatIDR = function (num) {
        num = parseFloat(num) || 0;
        return num.toFixed(2) // always two decimal digits
                .replace(".", ",") // replace decimal point character with ,
                .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // use . as a separator
    }

    //save item to DB
    $scope.saveOrder = function () {
        if ($scope.isCheckOutButtonDisabled == false) {
            $scope.isCheckOutButtonDisabled = true;
            console.log("save order");

            if ($scope.totalPrice > $scope.totalPaymentAllMethod) {
                $scope.isCheckOutButtonDisabled = false;
                alert("Pembayaran tidak cukup, Silahkan gunakan pembayaran lain.");
                return false;
            }

            $scope.generatePayment();
            var order = $scope.order;
            var orderParam = JSON.stringify($scope.order);
            var param = {"order": orderParam};
            console.log("param :", param);
            $.ajax({
                type: "POST",
                url: rootUrl + "/cashier/sales/saveOrder",
                data: param,
                success: function (data) {
                    var response = JSON.parse(data);
                    console.log("response: ", response);
                    console.log("response.success: ", response.success);
                    console.log("is response.success: ", response.success == true);

                    if (response.success == true) {
                        console.log("suksessss");
                        console.log("order: ", response.data);
                        localStorage.setItem("order2", JSON.stringify(response.data));
                        localStorage.setItem("order", JSON.stringify($scope.order));
                        $scope.printReceive();
                    } else {
                        $scope.isCheckOutButtonDisabled = false;
                        alert("Transaksi gagal dilakukan, silahkan hubungi Support! " + response.data);
                        console.log("gagal 1");
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $scope.isCheckOutButtonDisabled = false;
                    console.log(xhr.status);
                    console.log(thrownError);
                    alert("Transaksi gagal dilakukan, silahkan hubungi Support!");
                    console.log("gagal 2");
                },
                done: function () {
                    $scope.isCheckOutButtonDisabled = false;
                    console.log("gagal 3");
                }
            });
        }
    }

    $scope.saveOrder3 = function () {
        if ($scope.isCheckOutButtonDisabled == false) {
            $scope.isCheckOutButtonDisabled = true;
            var isCheckOutButtonDisabled = $scope.isCheckOutButtonDisabled;

            console.log("save order");

            if ($scope.totalPrice > $scope.totalPaymentAllMethod) {
                $scope.isCheckOutButtonDisabled = false;
                alert("Pembayaran tidak cukup, Silahkan gunakan pembayaran lain.");
                return false;
            }

            $scope.generatePayment();
            var orderParam = JSON.stringify($scope.order);
            var param = 'order=' + encodeURIComponent(orderParam);

            $http({
                method: 'POST',
                url: rootUrl + "/cashier/sales/saveOrder",
                data: param,
                headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    "X-Requested-With": "XMLHttpRequest"}
            }).success(function (data, status, headers, config) {
//					var response = JSON.parse(data);
                var response = data;
                console.log("response: ", response);
                console.log("response.success: ", response.success);
                console.log("is response.success: ", response.success == true);

                if (response.success == true) {
                    console.log("suksessss");
                    console.log("order: ", response.data);
                    localStorage.setItem("order2", JSON.stringify(response.data));
                    localStorage.setItem("order", JSON.stringify($scope.order));
                    $scope.printReceive();
                } else {
                    $scope.isCheckOutButtonDisabled = false;
                    alert("Transaksi gagal dilakukan, silahkan hubungi Support! " + response.data);
                    console.log("gagal 1");
                }
            }).error(function (data, status, headers, config) {
                $scope.isCheckOutButtonDisabled = false;
                console.log(status);
                console.log(data);
                alert("Transaksi gagal dilakukan, silahkan hubungi Support!");
                console.log("gagal 2");
            });

        }
    }

    $scope.saveOrder2 = function () {
        var orderParam = JSON.stringify($scope.order);
        var param = "order=" + encodeURI(orderParam);
        $http({
            method: 'POST',
            url: rootUrl + "/cashier/sales/saveOrder",
            data: param,
            headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                "X-Requested-With": "XMLHttpRequest"}
        })
                .success(function (data, status, headers, config) {
                    console.log("suksessss");
                    localStorage.setItem("order", JSON.stringify($scope.order));
                }
                ).error(function (data, status, headers, config) {
            console.log(status);
        });
    }

    //check out
    $scope.checkOut = function () {
        $scope.saveOrder3();
    }

    $scope.printReceive = function () {
        try {
            $('.payment-pos-modal-md').modal('hide');
            $('.print-pos-modal-md').modal({'show': true, backdrop: 'static', keyboard: true});
            $scope.selectedTable = 3;
            var url = rootUrl + "/cashier/sales/printReceive";
            $("#print_content").html('<iframe src="' + url + '" width="400" height="400" style="border:none"></iframe>');

            $("#print_content").hide();

            setTimeout(function () {
                $('.print-pos-modal-md').modal('hide');
                $scope.resetOrder();
            }, 500);
        } catch (e) {
        }

    }

    $scope.resetOrder = function () {
//			$scope.initializeOrder();
//			$scope.apply();
        $scope.isCheckOutButtonDisabled = false;
        location.reload();
    }

    $scope.showHelpModal = function () {
        $('.help-modal-lg').modal("show");
    }

});

posApp.directive('showCustomerList', function ($compile, $timeout) {
    return {
        scope: true,
        link: function (scope, element, attrs) {
            console.log("showCustomerListshowCustomerListshowCustomerListshowCustomerList");
            var el;
            attrs.$observe('template', function (tpl) {
                if (tpl != null && tpl != "") {
                    console.log("showCustomerListshowCustomerListshowCustomerListshowCustomerList:");
                    el = $compile(tpl)(scope);
                    element.html("");
                    element.append(el);
//				        		console.log("template: ",template);
                    //scope.templateCustomerList = "";
                    $('#searchCustomerModal').modal({'show': true, backdrop: 'static', keyboard: true});
                    scope.selectedTable = 5;
//				        		element.template="";
                    scope.templateCustomerList = "";
                }
            });

//			      var focusTarget = attrs['template'];
//			      scope.$watch(focusTarget, function(tpl) {
//						console.log("-------showCustomerListshowCustomerListshowCustomerListshowCustomerList ",element);
//						try{
//			        		if(tpl != null && tpl !=""){
//				        		console.log("showCustomerListshowCustomerListshowCustomerListshowCustomerList:");
//				        		el = $compile( tpl )( scope );
//				        		element.html("");
//				        		element.append( el );
////				        		console.log("template: ",template);
//				        		//scope.templateCustomerList = "";
//				        		$('#searchCustomerModal').modal({'show':true, backdrop: 'static', keyboard: true});
//				        		scope.selectedTable = 5;
////				        		element.template="";
//				        		scope.templateCustomerList="";
//			        		}
//			        	}catch (e) {
//						}
//					});

        }
    };
});

posApp.directive('orderSelector', ['$document', function ($document) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs, ctrl) {
                var elemFocus = false;
                elem.on('mouseenter', function () {
                    elemFocus = true;
                    console.log("table order focus : ", elemFocus);
                });
                elem.on('mouseleave', function () {
                    elemFocus = false;
                    console.log("table order focus : ", elemFocus);
                });
                $document.bind('keydown', function (e) {
                    if (scope.selectedTable == 1) {
                        console.log("keyOrderSelector: ", e.keyCode);
                        if (e.keyCode == 38) { // up
                            console.log(scope.selectedRow);
                            if (scope.selectedRow == 0) {
                                return;
                            }
                            scope.selectedRow--;
                            scope.$apply();
                            e.preventDefault();
                        } else
                        if (e.keyCode == 40) {// down
                            if (scope.selectedRow == scope.order.items.length - 1) {
                                scope.setSearchKeyTofocus();
                            } else {
                                scope.selectedRow++;
                                scope.$apply();
                                e.preventDefault();
                            }
                        }
                        else if (e.keyCode == 113) {//f2
                            scope.setQuantityToEditMode();
                            scope.isShowQuantityInput();
                            var newQuantity = scope.order.items[scope.selectedRow].quantity;
                            scope.order.items[scope.selectedRow].setQuantity(newQuantity);
                            scope.$apply();
                        } else if (e.keyCode == 46) {//del
                            if (scope.order.items.length > 0) {
                                $('.delete-item-confirm-modal-lg').modal({'show': true, backdrop: 'static', keyboard: true});
                                var input = $("#button_delete_item_order");
                                input.focus();
                                input.select();
                            }
                        } else if (e.keyCode == 119) {//f8
                            console.log("aaaaa");
                            scope.deleteSelectedItemConfirmed();
                        } else if (e.keyCode == 115) {//f4
                            if (scope.order.items.length > 0) {
                                scope.selectedTable = 2;
                                scope.showPopUpDiscount();
                                scope.setDiscountKeyTofocus();
                                console.log("setDiscountKeyTofocus");
                                scope.$apply();
                            }
                        }

                    }
                });
            }
        };
    }]);

//discount
posApp.directive('discountSelector', ['$document', function ($document) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs, ctrl) {
                var elemFocus = false;
                elem.on('mouseenter', function () {
                    elemFocus = true;
                    console.log("table discount focus : ", elemFocus);
                });
                elem.on('mouseleave', function () {
                    elemFocus = false;
                    console.log("table discount focus : ", elemFocus);
                });
                $document.bind('keydown', function (e) {
                    if (scope.selectedTable == 2) {
                        console.log("discountSelector: ", e.keyCode);
                        if (e.keyCode == 13) {//enter
                            scope.updateDiscountSelectedItem();
                            scope.$apply();
                            scope.goToHome();
                        }
                    }
                });
            }
        };
    }]);

// main-selector
posApp.directive('bodySelector', ['$document', function ($document) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs, ctrl) {
                var elemFocus = false;
                elem.on('mouseenter', function () {
                    elemFocus = true;
                });
                elem.on('mouseleave', function () {
                    elemFocus = false;
                });
                $document.bind('keydown', function (e) {
                    console.log("0000000000000000");
                    console.log("e.keyCode", e.keyCode);
                    if (e.keyCode == 33) { // up
                        if (scope.selectedTable > 0) {
                            scope.selectedTable--;
                            scope.$apply();
                        }
                        if (scope.selectedTable == 0) {
                            scope.setFirstInputOfHeaderToFocus();
                        }
                        return;
                    } else if (e.keyCode == 34) {// down
                        console.log("down scope.selectedTable ", scope.selectedTable);
                        if (scope.selectedTable < 1) {
                            scope.selectedTable++;
                            scope.$apply();
                            e.preventDefault();
                        }
                        if (scope.selectedTable == 1) {
                            scope.setSearchKeyTofocus();
                            scope.$apply();
                        }
                        return;
                    } else if (e.keyCode == 36) {//home
                        scope.goToHome();
                    } else if (e.keyCode == 121) {//f10
                        scope.showHelpModal();
                    } else if (e.keyCode == 120) {
                        //todo: refactor
                        scope.switchToOrder(0);
                        scope.$apply();
                    } else if (e.keyCode == 118) {//f7
                        scope.showPopUpPayment();
                        scope.$apply();
                    }
                });
            }
        };
    }]);

//search Customer Selector
posApp.directive('searchCustomerSelector', ['$document', function ($document) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs, ctrl) {
                var elemFocus = false;
                elem.on('mouseenter', function () {
                    elemFocus = true;
                    console.log("seacrh Customer selecttor focus in");
                });
                elem.on('mouseleave', function () {
                    elemFocus = false;
                    console.log("seacrh Customer selecttor focus out");
                });
                $document.bind('keydown', function (e) {
                    console.log("keydown: ", e.keyCode);
                    if (scope.selectedTable == 5) {
                        if (e.keyCode == 38) { // up
                            console.log("up scope.selectedTable customer", scope.selectedTable);
                            if (scope.selectedSearchCustomerRow < 0) {
                                scope.setSearchCustomerKeyTofocus();
                                console.log("scope.setSearchCustomerKeyTofocus customer");
                                return;
                            }
                            scope.selectedSearchCustomerRow--;
                            scope.$apply();
                            e.preventDefault();
                        } else if (e.keyCode == 40) {// down
                            console.log("down scope.selectedTable customer", scope.selectedTable);
                            console.log("scope.selectedSearchCustomerRow", scope.selectedSearchCustomerRow);
                            if (scope.selectedSearchCustomerRow < scope.listSearchedCustomer.length - 1) {
                                scope.selectedSearchCustomerRow++;
                                scope.$apply();
                            }
                        } else if (e.keyCode == 13) {
                            console.log("enter for search customer key table");
                            if (scope.selectedSearchCustomerRow > -1) {
                                scope.setCustomer(scope.listSearchedCustomer[scope.selectedSearchCustomerRow]);
                                console.log("add Customer from seacrh customer");
                                scope.listSearchedCustomer = [];
                                scope.searchCustomerKeyFocus = false;
                                scope.selectedSearchCustomerRow = -1;
                                scope.selectedTable = 4;
                                scope.hidePopUpPickCustomer();
                            } else {
                                console.log("cari ulang custumer");
//								scope.resetCustomer();
//								console.log("searchCustomerKey:",scope.searchCustomerKey);
//								scope.showPopUpPickCustomer(scope.searchCustomerKey);
                                scope.fetchListCustomer(scope.searchCustomerKey);
                                scope.selectedSearchCustomerRow = -1;
                            }
                        }
                    }
                });
            }
        };
    }]);

//search Item Selector
posApp.directive('searchItemSelector', ['$document', function ($document) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs, ctrl) {
                var elemFocus = false;
                elem.on('mouseenter', function () {
                    elemFocus = true;
                    console.log("seacrh item selecttor focus in");
                });
                elem.on('mouseleave', function () {
                    elemFocus = false;
                    console.log("seacrh item selecttor focus out");
                });
                $document.bind('keydown', function (e) {
                    console.log("keydown: ", e.keyCode);
                    if (scope.selectedTable == 4) {
                        if (e.keyCode == 38) { // up
                            console.log("up scope.selectedTable ", scope.selectedTable);
                            if (scope.selectedSearchItemRow < 0) {
                                scope.setSearchItemKeyTofocus();
                                console.log("scope.setSearchItemKeyTofocus");
                                return;
                            }
                            scope.selectedSearchItemRow--;
                            scope.$apply();
                            e.preventDefault();
                        } else if (e.keyCode == 40) {// down
                            console.log("down scope.selectedTable ", scope.selectedTable);
                            if (scope.selectedSearchItemRow < scope.listSearchedData.length - 1) {
                                scope.selectedSearchItemRow++;
                                scope.$apply();
                            }
                        } else if (e.keyCode == 13) {
                            console.log("enter for search key table");
                            if (scope.selectedSearchItemRow > -1) {
                                scope.addItemToActiveOrder(scope.listSearchedData[scope.selectedSearchItemRow]);
                                console.log("add item from seacrh");
                                scope.listSearchedData = [];
                                scope.searchItemKeyFocus = false;
                                scope.selectedSearchItemRow = -1;
                                scope.hidePopUpPickItem();
                            } else {
                                console.log("scope.searchItemKey", scope.searchItemKey);
                                scope.searchItem(scope.searchItemKey);
                            }
                        }
                    }
                });
            }
        };
    }]);

//payment selector
posApp.directive('paymentSelector', ['$document', function ($document) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs, ctrl) {
                var elemFocus = false;
                elem.on('mouseenter', function () {
                    elemFocus = true;
//						console.log("payment selecttor focus in");
                });
                elem.on('mouseleave', function () {
                    elemFocus = false;
//						console.log("payment selecttor focus out");
                });
                $document.bind('keydown', function (e) {
                    var input = e.target;
                    var td = $(e.target).closest('td');
                    var moveTo = null;
                    if (scope.selectedTable == 3) {
//					console.log("keyPaymentSelector: ", e.keyCode);
                        if (e.keyCode == 40 || e.keyCode == 38) {// down or up
                            var moveTo = null;
                            if (e.keyCode == 40) {
                                moveTo = $(':input:eq(' + ($(':input').index($(':focus')) + 1) + ')');
                            } else if (e.keyCode == 38) {
                                moveTo = $(':input:eq(' + ($(':input').index($(':focus')) - 1) + ')');
                            }
                        } else if (e.keyCode == 37) {// left
                            if (input.selectionStart == 0) {
                                moveTo = td.prev('td:has(input,textarea)');
                            }
                        } else if (e.keyCode == 39) {// right
                            if (input.selectionEnd == input.value.length) {
                                moveTo = td.next('td:has(input,textarea)');
                            }
                        } else if (e.keyCode == 113) {//f2
                            scope.checkOut();
                            scope.$apply();
                        } else if (e.keyCode == 119) {//f8 show hide payment method
                            scope.togglePaymentCreditCard();
                            $("#totalCash").focus();
                            scope.$apply();
                        } else if (e.keyCode == 120) {
                            scope.resetPayment();
                        }

                        if (moveTo && moveTo.length) {//move focus
                            moveTo.focus();
                            moveTo.select();
                        }

                    }
                });
            }
        };
    }]);

posApp.directive('headerSelector', ['$document', function ($document) {
        return {
            restrict: 'A',
            link: function (scope, elem, attrs, ctrl) {
                var elemFocus = false;
                elem.on('mouseenter', function () {
                    elemFocus = true;
                });
                elem.on('mouseleave', function () {
                    elemFocus = false;
                });

                $document.bind('keydown', function (e) {
                    var input = e.target;
                    var td = $(e.target).closest('td');
                    var moveTo = null;

                    if (scope.selectedTable == 0) {
                        console.log("keyHeaderSelector: ", e.keyCode);
                        if (e.keyCode == 40 || e.keyCode == 38) {// down or up
                            var tr = td.closest('tr');
                            var pos = td[0].cellIndex;

                            var moveToRow = null;
                            if (e.keyCode == 40) {
                                moveToRow = tr.next('tr');
                            } else if (e.keyCode == 38) {
                                moveToRow = tr.prev('tr');
                            }

                            if (moveToRow.length) {
                                moveTo = $(moveToRow[0].cells[pos]);
                            }
                        } else if (e.keyCode == 37) {// left
                            if (input.selectionStart == 0) {
                                moveTo = td.prev('td:has(input,textarea)');
                            }
                        } else if (e.keyCode == 39) {// right
                            console.log("input.selectionEnd", input.selectionEnd);
                            console.log("input.value.length", input.value.length);
                            if (input.selectionEnd == input.value.length) {
                                moveTo = td.next('td:has(input,textarea)');
                            }
                        }

                        if (moveTo && moveTo.length) {// move focus
                            e.preventDefault();
                            moveTo.find('input,textarea').each(function (i, input) {
                                input.focus();
                                input.select();
                            });
                        }
                    }
                });
            }
        };
    }]);

posApp.directive('firstInputOfHeaderFocus', function ($timeout) {
    return {
        link: function (scope, elem, attr) {
            var focusTarget = attr['firstInputOfHeaderFocus'];
            scope.$watch(focusTarget, function (value) {
                $timeout(function () {
                    elem[0].focus();
                });
            });
        }
    }
});

posApp.directive('searchKeyFocus', function ($timeout) {
    return {
        link: function (scope, elem, attr) {
            var focusTarget = attr['searchKeyFocus'];
            scope.$watch(focusTarget, function (value) {
//				console.log("---------------------------------------------------focus1: ",elem)
                $timeout(function () {
                    elem[0].focus();
                });
            });
        }
    }
});

posApp.directive('searchCustomerKeyFocus', function ($timeout) {
    return {
        link: function (scope, elem, attr) {
            var focusTarget = attr['searchCustomerKeyFocus'];
            scope.$watch(focusTarget, function (value) {
//				console.log("serach customer--------------------------------------focus: ",elem)
                $timeout(function () {
                    elem[0].focus();
                });
            });
        }
    }
});

posApp.directive('searchItemKeyFocus', function ($timeout) {
    return {
        link: function (scope, elem, attr) {
            var focusTarget = attr['searchItemKeyFocus'];
            scope.$watch(focusTarget, function (value) {
//				console.log("---------------------------------------------------focus: ",elem)
                $timeout(function () {
                    elem[0].focus();
                });
            });
        }
    }
});

posApp.directive('discountKeyFocus', function ($timeout) {
    return {
        link: function (scope, elem, attr) {
            var focusTarget = attr['discountKeyFocus'];
            scope.$watch(focusTarget, function (value) {
//				console.log("---------------------------------------------------focus2: ",elem)
                $timeout(function () {
                    elem[0].focus();
                });
            });
        }
    }
});

posApp.directive('paymentInputFocus', function ($timeout) {
    return {
        link: function (scope, elem, attr) {
            var focusTarget = attr['paymentInputFocus'];
            scope.$watch(focusTarget, function (value) {
//				console.log("---------------------------------------------------focus3: ",elem)
                $timeout(function () {
                    elem[0].focus();
                });
            });
        }
    }
});

posApp.directive('selectAllText', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, elem, attr) {
            var inputTarget = attr['selectAllText'];
            scope.$watch(inputTarget, function (value) {
                $timeout(function () {
                    elem[0].focus();
                    elem[0].select();
                });
            });
        }
    }
});

posApp.directive('validNumber', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            scope.$watch(attrs.ngModel, function (newValue, oldValue) {
                var spiltArray = String(newValue).split("");
                if (spiltArray.length === 0)
                    return;
                if (spiltArray.length === 1
                        && (spiltArray[0] == '-'
                                || spiltArray[0] === '.'))
                    return;
                //if(spiltArray.length === 2 && newValue === '-.') return; // 2 decimal point
                if ((newValue != undefined && newValue != "undefined") && isNaN(newValue)) {
                    console.log("not number");
                    ngModel.$setViewValue(oldValue);
                    ngModel.$render();
                }
            });
        }
    };
});

posApp.directive('fixedHeader', fixedHeader);
fixedHeader.$inject = ['$timeout'];
function fixedHeader($timeout) {
    return {
        restrict: 'A',
        link: link
    };

    function link($scope, $elem, $attrs, $ctrl) {
        var elem = $elem[0];
        // wait for data to load and then transform the table
        $scope.$watch(tableDataLoaded, function (isTableDataLoaded) {
            if (isTableDataLoaded) {
                transformTable();
            }
        });

        function tableDataLoaded() {
            // first cell in the tbody exists when data is loaded but doesn't have a width
            // until after the table is transformed
            var firstCell = elem.querySelector('tbody tr:first-child th:first-child');
            return firstCell && !firstCell.style.width;
        }

        function transformTable() {
            // reset display styles so column widths are correct when measured below
            angular.element(elem.querySelectorAll('thead, tbody, tfoot')).css('display', '');

            // wrap in $timeout to give table a chance to finish rendering
            $timeout(function () {
                var table = elem;
                // set widths of columns
                angular.forEach(elem.querySelectorAll('tr:first-child th'), function (thElem, i) {
                    var tdElems = elem.querySelector('tbody tr:first-child th:nth-child(' + (i + 1) + ')');
                    var columnWidth = tdElems ? tdElems.offsetWidth : thElem.offsetWidth;
                    if (tdElems) {
                        tdElems.style.width = columnWidth + 'px';
                    }
                    if (thElem) {
                        thElem.style.width = columnWidth + 'px';
                    }
                });

                // set css styles on thead and tbody
                angular.element(elem.querySelectorAll('thead, tfoot')).css('display', 'block');

                angular.element(elem.querySelectorAll('tbody')).css({
                    'display': 'block',
                    'height': $attrs.tableHeight || 'inherit',
                    'overflow': 'auto'
                });

                $('#table_order thead>tr:first').find('th').each(function (key, value) {
                    $('#table_order tbody>tr:last').find('td').eq(key).css("width", $(value).css("width"));
                });
                $("#searchKey").width($('#table_order thead>tr:first th:eq(1)').width() - 10);
                var widthLast = $('#table_order thead>tr:first th:last').width();
                $('#table_order tbody>tr:last td:last').css("width", (widthLast - 7));

            });
        }
    }
}
;
