@extends('dashboard')

@section('content')
<main class="signup-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h3 class="card-header text-center">Edit User</h3>
                    <div class="card-body">
                        <form action="{{ route('user.updateUser', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email_address">Email</label>
                                <input type="text" id="email_address" class="form-control" name="email" value="{{ old('email', $user->email) }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" required autofocus>
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                            <div class="form-group mt-5">
                                <label for="avatar">Avatar</label>
                                <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewImage(event)">
                                @if ($errors->has('avatar'))
                                    <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                @endif
                            </div>
                            <div class="form-group mt-5">
                                <label for="avatar-preview"></label>
                                <img id="avatar-preview" src="{{ asset('avatars/' . $user->avatar)}}" alt="Avatar Preview" class="img-fluid" style="max-width: 200px; max-height: 200px;">
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-dark btn-block">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var avatarPreview = document.getElementById('avatar-preview');
                avatarPreview.src = reader.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
</main>
@endsection
