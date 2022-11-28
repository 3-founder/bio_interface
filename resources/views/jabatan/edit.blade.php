@extends('layouts.template')

@section('content')
    <div class="card-header">
        <div class="card-header">
            <div class="card-title">
                <h5 class="card-title">Edit Jabatan</h5>
                <p class="card-title"><a href="/">Dashboard </a> > <a href="/jabatan">jabatan </a> > Edit</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <form action="{{ route('jabatan.update', $data->kd_jabatan) }}" class="form-group" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="nama_kantot">Kode Jabatan</label>
                            <input type="text" name="kd_jabatan" id="kd_jabatan" class="form-control" value="{{ $data->kd_jabatan }}">
                        </div>
                        <div class="col-lg-6">
                            <label for="nama_kantot">Nama Jabatan</label>
                            <input type="text" name="nama_jabatan" id="nama_jabatan" class="form-control"value="{{ $data->nama_jabatan }}">
                        </div>
                    </div>
                        <button class="btn btn-info" value="submit" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection