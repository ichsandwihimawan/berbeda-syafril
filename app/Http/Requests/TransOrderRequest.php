<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class TransOrderRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasar
        $rules = [
            'nama_depan' => 'required',
            'email' => 'required|email',
            'kontak' => 'required',
            'order_id' => 'required',
            'akun_induk_id' => 'required',
            'aktif_awal' => 'required',
            'paket' => 'required',
            'tipe' => 'required',
        ];


        

        if(strpos( $this->get('tipe'), 'NETFLIX') !== false)
        {
            $rules['profile'] = 'required';
        }

        return $rules;
    }
}