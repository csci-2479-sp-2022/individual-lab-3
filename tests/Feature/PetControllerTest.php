<?php

namespace Tests\Feature;

use App\Contracts\PetService;
use App\Models\Pet;
use App\Http\Controllers\PetController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class PetControllerTest extends TestCase
{

    private MockInterface $petServiceSpy;

    private $pets = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->pets = self::getPets();

        $this->petServiceSpy = $this->spy(PetService::class);
        
    }

    public function test_petsRoute_returns_successful()
    {
        // arrange

        $this->petServiceSpy->shouldRecieve('getPets')
            ->once()
            ->andReturn($pets);

        // act
        $response = $this->get('/pets');

        // assert
        $response->assertStatus(200);
        $response->assertViewHas('pets', [
            new Pet (1, 'Fido', 5, Pet::PET_TYPE_DOG)
        ]);
                
    }



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
}
