<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pet;




class PetTest extends TestCase {
    public function test_toString() {

        //arrange
        $pet = Pet::make([
            'id' => 1,
            'name' => 'Nemo',
            'age' => 5,
            'type' => Pet::PET_TYPE_DOG,
        ]);

        $expectedResponse = "name: Nemo, age: 5, type: dog";

        //act
        $actualResponse = $pet->toString();

        //assert
        $this->assertEquals($expectedResponse,$actualResponse);
        }
    }
