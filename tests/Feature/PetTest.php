<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pet;
use App\Contracts\PetService;

class PetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_toString()
    {
        //arrange
        $pet = new Pet;
        $expectedString = $pet->toString();
        //act
        $actualString = $pet->toString();

        //assert

        $this->assertEquals($expectedString, $actualString);
    }
}
