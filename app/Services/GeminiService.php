<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;

    protected string $model;

    protected float $temperature;

    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = (string) config('services.llm.api_key', '');
        $this->model = config('services.llm.model', 'gemini-3.8-flash');
        $this->temperature = (float) config('services.llm.temperature', 0.2);
        $this->baseUrl = rtrim(config('services.llm.base_url', 'https://generativelanguage.googleapis.com/v1beta'), '/');
    }

    public function ekstrakGejala(string $teksUser, array $daftarGejala): array
    {
        if ($this->apiKey === '') {
            throw new \RuntimeException('LLM_API_KEY is not configured.');
        }

        $daftarGejalaStr = collect($daftarGejala)
            ->map(fn ($g) => "- {$g['kode']}: {$g['nama']}")
            ->implode("\n");

        $systemPrompt = <<<PROMPT
Anda adalah asisten ekstraksi gejala penyakit tanaman cabai.
Tugas: dari teks user, identifikasi SEMUA gejala yang cocok dari DAFTAR GEJALA di bawah.

Keluarkan HANYA JSON dengan format:
{"gejala": ["G01","G02"], "confidence": 0.85}

Aturan:
1. Cocokkan berdasarkan MAKNA, bukan hanya kata persis.
2. Identifikasi SEMUA gejala yang disebutkan, jangan hanya satu.
3. Jika tidak ada yang cocok, keluarkan {"gejala": [], "confidence": 0}.
4. HANYA keluarkan kode gejala yang ADA di daftar. Jangan mengarang.
5. Jangan tambahkan penjelasan apapun di luar JSON.

CONTOH:
Input: "daun saya bercak coklat dan buahnya keriput"
Output: {"gejala": ["G09", "G14"], "confidence": 0.9}

Input: "akar tanaman warnanya coklat dan membusuk"
Output: {"gejala": ["G01", "G02"], "confidence": 0.95}

DAFTAR GEJALA:
$daftarGejalaStr

TEKS USER:
"$teksUser"
PROMPT;

        $url = "{$this->baseUrl}/models/{$this->model}:generateContent";

        $payload = [
            'contents' => [
                ['parts' => [['text' => $systemPrompt]]],
            ],
            'generationConfig' => [
                'temperature' => $this->temperature,
                'responseMimeType' => 'application/json',
                'maxOutputTokens' => 4096,
            ],
        ];

        // Retry logic dari teman Anda (429/503)
        $response = null;
        for ($attempt = 1; $attempt <= 3; $attempt++) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $this->apiKey,
            ])->connectTimeout(5)->timeout(20)->post($url, $payload);

            if ($response->successful()) {
                break;
            }

            $status = $response->status();
            if (! in_array($status, [429, 503], true) || $attempt === 3) {
                Log::error('Gemini API error', ['status' => $status, 'body' => $response->body()]);
                throw new \RuntimeException("Gemini API error: {$status} - {$response->body()}");
            }

            sleep(2 ** ($attempt - 1));
        }

        $raw = $response->json('candidates.0.content.parts.0.text', '');
        Log::info('Gemini RAW', ['status' => $response->status(), 'raw' => $raw]);

        if (empty($raw)) {
            throw new \RuntimeException('Gemini returned empty response');
        }

        $parsed = json_decode($raw, true);
        if (! $parsed && preg_match('/\{.*\}/s', $raw, $m)) {
            $parsed = json_decode($m[0], true);
        }

        if (! is_array($parsed)) {
            throw new \RuntimeException('Invalid JSON from LLM: '.$raw);
        }

        $gejala = $parsed['gejala'] ?? [];
        if (is_string($gejala)) {
            $gejala = [$gejala];
        }
        if (! is_array($gejala)) {
            $gejala = [];
        }

        return [
            'gejala' => $gejala,
            'confidence' => (float) ($parsed['confidence'] ?? 0),
            'raw' => $raw,
        ];
    }
}
