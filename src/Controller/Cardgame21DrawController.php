<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Cardgame21DrawController extends AbstractController
{
    #[Route("/game/play/draw", name: "game_draw", methods: ['POST'])]
    public function gameDraw(
        SessionInterface $session
    ): Response {
        $deck = $session->get("deck");
        $cardsLeft = $deck->getNumberCards();
        // if ($cardsLeft < 26 and $session->get("round_finished") === 1) {
        //     $this->addFlash(
        //         'notice',
        //         'Spelet är avslutat! Du kan inte dra fler kort!'
        //     );
        //     return $this->redirectToRoute('game_play');
        // }
        if ($session->get("round_finished")) {
            if ($cardsLeft < 26) {
                $this->addFlash(
                    'notice',
                    'Spelet är avslutat! Du kan inte dra fler kort!'
                );
                return $this->redirectToRoute('game_play');
            }
            $this->addFlash(
                'notice',
                'Du kan inte dra mer. Klicka på "Next Round"!'
            );
            return $this->redirectToRoute('game_play');
        }
        $player = $session->get("player");

        if ($player->fat($player->currentValues())) {
            $this->addFlash(
                'notice',
                'Du kan inte dra mer eftersom du är tjock! Klicka "Stand"'
            );
            return $this->redirectToRoute('game_play');
        }
        $player->draw($deck);

        return $this->redirectToRoute('game_play');
    }
}
