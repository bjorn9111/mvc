<?php

namespace App\Cardgame;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class BlackJackDealerTest extends TestCase
{
    private mixed $stubHand;
    private BlackJackDealer $dealer;

    /**
     * Call this template method before each test method is run.
     * Create BlackJackDealer with stubs as hands.
     */
    protected function setUp(): void
    {
        // Create a stub for the CardGraphic class.
        $this->stubHand = $this->createMock(CardHand::class);

        $this->stubHand->method('getValues')
            ->willReturn([1,2,13,13]);

        // $this->stubHand->method('getValues2')
        //     ->willReturn([11,11]);

        $this->dealer = new BlackJackDealer($this->stubHand);
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
        $blackJackDealer = new BlackJackDealer($this->stubHand);
        $this->assertInstanceOf("\App\Cardgame\BlackJackDealer", $blackJackDealer);

        $res = $this->dealer->getHand();
        $this->assertNotEmpty($res);
        $this->assertEquals($res, $this->stubHand);
    }

    /**
     * Verify moneyReturn work properly.
     */
    public function testMoneyReturn(): void
    {
        $this->assertEquals(0, $this->dealer->moneyReturn([22]));
        $this->assertEquals(2, $this->dealer->moneyReturn([20]));


        $newStubHand = $this->createMock(CardHand::class);
        $newStubHand->method('getValues')
        ->willReturn([11,11]);
        $blackJackDealerNew = new BlackJackDealer($newStubHand);
        $this->assertEquals(1, $blackJackDealerNew->moneyReturn([20]));
        $this->assertEquals(2, $blackJackDealerNew->moneyReturn([21]));
        $this->assertEquals(0, $blackJackDealerNew->moneyReturn([18]));

    }

    // /**
    //  * Verify blackjackPlayerWin work properly.
    //  */
    // public function testBlackjackPlayerWin(): void
    // {
    //     $newStubHand = $this->createMock(CardHand::class);
    //     $newStubHand->method('getValues')
    //     ->willReturn([11,11]);
    //     $blackJackDealerNew = new BlackJackDealer($newStubHand);

    //     $playerStub = $this->createMock(BlackJackPlayer::class);
    //     $playerStub->method('getHand')->method('getNumberCards')
    //     ->willReturn(2);
    //     $playerStub->method('currentValues')
    //     ->willReturn(11,21);


    //     $this->assertTrue($blackJackDealerNew->blackjackPlayerWin($playerStub));
    // }
}