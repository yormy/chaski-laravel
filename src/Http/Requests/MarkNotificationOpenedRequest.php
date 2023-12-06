<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Requests;

use Yormy\ValidationLaravel\Http\Requests\FormRouteRequest;

class MarkNotificationOpenedRequest extends FormRouteRequest
{
    protected $routeParamsToValidate = [
        'id' => 'id'
    ];

    public function rules(): array
    {
        $rules['id'] = ['required', 'exists:notifications,id'];

        return $rules;
    }
}
