@props(['userCount'])
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <span class="fw-semibold d-block mb-1">User</span>
                <h3 class="card-title mb-2">{{ $userCount }}</h3>
                <small class="text-success fw-semibold">
                    <i class="bx bx-up-arrow-alt"></i>
                    active user
                </small>
            </div>
        </div>
    </div>
</div>