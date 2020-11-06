<?php

namespace App\Models;

class Currency
{
    private string $name;
    private float $rate;

    public function __construct(string $name, float $rate)
    {
        $this->name = $name;
        $this->rate = $rate;
    }

        public function getName(): string
        {
            return $this->name;
        }

        public function getRate(): float
        {
            return $this->rate;
        }
}