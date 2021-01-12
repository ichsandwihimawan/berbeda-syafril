<?php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrderRequest extends Request
{

    
     /* Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // ambil validasi dasa
        $rules = [
            'nama' => 'required|unique:ref_order,nama,'.$this->get('id')
        ];

        return $rules;
    }
}


