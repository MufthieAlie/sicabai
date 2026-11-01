import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
// lokasi : pages/welcome.tsx

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Sistem Pakar Diagnosis Penyakit Cabai">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link
                    href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
                    rel="stylesheet"
                />
            </Head>

            <div className="flex min-h-screen flex-col bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
                {/* Header */}
                <header className="w-full border-b border-[#19140035] dark:border-[#3E3E3A]">
                    <div className="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                        <div className="flex items-center gap-2">
                            <span className="text-xl font-bold text-green-700 dark:text-green-400">
                                🌶️ SiPakarCabai
                            </span>
                        </div>
                        <nav className="flex items-center gap-3">
                            {auth.user ? (
                                <Link
                                    href={auth.user.role === 'user' ? '/diagnosis' : route('dashboard')}
                                    className="rounded-md border border-[#19140035] px-4 py-1.5 text-sm hover:border-[#1915014a] dark:border-[#3E3E3A] dark:hover:border-[#62605b]"
                                >
                                    {auth.user.role === 'user' ? 'Mulai Diagnosis' : 'Dashboard'}
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="rounded-md border border-transparent px-4 py-1.5 text-sm hover:border-[#19140035] dark:hover:border-[#3E3E3A]"
                                    >
                                        Masuk
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="rounded-md border border-[#19140035] bg-green-600 px-4 py-1.5 text-sm text-white hover:bg-green-700"
                                    >
                                        Daftar
                                    </Link>
                                </>
                            )}
                        </nav>
                    </div>
                </header>

                {/* Hero Section */}
                <main className="mx-auto flex w-full max-w-6xl flex-1 flex-col items-center justify-center px-6 py-16">
                    <div className="text-center">
                        <span className="inline-block rounded-full bg-green-100 px-4 py-1 text-xs font-semibold text-green-700 dark:bg-green-900 dark:text-green-300">
                            Sistem Pakar Berbasis Website
                        </span>
                        <h1 className="mt-4 text-4xl font-bold tracking-tight lg:text-5xl">
                            Diagnosis Penyakit <br />
                            <span className="text-green-700 dark:text-green-400">
                                Tanaman Cabai
                            </span>
                        </h1>
                        <p className="mx-auto mt-4 max-w-2xl text-[#706f6c] dark:text-[#A1A09A]">
                            Ceritakan kondisi tanaman cabai Anda dengan bahasa sehari-hari.
                            Sistem akan menganalisis gejala menggunakan metode{' '}
                            <strong>Forward Chaining</strong> dan{' '}
                            <strong>Certainty Factor</strong>, dengan bantuan{' '}
                            <strong>Large Language Model</strong> untuk memahami input
                            bahasa alami Anda.
                        </p>
                    </div>

                    {/* CTA */}
                    <div className="mt-8 flex flex-wrap items-center justify-center gap-3">
                        <Link
                            href="/diagnosis"
                            className="rounded-lg bg-green-600 px-6 py-3 text-base font-medium text-white shadow-md transition hover:bg-green-700"
                        >
                            Mulai Diagnosis
                        </Link>
                        <a
                            href="#cara-kerja"
                            className="rounded-lg border border-[#19140035] px-6 py-3 text-base font-medium hover:border-[#1915014a] dark:border-[#3E3E3A]"
                        >
                            Cara Kerja
                        </a>
                    </div>

                    {/* Fitur Utama */}
                    <section className="mt-16 grid w-full gap-6 md:grid-cols-3">
                        <FeatureCard
                            icon="🌿"
                            title="Input Bahasa Alami"
                            desc="Tidak perlu memilih dari daftar rumit. Cukup ceritakan gejala yang Anda lihat pada tanaman cabai Anda."
                        />
                        <FeatureCard
                            icon="🧠"
                            title="Penalaran Pakar"
                            desc="Menggunakan Forward Chaining untuk menelusuri aturan IF-THEN dan Certainty Factor untuk menghitung tingkat keyakinan."
                        />
                        <FeatureCard
                            icon="📋"
                            title="Penjelasan Transparan"
                            desc="Hasil diagnosis disertai penjelasan penyakit, penyebab, gejala terdeteksi, dan rekomendasi penanganan awal."
                        />
                    </section>

                    {/* Cara Kerja */}
                    <section
                        id="cara-kerja"
                        className="mt-20 w-full rounded-2xl bg-white p-8 shadow-sm dark:bg-[#161615]"
                    >
                        <h2 className="mb-6 text-2xl font-bold">Cara Kerja Sistem</h2>
                        <ol className="space-y-4">
                            {[
                                'Anda mengetik deskripsi kondisi tanaman cabai dalam bahasa sehari-hari (contoh: "daunnya ada totol-totol coklat dan akarnya buruk").',
                                'Large Language Model (Gemini) mengekstrak gejala dari teks Anda dan memetakannya ke basis pengetahuan pakar.',
                                'Anda mengonfirmasi gejala yang benar-benar ada pada tanaman Anda.',
                                'Sistem menghitung tingkat keyakinan diagnosis menggunakan metode Forward Chaining dan Certainty Factor.',
                                'Sistem menampilkan hasil diagnosis beserta penjelasan dan rekomendasi penanganan awal.',
                            ].map((step, i) => (
                                <li key={i} className="flex gap-4">
                                    <span className="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-600 text-sm font-bold text-white">
                                        {i + 1}
                                    </span>
                                    <p className="text-[#706f6c] dark:text-[#A1A09A]">
                                        {step}
                                    </p>
                                </li>
                            ))}
                        </ol>
                    </section>

                    {/* Catatan */}
                    <p className="mt-10 max-w-2xl text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        ⚠️ Hasil sistem ini merupakan <strong>diagnosis awal</strong>{' '}
                        untuk membantu proses konsultasi, bukan untuk menggantikan peran
                        tenaga ahli pertanian.
                    </p>
                </main>

                {/* Footer */}
                <footer className="border-t border-[#19140035] py-6 text-center text-sm text-[#706f6c] dark:border-[#3E3E3A] dark:text-[#A1A09A]">
                    © {new Date().getFullYear()} SiPakarCabai — Skripsi Mufthie Alie
                    (H1D023042), Informatika Unsoed.
                </footer>
            </div>
        </>
    );
}

function FeatureCard({
    icon,
    title,
    desc,
}: {
    icon: string;
    title: string;
    desc: string;
}) {
    return (
        <div className="rounded-2xl border border-[#19140035] bg-white p-6 shadow-sm dark:border-[#3E3E3A] dark:bg-[#161615]">
            <div className="mb-3 text-3xl">{icon}</div>
            <h3 className="mb-2 text-lg font-semibold">{title}</h3>
            <p className="text-sm text-[#706f6c] dark:text-[#A1A09A]">{desc}</p>
        </div>
    );
}