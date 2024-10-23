<html>
<head>
<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen" />
<link href="<?php echo base_url() ?>css/struk.css" rel="stylesheet" media="screen" />
<script>
	var rootUrl = "<?php echo base_url() ?>index.php";
</script>
</head>
<body ng-app="posApp" ng-controller="struckCtrl">
	<div class="invoice-container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="invoice-title"><?php echo $settings['COMPANY_NAME'];?></h3>
				<p id="address" class="address">
					<?php echo $settings['COMPANY_ADDRESS'];?><br>Tlp : <?php echo $settings['COMPANY_TELEPHONE'];?>
				</p>
				<h4 class="nota-bon" id="nota_bon">Nota Bon. #{{orderHeader.reference}}</h4>
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
						<tr ng-repeat="item in order.items" ng-class="{'active' : $index % 2 == 0}">
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
									<tr ng-show="order.payment.totalCash !='' ">
										<td class="text-right">Cash</td>
										<td>:</td>
										<td class="text-left">Rp.{{currencyFormatIDR(order.payment.totalCash)}}</td>
									</tr>
									<tr ng-show="order.payment.amountPayByCash !='' ">
										<td class="text-right">Pay by Cash</td>
										<td>:</td>
										<td class="text-left">Rp.{{currencyFormatIDR(order.payment.amountPayByCash)}}</td>
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
									<tr ng-showssss="order.payment.changeCash !=''">
										<td class="text-right">Change Cash</td>
										<td>:</td>
										<td class="text-left">Rp.{{currencyFormatIDR(order.payment.changeCash)}}</td>
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
			<small id="" class="timestamp">{{orderHeader.sales_date | date:'dd MMM yyyy HH:MM'}}</small><br /> 
			<small id="" class="chasier">CH#{{orderHeader.chasier_id}}</small>
		</div>
	</div>
	<script src="<?php echo base_url() ?>assets/angular/angular.min.js"></script>
	<script src="<?php echo base_url() ?>js/receiveCtrl.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-2.0.3.min.js"></script>
	<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
			window.print();
// 			window.close();
		});
	</script>
</body>
</html>