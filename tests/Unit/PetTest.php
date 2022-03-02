<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\Pet;

class PetTest extends TestCase
{
    public function test_call_string() {
        // arrange
        $pet = Pet::make([
            'id' => 2,
            'name' => 'Milo',
            'age' => 3,
            'type' => Pet::PET_TYPE_CAT,
        ]);

        $wantedString = "name: Milo, age: 3, type: cat";

        // act
        $actualString = $pet->toString();

        // assert
        $this->assertEquals($wantedString, $actualString);
    }
}
