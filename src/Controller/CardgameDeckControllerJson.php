<?php

namespace App\Controller;

use App\Cardgame\{CardGraphic, CardHand, DeckOfCards};
use Symfony\Component\HttpFoundation\{JsonResponse, Response};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardgameDeckControllerJson
{
    #[Route("/api/deck", methods: ['GET'])]
    public function deck(): Response
    {
        $deck = new DeckOfCards();

        for ($i = 1; $i <= 52; $i++) {
            $deck->add(new CardGraphic());
        }

        $deck->createDeck();
        $suit = $deck->getSuits();
        $deckGraphic = $deck->getDeckAsString();

        $data = [
            'deckGraphic' => $deckGraphic,
            'suit' => $suit
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/shuffle", methods: ['POST'])]
    public function shuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $hand = new CardHand();

        for ($i = 1; $i <= 52; $i++) {
            $deck->add(new CardGraphic());
        }

        $deck->createDeck();
        $deck->shuffle();

        // Set session
        $session->set("deck", $deck);
        $session->set("hand", $hand);

        $deckGraphicShuffled = $deck->getDeckAsString();
        $suit = $deck->getSuits();
        $data = [
            'deckGraphicShuffled' => $deckGraphicShuffled,
            'suit' => $suit
        ];

        $response = new JsonResponse($data, JsonResponse::HTTP_CREATED);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
