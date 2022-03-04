<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pet;
use Mockery\MockInterface;
use App\Contracts\PetService;

class PetControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private static function getPets()
    {
        return [
            Pet::make([
                'id' => 1,
                'name' => 'Fido',
                'age' => 5,
                'type' => Pet::PET_TYPE_DOG,
            ]),
            Pet::make([
                'id' => 2,
                'name' => 'Milo',
                'age' => 3,
                'type' => Pet::PET_TYPE_CAT,
            ]),
        ];
    }

    private array $pets;


    private MockInterface $petServiceSpy;

    protected function setUp(): void
    {
        parent::setUp();
        $pets = self::getPets();
        $this->petServiceSpy = $this->spy(PetService::class);
    }


    public function test_pets_returns_successful()
    {
        // arrange
        $pets = self::getPets();
        $this->petServiceSpy->shouldReceive('getPets')
        ->once()
        ->andReturn($pets);

        // act
        $response = $this->get('/pets');

        // assert
        $response->assertStatus(200);
        $response->assertViewHas('pets', $pets);
    }

    public function test_get_single_pet()
    {
        //arrange
        $pets = self::getPets(1);
        $this->petServiceSpy->shouldReceive('getPetById')
        ->with(1)
        ->once()
        ->andReturn($pets[1]);

        //act
        $response = $this->get('/pets/1');

        //assert
        $response->assertStatus(200);
        $response->assertViewHas('pet', $pets[1]);
    }

    public function test_get_invalid_param()
    {
        //arrange
        $pets = self::getPets(1);
        $this->petServiceSpy->shouldReceive('getPetById')
        ->with(1)
        ->andReturn($pets[1]);

        //act
        $response = $this->get('/pets/2');

        //assert
        $response->assertStatus(404);

    }

}
