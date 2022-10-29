@extends('layouts.admin')

@section('title')
    Edit Informasi
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Informasi</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.informations.update', $information) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title" class="required">Title</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" placeholder="Masukkan title" value="{{ $information->title }}"
                                            name="title" required autofocus>
                                        @error('title')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="description" class="required">Deskripsi</label>
                                        <textarea rows=6 class="form-control @error('description') is-invalid @enderror" id="description"
                                            placeholder="Masukkan deskripsi" name="description" required autofocus>{{ $information->description }}</textarea>
                                        @error('description')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if ($information->picture)
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <img src="{{ $information->picture }}" alt="" width="200" height="200">
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="picture" class="required">Deskripsi</label>
                                        <input type="file" class="form-control" id="picture" name="picture"
                                            accept=".png,.jpeg,.jpg">
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
