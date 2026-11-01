import AppLayout from '@/layouts/app-layout';
import { Head, router } from '@inertiajs/react';
import { Users } from 'lucide-react';
import type { BreadcrumbItem } from '@/types';

interface UserRow {
    id: number;
    name: string;
    email: string;
    created_at: string;
}

export default function UsersPage({ users }: { users: UserRow[] }) {
    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Dashboard', href: '/dashboard' },
        { title: 'Pengelolaan Akun', href: '/dashboard/users' },
    ];

    const removeUser = (user: UserRow) => {
        if (window.confirm(`Hapus akun ${user.name} (${user.email})?`)) {
            router.delete(route('dashboard.users.destroy', user.id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Pengelolaan Akun" />
            <main className="min-h-full bg-gradient-to-br from-green-50 via-white to-emerald-50 p-5 dark:from-[#0a0f0a] dark:via-[#101310] dark:to-[#0a0f0a] md:p-8">
                <div className="mx-auto max-w-6xl">
                    <div className="mb-6 flex items-center gap-4 rounded-2xl bg-white p-6 shadow-sm dark:bg-[#161a16]">
                        <span className="rounded-2xl bg-violet-100 p-3 text-violet-700"><Users className="size-6" /></span>
                        <div>
                            <h1 className="text-2xl font-bold text-gray-900 dark:text-white">Pengelolaan Akun User</h1>
                            <p className="mt-1 text-sm text-gray-500">Admin dapat menghapus akun yang terdaftar. Total: {users.length} user.</p>
                        </div>
                    </div>
                    <div className="overflow-hidden rounded-2xl border border-green-100 bg-white shadow-sm dark:border-gray-800 dark:bg-[#161a16]">
                        <div className="overflow-x-auto">
                            <table className="w-full text-left text-sm">
                                <thead className="bg-green-50 text-xs uppercase text-green-900 dark:bg-green-950/40 dark:text-green-200">
                                    <tr><th className="px-5 py-4">Nama</th><th className="px-5 py-4">Email</th><th className="px-5 py-4">Terdaftar</th><th className="px-5 py-4 text-right">Aksi</th></tr>
                                </thead>
                                <tbody className="divide-y divide-gray-100 dark:divide-gray-800">
                                    {users.map((user) => (
                                        <tr key={user.id}>
                                            <td className="px-5 py-4 font-medium text-gray-900 dark:text-white">{user.name}</td>
                                            <td className="px-5 py-4 text-gray-600 dark:text-gray-300">{user.email}</td>
                                            <td className="px-5 py-4 text-gray-500">{new Date(user.created_at).toLocaleDateString('id-ID')}</td>
                                            <td className="px-5 py-4 text-right">
                                                <button onClick={() => removeUser(user)} className="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 dark:border-red-900 dark:text-red-300">Hapus akun</button>
                                            </td>
                                        </tr>
                                    ))}
                                    {users.length === 0 && <tr><td colSpan={4} className="px-5 py-12 text-center text-gray-500">Belum ada akun user terdaftar.</td></tr>}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </AppLayout>
    );
}
