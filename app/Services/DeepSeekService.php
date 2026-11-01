<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepSeekService
{
    protected string $apiKey;
    protected string $model;
    protected float $temperature;
    protected string $endpoint;

    public function __construct()
    {
        $this->apiKey      = config('services.deepseek.key');
        $this->model       = config('services.deepseek.model', 'deepseek-chat');
        $this->temperature = (float) config('services.deepseek.temperature', 0.2);
        $this->endpoint    = config('services.deepseek.endpoint');
    }

    /**
     * Ekstrak gejala dari teks bebas user menggunakan DeepSeek.
     */
    public function ekstrakGejala(string $teksUser, array $daftarGejala): array
    {
        $daftarGejalaStr = collect($daftarGejala)
            ->map(fn($g) => "- {$g['kode']}: {$g['nama']}")
            ->implode("\n");

        $systemPrompt = <<<PROMPT
Anda adalah asisten ekstraksi gejala penyakit tanaman cabai.
Tugas: dari teks user, identifikasi gejala mana yang cocok dari DAFTAR GEJALA di bawah.
Keluarkan HANYA JSON dengan format:
{"gejala": ["G01","G02"], "confidence": 0.85}

Aturan:
- Hanya keluarkan kode gejala yang ADA di daftar.
- Jika tidak ada yang cocok, keluarkan {"gejala": [], "confidence": 0}.
- Jangan tambahkan penjelasan apapun di luar JSON.
PROMPT;

        $userPrompt = "DAFTAR GEJALA:\n{$daftarGejalaStr}\n\nTEKS USER:\n\"{$teksUser}\"";

        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ])
            ->post($this->endpoint, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'temperature' => $this->temperature,
                'response_format' => ['type' => 'json_object'], // paksa JSON
            ]);

        if ($response->failed()) {
            Log::error('DeepSeek API error', ['body' => $response->body()]);
            return ['gejala' => [], 'confidence' => 0, 'raw' => $response->body()];
        }

        $raw = $response->json('choices.0.message.content', '{}');
        $parsed = json_decode($raw, true) ?: ['gejala' => [], 'confidence' => 0];

        return [
            'gejala' => $parsed['gejala'] ?? [],
            'confidence' => (float) ($parsed['confidence'] ?? 0),
            'raw' => $raw,
        ];
    }
}