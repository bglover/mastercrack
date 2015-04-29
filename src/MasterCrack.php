<?php
namespace Access9;

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
     */
    private function setFirst()
    {
        if (!isset($this->resist)) {
            throw new Exception(
                'The resistance must be set before the first combination can be '
                . 'calculated.'
            );
        }

        $this->first = (ceil($this->resist) + 5) % 40;
    }

    /**
     * Set the mod to be used in the calculation
     * of the second and first digit.
     */
    private function setMod()
    {
        if (!isset($this->first)) {
            throw new Exception(
                'The first combination must be set before the modulus can be '
                . 'calculated.'
            );
        }

        $this->mod = $this->first % 4;
        return $this;
    }

    /**
     * Sets the second combination.
     *
     * @param int $checkDigit
     */
    private function setSecond($checkDigit = null)
    {
        if (!isset($this->third)) {
            throw new Exception(
                'The combination third must first be calculated to find the '
                . 'second combination.'
            );
        }

        $mod = ($this->mod + 2) % 4;
        for ($i = 0; $i < 10; $i++)
        {
            $tmp     = $mod + (4 * $i);
            $testFirst = 0;
            $testSecond = 0;

            if ($checkDigit) {
                $key     = $checkDigit - 1;
                $testFirst = $tmp != (($this->third[$key] + 2) % 40);
                $testSecond = $tmp != (($this->third[$key] - 2) % 40);
            }

            if (!$checkDigit || $testFirst && $testSecond) {
                $this->second[] = $tmp;
            }
        }
    }

    /**
     * Set the third number of the combination
     */
    private function setThird()
    {
        for ($i = 0; $i < 4; $i++) {
            if (((10 * $i) + $this->lp1) % 4 == $this->mod) {
                $this->third[] = (10 * $i) + $this->lp1;
            }

            if (((10 * $i) + $this->lp2) % 4 == $this->mod) {
                $this->third[] = (10 * $i) + $this->lp2;
            }
        }
    }

    public function calc()
    {
        $vars = ['lp1', 'lp2', 'resist'];
        foreach ($vars as $var) {

            if (!isset($this->{$var})) {
                throw new Exception(
                    'Can not continue: ' . $var . ' value not set.'
                );
            }
        }

        $this->setFirst();
        $this->setMod();
        $this->setThird();
        $this->setSecond();
    }

    public function getFirst()
    {
        return $this->first;
    }

    public function getSecond()
    {
        return $this->second;
    }

    public function getThird()
    {
        return $this->third;
    }
}

