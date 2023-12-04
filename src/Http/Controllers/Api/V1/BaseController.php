<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Yormy\ChaskiLaravel\Services\Resolvers\UserResolver;

class BaseController
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->user = UserResolver::getCurrent();
    }
}
