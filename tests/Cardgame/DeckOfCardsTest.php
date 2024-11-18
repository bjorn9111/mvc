<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DeckOfCardsTest extends TestCase
{
    private mixed $stub;
    private mixed $stubHand;
    private DeckOfCards $deckOfCards;

    /**
     * Call this template method before each test method is run.
     * Create Cardhand with stubs as cards.
     */
    protected function setUp(): void
    {
        // Create a stub for the CardGraphic class.
        $this->stub = $this->createMock(CardGraphic::class);
        $this->stubHand = $this->createMock(CardHand::class);

        // Configure the stub.
        $this->stub->method('getValue')
            ->willReturn(13);
        $this->stub->method('getSuit')
            ->willReturn('Hearts');
        $this->stub->method('getAsString')
            ->willReturn(mb_chr(127166, "UTF-8"));

        // $this->stubHand = new CardHand();
        $this->deckOfCards = new DeckOfCards();
        for ($i = 1; $i <= 52; $i++) {
            $this->deckOfCards->add(clone $this->stub);
        }
    }

    protected function tearDown(): void
    {
        $this->stub = null;
        $this->stubHand = null;
    }

    /**
     * Verify if getAsString generates proper string,
     * and raises proper out of range exception when value is too high.
     *
     */
    public function testCreateDeck(): void
    {
        $this->deckOfCards->createDeck();
        $this->assertNotEmpty($this->deckOfCards);
    }

    /**
     * Verify if getSuits generates proper strings.
     *
     */
    public function testGetSuits(): void
    {
        $res = $this->deckOfCards->getSuits();
        $this->assertEquals($res[0], 'Hearts');
        $this->assertEquals($res[25], 'Hearts');
        $this->assertNotEquals($res[51], 'Spades');
    }

    /**
     * Verify if getDeckAsString generates proper strings.
     *
     */
    public function testGetDeckAsString(): void
    {
        $res = $this->deckOfCards->getDeckAsString();
        $this->assertEquals($res[0], mb_chr(127166, "UTF-8"));
        $this->assertEquals($res[26], mb_chr(127166, "UTF-8"));
        $this->assertNotEquals($res[51], mb_chr(127167, "UTF-8"));
    }

    /**
     * Verify if draw works as intended.
     *
     * @depends testGetDeckAsString
     */
    public function testDraw(): void
    {
        $this->deckOfCards->draw($this->stubHand, 2);
        $resDeck = $this->deckOfCards->getDeckAsString();
        $this->assertEquals($resDeck[22], mb_chr(127166, "UTF-8"));
        $this->assertArrayNotHasKey(50, $resDeck);
        $this->assertArrayHasKey(49, $resDeck);
    }

    /**
     * Verify if randomDraw works as intended.
     *
     * @depends testGetDeckAsString
     */
    public function testRandomDraw(): void
    {
        $this->deckOfCards->randomDraw($this->stubHand);
        $resDeck = $this->deckOfCards->getDeckAsString();
        $this->assertEquals($resDeck[22], mb_chr(127166, "UTF-8"));
        $this->assertArrayNotHasKey(51, $resDeck);

        $this->deckOfCards->randomDraw($this->stubHand, 2);
        $resDeck = $this->deckOfCards->getDeckAsString();
        $this->assertEquals($resDeck[22], mb_chr(127166, "UTF-8"));
        $this->assertArrayNotHasKey(49, $resDeck);
    }

    /**
     * Verify if getNumberCards returns correct number of cards,
     * before and after drawing.
     *
     * @depends testDraw
     */
    public function testGetNumberCards(): void
    {
        $this->deckOfCards->draw($this->stubHand, 5);
        $resDeck = $this->deckOfCards->getNumberCards();
        $this->assertEquals($resDeck, 47);
    }
}
