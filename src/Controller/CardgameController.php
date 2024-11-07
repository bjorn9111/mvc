<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Cardgame\{Card, CardGraphic, CardHand, DeckOfCards};

class CardgameController extends AbstractController
{
    #[Route("/session", name: "session")]
    public function session(
        SessionInterface $session
    ): Response {

        $data = [
            'session' => $session
        ];

        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "delete_session")]
    public function deleteSession(
        Request $request,
    ): Response {
        $request->getSession()->clear();
        $this->addFlash(
            'success',
            'nu är sessionen raderad'
        );

        return $this->redirectToRoute('session');
    }

    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('cardgame/card.html.twig');
    }

    #[Route("/card/deck", name: "deck")]
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
        return $this->render('cardgame/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffle")]
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

        return $this->render('cardgame/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "draw")]
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

        return $this->render('cardgame/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{number<\d+>}", name: "draw_number")]
    public function drawNumber(
        int $number,
        SessionInterface $session
    ): Response {
        if ($number > 52) {
            $this->addFlash(
                'notice',
                'Du försökte dra fler kort än det kan finnas i en kortlek. Inte okej!'
            );
            return $this->redirectToRoute('card');
        }

        // Get deck form session
        $deck = $session->get("deck");
        $hand = $session->get("hand");

        $cardsLeft = $deck->getNumberCards();
        if ($number > $cardsLeft) {
            $this->addFlash(
                'notice',
                'Det finns inte så många kort kvar i kortleken!'
            );
        }
        if ($number <= $cardsLeft) {
            $deck->draw($hand, $number);
            $cardsLeft = $deck->getNumberCards();
        }
        $draw = $hand->getString();
        $suit = $hand->getSuits();

        $data = [
            'draw' => $draw,
            'cardsLeft' => $cardsLeft,
            'suit' => $suit
        ];
        return $this->render('cardgame/draw_number.html.twig', $data);
    }
}
