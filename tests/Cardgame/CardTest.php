<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Cardgame\Card", $card);

        $resValue = $card->getValue();
        $this->assertNull($resValue);
        $resSuit = $card->getSuit();
        $this->assertNull($resSuit);
    }

    /**
     * Use set value and assert values are valid after.
     */
    public function testSetValue(): void
    {
        $card = new Card();
        $card->setValue(5);
        $resValue = $card->getValue();
        $this->assertEquals($resValue, 5);
        $card->setSuit('Spades');
        $resSuit = $card->getSuit();
        $this->assertEquals($resSuit, 'Spades');
    }

    /**
     * Verify if getAsString works as intended,
     * also properly returning high and low values.
     */
    public function testGetAsString(): void
    {
        $card = new Card();
        $card->setValue(5);
        $card->setSuit('Spades');
        $resValue = $card->getAsString();
        $this->assertEquals($resValue, '5 of Spades');
        $card->setValue(1);
        $card->setSuit('Hearts');
        $resLowValue = $card->getAsString();
        $this->assertEquals($resLowValue, 'Ace of Hearts');
        $card->setValue(11);
        $card->setSuit('Diamonds');
        $resHighValue = $card->getAsString();
        $this->assertEquals($resHighValue, 'Jack of Diamonds');
        $card->setValue(12);
        $card->setSuit('Diamonds');
        $resHighValue = $card->getAsString();
        $this->assertEquals($resHighValue, 'Queen of Diamonds');
        $card->setValue(13);
        $card->setSuit('Diamonds');
        $resHighValue = $card->getAsString();
        $this->assertEquals($resHighValue, 'King of Diamonds');
    }

    /**
     * Draw the card and assert value is within bounds.
     */
    public function testDraw(): void
    {
        $card = new Card();
        $card->draw();
        $resValue = $card->getValue();
        $resSuit = $card->getSuit();
        $this->assertContains($resValue, range(1, 13));
        $this->assertContains($resSuit, ['Spades', 'Hearts', 'Diamonds', 'Clubs']);
    }
}
