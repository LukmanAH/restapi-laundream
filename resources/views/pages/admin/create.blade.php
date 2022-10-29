@extends('layouts.admin')

@section('title')
    Tambah Admin
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Admin Marketplace</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.admin.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="required">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" placeholder="Masukkan nama" name="name" value="{{ old('name') }}"
                                            required autofocus>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="required">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" placeholder="Masukkan email" name="email" value="{{ old('email') }}"
                                            required>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp" class="required">No HP</label>
                                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                            id="no_hp" placeholder="Masukkan No HP" name="no_hp" value="{{ old('no_hp') }}"
                                            required>
                                        @error('no_hp')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="required">Password</label>
                                        <input type="password" class="form-control form-password @error('password') is-invalid @enderror"
                                            id="password" placeholder="Masukkan password" name="password"
                                            value="{{ old('password') }}" required>
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="required">Konfirmasi
                                            Password</label>
                                        <input type="password"
                                            class="form-control form-password @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" placeholder="Masukkan konfirmasi password"
                                            name="password_confirmation" value="{{ old('password_confirmation') }}"
                                            required>
                                        @error('password_confirmation')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" class="form-checkbox" id="remember" name="remember">
                                        <label for="remember">
                                            Show Password
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
