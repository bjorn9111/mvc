<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class PlayerTest extends TestCase
{
    private mixed $stubHand;
    private Player $player;

    /**
     * Call this template method before each test method is run.
     * Create Cardhand with stubs as cards.
     */
    protected function setUp(): void
    {
        // Create a stub for the CardGraphic class.
        $this->stubHand = $this->createMock(CardHand::class);

        $this->stubHand->method('getValues')
            ->willReturn([1,2,13,13]);

        $this->player = new Player($this->stubHand);
    }

    protected function tearDown(): void
    {
        $this->stubHand = null;
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreatePlayer(): void
    {
        $this->assertInstanceOf("\App\Cardgame\Player", $this->player);

        $res = $this->player->getHand();
        $this->assertNotEmpty($res);
        $this->assertEquals($res, $this->stubHand);
    }

    /**
     * Control that hand can be reset.
     */
    public function testResetHand(): void
    {
        $newHand = $this->createMock(CardHand::class);
        $this->player->resetHand($newHand);

        $res = $this->player->getHand();
        $this->assertNotEmpty($res);
        $this->assertEquals($res, $newHand);
    }

    /**
     * Control that currentValues return correctly, for empty hand and with cards.
     *
     */
    public function testCurrentValues(): void
    {
        $emptyStubHand = $this->createMock(CardHand::class);
        $emptyStubHand->method('getValues')
        ->willReturn([]);
        $newPlayer = new Player($emptyStubHand);
        $resEmpty = $newPlayer->currentValues();
        // echo var_dump($resEmpty);
        $this->assertEquals($resEmpty, []);

        $this->player->currentValues();
        $resNotEmpty = $this->player->currentValues();
        $this->assertEquals($resNotEmpty, [29,42]);
    }

    /**
     * Control that player is fat (returns true) for high total values of hand.
     */
    public function testFat(): void
    {
        $this->assertFalse($this->player->fat([]));
        $this->assertFalse($this->player->fat([20]));
        $this->assertFalse($this->player->fat([8,21]));
        $this->assertTrue($this->player->fat([41]));
        $this->assertTrue($this->player->fat([29,42]));
    }
}
