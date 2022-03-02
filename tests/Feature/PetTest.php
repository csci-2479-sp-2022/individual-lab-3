<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pet;

class PetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_toString_pets() {
        //arange
        $pet =  Pet::make([
            'id' => 1,
            'name' => 'Fido',
            'age' => 5,
            'type' => Pet::PET_TYPE_DOG,
        ]);

        $expected = "name: Fido, age: 5, type: dog";

        //act 
        $actual = $pet -> toString();

        //assert
        $this -> assertEquals($expected, $actual);
    }

}
