@props(['user'])
<div class="card mb-4">
    <h5 class="card-header text-center">Edit User : {{ $user->name }}</h5>
    <div class="card-body">
        <form action="{{ route('user.update',['user' => $user->id]) }}" method="post" id="userForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group">
                            <input type="text" name="name" class="form-control" required autofocus value="{{ old('name') ??  $user->name }}" placeholder="Input Name" style="text-transform: capitalize;">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <input type="text" name="username" class="form-control" required autofocus value="{{ old('username') ?? $user->username }}" placeholder="Input Username">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="contact" class="form-label">Contact</label>
                        <div class="input-group">
                            <input type="number" name="contact" class="form-control" required autofocus value="{{ old('contact') ?? $user->contact}}" placeholder="Input Contact">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" required autofocus value="{{ old('email') ?? $user->email }}" placeholder="Input Email">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="" class="form-control">
                            <option selected value="{{ $user->role }}">{{$user->role}}</option>
                            <option value="admin">Admin</option>
                            <option value="technician">Technician</option>
                            <option value="head">Head</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end mt-3">
                <div class="col-md-3">
                    <button id="submitBtn" class="btn btn-md btn-primary" type="submit">
                        <span id="submitText">Submit</span>
                        <span id="submitSpinner" class="spinner-border spinner-border-sm text-success d-none" role="status" aria-hidden="true"></span>
                    </button>

                </div>
            </div>
        </form>
    </div>
</div>
@push('script')
<script>
    document.getElementById('userForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        const text = document.getElementById('submitText');
        const spinner = document.getElementById('submitSpinner');

        text.textContent = 'Loading...';
        spinner.classList.remove('d-none');

        btn.disabled = true;
    });
</script>
@endpush