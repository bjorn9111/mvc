<?php

namespace App\Cardgame;

use App\Cardgame\Card;
use App\Cardgame\CardGraphic;
use App\Cardgame\CardHand;
use Exception;

class DeckOfCards
{
    /**
    * @var array<mixed> $deck The deck which will contain cards.
    */
    private $deck = [];

    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function createDeck(): void
    {
        if (count($this->deck) !== 52) {
            throw new Exception("You need exactly 52 cards to
            print a deck!");
        }

        for ($i = 1; $i <= 52; $i++) {
            if ($i <= 13) {
                $this->deck[$i - 1]->setValue($i);
                $this->deck[$i - 1]->setSuit('Spades');
                continue;
            }
            if ($i <= 26) {
                $this->deck[$i - 1]->setValue($i - 13);
                $this->deck[$i - 1]->setSuit('Hearts');
                continue;
            }
            if ($i <= 39) {
                $this->deck[$i - 1]->setValue($i - 26);
                $this->deck[$i - 1]->setSuit('Diamonds');
                continue;
            }
            $this->deck[$i - 1]->setValue($i - 39);
            $this->deck[$i - 1]->setSuit('Clubs');
            // if ($i <= 13) {
            //     $this->deck[$i - 1]->setValue($i);
            //     $this->deck[$i - 1]->setSuit('Spades');
            // } elseif (13 < $i && 26 >= $i) {
            //     $this->deck[$i - 1]->setValue($i - 13);
            //     $this->deck[$i - 1]->setSuit('Hearts');
            // } elseif (26 < $i && 39 >= $i) {
            //     $this->deck[$i - 1]->setValue($i - 26);
            //     $this->deck[$i - 1]->setSuit('Diamonds');
            // } else {
            //     $this->deck[$i - 1]->setValue($i - 39);
            //     $this->deck[$i - 1]->setSuit('Clubs');
            // }
        }
    }

    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    public function draw(CardHand $hand, int $number = 1): void
    {
        if ([] !== $this->deck) {
            for ($i = 0; $i < $number; $i++) {
                $hand->add($this->deck[0]);
                array_splice($this->deck, 0, 1);
            }
        }
    }

    public function randomDraw(CardHand $hand, int $number = 1): void
    {
        if ([] !== $this->deck) {
            if (1 === $number) {
                $randomKey = array_rand($this->deck, 1);
                $hand->add($this->deck[$randomKey]);
                unset($this->deck[$randomKey]);
            }
            $randomKeys = array_rand($this->deck, $number);
            $randomKeys = (array) $randomKeys;
            foreach ($randomKeys as $randomKey) {
                $hand->add($this->deck[$randomKey]);
                unset($this->deck[$randomKey]);
            }
        }
    }

    public function getNumberCards(): int
    {
        if ($this->deck === []) {
            return 0;
        }
        return count($this->deck);
    }

    /**
     *  Get suits for cards in deck.
     *
     * @return array<null|string>
     */
    public function getSuits(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getSuit();
        }
        return $values;
    }

    /**
     *  Get text representation for cards in deck.
     *
     * @return array<null|string>
     */
    public function getDeckAsString(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}
