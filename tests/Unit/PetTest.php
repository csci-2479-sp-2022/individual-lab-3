<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Pet;

class PetTest extends TestCase
{
    
    public function test_toString_returns_string()
    {
        $pet =  new Pet([
        'id' => 1,
        'name' => 'Fido',
        'age' => 5,
        'type' => Pet::PET_TYPE_DOG,]);
        $expectedString = "name: Fido, age: 5, type: dog";

        $actualString = $pet->toString();

        $this->assertEquals($expectedString, $actualString);
    }
}
