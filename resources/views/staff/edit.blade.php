@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ route('user.update', $users->id) }}" class="card p-5">
        @csrf
        @method('PATCH')

        <div class="mb-3 row">
            <h2>Edit Akun</h2>

            @if (Session::get('success'))
                <div class="alert alert-primary" role="alert">{{ Session::get('success') }}</div>
            @endif

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <label for="name" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $users->name }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email :</label>
            <div class="col-sm-10">
                <input type="email" id="email" name="email" class="form-control" value="{{ $users->email }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Role :</label>
            <div class="col-sm-10">
                <select id="role" name="role" class="form-control">
                    <option value="staff" {{ $users->role === 'staff' ? 'selected' : '' }}>staff</option>
                    <option value="guru" {{ $users->role === 'guru' ? 'selected' : '' }}>guru</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password :</label>
            <div class="col-sm-10">
                <input type="password" id="password" name="password" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-" style="background-color: #153243; color:white">Update</button>
    </form>
@endsection
