<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Requests;

use Yormy\ValidationLaravel\Http\Requests\FormRouteRequest;

class EmailShowXidRequest extends FormRouteRequest
{
    protected $routeParamsToValidate = [
        'xid' => 'xid',
    ];

    public function rules(): array
    {
        return [];
        $rules['xid'] = ['required', 'exists:sent_emails,xid'];

        return $rules;
    }
}
