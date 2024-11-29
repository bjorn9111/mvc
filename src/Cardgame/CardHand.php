<?php

namespace App\Cardgame;

class CardHand
{
    /**
    * @var array<mixed> $hand The hand which will contain cards.
    */
    private $hand = [];

    public function add(CardGraphic $card): void
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

    /**
     *  Get values for cards in hand.
     *
     * @return array<int>
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

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

    /**
     * Get number of cards in hand.
     *
     * @return int Number of cards
     */
    public function getNumberCards(): int
    {
        if ($this->hand === []) {
            return 0;
        }
        return count($this->hand);
    }

}
