import { Head, Link } from '@inertiajs/react';

interface GejalaCocok {
    kode: string;
    nama: string;
    cf_pakar: number;
    cf_user: number;
    cf_gejala: number;
}

interface Penyakit {
    id: number;
    kode: string;
    nama: string;
    deskripsi: string;
    penyebab: string;
    rekomendasi: string;
}

interface HasilItem {
    penyakit_id: number;
    penyakit: Penyakit;
    cf_akhir: number;
    gejala_cocok: GejalaCocok[];
}

interface HasilProps {
    hasil: HasilItem[];
    top: HasilItem | null;
    penjelasan: string;
}

export default function Hasil({ hasil, top, penjelasan }: HasilProps) {
    return (
        <>
            <Head title="Hasil Diagnosis" />
            <div className="min-h-screen bg-gray-50 py-10 px-4">
                <div className="max-w-3xl mx-auto bg-white shadow rounded-2xl p-8">
                    <h1 className="text-2xl font-bold text-green-700 mb-4">
                        Hasil Diagnosis
                    </h1>

                    {!top ? (
                        <p className="text-red-500">
                            Tidak ada penyakit yang cocok dengan gejala yang dikonfirmasi.
                        </p>
                    ) : (
                        <>
                            <div className="bg-green-50 border-l-4 border-green-600 p-4 mb-4 rounded">
                                <p className="text-sm text-gray-600">Diagnosis Utama</p>
                                <p className="text-xl font-bold text-green-800">
                                    {top.penyakit.nama}
                                </p>
                                <p className="text-sm text-gray-600 mt-1">
                                    Tingkat keyakinan:{' '}
                                    <strong>
                                        {(top.cf_akhir * 100).toFixed(2)}%
                                    </strong>
                                </p>
                            </div>

                            <div className="prose max-w-none whitespace-pre-line mb-6">
                                {penjelasan}
                            </div>

                            <h2 className="text-lg font-semibold mt-6 mb-2">
                                Kemungkinan Lain
                            </h2>
                            <ul className="divide-y">
                                {hasil.slice(1).map((h) => (
                                    <li
                                        key={h.penyakit_id}
                                        className="py-2 flex justify-between"
                                    >
                                        <span>{h.penyakit.nama}</span>
                                        <span className="text-gray-600">
                                            {(h.cf_akhir * 100).toFixed(2)}%
                                        </span>
                                    </li>
                                ))}
                            </ul>
                        </>
                    )}

                    <div className="mt-8 flex gap-3">
                        <Link
                            href="/diagnosis"
                            className="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300"
                        >
                            Diagnosis Baru
                        </Link>
                    </div>
                </div>
            </div>
        </>
    );
}