<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCardGraphic(): void
    {
        $cardGraphic = new CardGraphic();
        $this->assertInstanceOf("\App\Cardgame\CardGraphic", $cardGraphic);
    }

    /**
     * Verify if getAsString generates proper string,
     * and raises proper out of range exception when value is too high.
     *
     */
    public function testGetAsString(): void
    {
        $cardGraphic = new CardGraphic();
        $cardGraphic->setValue(5);
        $cardGraphic->setSuit('Spades');
        $res = $cardGraphic->getAsString();
        $this->assertNotEmpty($res);
        $this->assertEquals($res, mb_chr(127141, "UTF-8"));
        $cardGraphic->setValue(1);
        $cardGraphic->setSuit('Diamonds');
        $res = $cardGraphic->getAsString();
        $this->assertEquals($res, mb_chr(127169, "UTF-8"));
        $cardGraphic->setValue(12);
        $cardGraphic->setSuit('Diamonds');
        $res = $cardGraphic->getAsString();
        $this->assertEquals($res, mb_chr(127181, "UTF-8"));
    }
}
