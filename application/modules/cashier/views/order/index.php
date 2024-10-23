<html>
<head>
<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen" />
<style>
body {
	background-color: #f5f5f5;
}

table {
	background-color: #f5f5f5;
}

.selected {
	background-color: #ec971f;
	/* 	color: red; */
	font-weight: bold;
}

.selected-name {
	background-color: #f5f5f5;
}

.form-control {
	height: 25px;
	padding: 0px;
	border-radius: 1px;
}

.table-pos-header {
	background-color: #f5f5f5 !important;
}

.table-bg-header {
	background-color: #f5f5f5 !important;
}

.table-pos-header>thead>tr>th, .table-pos-header>tbody>tr>th,
	.table-pos-header>tfoot>tr>th, .table-pos-header>thead>tr>td,
	.table-pos-header>tbody>tr>td, .table-pos-header>tfoot>tr>td {
	padding: 2px;
	border-top: none !important;
}

.table-pos-header>tbody>tr>td>label {
	padding-right: 5px;
	margin-bottom: 0px;
	font-weight: 500;
}

.table-active {
	border: 1px solid #eee;
	border-left-width: 2px;
	border-radius: 3px;
	border-left-color: #ce4844;
}

.text-align-right {
	text-align: right;
}

.row-payment {
	vertical-align: middle;
}

.row-payment .label-payment {
	font-size: 12px !important;
}
</style>
</head>
<body ng-app="posApp" ng-controller="posCtrl" body-selector>
	<div class="">
		<table id="main_table" class="table">
			<tr>
				<td width="50%">
					<table class="table table-pos-header" header-selector ng-class="{'table-active' : selectedTable == 0}">
						<tr>
							<td class="text-right">
								<label>Ref | No</label>
							</td>
							<td>
								<input first-input-of-header-focus="isFirstElementOfHeaderFocus" id="reference" class="form-control" type="text"
									ng-model="order.customerDetail.reference">
							</td>
							<td>
								<input id="number" class="form-control" type="text" ng-model="order.customerDetail.number">
							</td>
						</tr>
						<tr>
							<td class="text-right">
								<label>Kode | Nama Pelanggan</label>
							</td>
							<td>
								<input id="code" class="form-control" type="text" ng-model="order.customerDetail.code" name="code">
							</td>
							<td>
								<input id="name" class="form-control" type="text" ng-model="order.customerDetail.name" name="name">
							</td>
						</tr>
						<tr>
							<td class="text-right">
								<label>Alamat</label>
							</td>
							<td colspan="2">
								<input id="address" class="form-control" type="text" ng-model="order.customerDetail.address">
							</td>
						</tr>
					</table>
				</td>
				<td style="width: 50%">
					<table class="table table-bg-header">
						<tr>
							<td>
								<div class="panel-footer" style="text-align: right;">
									<h1>
										<div class="label label-danger ">Total Bayar: Rp {{currencyFormatIDR(calculatePriceTotal())}}</div>
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
							<table id="table_order" class="table table-bordered table-fixed" order-selector
								ng-class="{'table-active' : selectedTable == 1}" fixed-header style="height: 350px;">
								<thead>
									<tr class="info">
										<th class="col-xs-1">#</th>
										<th class="col-xs-2">Nama Barang</th>
										<th class="col-xs-2">Satuan</th>
										<th class="col-xs-2">Harga Jual</th>
										<th class="col-xs-1">Qty</th>
										<th class="col-xs-1">AmountTotal</th>
										<th class="col-xs-1">Disc(%)</th>
										<th class="col-xs-1">PPN(%)</th>
										<th class="col-xs-2">Amount(+Discount)</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="item in order.items" ng-click="setClickedRow($index)"
										ng-keypress="($event.which === 13) ? pick(item) : '' ">
										<td>{{$index+1}}</td>
										<td>{{item.name}}</td>
										<td>{{item.uom}}</td>
										<td>{{item.price}}</td>
										<td ng-class="{'selected':$index == selectedRow}">
											<span ng-show="!isShowQuantityInput($index)">{{item.quantity}}</span> <input style="width: 70px" type="text"
												ng-model="item.quantity" value="{{item.quantity}}" ng-show="isShowQuantityInput($index)"
												select-all-text="isShowQuantityInput($index)"></input>
										</td>
										<td>{{currencyFormatIDR(item.quantity * item.price)}}</td>
										<td>{{item.discount}}</td>
										<td>{{item.ppn}}</td>
										<td>{{currencyFormatIDR(item.totalPrice)}}</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<input id="searchKey" type="text" ng-model="searchKey" search-key-focus="isSearchKeyFocus"
												ng-keypress="($event.which === 13) ? pickItem(searchKey) : '' ">
										</td>
										<td></td>
										<td>
											<div class="modal fade delete-item-confirm-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
												aria-hidden="true">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
															<h4 class="modal-title" id="gridSystemModalLabel">Delete Confirmation</h4>
														</div>
														<div class="modal-body">
															<div class="container-fluid">
																<div class="row">
																	<div class="col-md-12">Are you sure want to delete?</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" id="button_delete_item_order" class="btn btn-danger" ng-click="deleteSelectedItemConfirmed()">Delete[F8]</button>
															<button type="button" class="btn btn-default" data-dismiss="modal">Cancel[Esc]</button>
														</div>
													</div>
												</div>
											</div>
										</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
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
					<td width="50%"></td>
					<td colspan="1" align="right" bordercolor="0px">
						<div class="col-md-4" style="text-align: right;">Total Price (+Discount):</div>
						<div class="col-md-6" style="text-align: left; vertical-align: middle;">
							<div class="">Rp {{currencyFormatIDR(calculatePriceTotal())}}</div>
						</div>
						<div class="col-md-2">
							<button type="button" ng-click="showPopUpPayment()" class="btn btn-primary tooltip-viewport-right btn-bottom"
								title="This should be shifted up">Pay [F7]</button>
						</div>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<!-- 	modal discount -->
	<!-- Modal Discout -->
	<div id="editDiscountModal" class="modal fade edit-discount-item-modal-lg" tabindex="-1" role="dialog"
		aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="gridSystemModalLabel">Edit Discount</h4>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-fetch-pos" discount-selector ng-class="{'table-active' : selectedTable == 2}">
									<tbody>
										<tr>
											<th>Nama Barang</th>
											<th>{{selectedItem().name}}</th>
										</tr>
										<tr>
											<th>Disc(%)</th>
											<td>
												<input id="newDiscount" type="text" ng-model="newDiscount" name="newDiscount" discount-key-focus="isDiscountKeyFocus"
													ng-keypress="($event.which === 13) ? updateDiscountSelectedItem(newDiscount) : '' ">
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="button_update_discount_item" class="btn btn-danger"
						ng-click="updateDiscountSelectedItem(newDiscount)">Update[Enter]</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel[Esc]</button>
				</div>
			</div>
		</div>
	</div>
	<!-- search Modal -->
	<div id="searchItemModal" class="modal fade search-item-pos-modal-lg" tabindex="-1" role="dialog"
		aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-bordered table-fetch-pos" search-item-selector ng-class="{'table-active' : selectedTable == 4}">
									<thead>
										<tr>
											<td colspan="6">
												<div class="col-md-10">
													<div class="col-md-12">
														<div class="col-md-10">
															<div class="input-group">
																<span class="input-group-addon"> <span class="glyphicon glyphicon glyphicon-barcode" aria-hidden="true"></span>
																</span> <input id="searchItemKey" type="text" class="form-control" ng-model="searchItemKey"
																	placeholder="Enter barcode here or Item Name">
															</div>
														</div>
														<button class="btn btn-primary" ng-click="searchItem(searchItemKey)" style="margin-top: 0;">
															Ok&nbsp;<span style="font-size: 10px;">[Enter]</span>
														</button>
													</div>
												</div>
												<div class="col-md-2">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="closeModal()">
														<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>[Esc]
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
										<tr ng-repeat="item in listSearchedData" ng-animate="'slide'" ng-class="{'selected':$index == selectedSearchItemRow}">
											<th scope="row">{{$index + 1}}</th>
											<td>{{item.name}}</td>
											<td>{{item.UOM}}</td>
											<td>{{currencyFormatIDR(item.price)}}</td>
											<td>{{item.discount}}</td>
											<td>{{item.ppn}}</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="5">isSearchItemKeyFocus: {{isSearchItemKeyFocus}}</td>
										</tr>
										<tr>
											<td>selectedSearchItemRow: {{selectedSearchItemRow}}</td>
										</tr>
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
	<div id="paymentModal" class="modal fade payment-pos-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
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
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="closeModal()">
										<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>[Esc]
									</button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<table id="tablePayment" class="table table-bordered table-fetch-pos" payment-selector ng-class="{'table-active' : selectedTable == 3}">
									<tbody>
										<tr>
											<td>
												<div class="form-group form-group-sm">
													<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Total Price:</label>
													<div class="col-sm-8">
														<h4>Rp {{currencyFormatIDR(calculatePriceTotal())}}</h4>
													</div>
												</div>
											</td>
										</tr>
										<tr ng-show="isShowPaymentCash">
											<td>
												<div class="col-sm-12">
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right label-payment" for="formGroupInputSmall">Total Cash:</label>
														<div class="col-sm-8">
															<input type="text" class="form-control" id="totalCash" ng-model="totalCash" valid-number
																payment-input-focus="isPaymentInputFocus" placeholder="" ng-change="calculatePayment()">
														</div>
													</div>
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Amount Pay By Cash:</label>
														<div class="col-sm-8">
															<input class="form-control" ng-model="amountPayByCash" type="text" id="amountPayByCash" placeholder="" valid-number
																ng-change="calculatePayment()">
														</div>
													</div>
												</div>
											</td>
										</tr>
										<tr ng-show="isShowPaymentDebitCard">
											<td>
												<div class="col-sm-12">
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right label-payment" for="formGroupInputSmall">Debit Card No.:</label>
														<div class="col-sm-8">
															<input id="debitCardNumber" class="form-control" type="text" ng-model="debitCardNumber">
														</div>
													</div>
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Customer Name:</label>
														<div class="col-sm-8">
															<input id="debitCardCustomerName" class="form-control" type="text" ng-model="debitCardCustomerName">
														</div>
													</div>
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Amount:</label>
														<div class="col-sm-8">
															<input id="amountPayByDebitCard" class="form-control" ng-model="amountPayByDebitCard" type="text"valid-number
															ng-change="calculatePayment()">
														</div>
													</div>
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Type:</label>
														<div class="col-sm-8">
															<select id="debitCardType" class="form-control" ng-model="debitCardType">
																<option>BCA</option>
																<option>BNI</option>
																<option>BRI</option>
																<option>MANDIRI</option>
																<option>OTHER</option>
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
														<label class="col-sm-4 control-label text-align-right label-payment" for="formGroupInputSmall">Credit Card No.:</label>
														<div class="col-sm-8">
															<input id="creditCardNumber" class="form-control" type="text" ng-model="creditCardNumber">
														</div>
													</div>
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Customer Name:</label>
														<div class="col-sm-8">
															<input id="creditCardCustomerName" class="form-control" type="text" ng-model="creditCardCustomerName">
														</div>
													</div>
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Amount:</label>
														<div class="col-sm-8">
															<input id="amountPayByCreditCard" class="form-control" ng-model="amountPayByCreditCard" type="text" valid-number
															ng-change="calculatePayment()">
														</div>
													</div>
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Type:</label>
														<div class="col-sm-8">
															<select id="creditCardType" class="form-control" ng-model="creditCardType">
																<option>BCA</option>
																<option>BNI</option>
																<option>BRI</option>
																<option>MANDIRI</option>
																<option>OTHER</option>
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
														<label class="col-sm-4 control-label text-align-right label-payment" for="formGroupInputSmall">Voucher
															Number:</label>
														<div class="col-sm-8">
															<input id="voucherNumber" class="form-control" type="text" ng-model="voucherNumber"
																payment-input-focus="isPaymentInputFocus">
														</div>
													</div>
													<div class="form-group form-group-sm">
														<label class="col-sm-4 control-label text-align-right" for="formGroupInputSmall">Amount Pay By Voucher:</label>
														<div class="col-sm-8">
															<input id="amountPayByVoucher" class="form-control" ng-model="amountPayByVoucher" type="text" valid-number
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
											    Total All Payment Methode: {{totalPaymentAllMethod}}<br/>
											    Change Cash: {{changeCash}}<br/>
											    
												<h2>{{infoPayment}}</h2>
											</div>
											<div class="col-md-3">
												<button type="button" ng-click="checkOut()" class="btn btn-primary tooltip-viewport-right btn-bottom"
													ng-disabled="false">Print[F2]</button>
												<button type="button" ng-click="resetPayment()" class="btn btn-warning tooltip-viewport-right btn-bottom"
													ng-disabled="false">Reset[F3]</button>	
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
	<div class="modal fade print-pos-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12" id="print_content" style="height: 400px"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="js/angular.min.js"></script>
	<script src="js/foodCtrl.js"></script>
	
	<script src="<?php echo base_url() ?>asets/angular/angular.min.js"></script>
	<script src="<?php echo base_url() ?>js/cashierApp.js"></script>
	<script src="<?php echo base_url() ?>asets/js/jquery-2.0.3.min.js"></script>
	<script src="<?php echo base_url() ?>asets/bootstrap/js/bootstrap.min.js"></script>
	<script>
		jQuery(function() {
			//prevent refresh page
			// 			$(window).bind('beforeunload', function() {
			// 				return 'If you do refresh, your current data will be lost...';
			// 			});

			// 			setTimeout(function() {
			// 				var body_heigh = $("body").height();
			// 				var header_heigh = $("#main_table tbody tr:first").height();
			// 				var footer_heigh = $("#main_table tfoot").height();
			// 				var table_order_height = body_heigh - header_heigh - footer_heigh;
			// 				$("#table_order").height(table_order_height);
			// 			}, 1000);
		});
		$('#searchItemModal').on('shown.bs.modal', function() {
			$('#searchItemKey').focus();
		});
		$('#editDiscountModal').on('shown.bs.modal', function() {
			$('#newDiscount').focus();
		});
		$('#paymentModal').on('shown.bs.modal', function() {
			$('#totalCash').focus();
		});
	</script>
</body>
</html>