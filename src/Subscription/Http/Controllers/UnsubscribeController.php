<?php

namespace Yormy\ChaskiLaravel\Subscription\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Yormy\ChaskiLaravel\Subscription\Services\UnsubscribeService;

class UnsubscribeController extends Controller
{
    public function unsubscribe(string $unsubscribeToken): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\Foundation\Application
    {
        $unsubscribe = new UnsubscribeService($unsubscribeToken);
        $returnView = $unsubscribe->execute();

        $language = $unsubscribe->getLanguage();
        App::setLocale($language);

        return view($returnView);
    }
}
