@extends('layouts.template')
@section('content')
    <div class="card-header">
        <div class="card-header">
            <h5 class="card-title">Edit Penambahan Bruto</h5>
            <p class="card-title"><a href="">Setting </a> > <a href="">Master</a> > <a href="{{ route('cabang.index') }}">Kantor Cabang</a> > <a>Edit</a></p>
        </div>
    </div>
    <div class="card-body ml-3 mr-3">
        <div class="row">
            <div class="col">
                <form action="{{ route('penambahan-bruto.update', $data->id) }}" method="POST" class="form-group" >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_profil_kantor" value="{{ $data->id_profil_kantor }}">

                    <label for="kode_cabang">Kode Kantor Cabang</label>
                    <input type="text" class="form-control" name="kode_cabang" id="kode_cabang"
                        value="{{ old('kode_cabang', $kd_cabang) }}" readonly>
                    @error('kode_cabang')
                        <div class="mt-2 alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="jkk" class="mt-2">
                        JKK(%)<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="@error('jkk') is-invalid @enderror form-control" name="jkk" id="jkk"
                        value="{{ old('jkk', $data->jkk) }}" onkeyup="hitungTotal()" required>
                    @error('jkk')
                        <div class="mt-2 alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="jht" class="mt-2">
                        JHT(%)<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="@error('jht') is-invalid @enderror form-control" name="jht" id="jht" value="{{ old('jht', $data->jht) }}" required>
                    @error('jht')
                        <div class="mt-2 alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="jkm" class="mt-2">
                        JKM(%)<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="@error('jkm') is-invalid @enderror form-control" name="jkm" id="jkm"
                        value="{{ old('jkm', $data->jkm) }}" onkeyup="hitungTotal()" required>
                    @error('jkm')
                        <div class="mt-2 alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="kesehatan" class="mt-2">
                        Kesehatan(%)<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="@error('kesehatan') is-invalid @enderror form-control" name="kesehatan" id="kesehatan"
                        value="{{ old('kesehatan', $data->kesehatan) }}" onkeyup="hitungTotal()" required>
                    @error('kesehatan')
                        <div class="mt-2 alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="kesehatan_batas_atas" class="mt-2">
                        Batas Atas(Rp)<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="@error('kesehatan_batas_atas') is-invalid @enderror rupiah form-control" name="kesehatan_batas_atas" id="kesehatan_batas_atas" value="{{ old('kesehatan_batas_atas', $data->kesehatan_batas_atas) }}" maxlength="10" required>
                    @error('kesehatan_batas_atas')
                        <div class="mt-2 alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="kesehatan_batas_bawah" class="mt-2">
                        Batas Bawah(Rp)<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="@error('kesehatan_batas_bawah') is-invalid @enderror rupiah form-control" name="kesehatan_batas_bawah" id="kesehatan_batas_bawah" value="{{ old('kesehatan_batas_bawah', $data->kesehatan_batas_bawah) }}" maxlength="10" required>
                    @error('kesehatan_batas_bawah')
                        <div class="mt-2 alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="jp" class="mt-2">
                        JP(%)<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="@error('jp') is-invalid @enderror form-control" name="jp" id="jp"
                        value="{{ old('jp', $data->jp) }}" onkeyup="hitungTotal()" required>
                    @error('jp')
                        <div class="mt-2 alert alert-danger">{{ $message }}</div>
                    @enderror

                    <label for="total" class="mt-2">
                        Total(%)<span class="text-danger">*</span>
                    </label>
                    <input type="text" class="@error('total') is-invalid @enderror form-control" name="total" id="total"
                        value="{{ old('total', $data->total) }}" onkeyup="hitungTotal()" readonly maxlength="">
                    @error('total')
                        <div class="mt-2 alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button class="btn btn-info">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            hitungTotal();
        })
        function hitungTotal() {
            console.log('hitung total')
            const jkk = !$('#jkk').val() ? 0.00 : parseFloat($('#jkk').val())
            const jht = !$('#jht').val() ? 0.00 : parseFloat($('#jht').val())
            const jkm = !$('#jkm').val() ? 0.00 : parseFloat($('#jkm').val())
            const kesehatan = !$('#kesehatan').val() ? 0.00 : parseFloat($('#kesehatan').val())
            const jp = !$('#jp').val() ? 0.00 : parseFloat($('#jp').val())
            const total = jkk + jht + jkm + kesehatan + jp
            $("#total").val(total)
        }

        $('.rupiah').keyup(function(){
            var angka = $(this).val();
            $(this).val(formatRupiah(angka));
        })

        $(document).ready(function() {
                // Selector untuk input dengan kelas "angka-saja"
            var inputElement = $('.only-angka');

            // Tambahkan event listener untuk memfilter input
            inputElement.on('input', function() {
                // Hapus semua karakter non-digit
                var sanitizedValue = $(this).val().replace(/[^\d.]/g, '');
                // Perbarui nilai input dengan angka yang telah difilter
                $(this).val(sanitizedValue);
            });
        });
    </script>
@endpush
