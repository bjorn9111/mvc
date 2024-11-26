<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Cardgame\{Card, CardGraphic, CardHand, DeckOfCards, Player, PlayerBank};

class Cardgame21Controller extends AbstractController
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
