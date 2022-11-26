@extends('layouts.template')

@section('content')
    <div class="card-header">
        <div class="card-header">
            <p class="card-title"><a href="/">Dashboard </a> > <a href="/cabang">Cabang </a> > Tambah</p>
        </div>
    </div>

    <div class="card-body">
        <div class="col">
            <div class="row">
                <a href="{{ route('cabang.create') }}">
                  <button class="btn btn-primary">tambah cabang</button>
                </a>
                <div class="table-responsive overflow-hidden">
                    <table class="table" id="table">
                      <thead class=" text-primary">
                        <th>
                            No
                        </th>
                        <th>
                            Nama Cabang
                        </th>
                        <th>
                            Alamat
                        </th>
                        <th>
                            Aksi
                        </th>
                      </thead>
                      @php
                          $no = 1;
                      @endphp
                      <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>
                                    {{ $no++ }}
                                </td>
                                <td>
                                    {{ $item->nama_cabang }}
                                </td>
                                <td>
                                    {{ $item->alamat_cabang }}
                                </td>
                                <td>
                                  <div class="row">
                                    <a href="{{ route('cabang.edit', $item->id) }}">
                                      <button class="btn btn-warning">
                                        Edit
                                      </button>
                                    </a>
                                    
                                    {{-- <form action="{{ route('cabang.destroy', $item->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                  
                                      <button type="submit" class="btn btn-danger btn-block">Delete</button>
                                    </form> --}}
                                  </div>
                                </td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection

@section('custom_script')
  <script>
    $(document).ready( function () {
      $('#table').DataTable();
    });
  </script>
@endsection 