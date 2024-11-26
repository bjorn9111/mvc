<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Cardgame\{CardGraphic, CardHand, DeckOfCards, Player, PlayerBank};

class Cardgame21InitController extends AbstractController
{
    #[Route("/game", name: "game_start")]
    public function gameStart(): Response
    {
        return $this->render('cardgame/start.html.twig');
    }

    #[Route("/game/init", name: "game_init")]
    public function gameInit(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $player = new Player(new CardHand());
        $bank = new PlayerBank(new CardHand());
        $gameRound = 1;
        $playerWins = 0;
        $bankWins = 0;
        $roundFinished = 0;

        for ($i = 1; $i <= 52; $i++) {
            $deck->add(new CardGraphic());
        }

        $deck->createDeck();
        $deck->shuffle();

        // Set session
        $session->set("deck", $deck);
        $session->set("player", $player);
        $session->set("bank", $bank);
        $session->set("game_round", $gameRound);
        $session->set("player_wins", $playerWins);
        $session->set("bank_wins", $bankWins);
        $session->set("round_finished", $roundFinished);

        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(
    ): Response {
        return $this->render('cardgame/doc.html.twig');
    }
}
