<!DOCTYPE html>
<html ng-app="myApp">
<head>
<meta charset="UTF-8">
<title>Point of Sale Interface</title>
<link rel="stylesheet" href="<?php echo base_url() ?>asets/css/bootstrap.min.css">
<script src="<?php echo base_url() ?>asets/js/jquery-2.0.3.min.js"></script>
<script src="<?php echo base_url() ?>asets/js/angular.js"></script>
<script src="<?php echo base_url() ?>asets/js/angular-animate.js"></script>
<script src="<?php echo base_url() ?>asets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>asets/js/keynavigator.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/style_cashier.css">
<script type="text/javascript" src="<?php echo base_url() ?>js/cashier.js"></script>
<style>
.active-row {
	background-color: red;
}

.table>tr>td.active {
	background-color: red;
}
</style>
</head>
<body data-ng-controller="POSController" arrow-selector>
	<div class="container container-pos">
		<div class="row well">
			<div class="col-sm-12">
				<div class="panel panel-pos">
					<div class="panel-body" style="max-height: 320px; overflow: auto;">
						<table  class="table table-bordered table-pos" id="table_order" navigator style="background-color: #eee;">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th>Nama Barang</th>
									<th>Qty</th>
									<th>Satuan</th>
									<th>Harga Jual</th>
									<th>Disc(%)</th>
									<th>PPN(%)</th>
									<th>Rupiah</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr onkeydown="function(key){console.log('key',key);}" class="order-item" ng-repeat="item in order" ng-animate="'slide'" ng-focusRow ng-dblclick="editRow($event)">
									<th scope="row">{{$index + 1}}</th>
									<td class="editable">{{item.item.detail}}</td>
									<td class="editable" ng-dblclick="showInputQuantity = ! showInputQuantity">
										<div ng-show="! showInputQuantity" ng-click="showInputQuantity = ! showInputQuantity"
											style="width: 100%; text-align: right; font-weight: bold; padding-right: 2px; color: #000; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 16px;">{{item.orderedItemCnt}}</div>
										<div class="form-group" ng-show="showInputQuantity">
											<input class="pull-right form-control qty" type="text" ng-model="item.orderedItemCnt"
												style="width: 80px; text-align: right; font-weight: bold; padding-right: 2px; color: #000; background-color: #fff; border-color: #d9534f; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 16px;"
												ng-change="changeAmount(item)" ng-click="onTextClick($event)"
												ng-keypress="($event.which === 13) ? (showInputQuantity = ! showInputQuantity) :''" />
										</div>
									</td>
									<td>{{item.item.UOM}}</td>
									<td>{{currencyFormatIDR(item.item.price)}}</td>
									<td>{{item.item.discount}}</td>
									<td>{{item.item.ppn}}</td>
									<td>
										<div class="label label-success pull-right">{{currencyFormatIDR(item.totalPrice)}}</div>
									</td>
									<td>
										<div class="btn-group pull-right" role="group" aria-label="...">
											<button type="button" class="btn btn-xs " ng-disabled="" ng-click="subtractItem(item, $index)">
												<span type="button" class="glyphicon glyphicon-minus"></span>
											</button>
											<button type="button" class="btn  btn-xs" ng-click="addItem(item, $index)">
												<span class="glyphicon glyphicon-plus"></span>
											</button>
											<button type="button" class="btn btn-danger btn-xs" ng-click="deleteItem($index)">
												<span class="glyphicon glyphicon-trash"></span>
											</button>
										</div>
									</td>
								</tr>
								<tr>
									<td></td>
									<td class="editable">
										<input type="text" id="searchKey" width="100px" class="form-control" ng-model="barcode" placeholder="Enter barcode here"
											ng-keypress="($event.which === 13)?pick(barcode):''">
									</td>
									<td class="editable"></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<div class="text-warning" ng-hide="order.length">Noting ordered yet !</div>
					</div>
					<div class="panel-footer" ng-show="order.length">
						<div class="label label-danger ">Total: Rp {{currencyFormatIDR(getSum())}}</div>
					</div>
					<div class="panel-footer" ng-show="order.length">
						<div class="text-muted">Do not let go of customer without taking payment !</div>
					</div>
					<div class="pull-right">
						<span class="btn btn-default" ng-click="clearOrder()" ng-disabled="!order.length">Clear</span> <span class="btn btn-danger"
							ng-click="checkout()" ng-disabled="!order.length">Checkout</span>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade bs-pos-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-bordered table-fetch-pos">
										<thead>
											<tr>
												<td colspan="6">
													<div class="col-md-10">
														<div class="col-md-12">
															<div class="col-md-10">
																<div class="input-group">
																	<span class="input-group-addon"> <span class="glyphicon glyphicon glyphicon-barcode" aria-hidden="true"></span>
																	</span> <input type="text" class="form-control" ng-model="barcode" placeholder="Enter barcode here or Item Name"
																		ng-keypress="($event.which === 13)?pick(barcode):''">
																</div>
															</div>
															<button class="btn btn-primary" ng-click="pick(barcode)" style="margin-top: 0;">
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
											<tr ng-repeat="item in listData" ng-animate="'slide'">
												<th scope="row">{{$index + 1}}</th>
												<td>{{item.item.detail}}</td>
												<td>{{item.item.UOM}}</td>
												<td>{{currencyFormatIDR(item.item.price)}}</td>
												<td>{{item.item.discount}}</td>
												<td>{{item.item.ppn}}</td>
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
</body>
</html>
