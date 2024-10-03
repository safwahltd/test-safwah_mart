<div class="modal" id="variationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="variationModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content rounded-0">
			<div class="modal-body text-center">
				<h3 class="p-3">SELECT VARIATION</h3>
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
					<tbody id="variationTableBody">
                            
                                
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				{{-- <button type="button" class="btn btn-success">OK</button> --}}
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="hideModal('variationModal')">Ok</button>
			</div>
		</div>
	</div>
</div>