<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Contracts\PetService;
use App\Models\Pet;
use Mockery\MockInterface;

use Tests\TestCase;

class PetControllerTest extends TestCase
{

    private MockInterface $petServiceSpy; 
    private array $pets; 

    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    private function getPets() {
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
    } //end getPets

    protected function setUp(): void {

        parent::setUp();
        
        $this -> pets = self::getPets();

       $this->petServiceSpy = $this -> spy(PetService::class);

    } // end setUp


    public function test_getPets_list() {
        
        //arrange 
        $this -> petServiceSpy -> shouldReceive('getPets')
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
        $response = $this -> get('/pets');
        
        //Assert 
        $response -> assertStatus(200);
        $response -> assertViewHas(
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
    } //end List Test

    public function test_getPets_id() {
        
        //arange
        $this -> petServiceSpy -> shouldReceive('getPetById')
        ->once()
        ->andReturn(
            Pet::make([
                'id' => 1,
                'name' => 'Fido',
                'age' => 5,
                'type' => Pet::PET_TYPE_DOG,
            ]),
        );

        //act 
        $response = $this -> get('/pets/1');

        //Assert
        $response -> assertStatus(200);
        $response -> assertViewHas(
            'pet',
                Pet::make([
                    'id' => 1,
                    'name' => 'Fido',
                    'age' => 5,
                    'type' => Pet::PET_TYPE_DOG,
                ]),
        );
    } // end Id Test

    public function test_getPets_invalid_id() {
        
        $response = $this -> get('/pets/3');
        $response -> assertStatus(404);
    }

}
