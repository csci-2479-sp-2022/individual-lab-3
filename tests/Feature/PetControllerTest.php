<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pet;
use Mockery;
use Mockery\MockInterface;

class PetControllerTest extends TestCase {
    private array $pets;
    private MockInterface $petSpy;

     /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function setUp(): void {
        parent::setUp();
        $this->petServiceSpy = $this->spy(PetService::class);
    }

    public function test_example() {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    private static function getPets() {
        return [
            Pet::make([
                'id' => 1,
                'name' => 'Nemo',
                'age' => 5,
                'type' => 'fish',
            ]),
            Pet::make([
                'id' => 3,
                'name' => 'Wallace',
                'age' => 8,
                'type' => 'rabbit',
            ]),
        ];

    }

    public function test_PetService_no_ID() {
        return [
            Pet::make([
                'name' => 'Nemo',
                'age' => 5,
                'type' => 'fish'
            ]),
            Pet::make([
                'name' => 'Wallace',
                'age' => 8,
                'type' => 'rabbit',
            ]),
        ];
    }

    public function test_PetService_Single_Pet() {
        return [
            Pet::make([
                'name' => 'Nemo',
                'age' => 5,
                'type' => 'fish',
            ])
        ];
    }

    public function test_PetService_Return_404() {
        return 404;
    }
}
