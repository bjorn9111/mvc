<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class BlackJackPlayerTest extends TestCase
{
    private mixed $stubHand;
    private BlackJackPlayer $player;

    /**
     * Call this template method before each test method is run.
     * Create BlackJackPlayer with stubs as hands.
     */
    protected function setUp(): void
    {
        // Create a stub for the CardGraphic class.
        $this->stubHand = $this->createMock(CardHand::class);

        $this->stubHand->method('getValues')
            ->willReturn([1,2,13,13]);

        $this->player = new BlackJackPlayer($this->stubHand);
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
        $blackJackPlayer = new BlackJackPlayer($this->stubHand);
        $this->assertInstanceOf("\App\Cardgame\BlackJackPlayer", $blackJackPlayer);

        $res = $this->player->getHand();
        $this->assertNotEmpty($res);
        $this->assertEquals($res, $this->stubHand);
    }

    /**
     * Verify currentValues work properly.
     */
    public function testCurrentValues(): void
    {
        $emptyStubHand = $this->createMock(CardHand::class);
        $emptyStubHand->method('getValues')
        ->willReturn([]);
        $blackJackPlayerEmpty = new BlackJackPlayer($emptyStubHand);
        $this->assertEmpty($blackJackPlayerEmpty->currentValues());

        $this->assertEquals([23,33],$this->player->currentValues());
    }
}