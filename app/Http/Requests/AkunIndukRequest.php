<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class AkunIndukRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasar
        $rules = [
            'tipe' => 'required',
            'email' => 'required|email|unique:ref_akun_induk,email,'.$this->get('id').',id,tipe,'.$this->get('tipe'),
            'aktif_awal' => 'required',
            'paket' => 'required',
        ];

        return $rules;
    }
}


