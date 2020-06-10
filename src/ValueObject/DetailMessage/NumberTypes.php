<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class NumberTypes
{
    /**
     * @var int
     */
    private $czMobile = 0;

    /**
     * @var int
     */
    private $czOther = 0;

    /**
     * @var int
     */
    private $sk = 0;

    /**
     * @var int
     */
    private $pl = 0;

    /**
     * @var int
     */
    private $hu = 0;

    /**
     * @var int
     */
    private $ro = 0;

    /**
     * @var int
     */
    private $other = 0;

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
            $data['czMobile'],
            $data['czOther'],
            $data['sk'],
            $data['pl'],
            $data['hu'],
            $data['ro'],
            $data['other']
        );
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
