<div>
    @if ($status == 1)
        <a class="updateStatus" id="id-{{ $column . '-' . $id }}" item-id="{{ $id }}"
            item-url="{{ route('update-status', ['table' => $table, 'column' => $column]) }}" href="javascript:void(0)">
            <i class="fa fa-toggle-on text-success" style="font-size: 20px" status="Active" name="{{ $column }}"></i>
        </a>
    @else
        <a class="updateStatus" id="id-{{ $column . '-' . $id }}" item-id="{{ $id }}"
            item-url="{{ route('update-status', ['table' => $table, 'column' => $column]) }}" href="javascript:void(0)">
            <i class="fa fa-toggle-off text-danger" style="font-size: 20px" status="Inactive"
                name="{{ $column }}"></i>
        </a>
    @endif
</div>
