<?php

namespace App\Cardgame;

use App\Cardgame\CardHand;

class PlayerBank extends Player
{
    public function __construct(CardHand $hand)
    {
        parent::__construct($hand);
    }

    /**
     * Bank draws card until 17 or higher.
     * If above 21 stop drawing.
     *
     * @param DeckOfCards $deck The card drawn by the bank.
     */
    public function draw(DeckOfCards $deck): void
    {
        $deck->draw($this->hand);

        while ((min($this->currentValues()) <= 21)
        and (($this->findRestTo21($this->currentValues())) > 4)) {
            $deck->draw($this->hand);
        }
    }

    /**
     * Determine if bank is the winner.
     *
     * @param array<int> $playerValues All possible values of player hand.
     *
     * @return bool True if the bank wins.
     */
    public function bankWins(array $playerValues): bool
    {

        if (min($this->currentValues()) > 21) {
            return false;
        }

        if (min($playerValues) > 21) {
            return true;
        }

        if ($this->findRestTo21($playerValues) < $this->findRestTo21(
            $this->currentValues()
        )) {
            return false;
        }
        return true;
    }

    /**
     * Find minimum remaining value to 21. Helper function in bankWins
     * and draw.
     *
     * @param array<int> $arrayWithInt All possible values.
     *
     * @return int The minimum remaining value to 21 as an int.
     */
    private function findRestTo21(array $arrayWithInt): int
    {
        foreach ($arrayWithInt as $index => $rest) {
            if ($rest <= 21) {
                $arrayWithInt[$index] = 21 - $rest;
            }
        }
        return min($arrayWithInt);
    }

    // /**
    //  * Do operation 21 % value for each value in an array<int>,
    //  * Look if rest is higher than 4.
    //  * Helper function in draw to determine if value is 17-21.
    //  *
    //  * @param array<int> The array with int values.
    //  *
    //  * @return bool True if value is in the range 17-21.
    //  */
    // private function find
}
