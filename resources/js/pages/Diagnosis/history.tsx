import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { Leaf } from 'lucide-react';
import type { BreadcrumbItem } from '@/types';

interface HistoryItem {
    id: number;
    input_asli: string;
    gejala_terdeteksi: string[] | null;
    cf_akhir: number | null;
    penjelasan: string | null;
    created_at: string;
    penyakit: { kode: string; nama: string } | null;
    user: { name: string; email: string } | null;
}

interface PaginatedHistory {
    data: HistoryItem[];
    links: { url: string | null; label: string; active: boolean }[];
}

export default function DiagnosisHistory({ history, includeUser }: { history: PaginatedHistory; includeUser: boolean }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: includeUser ? 'Dashboard' : 'Diagnosis', href: includeUser ? '/dashboard' : '/diagnosis' },
        { title: 'Riwayat Diagnosis', href: includeUser ? '/dashboard/history' : '/diagnosis/history' },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Riwayat Diagnosis" />
            <main className="min-h-full bg-gradient-to-br from-green-50 via-white to-emerald-50 p-5 dark:from-[#0a0f0a] dark:via-[#101310] dark:to-[#0a0f0a] md:p-8">
                <div className="mx-auto max-w-5xl">
                    <div className="mb-6 flex items-center justify-between gap-4 rounded-2xl bg-white p-6 shadow-sm dark:bg-[#161a16]">
                        <div>
                            <h1 className="text-2xl font-bold text-gray-900 dark:text-white">{includeUser ? 'Riwayat Diagnosis Pengguna' : 'Riwayat Diagnosis Saya'}</h1>
                            <p className="mt-1 text-sm text-gray-500">{includeUser ? 'Riwayat seluruh pengguna (hanya baca).' : 'Daftar diagnosis yang pernah Anda lakukan.'}</p>
                        </div>
                        <Link href="/diagnosis" className="shrink-0 rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800">Diagnosis baru</Link>
                    </div>

                    <div className="space-y-4">
                        {history.data.map((item) => (
                            <article key={item.id} className="rounded-2xl border border-green-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-[#161a16]">
                                <div className="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        {includeUser && <p className="mb-1 text-xs font-semibold text-green-700 dark:text-green-400">{item.user?.name ?? 'Akun telah dihapus'}{item.user?.email ? ` · ${item.user.email}` : ''}</p>}
                                        <p className="text-xs text-gray-500">{new Date(item.created_at).toLocaleString('id-ID')}</p>
                                        <h2 className="mt-2 flex items-center gap-2 text-lg font-bold text-gray-900 dark:text-white"><Leaf className="size-4 text-green-600" />{item.penyakit?.nama ?? 'Belum ada hasil diagnosis'}</h2>
                                    </div>
                                    {item.cf_akhir !== null && <span className="rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-800 dark:bg-green-900/40 dark:text-green-200">{(Number(item.cf_akhir) * 100).toFixed(2)}%</span>}
                                </div>
                                <div className="mt-4 rounded-xl bg-gray-50 p-4 dark:bg-gray-900/60">
                                    <p className="text-xs font-semibold uppercase tracking-wide text-gray-500">Deskripsi gejala</p>
                                    <p className="mt-1 text-sm text-gray-700 dark:text-gray-300">{item.input_asli}</p>
                                </div>
                                <div className="mt-3 flex flex-wrap gap-2">
                                    {(item.gejala_terdeteksi ?? []).map((code) => <span key={code} className="rounded-full border border-green-200 px-2.5 py-1 text-xs text-green-800 dark:border-green-900 dark:text-green-300">{code}</span>)}
                                </div>
                            </article>
                        ))}
                        {history.data.length === 0 && <div className="rounded-2xl border border-dashed border-green-300 bg-white p-12 text-center text-sm text-gray-500 dark:border-gray-800 dark:bg-[#161a16]">Belum ada riwayat diagnosis.</div>}
                    </div>

                    {history.links.length > 3 && <nav className="mt-6 flex flex-wrap justify-center gap-2">{history.links.map((link, index) => <Link key={index} href={link.url ?? '#'} preserveScroll className={`rounded-lg border px-3 py-2 text-xs ${link.active ? 'border-green-700 bg-green-700 text-white' : 'border-gray-200 bg-white text-gray-700 dark:border-gray-700 dark:bg-[#161a16] dark:text-gray-300'} ${!link.url ? 'pointer-events-none opacity-50' : ''}`} dangerouslySetInnerHTML={{ __html: link.label }} />)}</nav>}
                </div>
            </main>
        </AppLayout>
    );
}
