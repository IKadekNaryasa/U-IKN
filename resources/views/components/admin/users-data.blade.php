@props(['users'])
<div class="card mb-4">
    <h5 class="card-header text-center">Data of User</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table-striped" id="userTable">
                <thead>
                    <tr>
                        <th style="font-size: small;">No</th>
                        <th style="font-size: small;">Name</th>
                        <th style="font-size: small;">Username</th>
                        <th style="font-size: small;">Email</th>
                        <th style="font-size: small;">Contact</th>
                        <th style="font-size: small;" class="text-center">Status</th>
                        <th style="font-size: small;" class="text-center">Role</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="font-size: small;">{{ $loop->iteration  }}</td>
                        <td style="font-size: small;">{{ $user->name  }}</td>
                        <td style="font-size: small;">{{ $user->username  }}</td>
                        <td style="font-size: small;">{{ $user->email  }}</td>
                        <td style="font-size: small;">{{ $user->contact  }}</td>
                        <td style="font-size: small;" class="text-center">
                            @if ($user->status === 'active')
                            <span class="badge bg-success" style="text-transform: capitalize;">Active</span>
                            @elseif($user->status === 'waiting_verification')
                            <span class="badge bg-warning" style="text-transform: capitalize;">waitig verification</span>
                            @endif
                            @if ($user->logged_in == true)
                            <span class="badge bg-success" style="text-transform: capitalize;">
                                L
                            </span>
                            @elseif($user->logged_in == false)
                            <span class="badge bg-danger" style="text-transform: capitalize;">L</span>
                            @endif

                        </td>
                        <td style="font-size: small;" class="text-center">
                            @if ($user->role === 'admin')
                            <span class="badge bg-primary" style="text-transform: capitalize;">
                                Admin
                            </span>

                            @elseif($user->role === 'head')
                            <span class="badge bg-secondary" style="text-transform: capitalize;">Head</span>
                            @elseif($user->role === 'technician')
                            <span class="badge bg-info" style="text-transform: capitalize;">Technician</span>
                            @endif
                        </td>
                        <td class="d-flex justify-content-center">
                            <i class="bx bx-edit text-warning mx-1" type="button" data-bs-toggle="modal" data-bs-target="#updateUserModal-{{ $user->id }}"></i>
                            <form action="" method="post" id="userDeleteForm-{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <i class="bx bx-trash text-danger mx-1" type="button" onclick="confirmUserDelete(event)" data-id="{{ $user->id }}" data-user="{{ $user->name }}"></i>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">No User Found!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('script')
<script>
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>
@endpush