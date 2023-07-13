<?php
namespace Yormy\ChaskiLaravel\Subscriptions\Http\Controllers;

use Illuminate\Routing\Controller;
use Yormy\ChaskiLaravel\Subscription\Actions\UnsubscribeAction;

class UnsubscribeController extends Controller
{
    public function unsubscribe(string $unsubscribeToken)
    {
        UnsubscribeAction::execute($unsubscribeToken);
    }

}
