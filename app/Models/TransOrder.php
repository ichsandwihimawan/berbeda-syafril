<?php

namespace App\Models;
use Carbon\Carbon;
use Mail;


use Illuminate\Database\Eloquent\Model;

class TransOrder extends Model
{

    protected $table 		= 'trans_order';
    protected $fillable 	= ['nama_depan', 'tipe', 'nama_belakang', 'email', 'kontak', 'order_id', 'akun_induk_id', 'aktif_awal', 'aktif_akhir','paket','profile', 'pin'];

    protected $dates = [
        'aktif_awal', 'aktif_akhir'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

    // public function pin() {
    //     return $this->belongsTo(Pin::class, 'pin');
    // }

    public function akunInduk(){
        return $this->belongsTo(AkunInduk::class, 'akun_induk_id');
    }

    public function getAktifAwalAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d F Y');
    }

    public function getAktifAkhirAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d F Y');
    }

     public function Aktif($value)    {
        $date = Carbon::parse($value);
        return $date->format('d M Y');
    }

    public function Akhir()
    {
        return $this->aktif_akhir->format('d F Y');
    }

    // public function setAktifAwalAttribute($value)
    // {
    //     $this->attributes['aktif_awal'] = Carbon::createFromFormat('d/m/Y', $value);
    // }

    // public function setAktifAkhirAttribute($value)
    // {
    //     $c = Carbon::createFromFormat('d/m/Y', $this->aktif_awal);
    //     $this->attributes['aktif_akhir'] = $c->addMonth($this->paket);
    // }
    
    public function getFullnameAttribute()
    {
        return $this->nama_depan . ' '. $this->nama_belakang;
     }


    public function statusLabel()
    {
        switch($this->status) {
            case 1 : return '<span class="badge badge-secondary">Belum Lunas</span>';
            break;
            case 2 : return '<span class="badge badge-secondary">Sudah Lunas</span>';
            break;
            case 3 : return '<span class="badge badge-secondary">Hold</span>';
            break;
            case 4 : return '<span class="badge badge-secondary">Cancle</span>';
            break;
        }
    }


//     public function expireLabel(){

//     	$awal = Carbon::createFromFormat('d/m/Y', $this->tgl_awal);


//     	$b = $awal->addMonth($this->durasi);


//     	$c = $b->diffInDays(Carbon::now());


// // dd($this->tgl_awal);
// dd($awal->format("d/m/Y"));

//     	// $awal2 = $awal->addMonth($this->durasi)->format('d/m/Y');
    	
//     	return  $c;
//     }


    public function orderLabel()
    {
        switch($this->status) {
            case 0 : return '<a class="ui teal tag label">Tokopedia M</a>';
            break;
            case 1 : return '<a class="ui teal tag label">Tokopedia G</a>';
            break;
            case 2 : return '<a class="ui teal tag label">Line</a>';
            break;
        }
    }

    public function scopeUserExpire($q)
    {
        $from = Carbon::today();
        $to = Carbon::today()->addDays(7);


        return $q->whereBetween('aktif_akhir', [$from, $to])->get();
    }


    public static function sendEmail()
    {
        $datas = static::UserExpire();

        foreach ($datas as $key => $data) {
            Mail::send('email', ['data' => $data ], function ($message) use ($data)
            {
                $message->subject('Segera Perpanjang Akun Anda');
                $message->from('noreplay@frilstore.xyz', 'Syafril Store');
                $message->to($data->email);
            });
        }
    }


    public static function sendSingleEmail($e = null)
    {
        $datas = static::where('email',$e)->first();
// dd($datas);
        if($datas)
        {
            Mail::send('email', ['data' => $datas ], function ($message) use ($datas)
            {
                $message->subject('Segera Perpanjang Akun Anda');
                $message->from('noreplay@frilstore.xyz', 'Syafril Store');
                $message->to($datas->email);
            });
        }
    }
}
