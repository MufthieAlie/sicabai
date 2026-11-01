<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Penyakit, Gejala, AturanGejala, SinonimGejala};

class SistemPakarSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================================
        // 1. DATA PENYAKIT (12 Penyakit)
        // ============================================================
        $penyakits = [
                    // ---------- JAMUR ----------
                    [
                        'kode' => 'P01',
                        'nama' => 'Antraknosa (Patek)',
                        'deskripsi' => 'Penyakit akibat jamur Colletotrichum capsici yang menyerang buah cabai hingga busuk dan mengering.',
                        'penyebab' => 'Jamur Colletotrichum capsici, C. gloeosporioides',
                        'rekomendasi' => 'Gunakan benih sehat, rendam benih dengan Pseudomonas fluorescens, sanitasi buah terinfeksi, perbaiki drainase, aplikasi fungisida protektif (Bion M1/48 WP) sejak muncul putik.',
                    ],
                    [
                        'kode' => 'P02',
                        'nama' => 'Layu Fusarium',
                        'deskripsi' => 'Tanaman layu dimulai dari bagian bawah akibat jamur Fusarium oxysporum.',
                        'penyebab' => 'Jamur Fusarium oxysporum',
                        'rekomendasi' => 'Rotasi tanaman non-inang, gunakan agens hayati Trichoderma spp., perbaiki drainase, gunakan varietas tahan.',
                    ],
                    [
                        'kode' => 'P03',
                        'nama' => 'Layu Bakteri',
                        'deskripsi' => 'Layu mendadak akibat bakteri Ralstonia solanacearum, batang mengeluarkan lendir bila dipotong.',
                        'penyebab' => 'Bakteri Ralstonia solanacearum',
                        'rekomendasi' => 'Buang tanaman sakit, rotasi tanaman, sanitasi lahan, hindari luka mekanis pada akar.',
                    ],
                    [
                        'kode' => 'P04',
                        'nama' => 'Bercak Daun Cercospora',
                        'deskripsi' => 'Bercak kecil bulat kering pada daun dengan pusat pucat dan tepi lebih tua.',
                        'penyebab' => 'Jamur Cercospora capsici',
                        'rekomendasi' => 'Sanitasi sisa tanaman sakit, gunakan benih bebas patogen, fungisida bila serangan meluas, perbaiki drainase.',
                    ],
                    [
                        'kode' => 'P05',
                        'nama' => 'Virus Kuning (Gemini)',
                        'deskripsi' => 'Daun muda menguning cerah, mengerut, menebal, dan tanaman kerdil akibat virus Gemini.',
                        'penyebab' => 'Gemini Virus (TYLCV) via kutu kebul Bemisia tabaci',
                        'rekomendasi' => 'Kendalikan kutu kebul dengan perangkap kuning, insektisida, cabut dan musnahkan tanaman terinfeksi.',
                    ],
                    [
                        'kode' => 'P06',
                        'nama' => 'Busuk Daun Phytophthora',
                        'deskripsi' => 'Daun dan batang membusuk, sering muncul saat kelembaban tinggi dan genangan air.',
                        'penyebab' => 'Jamur Phytophthora capsici',
                        'rekomendasi' => 'Perbaiki drainase, hindari genangan, aplikasi fungisida, rotasi tanaman.',
                    ],
                    [
                        'kode' => 'P07',
                        'nama' => 'Busuk Pangkal Batang (Sclerotium)',
                        'deskripsi' => 'Tanaman layu mendadak, pangkal batang membusuk dengan benang putih dan sklerotia coklat.',
                        'penyebab' => 'Jamur Sclerotium rolfsii',
                        'rekomendasi' => 'Bajak tanah dalam untuk mengubur sklerotia, rotasi tanaman, aplikasi fungisida tanah.',
                    ],
                    [
                        'kode' => 'P08',
                        'nama' => 'Layu Verticillium',
                        'deskripsi' => 'Daun bawah keriting dan menguning, tanaman kerdil dan layu total akibat jamur Verticillium.',
                        'penyebab' => 'Jamur Verticillium albo-atrum, V. dahliae',
                        'rekomendasi' => 'Rotasi tanaman dengan non-inang selama 3-4 tahun, sanitasi lahan.',
                    ],
                    [
                        'kode' => 'P09',
                        'nama' => 'Bercak Daun Bakteri',
                        'deskripsi' => 'Bintik gelap cekung pada daun dan buah akibat bakteri Xanthomonas.',
                        'penyebab' => 'Bakteri Xanthomonas vesicatoria',
                        'rekomendasi' => 'Gunakan benih bebas patogen, sanitasi, hindari percikan air antar tanaman.',
                    ],
                    // ---------- VIRUS ----------
                    [
                        'kode' => 'P10',
                        'nama' => 'Mosaik (Kompleks Virus)',
                        'deskripsi' => 'Daun belang hijau tua-muda (mosaik), mengeriting, tanaman kerdil, buah mengecil.',
                        'penyebab' => 'TMV, CMV, CVMV, PVY',
                        'rekomendasi' => 'Kendalikan vektor kutu daun (Myzus persicae) dengan mulsa plastik perak/jerami, cabut tanaman terinfeksi muda, gunakan varietas toleran.',
                    ],
                    [
                        'kode' => 'P11',
                        'nama' => 'Kerupuk (CPSV)',
                        'deskripsi' => 'Daun menggulung ke bawah, keriput, hijau pekat mengkilap, ruas batang memendek seperti kerupuk.',
                        'penyebab' => 'Chilli Puckery Stunt Virus (CPSV)',
                        'rekomendasi' => 'Tekan populasi kutu daun vektor, cabut tanaman sakit, gunakan varietas tahan.',
                    ],
                    // ---------- NEMATODA ----------
                    [
                        'kode' => 'P12',
                        'nama' => 'Bintil Akar (Nematoda)',
                        'deskripsi' => 'Tanaman kerdil, menguning, layu; pada akar terbentuk bintil-bintil (galls).',
                        'penyebab' => 'Nematoda Meloidogyne incognita, M. arenaria, M. hapla',
                        'rekomendasi' => 'Rotasi tanaman jangka panjang dengan non-inang (padi/rumput), nematisida bila populasi tinggi.',
                    ],
                    // ---------- JAMUR (TAMBAHAN) ----------
                    [
                        'kode' => 'P13',
                        'nama' => 'Bercak Kering Alternaria',
                        'deskripsi' => 'Bercak coklat tua konsentris (target spot) pada daun dan buah, menyebabkan daun gugur dan buah busuk kering.',
                        'penyebab' => 'Jamur Alternaria solani',
                        'rekomendasi' => 'Rotasi tanaman, sanitasi sisa tanaman, aplikasi fungisida berbahan aktif mankozeb atau klorotalonil.',
                    ],
                    [
                        'kode' => 'P14',
                        'nama' => 'Embun Tepung (Powdery Mildew)',
                        'deskripsi' => 'Lapisan putih seperti tepung pada permukaan daun, daun menguning dan kering.',
                        'penyebab' => 'Jamur Oidium sp. / Leveillula taurica',
                        'rekomendasi' => 'Perbaiki sirkulasi udara, hindari kelembaban tinggi, aplikasi fungisida sulfur atau kalium bikarbonat.',
                    ],
                    [
                        'kode' => 'P15',
                        'nama' => 'Busuk Buah Rhizopus',
                        'deskripsi' => 'Buah membusuk lunak disertai bulu putih dan bintik hitam (sporangium) pada buah.',
                        'penyebab' => 'Jamur Rhizopus stolonifer',
                        'rekomendasi' => 'Panen tepat waktu, hindari luka pada buah, simpan di tempat kering, sanitasi buah busuk.',
                    ],
                    [
                        'kode' => 'P16',
                        'nama' => 'Busuk Batang Fusarium',
                        'deskripsi' => 'Batang membusuk coklat, tanaman layu dan mati, jaringan pembuluh berwarna gelap.',
                        'penyebab' => 'Jamur Fusarium solani',
                        'rekomendasi' => 'Gunakan agens hayati Trichoderma, rotasi tanaman, perbaiki drainase, hindari luka pada batang.',
                    ],
                    [
                        'kode' => 'P17',
                        'nama' => 'Bercak Daun Septoria',
                        'deskripsi' => 'Bercak kecil coklat dengan titik hitam di tengah (piknidia), daun menguning dan gugur.',
                        'penyebab' => 'Jamur Septoria lycopersici',
                        'rekomendasi' => 'Sanitasi daun terinfeksi, rotasi tanaman, aplikasi fungisida tembaga.',
                    ],
                    [
                        'kode' => 'P18',
                        'nama' => 'Busuk Leher Akar (Rhizoctonia)',
                        'deskripsi' => 'Pangkal batang dekat tanah membusuk coklat, tanaman rebah dan mati (damping off).',
                        'penyebab' => 'Jamur Rhizoctonia solani',
                        'rekomendasi' => 'Gunakan media semai steril, perbaiki drainase, aplikasi fungisida tanah, rotasi tanaman.',
                    ],
                    // ---------- BAKTERI (TAMBAHAN) ----------
                    [
                        'kode' => 'P19',
                        'nama' => 'Layu Bakteri Xanthomonas',
                        'deskripsi' => 'Tanaman layu, daun menguning, batang membusuk dan mengeluarkan lendir kuning.',
                        'penyebab' => 'Bakteri Xanthomonas campestris',
                        'rekomendasi' => 'Buang tanaman sakit, rotasi tanaman, sanitasi alat, hindari irigasi percikan.',
                    ],
                    [
                        'kode' => 'P20',
                        'nama' => 'Busuk Lunak Bakteri (Erwinia)',
                        'deskripsi' => 'Buah dan batang membusuk lunak, berbau busuk, jaringan menjadi berlendir.',
                        'penyebab' => 'Bakteri Erwinia carotovora',
                        'rekomendasi' => 'Hindari luka mekanis, sanitasi lahan, simpan hasil panen di tempat kering dan sejuk.',
                    ],
                    // ---------- VIRUS (TAMBAHAN) ----------
                    [
                        'kode' => 'P21',
                        'nama' => 'Virus Belang Kuning (TYLCV)',
                        'deskripsi' => 'Daun menguning di tepi, belang kuning, tanaman kerdil, buah kecil dan tidak normal.',
                        'penyebab' => 'Tomato Yellow Leaf Curl Virus via Bemisia tabaci',
                        'rekomendasi' => 'Kendalikan kutu kebul, gunakan mulsa perak, cabut tanaman terinfeksi, gunakan varietas tahan.',
                    ],
                    [
                        'kode' => 'P22',
                        'nama' => 'Virus Bercak Cincin (TSWV)',
                        'deskripsi' => 'Daun dan buah menunjukkan bercak cincin nekrotik, tanaman kerdil, buah cacat.',
                        'penyebab' => 'Tomato Spotted Wilt Virus via thrips',
                        'rekomendasi' => 'Kendalikan thrips dengan perangkap kuning/biru, sanitasi gulma inang, cabut tanaman sakit.',
                    ],
                    // ---------- NEMATODA (TAMBAHAN) ----------
                    [
                        'kode' => 'P23',
                        'nama' => 'Nematoda Sista (Heterodera)',
                        'deskripsi' => 'Tanaman kerdil dan menguning, pada akar terdapat sista (kista) kecil seperti butiran pasir.',
                        'penyebab' => 'Nematoda Heterodera sp.',
                        'rekomendasi' => 'Rotasi tanaman non-inang, gunakan varietas tahan, aplikasi nematisida organik.',
                    ],
                    // ---------- DEFISIENSI / FISIOLOGIS ----------
                    [
                        'kode' => 'P24',
                        'nama' => 'Defisiensi Kalsium (Blossom End Rot)',
                        'deskripsi' => 'Ujung buah membusuk kering kecoklatan (busuk ujung buah), pertumbuhan terhambat.',
                        'penyebab' => 'Kekurangan kalsium akibat kelembaban tidak stabil',
                        'rekomendasi' => 'Perbaiki irigasi agar stabil, aplikasi kalsium nitrat, hindari pemupukan nitrogen berlebih.',
                    ],
                    [
                        'kode' => 'P25',
                        'nama' => 'Defisiensi Magnesium',
                        'deskripsi' => 'Daun tua menguning di antara tulang daun (interveinal chlorosis), daun gugur prematur.',
                        'penyebab' => 'Kekurangan magnesium (Mg)',
                        'rekomendasi' => 'Aplikasi pupuk magnesium sulfat (kiserit), perbaiki pH tanah, lakukan uji tanah berkala.',
                    ],
                ];

                foreach ($penyakits as $p) {
                    Penyakit::create($p);
                }

                // ============================================================
                // 2. DATA GEJALA (50 Gejala)
                // ============================================================
                $gejalas = [
                    // Akar & Batang
                    ['kode' => 'G01', 'nama' => 'Warna jaringan akar kecoklatan'],
                    ['kode' => 'G02', 'nama' => 'Akar membusuk dalam tanah'],
                    ['kode' => 'G03', 'nama' => 'Bintil-bintil pada akar'],
                    ['kode' => 'G04', 'nama' => 'Pangkal batang membusuk'],
                    ['kode' => 'G05', 'nama' => 'Muncul benang putih pada pangkal batang'],
                    ['kode' => 'G06', 'nama' => 'Sklerotia coklat seperti biji mustard'],
                    ['kode' => 'G07', 'nama' => 'Batang mengeluarkan lendir bila dipotong'],
                    ['kode' => 'G08', 'nama' => 'Jaringan pembuluh batang berwarna coklat'],
                    // Daun
                    ['kode' => 'G09', 'nama' => 'Bercak bulat kering pada daun'],
                    ['kode' => 'G10', 'nama' => 'Bercak daun dengan pusat pucat dan tepi tua'],
                    ['kode' => 'G11', 'nama' => 'Daun menguning dan gugur'],
                    ['kode' => 'G12', 'nama' => 'Bercak gelap cekung pada daun'],
                    ['kode' => 'G13', 'nama' => 'Bercak hitam pada buah'],
                    ['kode' => 'G14', 'nama' => 'Buah keriput dan mengering'],
                    ['kode' => 'G15', 'nama' => 'Buah membusuk lunak'],
                    ['kode' => 'G16', 'nama' => 'Buah berwarna seperti jerami'],
                    ['kode' => 'G17', 'nama' => 'Daun belang hijau tua dan muda (mosaik)'],
                    ['kode' => 'G18', 'nama' => 'Daun mengeriting atau menyempit seperti tali'],
                    ['kode' => 'G19', 'nama' => 'Daun menggulung ke bawah dan keriput'],
                    ['kode' => 'G20', 'nama' => 'Daun hijau pekat mengkilap'],
                    ['kode' => 'G21', 'nama' => 'Daun menguning dan tanaman layu'],
                    ['kode' => 'G22', 'nama' => 'Daun muda menguning cerah dan menebal'],
                    ['kode' => 'G23', 'nama' => 'Daun mengecil dan pertumbuhan terhambat'],
                    ['kode' => 'G24', 'nama' => 'Daun bawah keriting dan menguning'],
                    // Tanaman keseluruhan
                    ['kode' => 'G25', 'nama' => 'Tanaman layu mendadak'],
                    ['kode' => 'G26', 'nama' => 'Tanaman kerdil'],
                    ['kode' => 'G27', 'nama' => 'Ruas batang memendek, daun menumpuk'],
                    ['kode' => 'G28', 'nama' => 'Bunga dan buah berguguran'],
                    ['kode' => 'G29', 'nama' => 'Tanaman layu mulai dari bagian bawah'],
                    ['kode' => 'G30', 'nama' => 'Daun dan batang membusuk saat kelembaban tinggi'],
                    // TAMBAHAN (G31 - G50)
                    ['kode' => 'G31', 'nama' => 'Bercak coklat konsentris (target spot) pada daun'],
                    ['kode' => 'G32', 'nama' => 'Bercak coklat konsentris pada buah'],
                    ['kode' => 'G33', 'nama' => 'Lapisan putih seperti tepung pada permukaan daun'],
                    ['kode' => 'G34', 'nama' => 'Daun menguning dan kering akibat lapisan tepung'],
                    ['kode' => 'G35', 'nama' => 'Buah membusuk lunak disertai bulu putih'],
                    ['kode' => 'G36', 'nama' => 'Bintik hitam (sporangium) pada buah busuk'],
                    ['kode' => 'G37', 'nama' => 'Batang membusuk coklat dan tanaman mati'],
                    ['kode' => 'G38', 'nama' => 'Bercak kecil coklat dengan titik hitam di tengah daun'],
                    ['kode' => 'G39', 'nama' => 'Tanaman rebah dan mati pada fase semai (damping off)'],
                    ['kode' => 'G40', 'nama' => 'Pangkal batang dekat tanah membusuk coklat'],
                    ['kode' => 'G41', 'nama' => 'Batang mengeluarkan lendir kuning'],
                    ['kode' => 'G42', 'nama' => 'Buah dan batang membusuk lunak berbau busuk'],
                    ['kode' => 'G43', 'nama' => 'Jaringan menjadi berlendir'],
                    ['kode' => 'G44', 'nama' => 'Daun menguning di tepi dan belang kuning'],
                    ['kode' => 'G45', 'nama' => 'Buah kecil dan tidak normal'],
                    ['kode' => 'G46', 'nama' => 'Bercak cincin nekrotik pada daun dan buah'],
                    ['kode' => 'G47', 'nama' => 'Buah cacat akibat bercak cincin'],
                    ['kode' => 'G48', 'nama' => 'Sista (kista) kecil seperti butiran pasir pada akar'],
                    ['kode' => 'G49', 'nama' => 'Ujung buah membusuk kering kecoklatan'],
                    ['kode' => 'G50', 'nama' => 'Daun tua menguning di antara tulang daun (interveinal chlorosis)'],
                ];

                foreach ($gejalas as $g) {
                    Gejala::create($g);
                }

                // ============================================================
                // 3. RELASI PENYAKIT - GEJALA + CF PAKAR
                // ============================================================
                $relasi = [
                    // P01 Antraknosa
                    ['kode_penyakit' => 'P01', 'kode_gejala' => 'G13', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P01', 'kode_gejala' => 'G14', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P01', 'kode_gejala' => 'G15', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P01', 'kode_gejala' => 'G16', 'cf_pakar' => 0.80],

                    // P02 Layu Fusarium
                    ['kode_penyakit' => 'P02', 'kode_gejala' => 'G01', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P02', 'kode_gejala' => 'G02', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P02', 'kode_gejala' => 'G08', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P02', 'kode_gejala' => 'G29', 'cf_pakar' => 0.80],

                    // P03 Layu Bakteri
                    ['kode_penyakit' => 'P03', 'kode_gejala' => 'G07', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P03', 'kode_gejala' => 'G21', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P03', 'kode_gejala' => 'G25', 'cf_pakar' => 0.80],

                    // P04 Bercak Daun Cercospora
                    ['kode_penyakit' => 'P04', 'kode_gejala' => 'G09', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P04', 'kode_gejala' => 'G10', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P04', 'kode_gejala' => 'G11', 'cf_pakar' => 0.60],

                    // P05 Virus Kuning (Gemini)
                    ['kode_penyakit' => 'P05', 'kode_gejala' => 'G21', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P05', 'kode_gejala' => 'G22', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P05', 'kode_gejala' => 'G23', 'cf_pakar' => 0.80],

                    // P06 Busuk Daun Phytophthora
                    ['kode_penyakit' => 'P06', 'kode_gejala' => 'G30', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P06', 'kode_gejala' => 'G04', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P06', 'kode_gejala' => 'G25', 'cf_pakar' => 0.60],

                    // P07 Busuk Pangkal Batang (Sclerotium)
                    ['kode_penyakit' => 'P07', 'kode_gejala' => 'G04', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P07', 'kode_gejala' => 'G05', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P07', 'kode_gejala' => 'G06', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P07', 'kode_gejala' => 'G25', 'cf_pakar' => 0.60],

                    // P08 Layu Verticillium
                    ['kode_penyakit' => 'P08', 'kode_gejala' => 'G24', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P08', 'kode_gejala' => 'G26', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P08', 'kode_gejala' => 'G08', 'cf_pakar' => 0.60],

                    // P09 Bercak Daun Bakteri
                    ['kode_penyakit' => 'P09', 'kode_gejala' => 'G12', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P09', 'kode_gejala' => 'G13', 'cf_pakar' => 0.60],
                    ['kode_penyakit' => 'P09', 'kode_gejala' => 'G11', 'cf_pakar' => 0.60],

                    // P10 Mosaik
                    ['kode_penyakit' => 'P10', 'kode_gejala' => 'G17', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P10', 'kode_gejala' => 'G18', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P10', 'kode_gejala' => 'G26', 'cf_pakar' => 0.60],

                    // P11 Kerupuk
                    ['kode_penyakit' => 'P11', 'kode_gejala' => 'G19', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P11', 'kode_gejala' => 'G20', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P11', 'kode_gejala' => 'G27', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P11', 'kode_gejala' => 'G28', 'cf_pakar' => 0.60],

                    // P12 Nematoda Bintil Akar
                    ['kode_penyakit' => 'P12', 'kode_gejala' => 'G03', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P12', 'kode_gejala' => 'G26', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P12', 'kode_gejala' => 'G21', 'cf_pakar' => 0.60],

                    // P13 Bercak Kering Alternaria
                    ['kode_penyakit' => 'P13', 'kode_gejala' => 'G31', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P13', 'kode_gejala' => 'G32', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P13', 'kode_gejala' => 'G11', 'cf_pakar' => 0.60],

                    // P14 Embun Tepung
                    ['kode_penyakit' => 'P14', 'kode_gejala' => 'G33', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P14', 'kode_gejala' => 'G34', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P14', 'kode_gejala' => 'G11', 'cf_pakar' => 0.60],

                    // P15 Busuk Buah Rhizopus
                    ['kode_penyakit' => 'P15', 'kode_gejala' => 'G35', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P15', 'kode_gejala' => 'G36', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P15', 'kode_gejala' => 'G15', 'cf_pakar' => 0.60],

                    // P16 Busuk Batang Fusarium
                    ['kode_penyakit' => 'P16', 'kode_gejala' => 'G37', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P16', 'kode_gejala' => 'G08', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P16', 'kode_gejala' => 'G25', 'cf_pakar' => 0.60],

                    // P17 Bercak Daun Septoria
                    ['kode_penyakit' => 'P17', 'kode_gejala' => 'G38', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P17', 'kode_gejala' => 'G11', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P17', 'kode_gejala' => 'G09', 'cf_pakar' => 0.60],

                    // P18 Busuk Leher Akar (Rhizoctonia)
                    ['kode_penyakit' => 'P18', 'kode_gejala' => 'G39', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P18', 'kode_gejala' => 'G40', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P18', 'kode_gejala' => 'G04', 'cf_pakar' => 0.60],

                    // P19 Layu Bakteri Xanthomonas
                    ['kode_penyakit' => 'P19', 'kode_gejala' => 'G41', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P19', 'kode_gejala' => 'G21', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P19', 'kode_gejala' => 'G25', 'cf_pakar' => 0.80],

                    // P20 Busuk Lunak Bakteri (Erwinia)
                    ['kode_penyakit' => 'P20', 'kode_gejala' => 'G42', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P20', 'kode_gejala' => 'G43', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P20', 'kode_gejala' => 'G15', 'cf_pakar' => 0.60],

                    // P21 Virus Belang Kuning (TYLCV)
                    ['kode_penyakit' => 'P21', 'kode_gejala' => 'G44', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P21', 'kode_gejala' => 'G45', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P21', 'kode_gejala' => 'G26', 'cf_pakar' => 0.60],

                    // P22 Virus Bercak Cincin (TSWV)
                    ['kode_penyakit' => 'P22', 'kode_gejala' => 'G46', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P22', 'kode_gejala' => 'G47', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P22', 'kode_gejala' => 'G26', 'cf_pakar' => 0.60],

                    // P23 Nematoda Sista (Heterodera)
                    ['kode_penyakit' => 'P23', 'kode_gejala' => 'G48', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P23', 'kode_gejala' => 'G26', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P23', 'kode_gejala' => 'G21', 'cf_pakar' => 0.60],

                    // P24 Defisiensi Kalsium (Blossom End Rot)
                    ['kode_penyakit' => 'P24', 'kode_gejala' => 'G49', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P24', 'kode_gejala' => 'G15', 'cf_pakar' => 0.60],
                    ['kode_penyakit' => 'P24', 'kode_gejala' => 'G23', 'cf_pakar' => 0.60],

                    // P25 Defisiensi Magnesium
                    ['kode_penyakit' => 'P25', 'kode_gejala' => 'G50', 'cf_pakar' => 1.00],
                    ['kode_penyakit' => 'P25', 'kode_gejala' => 'G11', 'cf_pakar' => 0.80],
                    ['kode_penyakit' => 'P25', 'kode_gejala' => 'G23', 'cf_pakar' => 0.60],
                ];

                foreach ($relasi as $r) {
                    $penyakit = Penyakit::where('kode', $r['kode_penyakit'])->first();
                    $gejala   = Gejala::where('kode', $r['kode_gejala'])->first();

                    if ($penyakit && $gejala) {
                        AturanGejala::create([
                            'penyakit_id' => $penyakit->id,
                            'gejala_id'   => $gejala->id,
                            'cf_pakar'    => $r['cf_pakar'],
                        ]);
                    }
                }

        // ============================================================
        // 4. SINONIM GEJALA (Fuzzy Matching)
        // ============================================================
        $sinonim = [
                    // Bercak
                    ['kata_tidak_baku' => 'totol-totol', 'kata_baku' => 'bercak'],
                    ['kata_tidak_baku' => 'totol totol', 'kata_baku' => 'bercak'],
                    ['kata_tidak_baku' => 'toto-toto', 'kata_baku' => 'bercak'],
                    ['kata_tidak_baku' => 'bintik-bintik', 'kata_baku' => 'bercak'],
                    ['kata_tidak_baku' => 'noda', 'kata_baku' => 'bercak'],
                    ['kata_tidak_baku' => 'spot', 'kata_baku' => 'bercak'],
                    ['kata_tidak_baku' => 'bintik', 'kata_baku' => 'bercak'],

                    // Busuk
                    ['kata_tidak_baku' => 'buruk', 'kata_baku' => 'busuk'],
                    ['kata_tidak_baku' => 'busukan', 'kata_baku' => 'busuk'],
                    ['kata_tidak_baku' => 'membusuk', 'kata_baku' => 'busuk'],
                    ['kata_tidak_baku' => 'bosok', 'kata_baku' => 'busuk'],
                    ['kata_tidak_baku' => 'basi', 'kata_baku' => 'busuk'],
                    ['kata_tidak_baku' => 'bau busuk', 'kata_baku' => 'busuk'],
                    ['kata_tidak_baku' => 'berlendir', 'kata_baku' => 'lendir'],

                    // Kering
                    ['kata_tidak_baku' => 'kering kerontang', 'kata_baku' => 'kering'],
                    ['kata_tidak_baku' => 'gering', 'kata_baku' => 'kering'],
                    ['kata_tidak_baku' => 'mengering', 'kata_baku' => 'kering'],
                    ['kata_tidak_baku' => 'kekeringan', 'kata_baku' => 'kering'],

                    // Menguning
                    ['kata_tidak_baku' => 'kuning pucat', 'kata_baku' => 'menguning'],
                    ['kata_tidak_baku' => 'kekuningan', 'kata_baku' => 'menguning'],
                    ['kata_tidak_baku' => 'menguning', 'kata_baku' => 'menguning'],
                    ['kata_tidak_baku' => 'menguning', 'kata_baku' => 'menguning'],
                    ['kata_tidak_baku' => 'kuning', 'kata_baku' => 'menguning'],

                    // Layu
                    ['kata_tidak_baku' => 'lembek', 'kata_baku' => 'layu'],
                    ['kata_tidak_baku' => 'lemas', 'kata_baku' => 'layu'],
                    ['kata_tidak_baku' => 'ndak segar', 'kata_baku' => 'layu'],
                    ['kata_tidak_baku' => 'tidak segar', 'kata_baku' => 'layu'],
                    ['kata_tidak_baku' => 'menggelepar', 'kata_baku' => 'layu'],
                    ['kata_tidak_baku' => 'rebah', 'kata_baku' => 'layu'],

                    // Keriput / Menggulung
                    ['kata_tidak_baku' => 'keriputan', 'kata_baku' => 'keriput'],
                    ['kata_tidak_baku' => 'kriput', 'kata_baku' => 'keriput'],
                    ['kata_tidak_baku' => 'menggulung', 'kata_baku' => 'menggulung'],
                    ['kata_tidak_baku' => 'mengkerut', 'kata_baku' => 'keriput'],
                    ['kata_tidak_baku' => 'menggulung ke bawah', 'kata_baku' => 'menggulung'],

                    // Kerdil
                    ['kata_tidak_baku' => 'kerdil', 'kata_baku' => 'kerdil'],
                    ['kata_tidak_baku' => 'pendek', 'kata_baku' => 'kerdil'],
                    ['kata_tidak_baku' => 'tidak tumbuh', 'kata_baku' => 'kerdil'],
                    ['kata_tidak_baku' => 'kerdilan', 'kata_baku' => 'kerdil'],

                    // Mosaik
                    ['kata_tidak_baku' => 'belang-belang', 'kata_baku' => 'mosaik'],
                    ['kata_tidak_baku' => 'bercorak', 'kata_baku' => 'mosaik'],
                    ['kata_tidak_baku' => 'belang', 'kata_baku' => 'mosaik'],
                    ['kata_tidak_baku' => 'corak', 'kata_baku' => 'mosaik'],

                    // Akar
                    ['kata_tidak_baku' => 'bintilan', 'kata_baku' => 'bintil'],
                    ['kata_tidak_baku' => 'benjolan akar', 'kata_baku' => 'bintil'],
                    ['kata_tidak_baku' => 'benjolan', 'kata_baku' => 'bintil'],
                    ['kata_tidak_baku' => 'kista', 'kata_baku' => 'sista'],

                    // Tepung / Embun
                    ['kata_tidak_baku' => 'bertepung', 'kata_baku' => 'tepung'],
                    ['kata_tidak_baku' => 'seperti tepung', 'kata_baku' => 'tepung'],
                    ['kata_tidak_baku' => 'embun', 'kata_baku' => 'tepung'],
                    ['kata_tidak_baku' => 'putih berbedak', 'kata_baku' => 'tepung'],

                    // Bulu / Jamur
                    ['kata_tidak_baku' => 'berbulu', 'kata_baku' => 'bulu'],
                    ['kata_tidak_baku' => 'berjamur', 'kata_baku' => 'bulu'],
                    ['kata_tidak_baku' => 'kapang', 'kata_baku' => 'bulu'],

                    // Cincin
                    ['kata_tidak_baku' => 'cincin', 'kata_baku' => 'cincin'],
                    ['kata_tidak_baku' => 'lingkaran', 'kata_baku' => 'cincin'],
                    ['kata_tidak_baku' => 'bercak cincin', 'kata_baku' => 'cincin'],

                    // Ujung buah
                    ['kata_tidak_baku' => 'ujung busuk', 'kata_baku' => 'ujung buah'],
                    ['kata_tidak_baku' => 'pucuk buah busuk', 'kata_baku' => 'ujung buah'],

                    // Interveinal
                    ['kata_tidak_baku' => 'daun kuning garis', 'kata_baku' => 'interveinal'],
                    ['kata_tidak_baku' => 'kuning di antara tulang daun', 'kata_baku' => 'interveinal'],
                ];

                foreach ($sinonim as $s) {
                    $gejala = Gejala::where('nama', 'like', '%' . $s['kata_baku'] . '%')->first();

                    SinonimGejala::firstOrCreate(
                        ['kata_tidak_baku' => $s['kata_tidak_baku']],
                        [
                            'kata_baku' => $s['kata_baku'],
                            'gejala_id' => $gejala?->id,
                        ]
                    );
                }

                // ============================================================
                // 5. OUTPUT INFORMASI
                // ============================================================
                $this->command->info('✅ Seeder Sistem Pakar Cabai berhasil dijalankan!');
                $this->command->info('   - ' . Penyakit::count() . ' penyakit');
                $this->command->info('   - ' . Gejala::count() . ' gejala');
                $this->command->info('   - ' . AturanGejala::count() . ' aturan gejala');
                $this->command->info('   - ' . SinonimGejala::count() . ' sinonim gejala');
            }
        }
