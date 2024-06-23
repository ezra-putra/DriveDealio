
@foreach ($user as $u)
<form action="{{ route('edit.role', $u->iduser) }}" method="POST"
    enctype="multipart/form-data" class="row gy-1 gx-2 mt-75" id="roleForm">
    @csrf
    <div class="col-12">
        <div class="row">
            <div class="col-12 mb-1">
                <label class="form-label" for="name">Name</label>
                <input type="text" name="name" id="name"
                class="form-control" placeholder="Username" value="{{ $u->firstname }} {{ $u->lastname }}" disabled/>
            </div>
            <div class="col-12 mb-1">
                <label class="form-label" for="select-role">Role</label>
                <select class="form-select" id="select-role" name="role">
                    <option value="">--Choose Role--</option>
                    @foreach ($role as $r)
                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-12 text-center">
        <input type="submit" class="btn btn-primary me-1 mt-1" value="Edit Role">
        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
            aria-label="Close">
            Cancel
        </button>
    </div>
</form>
@endforeach

