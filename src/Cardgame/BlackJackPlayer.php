<?php

namespace App\Cardgame;

class BlackJackPlayer extends Player
{
    /**
     * Constructor for BlackJackPlayer. Calls on parant constructor(class: Player).
     *
     * @param CardHand $hand The hand.
     */
    public function __construct(CardHand $hand)
    {
        parent::__construct($hand);
    }

    /**
     * Override method currentValues to fit values of cards in a game of Black Jack.
     * This means Ace is worth 11 instead of 14, and Jack, Queen, King is worth
     * 10 instead of 11,12,13.
     *
     * @return array<int> The total value of hand in an array of possible values.
     */
    public function currentValues(): array
    {
        $values = $this->hand->getValues();
        if ($values === []) {
            return [];
        }
        $values = $this->dressedCards($values);

        $totalValues = [0];
        foreach ($values as $value) {
            $totalValues[0] += $value;
            if (1 === $value) {
                $totalValues[] = 0;
            }
        }
        foreach (array_keys($totalValues) as $key) {
            $totalValues[$key] = $totalValues[0] + $key * 10;
        }
        return $totalValues;
    }

    /**
     * Change value of Jack, Queen, King which now is worth
     * 10 instead of 11,12,13. Helper function in currentValues.
     *
     * @param array<int> $arrayWithValues An array with original values of cards.
     *
     * @return array<int> An array with new values which are different for dressed cards.
     */
    private function dressedCards(array $arrayWithValues): array
    {
        foreach ($arrayWithValues as $index => $value) {
            if (in_array($value, [11, 12, 13])) {
                $arrayWithValues[$index] = 10;
            }
        }
        return $arrayWithValues;
    }
}
