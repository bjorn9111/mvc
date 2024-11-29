<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjPlayController extends AbstractController
{
    #[Route("/proj/play", name: "proj_play")]
    public function gamePlay(
        SessionInterface $session
    ): Response {
        $roundFinished = $session->get("b_round_finished");

        if ($roundFinished) {
            $name = $session->get("now_playing");
            $playerMoney = $session->get('b_'.strtolower($name));
            return $this->render('proj/pick_number_hands.html.twig', [
                'name' => $name, 'credits' => $playerMoney]);
        }

        $quantity = $session->get("quantity");
        $routeName = 'proj_play'.strval($quantity);
        return $this->redirectToRoute($routeName);
    }

    #[Route("/proj/play/stakes", name: "proj_play_stakes")]
    public function gamePlayStakes(
        SessionInterface $session
    ): Response {

        $name = $session->get("now_playing");
        $playerMoney = $session->get('b_'.strtolower($name));
        return $this->render('proj/pick_stakes.html.twig', [
            'name' => $name, 'credits' => $playerMoney]);


        // $quantity = $session->get("quantity");
        // $routeName = 'proj_play'.strval($quantity);
        // return $this->redirectToRoute($routeName);
    }

    #[Route("/proj/play/one", name: "proj_play1")]
    public function gamePlayOne(
        SessionInterface $session
    ): Response {
        $name = $session->get("now_playing");
        $playerMoney = $session->get('b_'.strtolower($name));
        $player = $session->get("black_jack_player1");
        $dealer = $session->get("dealer");
        $message = 'Nu spelar hand nummer 1... Såklart vi har ju bara en hand i denna rundan!';
        if ($player->fat($player->currentValues())) {
            $message = 'Du blev tjock';
        }
        $data = [
            'draw' => $player->getHand()->getString(),
            'suit' => $player->getHand()->getSuits(),
            'dealer_draw' => $dealer->getHand()->getString(),
            'dealer_suit' => $dealer->getHand()->getSuits(),
            'name' => $name,
            'credits' => $playerMoney,
            'round_summary' => $session->get("round_summary"),
            'hand_playing' => $session->get("hand_playing"),
            'message' => $message
        ];
        return $this->render('proj/play.html.twig', $data);
    }

    #[Route("/proj/play/two", name: "proj_play2")]
    public function gamePlayTwo(
        SessionInterface $session
    ): Response {
        $name = $session->get("now_playing");
        $playerMoney = $session->get('b_'.strtolower($name));
        $player1 = $session->get("black_jack_player1");
        $player2 = $session->get("black_jack_player2");
        $dealer = $session->get("dealer");
        $handPlaying = $session->get('hand_playing');
        $nowPlaying = $session->get("black_jack_player".$handPlaying);
        $message = 'Nu spelar hand nummer '.$handPlaying;
        if ($nowPlaying->fat($nowPlaying->currentValues())) {
            $message = 'Hand nummer '.$handPlaying.' blev tjock';
        }

        $data = [
            'draw1' => $player1->getHand()->getString(),
            'draw2' => $player2->getHand()->getString(),
            'suit1' => $player1->getHand()->getSuits(),
            'suit2' => $player2->getHand()->getSuits(),
            'dealer_draw' => $dealer->getHand()->getString(),
            'dealer_suit' => $dealer->getHand()->getSuits(),
            'name' => $name,
            'credits' => $playerMoney,
            'round_summary' => $session->get("round_summary"),
            'message' => $message
        ];
        return $this->render('proj/play_two.html.twig', $data);
    }

    #[Route("/proj/play/three", name: "proj_play3")]
    public function gamePlayThree(
        SessionInterface $session
    ): Response {
        $name = $session->get("now_playing");
        $playerMoney = $session->get('b_'.strtolower($name));
        $player1 = $session->get("black_jack_player1");
        $player2 = $session->get("black_jack_player2");
        $player3 = $session->get("black_jack_player3");
        $dealer = $session->get("dealer");
        $handPlaying = $session->get('hand_playing');
        $nowPlaying = $session->get("black_jack_player".$handPlaying);
        $message = 'Nu spelar hand nummer '.$handPlaying;
        if ($nowPlaying->fat($nowPlaying->currentValues())) {
            $message = 'Hand nummer '.$handPlaying.' blev tjock';
        }
        $data = [
            'draw1' => $player1->getHand()->getString(),
            'draw2' => $player2->getHand()->getString(),
            'draw3' => $player3->getHand()->getString(),
            'suit1' => $player1->getHand()->getSuits(),
            'suit2' => $player2->getHand()->getSuits(),
            'suit3' => $player3->getHand()->getSuits(),
            'dealer_draw' => $dealer->getHand()->getString(),
            'dealer_suit' => $dealer->getHand()->getSuits(),
            'name' => $name,
            'credits' => $playerMoney,
            'round_summary' => $session->get("round_summary"),
            'hand_playing' => $session->get("hand_playing"),
            'message' => $message
        ];
        return $this->render('proj/play_three.html.twig', $data);
    }

    // #[Route("/proj/play/stand", name: "proj_stand", methods: ['POST'])]
    // public function gameStand(
    //     SessionInterface $session
    // ): Response {
    //     $handPlaying = $session->get("hand_playing");
    //     $quantity = $session->get("quantity");

    //     if ($handPlaying >= $quantity) {
    //         $deck = $session->get("deck");
    //         $dealer = $session->get("dealer");
    //         $dealer->drawFinish($deck);
    //         $session->set("round_summary", true);
    //         return $this->redirectToRoute('proj_play');
    //     }

    //     $handPlaying += 1;

    //     $session->set("hand_playing", $handPlaying);
    //     return $this->redirectToRoute('proj_play');


    //     // if ($dealer->dealerWins($black_jack_player->currentValues())) {
    //     //     $this->addFlash(
    //     //         'warning',
    //     //         'PLAYER LOOSES!'
    //     //     );
    //     //     return $this->redirectToRoute('game_play');
    //     // }
    //     // $this->addFlash(
    //     //     'success',
    //     //     'PLAYER WINS!'
    //     // );
    //     // }
    //     // $this->addFlash(
    //     //     'notice',
    //     //     'Rundan är redan avslutat. Klicka på "Next Round"!'
    //     // );
    //     // return $this->redirectToRoute('game_play');
    // }

    // #[Route("/proj/play/next", name: "proj_next_round", methods: ['POST'])]
    // public function nextRound(
    //     SessionInterface $session
    // ): Response {
    //     $roundFinished = $session->get("b_round_finished");
    //     if (! $roundFinished) {
    //         $playerHand1 = $session->get("black_jack_player1");
    //         $playerHand2 = $session->get("black_jack_player2");
    //         $playerHand3 = $session->get("black_jack_player3");
    //         $playerHand1->resetHand(new CardHand());
    //         $playerHand2->resetHand(new CardHand());
    //         $playerHand3->resetHand(new CardHand());
    //         $dealer = $session->get("dealer");
    //         $dealer->resetHand(new CardHand());
    //         $roundFinished = true;
    //         $session->set("b_round_finished", $roundFinished);
    //         return $this->redirectToRoute('proj_play');
    //     }
    //     $this->addFlash(
    //         'notice',
    //         'Rundan är inte avslutat. Klicka på "Stand"!'
    //     );
    //     return $this->redirectToRoute('proj_play');
    // }
}
