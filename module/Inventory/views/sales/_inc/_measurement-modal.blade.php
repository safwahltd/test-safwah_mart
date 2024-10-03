<div class="modal" id="measurementModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="measurementModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content rounded-0">
			<div class="modal-body text-center">
				<h3 class="pt-2">SELECT MEASUREMENT</h3>
			</div>
			<div class="modal-body text-center">
				<table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-header-bg">
                            <th width="60px">Measurement</th>
							<th width="60px">Price</th>
                            <th width="25%">Action</th>
                        </tr>
                    </thead>
					<tbody id="measurementTableBody">
                            
                                
					</tbody>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="hideModal('measurementModal')">OK</button>
			</div>
		</div>
	</div>
</div>