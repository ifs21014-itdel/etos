<html>
    <head>

        <title>PT. Ebako Nusantara</title> 
        <script type="text/javascript" src="<?php echo base_url("easyui/jquery.min.js") ?>">"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("easyui/themes/metro/easyui.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("easyui/themes/icon.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("css/style.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("css/report.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("css/easyui.region.select.css") ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("css/custom.css") ?>">
        <script type="text/javascript" src="<?php echo base_url("easyui/jquery.easyui.min.js") ?>">"></script>
        <script type="text/javascript" src="<?php echo base_url("easyui/datagrid-filter.js") ?>">"></script>
        <script type="text/javascript" src="<?php echo base_url("easyui/datagrid-detailview.js") ?>">"></script>
        <script type="text/javascript" src="<?php echo base_url("easyui/easyui.region.select.min.js") ?>">"></script>   
        <script src="<?php echo base_url("Highcharts/js/highcharts.js") ?>"></script>
        <script src="<?php echo base_url("Highcharts/js/modules/exporting.js") ?>"></script>
        <script src="<?php echo base_url("Highcharts/js/modules/drilldown.js") ?>"></script>

        <link
            href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css"
            rel="stylesheet" media="screen" />
        <link
            href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-theme.min.css"
            rel="stylesheet" media="screen" />
        <link href="<?php echo base_url() ?>css/cashier.css" rel="stylesheet" media="screen" />
        <script>
            var rootUrl = "<?php echo base_url() ?>index.php";
        </script>
    </head>
<!----------------------------------------------------------->
<body ng-app="posApp" ng-controller="posCtrl" body-selector id="body">
    <div class="">
        <table id="main_table" class="table">
            <tr>
                <td width="50%">
                    <table class="table table-pos-header" header-selector
                           ng-class="{'table-active' : selectedTable == 0}">
                        <tr>
                            <td width="30%"><strong>Date</strong></td>
                            <td width="70%">
                                <input type="date" name="date" required="true">
                            </td>
                        </tr>
                        <tr>
                            <td> <strong>Container No</strong></td>
                            <td><input type="text" name="container_no" class="easyui-validatebox"/></td>
                        </tr>
                        <tr>
                            <td><strong>Seal No</strong></td>
                            <td><input type="text" name="seal_no"  class="easyui-validatebox"/></td>
                        </tr>
                        <tr>
                            <td><strong>Loadibility</strong></td>
                            <td><input type="text" name="loadibility" class="easyui-validatebox"/></td>
                        </tr>
                        <tr>
                            <td><strong>Description</strong></td>
                            <td><textarea name="description_of_goods"  class="easyui-validatebox"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <caption align="center"><span style="font-weight: bold;">Shipping Details</span></caption>
                                    <tr>
                                        <td width="30%"><strong>Client </strong></td>
                                        <td width="70%">                                    
                                            <input class="easyui-combobox" 
                                                   id="ship_to"
                                                   name="ship_to"
                                                   url="<?php echo site_url('client/get') ?>"
                                                   method="post"
                                                   mode="remote"
                                                   valueField="id"
                                                   textField="company"
                                                   data-options="formatter: PI_Client_Format"
                                                   style="width: 50%" 
                                                   required="true"/>
                                            <script type="text/javascript">
                                                function PI_Client_Format(row) {
                                                return '<span style="font-weight:bold;">' + row.name + ' - ' + row.code + '</span><br/>' +
                                                        '<span style="font-weight:bold;">Company : ' + row.company + '</span><br/>' +
                                                        '<span style="color:#888">Address: ' + row.address + '</span>';
                                                }
                                                $('#ship_to').combobox({
                                                onSelect: function (row) {
                                                $('#ship_phone_fax').val(row.phone + '/' + row.fax);
                                                $('#ship_address').val(row.address);
                                                $('#ship_email').val(row.email);
                                                $('#pi_ship_port_of_destination').val(row.country);
                                                }
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address</strong></td>
                                        <td><textarea name="ship_address" id="ship_address" class="easyui-validatebox"></textarea></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone / Fax</strong></td>
                                        <td>
                                            <input name="ship_phone_fax" id="ship_phone_fax" class="easyui-validatebox">
                                            <strong style="padding-right: 10px">Email</strong>
                                            <input name="ship_email" id="ship_email" class="easyui-validatebox"  data-options="validType:'email'">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Name</strong></td>
                                        <td><input name="ship_contact_name" class="easyui-textbox"></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Port of Destination</strong></td>
                                        <td>
                                            <input name="ship_port_of_destination" id='pi_ship_port_of_destination' class="easyui-validatebox">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div id="customerPopupContainer">
                        <div id="searchCustomerModal"
                             class="modal fade search-customer-pos-modal-lg" tabindex="-1"
                             role="dialog" aria-labelledby="myLargeModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered table-fetch-pos"
                                                           search-customer-selector
                                                           ng-class="{'table-active' : selectedTable == 5}">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="6">
                                                                    <div class="col-md-10">
                                                                        <div class="col-md-12">
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon"> <span
                                                                                            class="glyphicon glyphicon glyphicon-barcode"
                                                                                            aria-hidden="true"></span>
                                                                                    </span> <input id="searchCustomerKey" type="text"
                                                                                                   class="form-control" ng-model="searchCustomerKey"
                                                                                                   search-customer-key-focus="isSearchCustomerKeyFocus"
                                                                                                   placeholder="Enter Customer barcode or customer name here...">
                                                                                </div>
                                                                            </div>
                                                                            <button class="btn btn-primary"
                                                                                    ng-click="searchCustomer(searchCustomerKey)"
                                                                                    style="margin-top: 0;">
                                                                                Ok&nbsp;<span style="font-size: 10px;">[Enter]</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close"
                                                                                ng-click="closeSearchCustomerModal()">
                                                                            <span class="glyphicon glyphicon-remove-circle"
                                                                                  aria-hidden="true"></span>[Esc]
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 10px">#</th>
                                                                <th>Name</th>
                                                                <th>Barcode</th>
                                                                <th>Address</th>
                                                                <th>Discount</th>
<!-- 																<th>Reference</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="customer in listSearchedCustomer"
                                                                ng-animate="'slide'"
                                                                ng-class="{'selected':$index == selectedSearchCustomerRow}">
                                                                <th scope="row">{{$index + 1}}</th>
                                                                <td>{{customer.name}}</td>
                                                                <td>{{customer.barcode}}</td>
                                                                <td>{{customer.address}}</td>
                                                                <td>{{customer.discount}}</td>
<!-- 																<td>{{customer.reference}}</td> -->
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td style="width: 20%">
                    <table class="table table-bg-header">
                        <tr>
                            <td>
                                <div class="panel-footer"
                                     style="text-align: right; font-size: 72px;">
                                    <h1>
                                        <div class="label label-danger ">Real Time Loading System</div>
                                    </h1>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="">
                        <div class="">
                            <table id="table_order" class="table table-bordered table-fixed"
                                   order-selector ng-class="{'table-active' : selectedTable == 1}"
                                   fixed-header style="height: 350px;">
                                <thead>
                                    <tr class="info">
                                        <th class="col-xs-1">No</th>
                                        <th class="col-xs-3">Serial Number</th>
                                        <th class="col-xs-1">Ebako Code</th>
                                        <th class="col-xs-2">Customer Code</th>
                                        <th class="col-xs-1">Material</th>
                                        <th class="col-xs-1">Finishing</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in order.items"
                                        ng-click="setClickedRow($index)"
                                        ng-keypress="($event.which === 13) ? pick(item) : ''">
                                        <td>{{$index + 1}}</td>
                                        <td>{{item.name}}</td>
                                        <td>{{item.uom}}</td>
                                        <td style="text-align: right;">{{currencyFormatDefault(item.price)}}</td>
                                        <td ng-class="{'selected':$index == selectedRow}"><span
                                                ng-show="!isShowQuantityInput($index)">{{item.quantity}}</span>
                                            <input style="width: 70px" type="text"
                                                   ng-model="item.quantity" value="{{item.quantity}}"
                                                   ng-show="isShowQuantityInput($index)"
                                                   select-all-text="isShowQuantityInput($index)"></input></td>
                                        <td style="text-align: right;">{{currencyFormatDefault(item.totalPrice)}}</td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input id="searchKey" width="50" type="text"
                                                   ng-model="searchKey" search-key-focus="isSearchKeyFocus"
                                                   ng-keypress="($event.which === 13) ? pickItem(searchKey) : ''">
                                        </td>
                                        <td></td>
                                        <td>
                                            <div class="modal fade delete-item-confirm-modal-lg"
                                                 tabindex="-1" role="dialog"
                                                 aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <h4 class="modal-title" id="gridSystemModalLabel">Delete
                                                                Confirmation</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <div class="col-md-12">Are you sure want to delete?</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" id="button_delete_item_order"
                                                                    class="btn btn-danger"
                                                                    ng-click="deleteSelectedItemConfirmed()">Delete[F8]</button>
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Cancel[Esc]</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <tfoot>
                <tr style="border: 0px; text-align: right;">
                    <td width="60%">
                        <div class="col-md-8"
                             style="text-align: left; vertical-align: middle;">
                            <button type="button" ng-click="showHelpModal()"
                                    class="btn btn-info tooltip-viewport-right btn-bottom"><?php //echo label("help"); ?> [F10]</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;Cashier: <span style="font-size: 1.2em"><?php echo Authority::getUserName(); ?></span>
<?php if (Authority::isUserAuthenticated()) { ?>
                                &nbsp;&nbsp;<span><a
                                        href="<?php echo site_url($this->config->item('PATH_URI_LOGOUT')) ?>"><b>[LogOut]</b>
                                    </a></span>&nbsp;&nbsp; 

                                <span><a href="javascript:window.location.href='/closekiosk';"><b>[Tutup Browser]</b> </a></span>
                                <span><a href="<?php echo site_url() ?>" target="_blank"><b>[Open Back-End]</b> </a></span>
<?php } ?>
                        </div>
                    </td>
                    <td colspan="1" align="right" bordercolor="0px">
                        <div class="col-md-4" style="text-align: right;">
                            Total Price<span ng-show="order.customer.customertype == 'FAMILY-belum-dipake'">(+Beban)</span>
                            <span ng-show="order.customer.customertype != 'FAMILY'">(+Discount)</span>:</div>
                        <div class="col-md-6"
                             style="text-align: left; vertical-align: middle;">
                            <div class="">Rp {{currencyFormatDefault(calculatePriceTotal())}}</div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" ng-click="showPopUpPayment()"
                                    class="btn btn-primary tooltip-viewport-right btn-bottom"
                                    title="This should be shifted up">Pay [F7]</button>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- 	modal discount -->
    <div class="modal fade login-discount-modal-md" tabindex="-1"
         role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="container-fluid">
                <div class="row">
                    <button type="button" ng-click="closePopUpLoginDiscount()"
                            class="btn btn-warning tooltip-viewport-right btn-bottom"
                            ng-disabled="false">Close[Esc]</button>
                </div>
                <div class="row" style="padding: 10px; background-color: #ffffff;">
                    <div id="login_discount_content"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Discout -->
    <div id="editDiscountModal"
         class="modal fade edit-discount-item-modal-lg" tabindex="-1"
         role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Edit Discount</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-fetch-pos"
                                       discount-selector
                                       ng-class="{'table-active' : selectedTable == 2}">
                                    <tbody>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <td>{{selectedItem().name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Discount Type</th>
                                            <td><select
                                                    ng-init="is_discount_percentage = discountOptions[0].value"
                                                    ng-model="is_discount_percentage"
                                                    ng-change="updateIsDiscountPercentage(is_discount_percentage)"
                                                    ng-options="option.value as option.name for option in discountOptions"></select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Disc</th>
                                            <td><input id="newDiscount" type="text"
                                                       ng-model="newDiscount" name="newDiscount"
                                                       discount-key-focus="isDiscountKeyFocus"
                                                       ng-keypress="($event.which === 13) ? updateDiscountSelectedItem(newDiscount) : ''">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="button_update_discount_item"
                            class="btn btn-danger"
                            ng-click="updateDiscountSelectedItem(newDiscount)">Update[Enter]</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel[Esc]</button>
                </div>
            </div>
        </div>
    </div>
    <!-- search Modal -->
    <div id="searchItemModal" class="modal fade search-item-pos-modal-lg"
         tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-fetch-pos"
                                       search-item-selector
                                       ng-class="{'table-active' : selectedTable == 4}">
                                    <thead>
                                        <tr>
                                            <td colspan="6">
                                                <div class="col-md-10">
                                                    <div class="col-md-12">
                                                        <div class="col-md-10">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"> <span
                                                                        class="glyphicon glyphicon glyphicon-barcode"
                                                                        aria-hidden="true"></span>
                                                                </span> <input id="searchItemKey" type="text"
                                                                               class="form-control" ng-model="searchItemKey"
                                                                               placeholder="Enter barcode here or Item Name">
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary"
                                                                ng-click="searchItem(searchItemKey)"
                                                                style="margin-top: 0;">
                                                            Ok&nbsp;<span style="font-size: 10px;">[Enter]</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close" ng-click="closeModal()">
                                                        <span class="glyphicon glyphicon-remove-circle"
                                                              aria-hidden="true"></span>[Esc]
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th>Harga Jual</th>
                                            <th>Disc(%)</th>
                                            <th>PPN(%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in listSearchedData" ng-animate="'slide'"
                                            ng-class="{'selected':$index == selectedSearchItemRow}">
                                            <th scope="row">{{$index + 1}}</th>
                                            <td>{{item.name}}</td>
                                            <td>{{item.UOM}}</td>
                                            <td>{{currencyFormatDefault(item.price)}}</td>
                                            <td>{{item.discount}}</td>
                                            <td>{{item.ppn}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                            <!-- 										<tr> -->
                                            <!-- 											<td colspan="5">isSearchItemKeyFocus: {{isSearchItemKeyFocus}}</td> -->
                                        <!-- 										</tr> -->
                                        <!-- 										<tr> -->
                                        <!-- 											<td>selectedSearchItemRow: {{selectedSearchItemRow}}</td> -->
                                        <!-- 										</tr> -->
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 	modal payment -->
    <div id="paymentModal" class="modal fade payment-pos-modal-md"
         tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10">
                                    <h3>Payment</h3>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close" ng-click="closeModal()">
                                        <span class="glyphicon glyphicon-remove-circle"
                                              aria-hidden="true"></span>[Esc]
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tablePayment"
                                       class="table table-bordered table-fetch-pos" payment-selector
                                       ng-class="{'table-active' : selectedTable == 3}">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group form-group-sm">
                                                    <label class="col-sm-4 control-label text-align-right"
                                                           for="formGroupInputSmall">Total Price:</label>
                                                    <div class="col-sm-8">
                                                        <h4>Rp {{currencyFormatDefault(calculatePriceTotal())}}</h4>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr ng-show="isShowPaymentCash">
                                            <td>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-sm">
                                                        <label
                                                            class="col-sm-4 control-label text-align-right label-payment"
                                                            for="formGroupInputSmall">Total Cash:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="totalCash"
                                                                   ng-model="totalCash" valid-number
                                                                   payment-input-focus="isPaymentInputFocus" placeholder=""
                                                                   ng-change="calculatePayment()">
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <label class="col-sm-4 control-label text-align-right"
                                                               for="formGroupInputSmall">Need to pay by cash:</label>
                                                        <div class="col-sm-8">
                                                            {{currencyFormatDefault(totalPandingPayment)}}
                                                            <!-- 															<input class="form-control" ng-model="amountPayByCash" type="text" id="amountPayByCash" placeholder="" valid-number -->
                                                            <!-- 																ng-change="calculatePayment()"> -->
                                                        </div>
                                                        <div class="col-8-md"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr ng-show="isShowPaymentDebitCard">
                                            <td>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-sm">
                                                        <label
                                                            class="col-sm-4 control-label text-align-right label-payment"
                                                            for="formGroupInputSmall">Debit Card No.:</label>
                                                        <div class="col-sm-8">
                                                            <input id="debitCardNumber" class="form-control"
                                                                   type="text" ng-model="debitCardNumber">
                                                        </div>
                                                    </div>
                                                    <!-- 													<div class="form-group form-group-sm"> -->
                                                    <!-- 														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Customer Name:</label> -->
                                                    <!-- 														<div class="col-sm-8"> -->
                                                    <!-- 															<input id="debitCardHolderName" class="form-control" type="text" ng-model="debitCardHolderName"> -->
                                                    <!-- 														</div> -->
                                                    <!-- 													</div> -->
                                                    <div class="form-group form-group-sm">
                                                        <label class="col-sm-4 control-label text-align-right"
                                                               for="formGroupInputSmall">Amount:</label>
                                                        <div class="col-sm-8">
                                                            <input id="amountPayByDebitCard" class="form-control"
                                                                   ng-model="amountPayByDebitCard" type="text" valid-number
                                                                   ng-change="calculatePayment()">
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <label class="col-sm-4 control-label text-align-right"
                                                               for="formGroupInputSmall">Bank:</label>
                                                        <div class="col-sm-8">
                                                            <select id="debitCardType" class="form-control"
                                                                    ng-model="debitCardType">
                                                                <option ng-repeat="debitCardType in listDebitCardType"
                                                                        value="{{debitCardType.id}}">{{debitCardType.name}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr ng-show="isShowPaymentCreditCard">
                                            <td>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-sm">
                                                        <label
                                                            class="col-sm-4 control-label text-align-right label-payment"
                                                            for="formGroupInputSmall">Credit Card No.:</label>
                                                        <div class="col-sm-8">
                                                            <input id="creditCardNumber" class="form-control"
                                                                   type="text" ng-model="creditCardNumber">
                                                        </div>
                                                    </div>
                                                    <!-- 													<div class="form-group form-group-sm"> -->
                                                    <!-- 														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Customer Name:</label> -->
                                                    <!-- 														<div class="col-sm-8"> -->
                                                    <!-- 															<input id="creditCardHolderName" class="form-control" type="text" ng-model="creditCardHolderName"> -->
                                                    <!-- 														</div> -->
                                                    <!-- 													</div> -->
                                                    <div class="form-group form-group-sm">
                                                        <label class="col-sm-4 control-label text-align-right"
                                                               for="formGroupInputSmall">Amount:</label>
                                                        <div class="col-sm-8">
                                                            <input id="amountPayByCreditCard" class="form-control"
                                                                   ng-model="amountPayByCreditCard" type="text"
                                                                   valid-number ng-change="calculatePayment()">
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <label class="col-sm-4 control-label text-align-right"
                                                               for="formGroupInputSmall">Bank:</label>
                                                        <div class="col-sm-8">
                                                            <select id="creditCardType" class="form-control"
                                                                    ng-model="creditCardType">
                                                                <option ng-repeat="creditCardType in listCreditCardType"
                                                                        value="{{creditCardType.id}}">{{creditCardType.name}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr ng-show="isShowPaymentVoucher">
                                            <td>
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-sm">
                                                        <label
                                                            class="col-sm-4 control-label text-align-right label-payment"
                                                            for="formGroupInputSmall">Voucher Number:</label>
                                                        <div class="col-sm-8">
                                                            <input id="voucherNumber" class="form-control"
                                                                   type="text" ng-model="voucherNumber"
                                                                   payment-input-focus="isPaymentInputFocus">
                                                        </div>
                                                    </div>
                                                    <div class="form-group form-group-sm">
                                                        <label class="col-sm-4 control-label text-align-right"
                                                               for="formGroupInputSmall">Amount:</label>
                                                        <div class="col-sm-8">
                                                            <input id="amountPayByVoucher" class="form-control"
                                                                   ng-model="amountPayByVoucher" type="text" valid-number
                                                                   ng-change="calculatePayment()">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>
                                                    <button type="button" ng-click="togglePaymentCash()"
                                                            class="btn btn-{{!isShowPaymentCash?'default':'warning'}} btn-xs">{{!isShowPaymentCash?'Show':'Hide'}}
                                                        Payment Cash [f9]</button>
                                                    <button type="button" ng-click="togglePaymentDebitCard()"
                                                            class="btn btn-{{!isShowPaymentDebitCard?'default':'warning'}} btn-xs">{{!isShowPaymentDebitCard?'Show':'Hide'}}
                                                        Payment Debit Card [f9]</button>
                                                    <button type="button" ng-click="togglePaymentCreditCard()"
                                                            class="btn btn-{{!isShowPaymentCreditCard?'default':'warning'}} btn-xs">{{!isShowPaymentCreditCard?'Show':'Hide'}}
                                                        Payment Credit Card [f9]</button>
                                                    <button type="button" ng-click="togglePaymentVoucher()"
                                                            class="btn btn-{{!isShowPaymentVoucher?'default':'warning'}} btn-xs">{{!isShowPaymentVoucher?'Show':'Hide'}}
                                                        Payment Voucher [f9]</button>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <div class="col-md-9">
                                                Total All Payment Method: <span style="font-size: 1.5em">{{currencyFormatDefault(totalPaymentAllMethod)}}</span><br />
                                                Change Cash: <span style="font-size: 1.5em">{{currencyFormatDefault(changeCash)}}</span><br />
                                                <span ng-show="voucherNote">Info Voucher: {{voucherNote}}</span>
                                                <h2>{{infoPayment}}</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="button" ng-click="checkOut()"
                                                        class="btn btn-primary tooltip-viewport-right btn-bottom"
                                                        ng-disabled="isCheckOutButtonDisabled == true">Print[F2]</button>
                                                <button type="button" ng-click="resetPayment()"
                                                        class="btn btn-warning tooltip-viewport-right btn-bottom"
                                                        ng-disabled="false">Reset[F9]</button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-height-modal {
            height: 400px;
        }
    </style>

    <div class="modal fade print-pos-modal-md" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <!-- 			<div class="modal-content"> -->
            <!-- 				<div class="modal-body"> -->
            <div class="container-fluid">
                <div class="row">
                    <button type="button" ng-click="resetOrder()"
                            class="btn btn-warning tooltip-viewport-right btn-bottom"
                            ng-disabled="false">Close[Esc]</button>
                </div>
                <div class="row">
                    <div id="print_content" style="height: 400px; width: 400px;"></div>
                </div>
            </div>
            <!-- 				</div> -->
            <!-- 			</div> -->
        </div>
    </div>

    <!-- 	modal help -->
    <div id="helpModal" class="modal fade help-modal-lg" tabindex="-1"
         role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>[Esc]
                    </button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Help</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <h4>
                                        <span class="label label-default">F11</span> Full Screen/Exit
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <span class="label label-default">Home</span> Go to input
                                        barcode
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <span class="label label-default">PgUp</span> Go to Customer
                                        Detail
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <span class="label label-default">PgDn</span> Back to Input
                                        Barcode
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <span class="label label-default">F2</span> Change
                                        Quantity/Save
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <span class="label label-default">F4</span> Change Discount
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <span class="label label-default">Del</span> Delete Item
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <span class="label label-default">F7</span> Show Payment
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <button type="button" class="btn btn-default"
                                                aria-label="Center Align">
                                            <span class="glyphicon glyphicon glyphicon-arrow-up"
                                                  aria-hidden="true"></span>
                                        </button>
                                        Navigation Up
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <button type="button" class="btn btn-default"
                                                aria-label="Center Align">
                                            <span class="glyphicon glyphicon glyphicon-arrow-down"
                                                  aria-hidden="true"></span>
                                        </button>
                                        Navigation Down
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <button type="button" class="btn btn-default"
                                                aria-label="Center Align">
                                            <span class="glyphicon glyphicon glyphicon-arrow-left"
                                                  aria-hidden="true"></span>
                                        </button>
                                        Navigation Left
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        <button type="button" class="btn btn-default"
                                                aria-label="Center Align">
                                            <span class="glyphicon glyphicon glyphicon-arrow-right"
                                                  aria-hidden="true"></span>
                                        </button>
                                        Navigation Right
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url() ?>assets/angular/angular.min.js"></script>
    <script src="<?php echo base_url() ?>js/cashierApp.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery-2.0.3.min.js"></script>
    <script
    src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
                                jQuery(function () {
                                //prevent refresh page
// 			$(window).bind('beforeunload', function() {
// 				return 'If you do refresh, your current data will be lost...';
// 			});
                                });
                                $('#searchItemModal').on('shown.bs.modal', function () {
                                $('#searchItemKey').focus();
                                });
                                $('#editDiscountModal').on('shown.bs.modal', function () {
                                $('#newDiscount').focus();
                                });
                                $('#paymentModal').on('shown.bs.modal', function () {
                                $('#totalCash').focus();
                                });
                                /**
                                 * ex: fetchRemoteContentPopUp({elementTarget:"",link:"",onSuccess:function(){}});
                                 */
                                function fetchRemoteContentPopUp(objPopUp) {
                                $(objPopUp.elementTarget).html("<p>Loading, please wait...<p/>");
                                $.ajax({url: objPopUp.link,
                                        success: function (response) {
                                        $(objPopUp.elementTarget).html(response);
                                        objPopUp.onSuccess();
                                        }
                                });
                                }


                                /**
                                 * ex: firePopOver({idTarget:"",url:"",html:true});
                                 */
                                function firePopOver(objPopOver) {
                                var div_id = "#tmp-id-" + $.now();
                                var fetch_remote_content_popup = function (url) {
                                $.ajax({url: url,
                                        success: function (response) {
                                        $(div_id).html(response);
                                        }
                                });
                                return '<div id="' + div_id + '">Loading...</div>';
                                }
                                $(objPopOver.idTarget).popover({
                                "html": objPopOver.html,
                                        "content": function () {
                                        return fetch_remote_content_popup(objPopOver.url);
                                        }
                                });
                                }

    </script>
</body>
</html>