<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Operational\Doctor;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class StoreDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // do not bring access if
        abort_if(Gate::denies('doctor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'specialist_id' => [
                'required', 'integer', 'max:255'
            ],
            'name' => [
                'required', 'string', 'max:255'

            ],
            'fee' => [
                'required', 'string', 'max:255'

            ],
             'photo' => [
                'nullable', 'string', 'max:10000'

            ],
        ];
    }
}
