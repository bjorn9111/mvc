<?php

namespace App\Cardgame;

use App\Cardgame\CardGraphic as Card;

class CardHand
{
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    // public function draw(): void
    // {
    //     foreach ($this->hand as $card) {
    //         $card->draw();
    //     }
    // }

    // public function getNumberCards(): int
    // {
    //     return count($this->hand);
    // }

    // public function getValues(): array
    // {
    //     $values = [];
    //     foreach ($this->hand as $card) {
    //         $values[] = $card->getValue();
    //     }
    //     return $values;
    // }

    public function getSuits(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getSuit();
        }
        return $values;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}
