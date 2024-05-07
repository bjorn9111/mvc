<?php

namespace App\Cardgame;

use App\Cardgame\Card;

class CardGraphic extends Card
{
    private $representation;

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        $spadesRepresentation = [
            mb_chr(127137, "UTF-8"),
            mb_chr(127138, "UTF-8"),
            mb_chr(127139, "UTF-8"),
            mb_chr(127140, "UTF-8"),
            mb_chr(127141, "UTF-8"),
            mb_chr(127142, "UTF-8"),
            mb_chr(127143, "UTF-8"),
            mb_chr(127144, "UTF-8"),
            mb_chr(127145, "UTF-8"),
            mb_chr(127146, "UTF-8"),
            mb_chr(127147, "UTF-8"),
            mb_chr(127149, "UTF-8"),
            mb_chr(127150, "UTF-8")
            ];

        $heartsRepresentation = [
            mb_chr(127153, "UTF-8"),
            mb_chr(127154, "UTF-8"),
            mb_chr(127155, "UTF-8"),
            mb_chr(127156, "UTF-8"),
            mb_chr(127157, "UTF-8"),
            mb_chr(127158, "UTF-8"),
            mb_chr(127159, "UTF-8"),
            mb_chr(127160, "UTF-8"),
            mb_chr(127161, "UTF-8"),
            mb_chr(127162, "UTF-8"),
            mb_chr(127163, "UTF-8"),
            mb_chr(127165, "UTF-8"),
            mb_chr(127166, "UTF-8")
            ];

        $diamondsRepresentation = [
            mb_chr(127169, "UTF-8"),
            mb_chr(127170, "UTF-8"),
            mb_chr(127171, "UTF-8"),
            mb_chr(127172, "UTF-8"),
            mb_chr(127173, "UTF-8"),
            mb_chr(127174, "UTF-8"),
            mb_chr(127175, "UTF-8"),
            mb_chr(127176, "UTF-8"),
            mb_chr(127177, "UTF-8"),
            mb_chr(127178, "UTF-8"),
            mb_chr(127179, "UTF-8"),
            mb_chr(127181, "UTF-8"),
            mb_chr(127182, "UTF-8")
            ];

        $clubsRepresentation = [
            mb_chr(127185, "UTF-8"),
            mb_chr(127186, "UTF-8"),
            mb_chr(127187, "UTF-8"),
            mb_chr(127188, "UTF-8"),
            mb_chr(127189, "UTF-8"),
            mb_chr(127190, "UTF-8"),
            mb_chr(127191, "UTF-8"),
            mb_chr(127192, "UTF-8"),
            mb_chr(127193, "UTF-8"),
            mb_chr(127194, "UTF-8"),
            mb_chr(127195, "UTF-8"),
            mb_chr(127197, "UTF-8"),
            mb_chr(127198, "UTF-8")
            ];

        if ('Spades' === $this->suit) {
            $this->representation = $spadesRepresentation[$this->value - 1];
        }

        if ('Hearts' === $this->suit) {
            $this->representation = $heartsRepresentation[$this->value - 1];
        }

        if ('Diamonds' === $this->suit) {
            $this->representation = $diamondsRepresentation[$this->value - 1];
        }

        if ('Clubs' === $this->suit) {
            $this->representation = $clubsRepresentation[$this->value - 1];
        }

        return $this->representation;
    }
}
