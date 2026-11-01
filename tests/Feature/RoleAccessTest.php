<?php

use App\Models\RiwayatDiagnosis;
use App\Models\Gejala;
use App\Models\SinonimGejala;
use App\Models\User;

test('regular users can only see their own diagnosis history', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    RiwayatDiagnosis::create([
        'user_id' => $user->id,
        'input_asli' => 'Daun menguning',
        'gejala_terdeteksi' => ['G01'],
        'cf_pengguna' => ['G01' => 1],
    ]);
    RiwayatDiagnosis::create([
        'user_id' => $other->id,
        'input_asli' => 'Buah membusuk',
        'gejala_terdeteksi' => ['G02'],
        'cf_pengguna' => ['G02' => 1],
    ]);

    $this->actingAs($user)
        ->get('/diagnosis/history')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('diagnosis/history')
            ->where('history.data.0.input_asli', 'Daun menguning')
            ->has('history.data', 1));
});

test('admins can read knowledge records and manage synonyms but not diseases', function () {
    $admin = User::factory()->create();
    $admin->forceFill(['role' => 'admin'])->save();
    $this->actingAs($admin);

    $this->get('/dashboard/knowledge/penyakits')->assertOk();
    $this->post('/dashboard/knowledge/synonyms', [
        'kata_tidak_baku' => 'totol totol',
        'kata_baku' => 'bercak',
        'gejala_id' => null,
    ])->assertRedirect();
    $this->post('/dashboard/knowledge/penyakits', [
        'kode' => 'P99',
        'nama' => 'Test',
        'deskripsi' => 'Test',
        'penyebab' => 'Test',
        'rekomendasi' => 'Test',
    ])->assertForbidden();
});

test('experts can create knowledge records', function () {
    $expert = User::factory()->create();
    $expert->forceFill(['role' => 'pakar'])->save();

    $this->actingAs($expert)->post('/dashboard/knowledge/penyakits', [
        'kode' => 'P99',
        'nama' => 'Penyakit Uji',
        'deskripsi' => 'Deskripsi',
        'penyebab' => 'Penyebab',
        'rekomendasi' => 'Rekomendasi',
    ])->assertRedirect();

    $this->assertDatabaseHas('penyakits', ['kode' => 'P99']);
});

test('synonym groups can be saved updated and deleted together', function () {
    $admin = User::factory()->create();
    $admin->forceFill(['role' => 'admin'])->save();
    $gejala = Gejala::create(['kode' => 'G02', 'nama' => 'Akar membusuk dalam tanah']);

    $this->actingAs($admin)
        ->post('/dashboard/knowledge/synonyms/group', [
            'gejala_id' => $gejala->id,
            'kata_baku' => 'busuk',
            'kata_tidak_baku' => ['busukan', 'buruk'],
        ])
        ->assertRedirect();

    expect(SinonimGejala::where('gejala_id', $gejala->id)->where('kata_baku', 'busuk')->count())->toBe(2);

    $this->put('/dashboard/knowledge/synonyms/group', [
        'original_gejala_id' => $gejala->id,
        'original_kata_baku' => 'busuk',
        'gejala_id' => $gejala->id,
        'kata_baku' => 'membusuk',
        'kata_tidak_baku' => ['busukan', 'buruk', 'pembusukan'],
    ])->assertRedirect();

    expect(SinonimGejala::where('gejala_id', $gejala->id)->where('kata_baku', 'membusuk')->count())->toBe(3);

    $this->delete('/dashboard/knowledge/synonyms/group', [
        'gejala_id' => $gejala->id,
        'kata_baku' => 'membusuk',
    ])->assertRedirect();

    expect(SinonimGejala::where('gejala_id', $gejala->id)->count())->toBe(0);
});
