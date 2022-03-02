<?php

namespace Tests\Feature;

use App\Contracts\PetService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Mockery\MockInterface;
use Tests\TestCase;

use App\Models\Pet;

class PetControllerTest extends TestCase
{
    private MockInterface $petServiceSpy;
    private $pets = [];

    private static function getPets() {
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

    public function setUp(): void {
        parent::setUp();

        $this->pets = self::getPets();

        $this->PetServiceSpy = $this->spy(PetService::class);
    }

    public function test_get_pets_returns_list() {
        // arrange
        $this->PetServiceSpy->shouldReceive('getPets')
            ->once()
            ->andReturn([
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
            ]);

        // act
        $response = $this->get('/pets');

        // assert
        $response->assertStatus(200);
        $response->assertViewHas('pets', [
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
        ]);
    }

    public function test_get_pets_returns_single() {
        // arrange
        $this->PetServiceSpy->shouldReceive('getPetById')
            ->once()
            ->andReturn(
                Pet::make([
                    'id' => 2,
                    'name' => 'Milo',
                    'age' => 3,
                    'type' => Pet::PET_TYPE_CAT,
                ]),
            );

        // act
        $response = $this->get('/pets/1');

        // assert
        $response->assertStatus(200);
        $response->assertViewHas(
            'pet',
            Pet::make([
                'id' => 2,
                'name' => 'Milo',
                'age' => 3,
                'type' => Pet::PET_TYPE_CAT,
            ]),
        );
    }

    public function test_get_pets_invalid_id() {
        $response = $this->get('/pets/3');

        $response->assertStatus(404);
    }

}
