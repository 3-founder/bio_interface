<?php

namespace App\Models;

use App\Enum\KategoriPenonaktifan;
use App\Service\EntityService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengkinianKaryawanModel extends Model
{
    use HasFactory;

    protected $table = 'history_pengkinian_data_karyawan';
    protected $primaryKey = 'nip';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nip',
        'nama_karyawan',
        'nik',
        'ket_jabatan',
        'kd_subdivisi',
        'id_cabang',
        'kd_jabatan',
        'kd_panggol',
        'id_is',
        'kd_agama',
        'tmp_lahir',
        'tgl_lahir',
        'kewarganegaraan',
        'jk',
        'status',
        'alamat_ktp',
        'alamat_sek',
        'kpj',
        'jkn',
        'gj_pokok',
        'gj_penyesuaian',
        'status_karyawan',
        'skangkat',
        'tanggal_pengangkat',
        'tanggal_penonaktifan',
        'kategori_penonaktifan',
        'sk_pemberhentian',
        'no_rekening',
        'npwp',
        'pendidikan',
        'pendidikan_major',       
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'tgl_mulai' => 'date',
        'kategori_penonaktifan' => KategoriPenonaktifan::class,
    ];

    public function entitas(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => EntityService::getEntity($attributes['kd_entitas'])
        );
    }

    public function agama()
    {
        return $this->belongsTo(AgamaModel::class, 'kd_agama', 'kd_agama');
    }

    public function jabatan()
    {
        return $this->belongsTo(JabatanModel::class, 'kd_jabatan', 'kd_jabatan');
    }

    public function bagian()
    {
        return $this->belongsTo(BagianModel::class, 'kd_bagian', 'kd_bagian');
    }

    public function cabang()
    {
        return $this->belongsTo(CabangModel::class);
    }

    public function panggol()
    {
        return $this->belongsTo(PanggolModel::class, 'kd_panggol', 'golongan');
    }

    public function keluarga()
    {
        return $this->hasOne(PengkinianKeluargaModel::class, 'nip');
    }

    public function tunjangan()
    {
        return $this->belongsToMany(
            PengkinianTunjanganModel::class,
            'tunjangan_karyawan',
            'nip',
            'id_tunjangan'
        )->withPivot('nominal');
    }
}
