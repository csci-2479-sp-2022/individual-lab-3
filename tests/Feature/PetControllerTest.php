<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pet;
use App\Contracts\PetService;

use Mockery;
use Mockery\MockInterface;

class PetControllerTest extends TestCase
{
    private MockInterface $petServiceSpy;
    private $pets = [];

    /**
     * A basic feature test example.
     *
     * @return void
     */


    protected function setUp(): void
    {
        parent::setUp();

        $this->petServiceSpy = $this->spy(PetService::class);
        $pets = self::getPets();


        
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

    public function test_PetService_Invalid_ID(){
        $response = $this->get('/pets/3');
        $response->assertStatus(404);
    }

    public function test_PetService_Single_Pet(){
        /*
        return [
            Pet::make([
                'name' => 'Fido',
                'age' => 5,
                'type' => 'hound',
            ])
        ];
        */


                // arrange
                $this->petServiceSpy->shouldReceive('getPetById')
                ->once()
                ->andReturn(
                    Pet::make([
                        'name' => 'Salem',
                        'age' => 9,
                        'type' => 'dog',
                        'id'=> 1
                    ]),
                );
                
    
            // act
            $response = $this->get('/pets/1');
    
            // assert
            $response->assertStatus(200);
            $response->assertViewHas('pet', 
                Pet::make([
                    'name' => 'Salem',
                        'age' => 9,
                        'type' => 'dog',
                        'id'=> 1
                ]),
            );
    }

    public function test_PetService_Return_404(){
        $response = $this->get('/pet');

        $response->assertStatus(404);
    }


    public function test_example()
    {

        $response = $this->get('/');

        $response->assertStatus(200);


    }

    public function test_getPets_list(){

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




    


    
    public function test_getPets_with_ID(){
        //arrange
        $id = 1;
        $fido = $this->getPets()[0];

        $this->petServiceSpy->shouldReceive('getPetById')
            ->with($id)
            ->once()
            ->andReturn($fido);
        
        //act
        $response = $this->get('/pets/'.$id);
         
        //assert
        $response->assertViewHas('pet', $fido);
        $response->assertStatus(200);
    }

    

    
}
