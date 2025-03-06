@extends('layouts.app')

@section('content')
<div class="container1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Profile Information Card -->
            <div class="profile-card">
                <div class="card-header">
                    <h4>Profile Information</h4>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="profile-input" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="profile-input" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="profile-input" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="profile-input" name="address" value="{{ old('address', auth()->user()->address) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Age</label>
                            <input type="number" class="profile-input" name="age" value="{{ old('age', auth()->user()->age) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Year Level</label>
                            <input type="number" class="profile-input" name="year_level" value="{{ old('year_level', auth()->user()->year_level) }}" required min="1" max="6">
                        </div>

                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="text" id="course" value="{{ Auth::user()->course }}" class="form-control" readonly disabled>
                            <input type="hidden" name="course" value="{{ Auth::user()->course }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="update-btn">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="profile-card mt-4">
                <div class="card-header">
                    <h4>Update Password</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}" id="passwordForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" class="profile-input" name="current_password" required>
                        </div>

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="profile-input" name="password" required>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="profile-input" name="password_confirmation" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="update-btn">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Make sure jQuery is loaded first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Profile updated successfully!',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update profile. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                });
            }
        });
    });

    $('#passwordForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Password updated successfully!',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            },
            error: function(xhr) {
                let errorMessage = 'Failed to update password.';
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    if (xhr.responseJSON.errors.current_password) {
                        errorMessage = 'Current password is incorrect.';
                    } else if (xhr.responseJSON.errors.password) {
                        errorMessage = 'New password and confirmation do not match.';
                    }
                }

                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                });
            }
        });
    });
});
</script>

<style>
.container1 {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.profile-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
    background: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
}

.card-header h4 {
    margin: 0;
    color: #333;
}

.card-body {
    padding: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #666;
    font-weight: 500;
}

.profile-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    margin-top: 5px;
}

.profile-input:focus {
    border-color: #4a90e2;
    outline: none;
    box-shadow: 0 0 0 2px rgba(74,144,226,0.2);
}

.update-btn {
    background: #4a90e2;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
}

.update-btn:hover {
    background: #357abd;
}

.mt-4 {
    margin-top: 20px;
}

.alert {
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-danger {
    background: #fee;
    border: 1px solid #fcc;
    color: #c33;
}
</style>
@endsection
