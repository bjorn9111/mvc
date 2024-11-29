<?php

namespace App\Cardgame;

class BlackJackDealer extends BlackJackPlayer
{
    /**
     * Constructor for BlackJackDealer. Calls on parant constructor(class: BlackJackPlayer).
     *
     * @param CardHand $hand The hand.
     */
    public function __construct(CardHand $hand)
    {
        parent::__construct($hand);
    }

    /**
     * Dealer draws card until 17 or higher.
     * Always stop after, even with Ace.
     *
     * @param DeckOfCards $deck The card drawn by the dealer.
     */
    public function drawFinish(DeckOfCards $deck): void
    {
        $deck->draw($this->hand);

        while (max($this->currentValues()) < 17) {
            $deck->draw($this->hand);
        }
    }

    /**
     * Determine what the return on bet should be.
     * The dealer wins if both player and dealer have 17, 18 or 19.
     * At 20 or 21 neither wins.
     *
     * @param array<int> $playerValues All possible values of player hand.
     *
     * @return float Return of bet. 0 the dealer wins, 1 if neither wins and 2 if player wins.
     */
    public function moneyReturn(array $playerValues): float
    {
        if (min($playerValues) > 21) {
            return 0;
        }

        if (min($this->currentValues()) > 21) {
            return 2;
        }

        $playerRest = $this->findRestTo21($playerValues);
        $dealerRest = $this->findRestTo21($this->currentValues());

        if ($playerRest < $dealerRest) {
            return 2;
        }

        if ($playerRest === $dealerRest) {
            return 1;
        }

        return 0;
    }

    /**
     * Returns true if player gets Black Jack and dealer does not.
     * This will result in higher return on bet.
     *
     * @param BlackJackPlayer $player .
     *
     * @return bool true if Black Jack rule applies.
     */
    public function blackjackPlayerWin(BlackJackPlayer $player): bool
    {
        $playerCards = $player->getHand()->getNumberCards();
        $dealerCards = $this->getHand()->getNumberCards();
        $playerRest = $this->findRestTo21($player->currentValues());
        $dealerRest = $this->findRestTo21($this->currentValues());
        if ($playerCards === 2 and $playerRest === 0
            and $dealerCards !== 2 and $dealerRest !== 0) {
            return true;
        }
        return false;
    }

    /**
     * Find minimum remaining value to 21. Helper function in dealerWins
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
}
