<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    /**
    * @var int $number Random number between 0 and 3..
    */
    private $number;

    /**
    * @var array<string> $quotes An array with text quotes
    */
    private $quotes;

    /**
     * @Route("/api/quote")
     */
    #[Route("/api/quote")]
    public function jsonApi(): Response
    {
        $this->number = random_int(0, 4);

        $this->quotes = [
            'Du kan inte skydda dig själv från sorg utan att skydda dig själv från lycka.',
            'Vakna. Träna. Se het ut. Kick ass.',
            'Du behöver inte vara extrem, bara konsekvent.',
            'Att ursäkta bränner noll kalorier per timme.',
            'Var inte rädd för att vara nybörjare.',
        ];

        $data = [
            'lucky-message' => $this->quotes[$this->number],
            'lucky-day' => date("Y-m-d"),
            'lucky-time' => date("H:i:s"),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
