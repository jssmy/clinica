<?php

namespace App\Http\Requests;

use App\Models\Paciente;
use App\Models\Persona;
use Illuminate\Foundation\Http\FormRequest;

class CambiarAnalisisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            $paciente = Paciente::where('persona_id',$this->paciente_id)->first();
            if(!$paciente) {
                $persona = Persona::where('id',$this->paciente_id)->first();
                $validator->errors()->add('paciente',"La persona no tiene historia clínica. Por favor, registre la historia clínica del paciente $persona->nombre_completo");
            }
        });
        return $validator;
    }
}
