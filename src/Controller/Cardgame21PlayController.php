<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Cardgame\CardHand;

// use App\Cardgame\{Card, CardGraphic, CardHand, DeckOfCards, Player, PlayerBank};

class Cardgame21PlayController extends AbstractController
{
    #[Route("/game/play", name: "game_play")]
    public function gamePlay(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");
        $player = $session->get("player");
        $bank = $session->get("bank");

        $data = [
            'cards_left' => $deck->getNumberCards(),
            'draw' => $player->getHand()->getString(),
            'suit' => $player->getHand()->getSuits(),
            'bank_draw' => $bank->getHand()->getString(),
            'bank_suit' => $bank->getHand()->getSuits(),
            'game_round' => $session->get("game_round"),
            'player_wins' => $session->get("player_wins"),
            'bank_wins' => $session->get("bank_wins"),
            'currentValues' => $player->currentValues()
        ];

        return $this->render('cardgame/play.html.twig', $data);
    }

    #[Route("/game/play/stand", name: "game_stand", methods: ['POST'])]
    public function gameStand(
        SessionInterface $session
    ): Response {
        $roundFinished = $session->get("round_finished");
        if (!$roundFinished) {
            $deck = $session->get("deck");
            $player = $session->get("player");
            $bank = $session->get("bank");
            $bank->draw($deck);
            $roundFinished = 1;
            $session->set("round_finished", $roundFinished);

            if ($bank->bankWins($player->currentValues())) {
                $bankWins = $session->get("bank_wins");
                $bankWins += 1;
                $session->set("bank_wins", $bankWins);
                $this->addFlash(
                    'warning',
                    'PLAYER LOOSES!'
                );
                return $this->redirectToRoute('game_play');
            }
            $playerWins = $session->get("player_wins");
            $playerWins += 1;
            $session->set("player_wins", $playerWins);
            $this->addFlash(
                'success',
                'PLAYER WINS!'
            );
            return $this->redirectToRoute('game_play');
        }
        $this->addFlash(
            'notice',
            'Rundan är redan avslutat. Klicka på "Next Round"!'
        );
        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/play/next", name: "next_round", methods: ['POST'])]
    public function nextRound(
        SessionInterface $session
    ): Response {
        $roundFinished = $session->get("round_finished");
        if ($roundFinished) {
            $player = $session->get("player");
            $bank = $session->get("bank");
            $player->resetHand(new CardHand());
            $bank->resetHand(new CardHand());
            $gameRound = $session->get("game_round");
            $gameRound += 1;
            $session->set("game_round", $gameRound);
            $roundFinished = 0;
            $session->set("round_finished", $roundFinished);
            return $this->redirectToRoute('game_play');
        }
        $this->addFlash(
            'notice',
            'Rundan är inte avslutat. Klicka på "Stand"!'
        );
        return $this->redirectToRoute('game_play');
    }
}
