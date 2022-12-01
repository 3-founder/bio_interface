@extends('layouts.template')

@section('content')
    <div class="card-header">
        <div class="card-header">
            <h5 class="card-title">Data Bagian</h5>
            <p class="card-title"><a href="/">Dashboard </a> > <a href="/bagian">Bagian</p>
        </div>
        
        <div class="card-body">
            <div class="col">
                <div class="row">
                    <a class="mb-3" href="{{ route('bagian.create') }}">
                      <button class="btn btn-primary">tambah cabang</button>
                    </a>
                    <div class="table-responsive overflow-hidden">
                        <table class="table" id="table">
                          <thead class=" text-primary">
                            <th>
                                No
                            </th>
                            <th>
                                Kode Bagian
                            </th>
                            <th>
                                Nama Bagian
                            </th>
                            <th>Kode Kantor</th>
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
                                        {{ $item->kd_bagian }}
                                    </td>
                                    <td>
                                        {{ $item->nama_bagian }}
                                    </td>
                                    <td>
                                        @if ($item->kd_entitas == "2")
                                          Cabang
                                        @else
                                          Pusat
                                        @endif
                                    </td>
                                    <td>
                                      <div class="row">
                                        <a href="{{ route('bagian.edit', $item->kd_bagian) }}">
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
    </div>
@endsection

@section('custom_script')
  <script>
    $(document).ready( function () {
      $('#table').DataTable();
    });
  </script>
@endsection 