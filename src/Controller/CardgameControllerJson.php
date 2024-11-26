<?php

namespace App\Controller;

// use App\Cardgame\{Card, CardGraphic, CardHand, DeckOfCards};
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardgameControllerJson
{
    #[Route("/api/game", methods: ['GET'])]
    public function game(
        SessionInterface $session
    ): Response {
        $data = [
            'game_round' => $session->get("game_round"),
            'player_wins' => $session->get("player_wins"),
            'bank_wins' => $session->get("bank_wins")
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
