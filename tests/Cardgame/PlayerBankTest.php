<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class PlayerBankTest extends TestCase
{
    private mixed $stubHand;
    private PlayerBank $playerBank;

    /**
     * Call this template method before each test method is run.
     * Create Cardhand with stubs as cards.
     */
    protected function setUp(): void
    {
        // Create a stub for the CardGraphic class.
        $this->stubHand = $this->createMock(CardHand::class);

        $this->stubHand->method('getValues')
            ->willReturn([1,5]);

        $this->playerBank = new PlayerBank($this->stubHand);
    }

    protected function tearDown(): void
    {
        $this->stubHand = null;
    }

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreatePlayerBank(): void
    {
        $this->assertInstanceOf("\App\Cardgame\PlayerBank", $this->playerBank);

        $res = $this->playerBank->getHand();
        $this->assertNotEmpty($res);
        $this->assertEquals($res, $this->stubHand);
    }

    /**
     * Control is bank wins when it should.
     */
    public function testBankWins(): void
    {
        $this->assertFalse($this->playerBank->bankWins([21]));
        $this->assertFalse($this->playerBank->bankWins([20]));
        $this->assertTrue($this->playerBank->bankWins([16,26]));
        $this->assertTrue($this->playerBank->bankWins([25]));
    }
}
