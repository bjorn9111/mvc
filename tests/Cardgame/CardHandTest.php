<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardHandTest extends TestCase
{
    private mixed $stub;
    private mixed $stub2;
    private CardHand $cardHand;

    /**
     * Call this template method before each test method is run.
     * Create Cardhand with stubs as cards.
     */
    protected function setUp(): void
    {
        // Create a stub for the CardGraphic class.
        $this->stub = $this->createMock(CardGraphic::class);
        $this->stub2 = $this->createMock(CardGraphic::class);

        // Configure the stub.
        $this->stub->method('getValue')
            ->willReturn(13);
        $this->stub->method('getSuit')
            ->willReturn('Hearts');
        $this->stub->method('getAsString')
            ->willReturn(mb_chr(127166, "UTF-8"));
        $this->stub2->method('getValue')
            ->willReturn(2);
        $this->stub2->method('getSuit')
            ->willReturn('Spades');
        $this->stub2->method('getAsString')
            ->willReturn(mb_chr(127138, "UTF-8"));

        $this->cardHand = new CardHand();
    }

    /**
     * Reset properties after each test.
     */
    protected function tearDown(): void
    {
        $this->stub = null;
        $this->stub2 = null;
    }

    /**
     * Add stubs to Cardhand.
     */
    public function addStubs(): void
    {
        $this->cardHand->add(clone $this->stub);
        $this->cardHand->add(clone $this->stub2);
    }

    /**
     * Verify if getSuits generates proper strings.
     *
     */
    public function testGetSuits(): void
    {
        $resNull = $this->cardHand->getSuits();
        $this->assertEmpty($resNull);
        $this->addStubs();
        $res = $this->cardHand->getSuits();
        $this->assertEquals($res, ['Hearts','Spades']);
    }

    /**
     * Verify if getValues generates proper values.
     *
     */
    public function testGetValues(): void
    {
        $resNull = $this->cardHand->getValues();
        $this->assertEmpty($resNull);
        $this->addStubs();
        $res = $this->cardHand->getValues();
        $this->assertEquals($res, [13,2]);
    }

    /**
     * Verify if GetString generates proper strings.
     *
     */
    public function testGetString(): void
    {
        $resNull = $this->cardHand->getString();
        $this->assertEmpty($resNull);
        $this->addStubs();
        $res = $this->cardHand->getString();
        $this->assertEquals($res, [mb_chr(127166, "UTF-8"),
        mb_chr(127138, "UTF-8")]);
    }

    /**
     * Verify if getNumberCards returns correct number.
     *
     */
    public function testGetNumberCards(): void
    {
        $resNull = $this->cardHand->getNumberCards();
        $this->assertEquals($resNull, 0);
        $this->addStubs();
        $res = $this->cardHand->getNumberCards();
        $this->assertEquals($res, 2);
    }
}
