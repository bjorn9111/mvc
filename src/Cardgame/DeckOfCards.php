<?php

namespace App\Cardgame;

use App\Cardgame\Card;
use App\Cardgame\CardGraphic;
use App\Cardgame\CardHand;

class DeckOfCards
{
    private $deck = [];

    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function createDeck(): void
    {
        if (count($this->deck) !== 52) {
            throw new \Exception("You need exactly 52 cards to
            print a deck!");
        }

        for ($i = 1; $i <= 52; $i++) {
            if ($i <= 13) {
                $this->deck[$i - 1]->setValue($i);
                $this->deck[$i - 1]->setSuit('Spades');
            } elseif (13 < $i && 26 >= $i) {
                $this->deck[$i - 1]->setValue($i - 13);
                $this->deck[$i - 1]->setSuit('Hearts');
            } elseif (26 < $i && 39 >= $i) {
                $this->deck[$i - 1]->setValue($i - 26);
                $this->deck[$i - 1]->setSuit('Diamonds');
            } else {
                $this->deck[$i - 1]->setValue($i - 39);
                $this->deck[$i - 1]->setSuit('Clubs');
            }
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
                $random_key = array_rand($this->deck, 1);
                $hand->add($this->deck[$random_key]);
                unset($this->deck[$random_key]);
            } else {
                $random_keys = array_rand($this->deck, $number);
                foreach ($random_keys as $random_key) {
                    $hand->add($this->deck[$random_key]);
                    unset($this->deck[$random_key]);
                }
            }
        }
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

    public function getSuits(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getSuit();
        }
        return $values;
    }

    public function getDeckAsString(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}
