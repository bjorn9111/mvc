<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Cardgame\{CardGraphic, CardHand, DeckOfCards, BlackJackPlayer, BlackJackDealer};

class ProjInitController extends AbstractController
{
    #[Route("/proj/init", name: "proj_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('proj/init.html.twig');
    }

    #[Route("/proj/init", name: "proj_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response {
        $name = $request->request->get('name');
        $name = (string) $name;
        if ($name) {
            $namePlayer = 'b_'.strtolower($name);
            if (! $session->has($namePlayer)) {
                $session->set($namePlayer, 500);
            }
            $playerMoney = $session->get($namePlayer);
            if ($playerMoney === 0) {
                $this->addFlash(
                    'warning',
                    'Player with name'.$name.' is broke!'
                );
                return $this->redirectToRoute('proj_init_get');
            }
            $this->addFlash(
                'notice',
                'Spelare med namn '.$name.' har '.$playerMoney.' krediter kvar'
            );

            // Set session
            $session->set("black_jack_player1", new BlackJackPlayer(new CardHand()));
            $session->set("black_jack_player2", new BlackJackPlayer(new CardHand()));
            $session->set("black_jack_player3", new BlackJackPlayer(new CardHand()));
            $session->set("dealer", new BlackJackDealer(new CardHand()));
            $session->set("b_round_finished", true);
            $session->set("now_playing", $name);

            return $this->redirectToRoute('proj_play');
        }

        $this->addFlash(
            'warning',
            'You need to fill in a name!'
        );
        return $this->redirectToRoute('proj_init_get');
    }

    #[Route("/proj/init/shuffle", name: "proj_init_shuffle", methods: ['POST'])]
    public function projShuffleDeck(
        Request $request,
        SessionInterface $session
    ): Response {

        $quantity = $request->request->get('quantity');

        if (! $quantity) {
            $this->addFlash(
                'warning',
                'You need pick a quantity!'
            );
            return $this->redirectToRoute('proj_play');
        }
        $session->set("quantity", $quantity);

        $deck = new DeckOfCards();
        for ($i = 1; $i <= 52; $i++) {
            $deck->add(new CardGraphic());
        }
        $deck->createDeck();
        $deck->shuffle();
        $session->set("deck", $deck);


        for ($i = 1; $i <= $quantity; $i++) {
            $player = $session->get("black_jack_player".strval($i));
            $player->draw($deck);
            $player->draw($deck);
        }

        $dealer = $session->get("dealer");

        $dealer->draw($deck);
        $session->set("b_round_finished", false);
        $session->set("hand_playing", 1);
        $session->set("round_summary", false);
        return $this->redirectToRoute('proj_play');
    }
}
