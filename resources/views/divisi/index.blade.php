@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
      <div class="card-header">
        <p class="card-title"><a href="/">Dashboard </a> - <a href="/divisi">Divisi </a> - Data Master</p>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col">
          <a href="{{ route('divisi.create') }}">
            <button class="btn btn-primary">tambah</button>
          </a>
          <div class="table-responsive overflow-hidden">
            <table class="table" id="table">
              <thead class=" text-primary">
                <th>
                  No
                </th>
                <th>
                    Kode Divisi
                </th>
                <th>
                    Nama Divisi
                </th>
                <th>
                    Aksi
                </th>
              </thead>
              @php
                  $i = 1;
              @endphp
              <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>
                          {{ $i++ }}
                        </td>
                        <td>
                            {{ $item['kd_divisi'] }}
                        </td>
                        <td>
                            {{ $item['nama_divisi'] }}
                        </td>
                        <td>
                          <div class="row">
                            <a href="{{ route('divisi.edit', $item['kd_divisi']) }}">
                              <button class="btn btn-warning">
                                  Edit
                              </button>
                            </a>

                            {{-- <form action="{{ route('divisi.destroy', $item['kd_divisi']) }}" method="POST">
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
          <div class="row">
            <div class="col">
            </div>
          </div>
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