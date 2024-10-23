<html>
<head>
<link href="http://localhost:45/dts/angular/selector/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="http://localhost:45/dts/angular/selector/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="http://localhost:45/dts/PointOfSales/easyui/jquery.min.js"></script>
<style>
body {
	margin: 0;
	padding: 0;
	font-family: Arial;
	font-size: 12px;
}

div.invoice-container {
	margin: 0px auto;
	width: 230px;
	text-align: left;
	padding: 0 4px 0px 4px;
}

table.table-invoice thead tr {
	background-color: #FCECA3 !important;
	background-image: none !important;
}

p.address {
	padding: 0 0 5px 0;
	margin-top: 3px;
	text-align: center;
	line-height: 18px;
	font-size: 10px !important;
}

h3.invoice-title {
	font-family: Garamond;
	font-size: 25px;
	font-weight: normal;
	margin: 0;
	padding: 0;
	text-align: center;
}

h4.nota-bon {
	margin: 0 0 2px 0 !important;
	font-size: 15px !important;
	padding: 0;
	text-align: center;
}

table.order-item {
	margin-bottom: 5px;
}

table.order-item thead tr th {
	color: Black;
	text-shadow: none;
	border: solid 1px #9E9E9E;
	height: 22px;
	line-height: 16px;
	border-bottom: 1px solid #333;
	padding: 2px 7px;
	font-weight: bold;
}

table.order-item thead tr {
	background-color: #FCECA3 !important;
	background-image: none !important;
}

table.order-item tbody tr td {
	height: 24px;
	line-height: 16px;
	padding: 2px 7px;
	font-size: 12px;
	text-align: left;
	vertical-align: middle;
	border: 0px;
	border-bottom: 1px solid #d8d8d8;
}

table.order-item tfoot tr td {
	height: 20px;
	line-height: 16px;
	padding: 2px 7px;
	font-size: 12px;
	text-align: right;
	vertical-align: middle;
	border: 0px;
}

.text-right {
	text-align: right !important;
}

.text-center {
	text-align: center !important;
}

.text-left {
	text-align: left !important;
}

footer {
	font-size: 12px;
	text-align: center;
	display: block;
	margin: 15px 0 0 0;
	font-weight: bold;
	padding: 0px;
	margin: 0px;
}

small {
	text-align: center;
}
</style>
</head>
<body ng-app="posApp" ng-controller="struckCtrl">
	<div class="invoice-container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="invoice-title">KDS Store</h3>
				<p id="address" class="address">
					Tj.Priuk Street #45<br>P : (62-21) 235 4990
				</p>
				<h4 class="nota-bon" id="nota_bon">Nota Bon. #15.06.00011</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered order-item">
					<thead>
						<tr class="header">
							<th>Name</th>
							<th class="number" style="width: 20px">Qty</th>
							<th id="" class="number" style="width: 18px">%</th>
							<th id="" class="number" style="width: 50px">Total</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="item in order" ng-class="{'active' : $index % 2 == 0}">
							<td>{{item.name}}</td>
							<td class="text-right">{{item.quantity}}</td>
							<td class="text-center">{{item.discount}}</td>
							<td>{{currencyFormatIDR(item.totalPrice)}}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4">
								<table style="width: 100%">
									<tr>
										<td class="text-right">Total Price</td>
										<td>:</td>
										<td class="text-left">Rp.{{currencyFormatIDR(order.payment.totalPrice)}}</td>
									</tr>
									<tr ng-show="order.payment.amountPayByCash !='' ">
										<td class="text-right">Cash</td>
										<td>:</td>
										<td class="text-left">Rp.{{currencyFormatIDR(order.payment.amountPayByCash)}}</td>
									</tr>
									<tr ng-show="order.payment.changeCash !=''">
										<td class="text-right">Change Cash:</td>
										<td>:</td>
										<td class="text-left">Rp.{{currencyFormatIDR(order.payment.changeCash)}}</td>
									</tr>
									<tr ng-show="order.payment.amountPayByDebitCard !=''">
										<td class="text-right">Debit Card:</td>
										<td>:</td>
										<td class="text-left">Rp.{{currencyFormatIDR(order.payment.amountPayByDebitCard)}}</td>
									</tr>
									<tr ng-show="order.payment.amountPayByCreditCard !=''">
										<td class="text-right">Credit Card:</td>
										<td>:</td>
										<td class="text-left">Rp.{{currencyFormatIDR(order.payment.amountPayByCreditCard)}}</td>
									</tr>
									<tr ng-show="order.payment.amountPayByVoucher !=''">
										<td class="text-right">Voucher:</td>
										<td>:</td>
										<td class="text-left">Rp.{{currencyFormatIDR(order.payment.amountPayByVoucher)}}</td>
									</tr>
								</table>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<div class="row" style="text-align: center;">
			<footer>We Thank You For Your Purchase</footer>
			<small id="" class="timestamp">{{date | date:'dd MMM yyyy HH:MM'}}</small><br /> <small id="" class="chasier">CH#Rizal</small>
		</div>
	</div>
	<script src="js/angular.js"></script>
	<script src="js/strukCtrl.js"></script>
	<script src="http://localhost:45/dts/angular/selector/bootstrap/js/bootstrap.min.js"></script>
	<script>
// 		$(document).ready(function() {
// 			window.print();
// // 			window.close();
// 		});
	</script>
</body>
</html>