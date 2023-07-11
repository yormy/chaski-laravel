<?php

namespace Yormy\ChaskiLaravel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\DataObjects\WireConfig;
use Yormy\ChaskiLaravel\Observers\Events\Failed\HoneypotFailedEvent;
use Yormy\ChaskiLaravel\Services\HoneypotService;
use Yormy\ChaskiLaravel\Services\ResponseDeterminer;
use Yormy\ChaskiLaravel\Traits\TripwireHelpers;

/**
 * Goal:
 * Trigger when hackers try to edit the request in a way to guess hidden parameters.
 *
 * Effect:
 * When a honeypot is filled or changed the application will immediately notice malicious intent
 * No real user would do this
 */
class Honeypot
{
    use TripwireHelpers;

    public const NAME = 'honeypot';

    /**
     * @return mixed
     *
     * @throws \Mexion\BedrockCore\Exceptions\ExceptionResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $this->request = $request;

        $this->config = new WireConfig(self::NAME);

        $honeypotsMustBeFalseOrMissing = $this->config->tripwires();

        $violations = HoneypotService::checkFalseValues($request, $honeypotsMustBeFalseOrMissing);

        if (! empty($violations)) {
            $triggerEventData = new TriggerEventData(
                attackScore: $this->config->attackScore(),
                violations: $violations,
                triggerData: implode(',', $violations),
                triggerRules: [],
                trainingMode: $this->config->trainingMode(),
                debugMode: $this->config->debugMode(),
                comments: '',
            );

            $this->attackFound($triggerEventData);

            $rejectResponse = $this->getConfig($request, 'honeypot');
            $respond = new ResponseDeterminer($rejectResponse, $request->url());
            if ($request->wantsJson()) {
                return $respond->respondWithJson();
            }

            return $respond->respondWithHtml();
        }

        $this->cleanup($request, $this->config);

        return $next($request);
    }

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new HoneypotFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }

    protected function cleanup(Request $request, WireConfig $wireConfig): void
    {
        foreach ($wireConfig->tripwires() as $field) {
            $request->request->remove($field);
        }
    }
}
