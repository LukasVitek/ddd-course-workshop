<?php declare(strict_types=1);
namespace DDDWorkshop\Domain;

use DDDWorkshop\Domain\Interfaces\IEquatable;
use DDDWorkshop\Domain\Interfaces\IValueObject;
use Money\Currency;
use Money\Money;

class TotalAmount implements IValueObject
{
    private const CZK = 'CZK';

    /** @var Money */
    private $amount;


    /**
     * @param Money $amount
     * @throws \DDDWorkshop\Domain\Exceptions\CurrencyIsNotCzkException
     */
    public function __construct(Money $amount)
    {
        if (! $amount->getCurrency()->equals(new Currency(self::CZK))) {
            throw new \DDDWorkshop\Domain\Exceptions\CurrencyIsNotCzkException();
        }
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function toFloat(): float
    {
        return (float) ($this->amount->getAmount() / 100);
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * @param IEquatable $other
     * @return bool
     */
    public function equals(IEquatable $other): bool
    {
        return ($other instanceof self
            && $other->amount->equals($this->amount));
    }
}
