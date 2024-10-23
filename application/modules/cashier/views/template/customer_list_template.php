
<!-- search Customer -->
<div id="searchCustomerModal" class="modal fade search-customer-pos-modal-lg" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-fetch-pos" search-customer-selector ng-class="{'table-active' : selectedTable == 5}">
								<thead>
									<tr>
										<td colspan="6">
											<div class="col-md-10">
												<div class="col-md-12">
													<div class="col-md-10">
														<div class="input-group">
															<span class="input-group-addon"> <span class="glyphicon glyphicon glyphicon-barcode" aria-hidden="true"></span>
															</span> <input id="searchCustomerKey" type="text" class="form-control" ng-model="searchCustomerKey"
																placeholder="Enter Customer barcode or customer name here...">
														</div>
													</div>
													<button class="btn btn-primary" ng-click="searchCustomer(searchCustomerKey)" style="margin-top: 0;">
														Ok&nbsp;<span style="font-size: 10px;">[Enter]</span>
													</button>
												</div>
											</div>
											<div class="col-md-2">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="closeSearchCustomerModal()">
													<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>[Esc]
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
										<th>Reference</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="customer in listSearchedCustomer" ng-animate="'slide'" ng-class="{'selected':$index == selectedSearchCustomerRow}">
										<th scope="row">{{$index + 1}}</th>
										<td>{{customer.name}}</td>
										<td>{{customer.barcode}}</td>
										<td>{{customer.address}}</td>
										<td>{{customer.discount}}</td>
										<td>{{customer.reference}}</td>
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