<?php

use App\Services\SymptomMatcherService;

test('matches root symptoms from an Indonesian description', function () {
    $matcher = new SymptomMatcherService;
    $catalog = [
        ['kode' => 'G01'],
        ['kode' => 'G02'],
    ];

    expect($matcher->ekstrakGejala(
        'Akar tanaman cabai membusuk dan berwarna coklat',
        $catalog
    ))->toBe(['G01', 'G02']);
});

test('matches leaf spots and wrinkled fruit without a false black-fruit spot', function () {
    $matcher = new SymptomMatcherService;
    $catalog = [
        ['kode' => 'G09'],
        ['kode' => 'G13'],
        ['kode' => 'G14'],
    ];

    expect($matcher->ekstrakGejala(
        'Daun cabai saya bercak-bercak coklat dan buahnya keriput',
        $catalog
    ))->toBe(['G09', 'G14']);
});

test('matches wilting plants and ignores unrelated symptom codes', function () {
    $matcher = new SymptomMatcherService;

    expect($matcher->ekstrakGejala(
        'Tanaman cabai saya layu padahal tanahnya basah',
        [['kode' => 'G21']]
    ))->toBe(['G21']);

    expect($matcher->ekstrakGejala(
        'Tanaman cabai tumbuh subur',
        [['kode' => 'G01'], ['kode' => 'G21']]
    ))->toBe([]);
});

test('matches synonyms connected to a symptom in the database', function () {
    $matcher = new SymptomMatcherService;
    $catalog = [
        ['kode' => 'G09'],
        ['kode' => 'G14'],
    ];
    $sinonim = [
        [
            'kata_tidak_baku' => 'totol-totol',
            'kata_baku' => 'bercak',
            'kode' => 'G09',
        ],
    ];

    expect($matcher->ekstrakGejala(
        'Daunnya banyak totol-totol',
        $catalog,
        $sinonim
    ))->toBe(['G09']);
});
