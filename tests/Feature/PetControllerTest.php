<?php

namespace Tests\Feature;

use App\Contracts\PetService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;


use Tests\TestCase;
use Mockery\MockInterface;

use App\Models\Pet;

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


    public function setUp(): void
    {
        parent::setUp();

        $this->pets = self::getPets();

        $this->petServiceSpy = $this->spy(PetService::class);
    }




    public function test_get_Pets_list()
    {
        //arrange
        $this->petServiceSpy->shouldReceive('getPets')
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
        //act
        $response = $this->get('/pets');
        //assert
        $response->assertStatus(200);
        $response->assertViewHas(
            'pets',
            [
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
            ]
        );
    }

    public function test_get_Pet_by_id()
    {
        //arrange
        $this->petServiceSpy->shouldReceive('getPetById')
            ->once()
            ->andReturn(
                Pet::make([
                    'id' => 1,
                    'name' => 'Fido',
                    'age' => 5,
                    'type' => 'dog',
                ]),
            );

        //act
        $response = $this->get('/pets/1');

        //assert
        $response->assertStatus(200);
        $response->assertViewHas(
            'pet',
            Pet::make([
                'id' => 1,
                'name' => 'Fido',
                'age' => 5,
                'type' => 'dog',
            ]),

        );
    }

    public function test_get_Pet_with_invalid_id()
    {
        $response = $this->get('/pets/3');

        $response->assertStatus(404);
    }
}
