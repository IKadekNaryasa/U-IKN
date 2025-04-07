<div class="card mb-4">
    <h5 class="card-header">Profile</h5>
    <!-- Account -->
    <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img
                src="{{asset('ikn_sneat')}}/assets/img/avatars/1.png"
                alt="user-avatar"
                class="d-block rounded"
                height="100"
                width="100"
                id="uploadedAvatar" />
            <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">Upload new photo</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input
                        type="file"
                        id="upload"
                        name="foto"
                        class="account-file-input"
                        hidden
                        accept="image/png, image/jpeg" />
                </label>

                <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 1MB</p>
            </div>
        </div>
    </div>
    <hr class="my-0" />
    <div class="card-body">
        <form id="formAccountSettings" action="{{ route('user.update',['user' => auth()->user()->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <input type="hidden" name="regenerate" value="false">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group">
                            <input type="text" name="name" class="form-control" required autofocus value="{{ old('name') ??  auth()->user()->name }}" placeholder="Input Name" style="text-transform: capitalize;">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <input type="text" name="username" class="form-control" required autofocus value="{{ old('username') ?? auth()->user()->username}}" placeholder="Input Username">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="contact" class="form-label">Contact</label>
                        <div class="input-group">
                            <input type="number" name="contact" class="form-control" required autofocus value="{{ old('contact') ?? auth()->user()->contact }}" placeholder="Input Contact">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" required autofocus value="{{ old('email') ?? auth()->user()->email }}" placeholder="Input Email">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="role" value="{{ auth()->user()->role }}">
            </div>
            <div class="mt-2">
                <button id="submitBtn" class="btn btn-md btn-primary" type="submit">
                    <span id="submitText">Save Changes</span>
                    <span id="submitSpinner" class="spinner-border spinner-border-sm text-success d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </form>
    </div>
    <!-- /Account -->
</div>

@push('script')
<script>
    document.getElementById('formAccountSettings').addEventListener('submit', function(e) {
        const btn = document.getElementById('submitBtn');
        const text = document.getElementById('submitText');
        const spinner = document.getElementById('submitSpinner');

        text.textContent = 'Loading...';
        spinner.classList.remove('d-none');

        btn.disabled = true;
    });
</script>
@endpush