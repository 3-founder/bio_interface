@extends('layouts.template')

@section('content')
    <div class="card-header">
        <div class="card-header">
            <div class="card-title"><a href="/">Dashboard </a> > <a href="/pangkat_golongan">Pangkat dan Golongan </a> 
        </div>
    </div>

    <div class="card-body">
        <div class="col">
            <div class="row">
                <a href="{{ route('pangkat_golongan.create') }}">
                  <button class="btn btn-primary">tambah pangkat dan golongan</button>
                </a>
                <div class="table-responsive overflow-hidden">
                    <table class="table" id="table">
                      <thead class=" text-primary">
                        <th>
                            No
                        </th>
                        <th>
                            Pangkat
                        </th>
                        <th>
                            Golongan
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
                                    {{ $item->pangkat }}
                                </td>
                                <td>
                                    {{ $item->golongan }}
                                </td>
                                <td>
                                  <div class="row">
                                    <a href="{{ route('pangkat_golongan.edit', $item->id) }}">
                                      <button class="btn btn-warning">
                                        Edit
                                      </button>
                                    </a>
                                    
                                    {{-- <form action="{{ route('pangkat_golongan.destroy', $item->id) }}" method="POST">
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