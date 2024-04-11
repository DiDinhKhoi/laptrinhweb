@extends('dashboard')

@section('content')
<main class="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User List</div>
                    <div class="card-body">
                        <a class="btn btn-success" href="{{ route('user.create') }}">Create User</a>
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <a href="{{ route('user.show', ['id' => $user->id]) }}" class="btn btn-primary">View</a> 
                                        <a href="{{ route('user.editUser', ['id' => $user->id]) }}" class="btn btn-info">Edit</a>
                                        <a href="{{ route('user.delete', ['id' => $user->id]) }}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-3">
                    {!! $users->links('pagination::bootstrap-4', ['prev_page' => '← Previous', 'next_page' => 'Next →']) !!}
                </div>
            </div>
        </div>
    </div>
</main>

@endsection