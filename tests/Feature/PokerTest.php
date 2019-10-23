<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Poker;

class PockerTest extends TestCase
{
    /** @test */
    public function countGeneratedData()
    {
        $deck = (new Poker)->deck();

        $this->assertCount(52, $deck);
        $this->assertIsIterable($deck);
    }

    /** @test */
    public function generateRandomDecks()
    {
        $deck1 = (new Poker)->deck();
        $deck2 = (new Poker)->deck();

        $this->assertEquals(count($deck1), count($deck2));

        $deck1_str = implode(',', $deck1);
        $deck2_str = implode(',', $deck2);

        $this->assertNotEquals($deck1_str, $deck2_str);
    }

    /** @test */
    public function checkChanceCalculations()
    {
        $response = $this->post('/', [
            'suit' => 'S',
            'value' => '7',
            'selected_card' => 'S8',
            'selected_cards' => 'S2,DJ,H10,HQ,C6,DK'
        ]);

        $data = $response->getOriginalContent()->getData();

        // make sure it loads
        $response->assertStatus(200);

        // check the returned data
        $this->assertEquals($data['suit'], 'S');
        $this->assertEquals($data['value'], '7');
        $this->assertEquals($data['selected_card'], 'S8');
        $this->assertEquals($data['selected_cards'], 'S8,' . 'S2,DJ,H10,HQ,C6,DK');
        $this->assertCount(52, explode(',', $data['deck']));
        $this->assertEquals($data['chance'], round(1 / (52 - 7) * 100, 2));

    }
}

/* [
    'suit', 'value', 'selected_card', 'selected_cards', 'deck', 'chance'
] */