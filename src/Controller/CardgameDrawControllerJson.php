<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardgameDrawControllerJson
{
    #[Route("/api/deck/draw", methods: ['POST'])]
    public function draw(
        SessionInterface $session
    ): Response {
        // Get deck form session
        $deck = $session->get("deck");
        $hand = $session->get("hand");

        $deck->draw($hand);
        $cardsLeft = $deck->getNumberCards();
        $draw = $hand->getString();
        $suit = $hand->getSuits();

        $data = [
            'draw' => $draw,
            'cardsLeft' => $cardsLeft,
            'suit' => $suit
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route("/api/deck/draw/number", methods: ['POST'])]
    public function drawNumber(
        Request $request,
        SessionInterface $session
    ): Response {
        $number = $request->request->get('number');

        // Get deck form session
        $deck = $session->get("deck");
        $hand = $session->get("hand");

        $cardsLeft = $deck->getNumberCards() - $number;
        if (0 <= $cardsLeft) {
            $deck->draw($hand, $number);
        }
        if (0 > $cardsLeft) {
            $deck->draw($hand, $deck->getNumberCards());
        }
        $cardsLeft = $deck->getNumberCards();
        $draw = $hand->getString();
        $suit = $hand->getSuits();
        $data = [
            'draw' => $draw,
            'cardsLeft' => $cardsLeft,
            'suit' => $suit
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

}
