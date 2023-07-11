<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\AgentFailedEvent;
use Yormy\ChaskiLaravel\Services\RequestSource;

class Agent extends BaseWire
{
    public const NAME = 'agent';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new AgentFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }

    public function isAttack($patterns): bool
    {
        $agents = $this->config->tripwires();
        if (empty($agents)) {
            return false;
        }

        $violations = [];

        $browsers = $agents['browsers'];
        if ($this->isFilterAttack(RequestSource::getBrowser(), $browsers)) {
            $violations[] = RequestSource::getBrowser();
        }

        $platforms = $agents['platforms'];
        if ($this->isFilterAttack(RequestSource::getPlatform(), $platforms)) {
            $violations[] = RequestSource::getPlatform();
        }

        $devicesBlocked = $agents['devices']['block'];
        if ($blocked = $this->isDeviceBlocked($devicesBlocked)) {
            $violations[] = $blocked;
        }

        if ($maliciousAgent = $this->isMaliciousAgent()) {
            $violations[] = $maliciousAgent;
        }

        if (! empty($violations)) {
            $this->attackFound($violations);
        }

        return ! empty($violations);
    }

    private function isDeviceBlocked(array $devices): ?string
    {
        if (RequestSource::isPhone()) {
            if (in_array('PHONE', $devices)) {
                return 'PHONE';
            }
        }

        if (RequestSource::isMobile()) {
            if (in_array('MOBILE', $devices)) {
                return 'MOBILE';
            }
        }

        if (RequestSource::isTablet()) {
            if (in_array('TABLET', $devices)) {
                return 'TABLET';
            }
        }

        if (RequestSource::isDesktop()) {
            if (in_array('DESKTOP', $devices)) {
                return 'DESKTOP';
            }
        }

        return null;
    }

    /**
     * @psalm-return array<never, never>|null|string
     */
    protected function isMaliciousAgent(): array|string|null
    {
        $agent = RequestSource::getUserAgent();

        if (empty($agent) || ($agent == '-') || strstr($agent, '<?')) {
            return [];
        }

        $patterns = [
            '@"feed_url@',
            '@}__(.*)|O:@',
            '@J?Simple(p|P)ie(Factory)?@',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $agent, $matches)) {
                return $matches[0];
            }
        }

        return null;
    }
}
