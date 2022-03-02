<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pet;
use Mockery\MockInterface;

class PetTest extends TestCase {

    private MockInterface $petSpy;

    protected function setUp(): void {
        parent::setUp();
        $this->petSpy = $this->spy(Pet::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_example() {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_toString()
    {
        //arrange
        $this->petSpy->shouldReceive('getPets')
        ->once() // number of times method should be called
        ->andReturn([
            new Pet([1], 'Nemo', '5', 'fish'),
            ]);

        //act
        $response = $this->get('/pets');

        $expectedResponse = 'Nemo is a 5 year old fish.';

        //assert
        $response->assertEquals($this,$expectedResponse);
        }
    }
