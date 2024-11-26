<?php

namespace App\Cardgame;

class Card
{
    protected ?int $value;
    protected ?string $suit;

    public function __construct()
    {
        $this->value = null;
        $this->suit = null;
    }

    public function draw(): void
    {
        $suit = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
        $this->value = random_int(1, 13);
        $this->suit = $suit[random_int(0, 3)];
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function getSuit(): ?string
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
        if (1 === $this->value) {
            return "Ace of {$this->suit}";
        }
        if (11 === $this->value) {
            return "Jack of {$this->suit}";
        }
        if (12 === $this->value) {
            return "Queen of {$this->suit}";
        }
        if (13 === $this->value) {
            return "King of {$this->suit}";
        }
        return "{$this->value} of {$this->suit}";
    }
}
