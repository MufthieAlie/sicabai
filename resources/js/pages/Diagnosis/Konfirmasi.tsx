import { Head, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';

interface GejalaItem {
    kode: string;
    nama: string;
    sesuai: boolean;
}

interface KonfirmasiProps {
    teksAsli: string;
    teksNormal: string;
    gejala: { kode: string; nama: string }[];
    confidence: number;
}

export default function Konfirmasi({
    teksAsli,
    teksNormal,
    gejala,
    confidence,
}: KonfirmasiProps) {
    const { data, setData, post, processing } = useForm({
        teks_asli: teksAsli,
        gejala: gejala.map((g): GejalaItem => ({
            kode: g.kode,
            nama: g.nama,
            sesuai: true,
        })),
    });

    const toggle = (i: number) => {
        const baru = [...data.gejala];
        baru[i] = { ...baru[i], sesuai: !baru[i].sesuai };
        setData('gejala', baru);
    };

    const submit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post('/diagnosis/proses');
    };

    return (
        <>
            <Head title="Konfirmasi Gejala" />
            <div className="min-h-screen bg-gray-50 py-10 px-4">
                <div className="max-w-2xl mx-auto bg-white shadow rounded-2xl p-8">
                    <h1 className="text-2xl font-bold text-green-700 mb-2">
                        Konfirmasi Gejala
                    </h1>
                    <p className="text-gray-600 mb-4">
                        Sistem mendeteksi gejala berikut dari deskripsi Anda:
                    </p>
                    {teksNormal !== teksAsli && (
                        <p className="text-sm text-gray-500 italic mb-4">
                            (Teks dinormalisasi: &quot;{teksNormal}&quot;)
                        </p>
                    )}

                    <div className="space-y-3 mb-6">
                        {data.gejala.map((g: GejalaItem, i: number) => (
                            <label
                                key={g.kode}
                                className="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50"
                            >
                                <input
                                    type="checkbox"
                                    checked={g.sesuai}
                                    onChange={() => toggle(i)}
                                    className="w-5 h-5 text-green-600"
                                />
                                <span className="font-medium">{g.nama}</span>
                                <span className="text-xs text-gray-400 ml-auto">
                                    ({g.kode})
                                </span>
                            </label>
                        ))}
                    </div>

                    <p className="text-sm text-gray-500 mb-4">
                        Centang gejala yang <strong>benar-benar ada</strong> pada tanaman
                        Anda. Gejala yang tidak dicentang akan diabaikan.
                    </p>

                    <form onSubmit={submit}>
                        <button
                            type="submit"
                            disabled={
                                processing ||
                                data.gejala.every((g: GejalaItem) => !g.sesuai)
                            }
                            className="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 disabled:opacity-50"
                        >
                            {processing ? 'Menghitung...' : 'Proses Diagnosis'}
                        </button>
                    </form>
                </div>
            </div>
        </>
    );
}