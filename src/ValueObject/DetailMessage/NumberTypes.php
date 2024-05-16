<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class NumberTypes
{
    private int $czMobile = 0;

    private int $czOther = 0;

    private int $sk = 0;

    private int $pl = 0;

    private int $hu = 0;

    private int $ro = 0;

    private int $other = 0;

    public function __construct(int $czMobile, int $czOther, int $sk, int $pl, int $hu, int $ro, int $other)
    {
        $this->czMobile = $czMobile;
        $this->czOther = $czOther;
        $this->sk = $sk;
        $this->pl = $pl;
        $this->hu = $hu;
        $this->ro = $ro;
        $this->other = $other;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): NumberTypes
    {
        return new self(
            $data['czMobile'], // @phpstan-ignore-line
            $data['czOther'], // @phpstan-ignore-line
            $data['sk'], // @phpstan-ignore-line
            $data['pl'], // @phpstan-ignore-line
            $data['hu'], // @phpstan-ignore-line
            $data['ro'], // @phpstan-ignore-line
            $data['other'], // @phpstan-ignore-line
        );
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'czMobile' => $this->getCzMobile(),
            'czOther' => $this->getCzOther(),
            'sk' => $this->getSk(),
            'pl' => $this->getPl(),
            'hu' => $this->getHu(),
            'ro' => $this->getRo(),
            'other' => $this->getOther(),
        ];
    }

    public function getCzMobile(): int
    {
        return $this->czMobile;
    }

    public function getCzOther(): int
    {
        return $this->czOther;
    }

    public function getSk(): int
    {
        return $this->sk;
    }

    public function getPl(): int
    {
        return $this->pl;
    }

    public function getHu(): int
    {
        return $this->hu;
    }

    public function getRo(): int
    {
        return $this->ro;
    }

    public function getOther(): int
    {
        return $this->other;
    }
}
