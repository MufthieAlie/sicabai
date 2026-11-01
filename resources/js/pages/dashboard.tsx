import AppLayout from '@/layouts/app-layout';
import { Head, Link, usePage } from '@inertiajs/react';
import { Activity, BookOpen, ClipboardList, Leaf, ListChecks, Users } from 'lucide-react';
import type { BreadcrumbItem, SharedData } from '@/types';

interface DashboardProps {
    stats: {
        users: number;
        penyakit: number;
        gejalas: number;
        rules: number;
        diagnoses: number;
    };
}

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Dashboard', href: '/dashboard' }];

export default function Dashboard({ stats }: DashboardProps) {
    const { auth } = usePage<SharedData>().props;
    const isAdmin = auth.user.role === 'admin';
    const cards = [
        { label: 'Penyakit', value: stats.penyakit, icon: Leaf, href: '/dashboard/knowledge/penyakits', color: 'bg-emerald-100 text-emerald-700' },
        { label: 'Gejala', value: stats.gejalas, icon: ClipboardList, href: '/dashboard/knowledge/gejalas', color: 'bg-lime-100 text-lime-700' },
        { label: 'Rules', value: stats.rules, icon: ListChecks, href: '/dashboard/knowledge/rules', color: 'bg-amber-100 text-amber-700' },
        { label: 'Diagnosis tercatat', value: stats.diagnoses, icon: Activity, href: '/dashboard/history', color: 'bg-sky-100 text-sky-700' },
        ...(isAdmin ? [{ label: 'Akun user', value: stats.users, icon: Users, href: '/dashboard/users', color: 'bg-violet-100 text-violet-700' }] : []),
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard SiPakarCabai" />
            <main className="min-h-full bg-gradient-to-br from-green-50 via-white to-emerald-50 p-5 dark:from-[#0a0f0a] dark:via-[#101310] dark:to-[#0a0f0a] md:p-8">
                <div className="mx-auto max-w-7xl">
                    <section className="overflow-hidden rounded-3xl bg-gradient-to-r from-green-800 to-emerald-600 p-7 text-white shadow-lg md:p-10">
                        <div className="flex flex-col justify-between gap-6 md:flex-row md:items-center">
                            <div>
                                <span className="rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-wider">
                                    {isAdmin ? 'Administrator' : 'Pakar tanaman cabai'}
                                </span>
                                <h1 className="mt-4 text-3xl font-bold md:text-4xl">Halo, {auth.user.name}</h1>
                                <p className="mt-2 max-w-xl text-sm text-green-50 md:text-base">
                                    {isAdmin
                                        ? 'Kelola akun, pantau basis pengetahuan, dan perbarui sinonim untuk pencocokan gejala.'
                                        : 'Kelola basis pengetahuan dan tinjau riwayat diagnosis untuk membantu pengguna.'}
                                </p>
                            </div>
                            <Link href="/diagnosis" className="inline-flex items-center justify-center gap-2 self-start rounded-xl bg-white px-5 py-3 text-sm font-semibold text-green-800 shadow transition hover:bg-green-50 md:self-center">
                                <Leaf className="size-4" /> Mulai diagnosis
                            </Link>
                        </div>
                    </section>

                    <section className="mt-7 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
                        {cards.map(({ label, value, icon: Icon, href, color }) => (
                            <Link key={label} href={href} className="group rounded-2xl border border-green-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-gray-800 dark:bg-[#161a16]">
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-gray-500 dark:text-gray-400">{label}</span>
                                    <span className={`rounded-xl p-2 ${color}`}><Icon className="size-5" /></span>
                                </div>
                                <p className="mt-4 text-3xl font-bold text-gray-900 dark:text-white">{value}</p>
                                <p className="mt-2 text-xs font-medium text-green-700 group-hover:underline dark:text-green-400">Lihat data →</p>
                            </Link>
                        ))}
                    </section>

                    <section className="mt-7 grid gap-5 lg:grid-cols-2">
                        <div className="rounded-2xl border border-green-100 bg-white p-6 dark:border-gray-800 dark:bg-[#161a16]">
                            <div className="flex items-center gap-3">
                                <span className="rounded-xl bg-green-100 p-2 text-green-700"><BookOpen className="size-5" /></span>
                                <div>
                                    <h2 className="font-semibold text-gray-900 dark:text-white">Basis pengetahuan</h2>
                                    <p className="text-sm text-gray-500 dark:text-gray-400">Data yang digunakan sistem pakar.</p>
                                </div>
                            </div>
                            <div className="mt-5 flex flex-wrap gap-2">
                                <Link className="rounded-lg border px-3 py-2 text-sm hover:bg-green-50 dark:border-gray-700 dark:hover:bg-gray-800" href="/dashboard/knowledge/penyakits">Penyakit</Link>
                                <Link className="rounded-lg border px-3 py-2 text-sm hover:bg-green-50 dark:border-gray-700 dark:hover:bg-gray-800" href="/dashboard/knowledge/gejalas">Gejala</Link>
                                <Link className="rounded-lg border px-3 py-2 text-sm hover:bg-green-50 dark:border-gray-700 dark:hover:bg-gray-800" href="/dashboard/knowledge/rules">Rules & CF pakar</Link>
                                <Link className="rounded-lg border px-3 py-2 text-sm hover:bg-green-50 dark:border-gray-700 dark:hover:bg-gray-800" href="/dashboard/knowledge/synonyms">Sinonim fuzzy</Link>
                            </div>
                            {isAdmin && <p className="mt-4 text-xs text-gray-500">Data penyakit, gejala, dan rules hanya dapat dilihat oleh admin. Pakar dapat mengelolanya.</p>}
                        </div>
                        <div className="rounded-2xl border border-green-100 bg-white p-6 dark:border-gray-800 dark:bg-[#161a16]">
                            <div className="flex items-center gap-3">
                                <span className="rounded-xl bg-sky-100 p-2 text-sky-700"><Activity className="size-5" /></span>
                                <div>
                                    <h2 className="font-semibold text-gray-900 dark:text-white">Riwayat diagnosis</h2>
                                    <p className="text-sm text-gray-500 dark:text-gray-400">Tinjau hasil diagnosis yang telah tersimpan.</p>
                                </div>
                            </div>
                            <Link href="/dashboard/history" className="mt-5 inline-flex rounded-lg bg-green-700 px-4 py-2 text-sm font-medium text-white hover:bg-green-800">Lihat riwayat seluruh user</Link>
                        </div>
                    </section>
                </div>
            </main>
        </AppLayout>
    );
}
