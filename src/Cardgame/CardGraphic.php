<?php

namespace App\Cardgame;

// use App\Cardgame\Card;

class CardGraphic extends Card
{
    private string $representation;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
        $mdChrStart = 127136;
        foreach ($suits as $suit) {
            if ($suit === $this->suit) {
                if ($this->value > 11) {
                    return $this->representation = mb_chr((($mdChrStart + 1) + $this->value), "UTF-8");
                }
                return $this->representation = mb_chr(($mdChrStart + $this->value), "UTF-8");
            }
            $mdChrStart += 16;
        }
        return $this->representation;
        // if ('Spades' === $this->suit) {
        //     if ($this->value > 11) {
        //         return $this->representation = mb_chr((127137 + $this->value), "UTF-8");
        //     }
        //     return $this->representation = mb_chr((127136 + $this->value), "UTF-8");
        // }

        // if ('Hearts' === $this->suit) {
        //     if ($this->value > 11) {
        //         return $this->representation = mb_chr((127153 + $this->value), "UTF-8");
        //     }
        //     return $this->representation = mb_chr((127152 + $this->value), "UTF-8");
        // }

        // if ('Diamonds' === $this->suit) {
        //     if ($this->value > 11) {
        //         return $this->representation = mb_chr((127169 + $this->value), "UTF-8");
        //     }
        //     return $this->representation = mb_chr((127168 + $this->value), "UTF-8");
        // }

        // if ($this->value > 11) {
        //     return $this->representation = mb_chr((127185 + $this->value), "UTF-8");
        // }
        // $this->representation = mb_chr((127184 + $this->value), "UTF-8");
        // return $this->representation;
    }
}
