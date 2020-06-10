<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

class DetailOrganization
{
    /**
     * @var float
     */
    private $currentCredit = 0.0;

    /**
     * @var array<Channel>
     */
    private $channels = [];

    /**
     * @param array<Channel> $channels
     */
    public function __construct(float $currentCredit, array $channels)
    {
        $this->currentCredit = $currentCredit;
        $this->channels = $channels;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): DetailOrganization
    {
        $channels = [];

        foreach ($data['channels'] as $channel) {
            $channels[] = Channel::fromArray($channel);
        }

        return new self(
            $data['currentCredit'],
            $channels
        );
    }

    public function getCurrentCredit(): float
    {
        return $this->currentCredit;
    }

    /**
     * @return array<Channel>
     */
    public function getChannels(): array
    {
        return $this->channels;
    }
}
