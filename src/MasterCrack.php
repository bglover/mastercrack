<?php
namespace Access9;

use InvalidArgumentException;
use UnexpectedValueException;

/**
 * @package Access9\MasterCrack;
 */
class MasterCrack
{
    /**
     * @var float
     */
    private $firstLockPosition;

    /**
     * @var float
     */
    private $secondLockPosition;

    /**
     * @var float
     */
    private $resistance;

    /**
     * @var int
     */
    private $first;

    /**
     * @var array
     */
    private $second = [];

    /**
     * @var array
     */
    private $third = [];

    /**
     * Holds the value of $this->first % 4.
     *
     * @var float
     */
    private $mod;

    /**
     * Set the value of the First Lock Position.
     *
     * @param float $val
     * @throws InvalidArgumentException
     * @return MasterCrack
     */
    public function setFirstLockPosition($val)
    {
        $this->validatePosition($val);
        $this->firstLockPosition = $val;
        return $this;
    }

    /**
     * Set the value of the Second Lock Position.
     *
     * @param float $val
     * @throws InvalidArgumentException
     * @return MasterCrack
     */
    public function setSecondLockPosition($val)
    {
        $this->validatePosition($val);
        $this->secondLockPosition = $val;
        return $this;
    }

    /**
     * @param float|int $resistance
     * @return MasterCrack
     */
    public function setResistance($resistance)
    {
        $this->resistance = $resistance;

        return $this;
    }

    /**
     * Perform the calculation.
     *
     * @throws UnexpectedValueException
     * @return MasterCrack
     */
    public function calc()
    {
        foreach (['firstLockPosition', 'secondLockPosition', 'resistance'] as $var) {
            if (!isset($this->{$var})) {
                throw new UnexpectedValueException(
                    'Can not continue: ' . $var . ' value not set.'
                );
            }
        }

        $this->setFirst();
        $this->setMod();
        $this->setThird();
        $this->setSecond();

        return $this;
    }

    /**
     * Get the first combination value.
     *
     * @return int
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * Get the second combination value(s).
     *
     * @return array
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * Get the third combination value(s).
     *
     * @return array
     */
    public function getThird()
    {
        return $this->third;
    }

    /**
     * Validate that the given input is between 1 and 10.
     *
     * @throws InvalidArgumentException
     * @param int|float $val
     */
    private function validatePosition($val)
    {
        if ($val < 1 || $val > 10) {
            throw new InvalidArgumentException(
                'Position must be a number between 1 and 10 (inclusive)'
            );
        }
    }

    /**
     * Set the first combination digit.
     *
     * @throws UnexpectedValueException
     * @return MasterCrack
     */
    private function setFirst()
    {
        if (!isset($this->resistance)) {
            throw new UnexpectedValueException(
                'The resistance must be set before the first combination can be calculated.'
            );
        }

        $this->first = (ceil($this->resistance) + 5) % 40;

        return $this;
    }

    /**
     * Set the mod to be used in the calculation
     * of the second and first digit.
     *
     * @throws UnexpectedValueException
     * @return MasterCrack
     */
    private function setMod()
    {
        if (!isset($this->first)) {
            throw new UnexpectedValueException(
                'The first combination must be set before the modulus can be calculated.'
            );
        }

        $this->mod = $this->first % 4;

        return $this;
    }

    /**
     * Sets the second combination.
     *
     * @param int|null $checkDigit
     * @throws UnexpectedValueException
     * @return MasterCrack
     */
    private function setSecond($checkDigit = null)
    {
        if (!isset($this->third)) {
            throw new UnexpectedValueException(
                'The third combination must first be calculated to find the second combination.'
            );
        }

        $mod = ($this->mod + 2) % 4;
        for ($i = 0; $i < 10; $i++) {
            $tmp        = $mod + (4 * $i);
            $testFirst  = 0;
            $testSecond = 0;

            if ($checkDigit) {
                $key        = $checkDigit - 1;
                $testFirst  = $tmp !== (($this->third[$key] + 2) % 40);
                $testSecond = $tmp !== (($this->third[$key] - 2) % 40);
            }

            if (!$checkDigit || ($testFirst && $testSecond)) {
                $this->second[] = $tmp;
            }
        }

        return $this;
    }

    /**
     * Set the third number of the combination
     *
     * @return MasterCrack
     */
    private function setThird()
    {
        for ($i = 0; $i < 4; $i++) {
            $x = 10 * $i;
            $lockPositionOneTest = ($x + $this->firstLockPosition) % 4;
            if ($lockPositionOneTest === $this->mod) {
                $this->third[] = $x + $this->firstLockPosition;
            }

            $lockPositionTwoTest = ($x + $this->secondLockPosition) % 4;
            if ($lockPositionTwoTest === $this->mod) {
                $this->third[] = $x + $this->secondLockPosition;
            }
        }

        return $this;
    }
}
