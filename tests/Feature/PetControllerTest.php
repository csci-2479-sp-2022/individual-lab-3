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

    private array $pets;

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

    public function test_getPetsWithoutId_returns_list(){
        $this->petServiceSpy->shouldReceive('getPets')
            ->once()
            ->andReturn(
                $this->pets
            );
        $response = $this->get('/pets');

        $response->assertStatus(200);
        $response->assertViewHas('pets', $this->pets);
    }

    public function test_getPetsWithId_returns_pet(){
        $this->petServiceSpy->shouldReceive('getPetById')
            ->with(1)
            ->once()
            ->andReturn(
                $this->pets[0]
            );
        $response = $this->get('/pets/1');

        $response->assertStatus(200);
        $response->assertViewHas('pet', $this->pets[0]);
    }

    public function test_getPetsWithInvalidId_returns_404(){

        $response = $this->get('/pets/3');

        $response->assertStatus(404);
    }
}
