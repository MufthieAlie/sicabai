<?php

use App\Models\Gejala;
use App\Models\User;
use Illuminate\Support\Facades\Http;

it('uses local symptom matching when Gemini rejects the API key', function () {
    config(['services.llm.api_key' => 'test-api-key']);
    Http::fake([
        '*' => Http::response([
            'error' => [
                'message' => 'API key not valid',
            ],
        ], 401),
    ]);

    Gejala::create(['kode' => 'G09', 'nama' => 'Bercak bulat kering pada daun']);
    Gejala::create(['kode' => 'G14', 'nama' => 'Buah keriput']);

    $this->actingAs(User::factory()->create())
        ->postJson('/diagnosis/ekstrak', [
        'teks' => 'Daun bercak coklat dan buahnya keriput',
    ])
        ->assertOk()
        ->assertJsonPath('fallbackLokal', true)
        ->assertJsonPath('gejala.0.kode', 'G09')
        ->assertJsonPath('gejala.1.kode', 'G14');
});
