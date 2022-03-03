<?php

namespace Tests\Unit;


use App\Models\Pet;
use Tests\TestCase;

class PetTest extends TestCase
{

    public function test_toString()
    {
        // arrange
        $pet = Pet::make([
            'id' => 1,
            'name' => 'Fido',
            'age' => 5,
            'type' => Pet::PET_TYPE_DOG,
        ]);
        $expectedString = "name: Fido, age: 5, type: dog"; 
      
 
        // act
        $actualString = $pet->toString();

        // assert
        $this->assertEquals($expectedString, $actualString);
    }
}


