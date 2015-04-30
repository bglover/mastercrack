<?php
namespace Access9;

use UnexpectedValueException;

/**
 * @package Access9\MasterCrack;
 */
class MasterCrack
{
    /**
     * @var float
     */
    private $lp1;

    /**
     * @var float
     */
    private $lp2;

    /**
     * @var int|float
     */
    private $resist;

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
     * Public setter
     *
     * @param string $key
     * @param mixed  $val
     */
    public function __set($key, $val)
    {
        if (!in_array($key, ['first', 'second', 'third'])) {
            $this->{$key} = $val;
        }
    }

    /**
     * Set the first combination digit.
     *
     * @return MasterCrack
     */
    private function setFirst()
    {
        if (!isset($this->resist)) {
            throw new UnexpectedValueException(
                'The resistance must be set before the first combination can be calculated.'
            );
        }

        $this->first = (ceil($this->resist) + 5) % 40;

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
                $testFirst  = $tmp != (($this->third[$key] + 2) % 40);
                $testSecond = $tmp != (($this->third[$key] - 2) % 40);
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
            $lp1Test = ((10 * $i) + $this->lp1) % 4;
            if ($lp1Test == $this->mod) {
                $this->third[] = (10 * $i) + $this->lp1;
            }

            $lp2Test = ((10 * $i) + $this->lp2) % 4;
            if ($lp2Test == $this->mod) {
                $this->third[] = (10 * $i) + $this->lp2;
            }
        }

        return $this;
    }

    /**
     * Perform the calculation.
     *
     * @return $this
     * @throws UnexpectedValueException
     * @return MasterCrack
     */
    public function calc()
    {
        foreach (['lp1', 'lp2', 'resist'] as $var) {
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
}
