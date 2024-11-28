<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Cardgame\CardHand;

class ProjStandNextController extends AbstractController
{
    #[Route("/proj/play/stand", name: "proj_stand", methods: ['POST'])]
    public function gameStand(
        SessionInterface $session
    ): Response {
        $handPlaying = $session->get("hand_playing");
        $quantity = $session->get("quantity");

        if ($handPlaying >= $quantity) {
            $deck = $session->get("deck");
            $dealer = $session->get("dealer");
            $dealer->drawFinish($deck);
            $session->set("round_summary", true);
            return $this->redirectToRoute('proj_play');
        }

        $handPlaying += 1;

        $session->set("hand_playing", $handPlaying);
        return $this->redirectToRoute('proj_play');


        // if ($dealer->dealerWins($black_jack_player->currentValues())) {
        //     $this->addFlash(
        //         'warning',
        //         'PLAYER LOOSES!'
        //     );
        //     return $this->redirectToRoute('game_play');
        // }
        // $this->addFlash(
        //     'success',
        //     'PLAYER WINS!'
        // );
        // }
        // $this->addFlash(
        //     'notice',
        //     'Rundan är redan avslutat. Klicka på "Next Round"!'
        // );
        // return $this->redirectToRoute('game_play');
    }

    #[Route("/proj/play/next", name: "proj_next_round", methods: ['POST'])]
    public function nextRound(
        SessionInterface $session
    ): Response {
        $roundFinished = $session->get("b_round_finished");
        // if (false === $roundFinished) {
        $playerHand1 = $session->get("black_jack_player1");
        $playerHand2 = $session->get("black_jack_player2");
        $playerHand3 = $session->get("black_jack_player3");
        $playerHand1->resetHand(new CardHand());
        $playerHand2->resetHand(new CardHand());
        $playerHand3->resetHand(new CardHand());
        $dealer = $session->get("dealer");
        $dealer->resetHand(new CardHand());
        $roundFinished = true;
        $session->set("b_round_finished", $roundFinished);
        //     return $this->redirectToRoute('proj_play');
        // }
        // $this->addFlash(
        //     'notice',
        //     'Rundan är inte avslutat. Klicka på "Stand"!'
        // );
        return $this->redirectToRoute('proj_play');
    }
}
