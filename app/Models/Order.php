<?php

namespace App\Models;
use Carbon\Carbon;

use App\Models\Traits\Utilities;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Utilities;
	
    protected $table 		= 'ref_order';
    protected $fillable 	= ['nama'];

    public function transOrder(){
        return $this->hasMany(TransOrder::class);
    }

}

