<?php

namespace App\Cardgame;

class Card
{
    protected $value;
    protected $suit;

    public function __construct()
    {
        $this->value = null;
        $this->suit = null;
    }

    public function draw(): void
    {
        // $valueAndSuit = [];
        $suit = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
        $this->value = random_int(1, 13);
        $this->suit = $suit[random_int(0, 3)];
        // $valueAndColor[] = $this->value;
        // $valueAndColor[] = $this->suit;
        // return [$this->value, $this->suit];
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function setSuit(string $suit): void
    {
        $this->suit = $suit;
    }

    public function getAsString(): string
    {
        if (1 === $this->value) $this->value = 'Ace';
        if (11 === $this->value) $this->value = 'Jack';
        if (12 === $this->value) $this->value = 'Queen';
        if (13 === $this->value) $this->value = 'King';
        return "{$this->value} of {$this->suit}";
    }
}
