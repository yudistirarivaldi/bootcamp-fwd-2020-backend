<?php

namespace App\Http\Requests\ConfigPayment;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Models\MasterData\ConfigPayment;
use Gate;

class UpdateConfigPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // do not bring access if
        abort_if(Gate::denies('config_payment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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

                'fee' => [
                    'required', 'string', 'max:255'
                ],

                'vat' => [
                    'required', 'string', 'max:255'
                ],

            ];

    }
}
