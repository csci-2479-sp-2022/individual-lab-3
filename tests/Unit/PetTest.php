<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Pet;

class PetTest extends TestCase
{

    public function test_toString(Pet $pet)
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
        $this->assertEquals($expectedString, $actualYesNo);
    }
}
