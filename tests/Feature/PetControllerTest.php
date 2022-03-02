<?php

namespace Tests\Feature;

use App\Contracts\PetService;
use App\Models\Pet;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class PetControllerTest extends TestCase
{

    private MockInterface $petServiceSpy;

    private $pets = [];

    private static function getPets(): array
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

    protected function setUp(): void
    {
        parent::setUp();

        $this->pets = self::getPets();

        $this->petServiceSpy = $this->spy(PetService::class);
        
    }

    public function test_petsRoute_returns_successful()
    {
        // arrange
        $this->petServiceSpy->shouldReceive('getPets')
            ->once()
            ->andReturn($this->pets);

        // act
        $response = $this->get('/pets');

        // assert
        $response->assertStatus(200);
        $response->assertViewHas('pets', $this->pets);
                
    }

    public function test_petRoute_returns_successful()
    {
        // arrange
        $this->petServiceSpy->shouldReceive('getPetById')
            ->once()
            ->andReturn($this->pets[0]);

        // act
        $response = $this->get('/pets/1');

        // assert
        $response->assertStatus(200);
        $response->assertViewHas('pet', $this->pets[0]);
                
    }

    public function test_petRoute_returns_unsuccessful()
    {
        // arrange
        $this->petServiceSpy->shouldReceive('getPetById')
            ->once()
            ->andReturn($this->pets[0]);

        // act
        $response = $this->get('/pets/5');

        // assert
        $response->assertStatus(404);
                
    }




}
