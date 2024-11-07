<?php

namespace App\Cardgame;

use App\Cardgame\CardHand;
use App\Cardgame\DeckOfCards;

class Player
{
    /**
     * @var CardHand $hand The card-hand the player holds.
     */
    protected $hand;

    public function __construct(CardHand $hand)
    {
        $this->hand = $hand;
    }

    /**
     * Getter for hand property.
     *
     * @return CardHand $hand The card hand object.
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * Player draw a card and add it to card-hand.
     *
     * @param DeckOfCards $deck The deck to draw card from
     * and add to hand held by player.
     */
    public function draw(DeckOfCards $deck): void
    {
        $deck->draw($this->hand);
    }

    /**
     * Get total value for cards in hand.
     * Adjust for best value if ace/aces are in hand.
     *
     * @return array<int> The total value of hand in an array of possible values.
     */
    public function currentValues(): array
    {
        $values = $this->hand->getValues();
        if ($values === []) {
            return [];
        }
        $totalValues = [0];
        foreach ($values as $value) {
            $totalValues[0] += $value;
            if (1 === $value) {
                $totalValues[] = 0;
            }
        }
        foreach (array_keys($totalValues) as $key) {
            $totalValues[$key] = $totalValues[0] + $key * 13;
        }

        // for ($i = 0; $i < count($totalValues); $i++) {
        //     $totalValues[$i] = $totalValues[0] + $i * 13;
        // }

        // foreach ($totalValues as $totalValue) {
        //     $totalValue += $value;
        // }
        // if (1 === $value) {
        //     $totalValues[] = $totalValues[0] + 13;
        // }
        return $totalValues;
    }

    /**
     * Reset player card-hand to an empty state.
     *
     * @param CardHand $hand The new empty card-hand the player holds.
     */
    public function resetHand(CardHand $hand): void
    {
        $this->hand = $hand;
    }

    /**
     * Find if player is fat.
     *
     * @param array<int> $arrayWithInt All possible values.
     *
     * @return bool Return true if player is fat.
     */
    public function fat(array $arrayWithInt): bool
    {
        if ($arrayWithInt === []) {
            return false;
        }
        foreach ($arrayWithInt as $value) {
            if ($value <= 21) {
                return false;
            }
        }
        return true;
    }
}
