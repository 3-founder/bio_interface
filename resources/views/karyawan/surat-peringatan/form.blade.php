@include('vendor.select2')
@csrf
<div class="row">
    <div class="col-md-4 form-group">
        <label for="">Karyawan:</label>
        <select name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" @disabled($ro ?? null)></select>
        @error('nip')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="no_sp">No. SP</label>
        <input type="text" name="no_sp" id="no_sp" class="form-control @error('no_sp') is-invalid @enderror" value="{{ $sp?->no_sp }}" @disabled($ro ?? null) autofocus>

        @error('no_sp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="tanggal_sp">Tanggal SP</label>
        <input type="date" name="tanggal_sp" id="tanggal_sp" class="form-control @error('tanggal_sp') is-invalid @enderror" value="{{ $sp?->tanggal_sp?->format('Y-m-d') }}" @disabled($ro ?? null)>

        @error('tanggal_sp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="pelanggaran">Pelanggaran</label>
        <input type="text" name="pelanggaran" id="pelanggaran" class="form-control @error('pelanggaran') is-invalid @enderror" value="{{ $sp?->pelanggaran }}" @disabled($ro ?? null)>

        @error('pelanggaran')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="sanksi">Sanksi</label>
        <input type="text" name="sanksi" id="sanksi" class="form-control @error('sanksi') is-invalid @enderror" value="{{ $sp?->sanksi }}" @disabled($ro ?? null)>

        @error('sanksi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-right">
        @isset($ro)
            <a href="{{ route('surat-peringatan.index') }}" class="btn btn-primary">Kembali</a>
        @else
            <button type="submit" class="btn btn-primary">Simpan</button>
        @endisset
    </div>
</div>

@push('script')
<script>
    const nipSelect = $('#nip').select2({
        ajax: {
            url: '{{ route('api.select2.karyawan') }}',
            data: function(params) {
                return {
                    search: params.term || '',
                    page: params.page || 1
                }
            },
            cache: true,
        },
        templateResult: function(data) {
            if(data.loading) return data.text;
            return $(`
                <span>${data.nama}<br><span class="text-secondary">${data.id} - ${data.jabatan}</span></span>
            `);
        }
    });

    @isset($sp)
        nipSelect.append(`
            <option value="{{$sp->karyawan?->nip}}">{{$sp->karyawan?->nip}} - {{$sp->karyawan?->nama_karyawan}}</option>
        `).trigger('change');
    @endisset
</script>
@endpush