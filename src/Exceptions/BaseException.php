<?php

namespace Yormy\ChaskiLaravel\Exceptions;

use Exception;
use Illuminate\Http\Request;

abstract class BaseException extends Exception
{
    public function render(Request $request)
    {
        $this->dispatchEvents($request);

        if ($request->wantsJson()) {
            return $this->renderJson($request);
        }

        return $this->renderHtml($request);
    }

    abstract protected function dispatchEvents(Request $request);

    abstract protected function renderJson(Request $request);

    abstract protected function renderHtml(Request $request);
}
