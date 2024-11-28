<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjDrawController extends AbstractController
{
    #[Route("/proj/play/draw", name: "proj_draw", methods: ['POST'])]
    public function gameDraw(
        SessionInterface $session
    ): Response {
        // $cardsLeft = $deck->getNumberCards();

        // if ($session->get("round_finished")) {
        //     if ($cardsLeft < 26) {
        //         $this->addFlash(
        //             'notice',
        //             'Spelet är avslutat! Du kan inte dra fler kort!'
        //         );
        //         return $this->redirectToRoute('game_play');
        //     }
        //     $this->addFlash(
        //         'notice',
        //         'Du kan inte dra mer. Klicka på "Next Round"!'
        //     );
        //     return $this->redirectToRoute('game_play');
        // }
        $deck = $session->get("deck");
        $handPlaying = $session->get("hand_playing");
        $player = $session->get("black_jack_player".strval($handPlaying));

        if ($player->fat($player->currentValues())) {
            $this->addFlash(
                'notice',
                'Du kan inte dra mer eftersom du är tjock! Klicka "Stand"'
            );
            return $this->redirectToRoute('proj_play');
        }
        $player->draw($deck);

        return $this->redirectToRoute('proj_play');
    }

    // #[Route("/proj/play/draw/start", name: "proj_draw_start")]
    // public function gameDrawStart(
    //     SessionInterface $session
    // ): Response {
    //     $deck = $session->get("deck");

    //     $player = $session->get("black_jack_player");
    //     $player->draw($deck);
    //     $player->draw($deck);

    //     $dealer = $session->get("dealer");
    //     $dealer->draw($deck);

    //     return $this->redirectToRoute('proj_play');
    // }
}
