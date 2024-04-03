<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Requests;

use Yormy\ValidationLaravel\Http\Requests\FormRouteRequest;

class EmailShowUuidRequest extends FormRouteRequest
{
    protected $routeParamsToValidate = [
        'uuid' => 'uuid',
    ];

    public function rules(): array
    {
        $rules['uuid'] = ['required', 'exists:sent_emails,sent_email_id'];

        return [];
    }
}
