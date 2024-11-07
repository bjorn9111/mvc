<?php

namespace App\Cardgame;

use App\Cardgame\CardGraphic as Card;

class CardHand
{
    /**
    * @var array<mixed> $hand The hand which will contain cards.
    */
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

    /**
     *  Get suits for cards in hand.
     *
     * @return array<null|string>
     */
    public function getSuits(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getSuit();
        }
        return $values;
    }

    /**
     *  Get text representation for cards in hand.
     *
     * @return array<null|string>
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}
