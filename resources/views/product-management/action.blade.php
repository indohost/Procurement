<div class="row">
    <div class="col-md-2">
        <a href="{{ route('product-management.show', $id) }}" class="btn btn-primary" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Detail" style="text-decoration: none;">Detail</a>
    </div>
    <div class="col-md-2">
        <a href="{{ route('product-management.edit', $id) }}" class="btn btn-info" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Edit" style="text-decoration: none;">Edit</a>
    </div>
    <div class="col-md-2">
        <form method="POST" action="{{ route('product-management.destroy', $id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Delete" style="text-decoration: none;">Delete</button>
        </form>
    </div>
</div>
