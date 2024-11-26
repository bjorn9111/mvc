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

    // #[Route("/api/deck", methods: ['GET'])]
    // public function deck(): Response
    // {
    //     $deck = new DeckOfCards();

    //     for ($i = 1; $i <= 52; $i++) {
    //         $deck->add(new CardGraphic());
    //     }

    //     $deck->createDeck();
    //     $suit = $deck->getSuits();
    //     $deckGraphic = $deck->getDeckAsString();

    //     $data = [
    //         'deckGraphic' => $deckGraphic,
    //         'suit' => $suit
    //     ];

    //     $response = new JsonResponse($data);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT
    //     );

    //     return $response;
    // }

    // #[Route("/api/deck/shuffle", methods: ['POST'])]
    // public function shuffle(
    //     SessionInterface $session
    // ): Response {
    //     $deck = new DeckOfCards();
    //     $hand = new CardHand();

    //     for ($i = 1; $i <= 52; $i++) {
    //         $deck->add(new CardGraphic());
    //     }

    //     $deck->createDeck();
    //     $deck->shuffle();

    //     // Set session
    //     $session->set("deck", $deck);
    //     $session->set("hand", $hand);

    //     $deckGraphicShuffled = $deck->getDeckAsString();
    //     $suit = $deck->getSuits();
    //     $data = [
    //         'deckGraphicShuffled' => $deckGraphicShuffled,
    //         'suit' => $suit
    //     ];

    //     $response = new JsonResponse($data, JsonResponse::HTTP_CREATED);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT
    //     );

    //     return $response;
    // }

    // #[Route("/api/deck/draw", methods: ['POST'])]
    // public function draw(
    //     SessionInterface $session
    // ): Response {
    //     // Get deck form session
    //     $deck = $session->get("deck");
    //     $hand = $session->get("hand");

    //     $deck->draw($hand);
    //     $cardsLeft = $deck->getNumberCards();
    //     $draw = $hand->getString();
    //     $suit = $hand->getSuits();

    //     $data = [
    //         'draw' => $draw,
    //         'cardsLeft' => $cardsLeft,
    //         'suit' => $suit
    //     ];

    //     $response = new JsonResponse($data);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT
    //     );

    //     return $response;
    // }

    // #[Route("/api/deck/draw/number", methods: ['POST'])]
    // public function drawNumber(
    //     Request $request,
    //     SessionInterface $session
    // ): Response {
    //     $number = $request->request->get('number');

    //     // Get deck form session
    //     $deck = $session->get("deck");
    //     $hand = $session->get("hand");

    //     $cardsLeft = $deck->getNumberCards() - $number;
    //     if (0 <= $cardsLeft) {
    //         $deck->draw($hand, $number);
    //     }
    //     if (0 > $cardsLeft) {
    //         $deck->draw($hand, $deck->getNumberCards());
    //     }
    //     $cardsLeft = $deck->getNumberCards();
    //     $draw = $hand->getString();
    //     $suit = $hand->getSuits();
    //     $data = [
    //         'draw' => $draw,
    //         'cardsLeft' => $cardsLeft,
    //         'suit' => $suit
    //     ];
    //     $response = new JsonResponse($data);
    //     $response->setEncodingOptions(
    //         $response->getEncodingOptions() | JSON_PRETTY_PRINT
    //     );

    //     return $response;
    // }

}
