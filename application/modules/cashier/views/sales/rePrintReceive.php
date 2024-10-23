<html>
<head>
<script>
	var rootUrl = "<?php echo base_url() ?>index.php";
</script>
<style>
@page {
	size: portrait;
	margin-left:  5mm;
	margin-right:  5mm;
	margin-top:  0;
}

* {
	margin: 0px;
	padding: 0px;
	font-size: 9px;
	font-family: 'MS Gothic', Arial, bubbledot, 'Arial Narrow';
</style>
</head>
<body ng-app="rePrintReceiveApp" ng-controller="struckCtrl2">
<table width="300">
	<table style="width: 100%;">
		<tr>
			<td style="text-align: left;">
				<span style="text-align: left; width: 20px"><?php echo $settings['COMPANY_NAME'];?></span>
				<p id="address" class="address" style="text-align: left;width: 170px;">
					<?php echo $settings['COMPANY_ADDRESS'];?>
					<br/>Tlp : <?php echo $settings['COMPANY_TELEPHONE'];?>
					<br/>NPWP : <?php echo $settings['STORE_NPWP'];?>
				</p>
				<br/>
				<p>
					===REPRINT===
				</p>
				<br/>
				<h4 class="nota-bon" id="nota_bon" style="text-align: left;">NO. #{{sales.reference}}</h4>
				
				<table style="width: 100%; margin-left: -2px;padding-left: 0px;" border=0 ng-show="customer !='undefined' && customer !=null ">
					<tr>
						<td width="30%">CUSTOMER ID</td>
						<td width="1%">:</td>
						<td>{{customer.barcode}}</td>
					</tr>
					<tr>
						<td width="30%">NAME</td>
						<td width="1%">:</td>
						<td>{{customer.name}}</td>
					</tr>
					<tr>
						<td width="30%">TYPE</td>
						<td width="1%">:</td>
						<td>{{customer.customertype}}</td>
					</tr>
				</table>
				
			</td>
		</tr>
	</table>
	<table style="width: 100%;margin-left: -1px;padding-left: 0px !important;" cellpadding=0 cellspacing=0>
		<tbody>
		    <tr>
		    	<td style="border-top: 1px #000000 dashed;border-bottom: 1px #000000 dashed;">
		    	</td>
		    </tr>
			<tr ng-repeat="item in salesDetails">
				<td align="center" width="100%">
					<table width="100%">
						<tr>
							<td colspan="3">{{item.item_name}}</td>
						</tr>
						<tr>
							<td style="text-align: left;">{{item.quantity}}x@{{currencyFormatIDR(item.price)}}</td>
							<td style="text-align: right;"  ng-show="item.discount > 0 ">-{{currencyFormatIDR(item.discount)}}</td>
							<td width="23%" style="text-align: right;">{{currencyFormatIDR( item.sub_total_price )}}</td>
							<td width="30%"></td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4" style="border-top: 1px #000000 dashed;border-bottom: 1px #000000 dashed;">
					<table style="width: 100%; font-size: 7px;">
						<tr>
							<td width="30%" style="text-align: left;">TOTAL ITEM</td>
							<td width="10%">:</td>
							<td width="30%" style="text-align: right;float: right;">{{currencyFormatIDR(sales.total_quantity)}}</td>
							<td width="30%"></td>
						</tr>
						<tr>
							<td width="30%" style="text-align: left;">TOTAL HARGA</td>
							<td width="10%">:</td>
							<td width="30%" style="text-align: right;">{{currencyFormatIDR( sales.total_price )}}</td>
							<td width="30%"></td>
						</tr>
						<tr>
							<td width="30%" style="text-align: left;">TOTAL DISCOUNT</td>
							<td width="10%">:</td>
							<td width="30%" style="text-align: right;">{{sales.total_discount}}</td>
							<td width="30%"></td>
						</tr>
						
						<tr ng-show="order.payment.totalCash !='' ">
							<td width="30%" style="text-align: left;">UANG TUNAI</td>
							<td width="10%">:</td>
							<td width="30%" style="text-align: right;">{{currencyFormatIDR(sales.total_cash)}}</td>
							<td width="30%"></td>
						</tr>
						<tr ng-show="sales.amount_pay_cash > 0 ">
							<td width="30%" style="text-align: left;">BAYAR TUNAI</td>
							<td width="10%">:</td>
							<td width="30%" style="text-align: right;">{{currencyFormatIDR(sales.amount_pay_cash)}}</td>
							<td width="30%"></td>
						</tr>
						<tr ng-show="sales.amount_pay_cash_debit_card > 0 ">
							<td width="30%" style="text-align: left;">DEBIT CARD</td>
							<td width="10%">:</td>
							<td width="30%" style="text-align: right;">{{currencyFormatIDR(sales.amount_pay_cash_debit_card)}}</td>
							<td width="30%"></td>
						</tr>
						<tr ng-show="sales.amount_pay_cash_credit_card > 0 ">
							<td width="30%" style="text-align: left;">CREDIT CARD</td>
							<td width="10%">:</td>
							<td width="30%" style="text-align: right;">{{currencyFormatIDR(sales.amount_pay_cash_credit_card)}}</td>
							<td width="30%"></td>
						</tr>
						<tr ng-show="sales.amount_pay_cash_voucher > 0 ">
							<td width="30%" style="text-align: left;">VOUCHER</td>
							<td width="10%">:</td>
							<td width="30%" style="text-align: right;">{{currencyFormatIDR(sales.amount_pay_cash_voucher)}}</td>
							<td width="30%"></td>
						</tr>
						<tr ng-show="sales.cash_retun > 0 ">
							<td width="30%" style="text-align: left;">KEMBALIAN</td>
							<td width="10%">:</td>
							<td width="30%" style="text-align: right;">{{currencyFormatIDR(sales.cash_retun)}}</td>
							<td width="30%"></td>
						</tr>
						<tr>
							<td> </td>
						</tr>
					</table>
				</td>
			</tr>
		</tfoot>
	</table>
	<table style="margin-left: -1px;padding-left: 0px;">
		<tr>
			<td style="text-align: left;">
				<footer>
					HARGA SUDAH TERMASUK PPN DAN PPnBM<br /> TERIMA KASIH
				</footer>
				<small id="" class="timestamp">{{sales.sales_date | date:'dd MMM yyyy HH:mm:i'}}</small><br /> <small id=""
					class="chasier">KASIR: <?php echo Authority::getUserName()?></small>
			</td>
		</tr>
	</table>
</table>	
	<script src="<?php echo base_url() ?>assets/angular/angular.min.js"></script>
	<script src="<?php echo base_url() ?>js/rePrintReceiveCtrl.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-2.0.3.min.js"></script>
	<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
			window.print();
// 			document.close();
// 			self.close();
// 			setTimeout (function() {window.close();},1000);
// 			close();
// 			setTimeout(function(){ window.print(); }, 30);
// 			window.open('','_parent',''); 
// 			window.close();
		});
	</script>
</body>
</html>