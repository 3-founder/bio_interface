@extends('layouts.template')

@section('content')
    <div class="card-header">
        <div class="card-header">
            <div class="card-title">
                <p class="card-title"><a href="/">Dashboard </a> > <a href="/jabatan">Jabatan </a> > Tambah</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="container">
                    <form action="{{ route('jabatan.store') }}" class="form-group" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="nama_kantot">Nama Jabatan</label>
                        <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control">
                        <button class="btn btn-info" value="submit" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection