<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Utilities;


class AkunInduk extends Model
{
    use Utilities;

	// Default
    protected $table 		= "ref_akun_induk";
    protected $fillable 	= ['tipe','email', 'aktif_awal', 'paket', 'aktif_akhir','keterangan','password'];
    protected $dates        = ['aktif_awal', 'aktif_akhir'];

    public function order(){
        return $this->hasMany(TransOrder::class);
    }

    public function getAktifAwalAttribute($value)
    {
        return ($this->attributes['aktif_awal'] ? Carbon::parse($value)->format('d F Y') : '' );
    }

    public function setAktifAwalAttribute($value)
    {
        $this->attributes['aktif_awal'] = Carbon::createFromFormat('d F Y',$value)->format('Y-m-d');
    }

    public function getAktifAkhirAttribute($value)
    {
        return ($this->attributes['aktif_akhir'] ? Carbon::parse($value)->format('d F Y') : '' );
        // return Carbon::parse($value)->format('d F Y');
    }

    public function setAktifAkhirAttribute($value)
    {
        $this->attributes['aktif_akhir'] = Carbon::createFromFormat('d F Y',$value)->format('Y-m-d');
    }
}
