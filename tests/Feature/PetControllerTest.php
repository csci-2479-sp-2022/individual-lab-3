<?php

namespace Tests\Feature;

use App\Contracts\PetService;
use App\Models\Pet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery\MockInterface;

class PetControllerTest extends TestCase
{
    private $pets = [];
    private MockInterface $petServiceSpy;
    

    protected function setUp() : void
    {   
        parent::setUp();
        $this->pets = self::getPets();
        $this->petServiceSpy = $this->spy(PetService::class);

}
private static function getPets(){
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

    public function test_list_pets()
    {
        // arrange
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
        // act
        $response = $this->get('/pets');
        // assert
        $response->assertStatus(200);
        $response->assertViewHas('pets',
            [   Pet::make([
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
    public function test_pets_valid_id()
    {
        // arrange
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

        // act
        $response = $this->get('/pets/1');

        // assert
        $response->assertStatus(200);
        $response->assertViewHas('pet',
            Pet::make([
                'id' => 1,
                'name' => 'Fido',
                'age' => 5,
                'type' => 'dog',
            ]),
        );
    }
        public function test_pets_invalid_id() {
        $response = $this->get('/pets/5');

        $response->assertStatus(404);
    }
    
}
