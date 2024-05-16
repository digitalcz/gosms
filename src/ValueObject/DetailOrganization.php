<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

class DetailOrganization
{
    private float $currentCredit = 0.0;

    /**
     * @var array<Channel>
     */
    private array $channels = [];

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

        foreach ($data['channels'] as $channel) { // @phpstan-ignore-line
            $channels[] = Channel::fromArray($channel); // @phpstan-ignore-line
        }

        return new self($data['currentCredit'], $channels);
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $channels = [];

        foreach ($this->getChannels() as $channel) {
            $channels[] = $channel->toArray();
        }

        return [
            'currentCredit' => $this->getCurrentCredit(),
            'channels' => $channels,
        ];
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
