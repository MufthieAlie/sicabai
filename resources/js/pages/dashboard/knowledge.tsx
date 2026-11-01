import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';
import { Head, router, useForm, Link } from '@inertiajs/react';
import { Plus, X } from 'lucide-react';
import { useState } from 'react';

type Resource = 'penyakits' | 'gejalas' | 'rules' | 'synonyms';
type Row = {
    id: number;
    kode?: string;
    nama?: string;
    deskripsi?: string;
    penyebab?: string;
    rekomendasi?: string;
    penyakit_id?: number;
    gejala_id?: number | null;
    cf_pakar?: number;
    penyakit?: { kode: string; nama: string } | null;
    gejala?: { kode: string; nama: string } | null;
    kata_tidak_baku?: string;
    kata_baku?: string;
};
type Option = { id: number; kode: string; nama: string };
type SynonymGroup = {
    key: string;
    gejala_id: number | null;
    gejala: { kode: string; nama: string } | null;
    kata_baku: string;
    aliases: string[];
};
type Field = { name: string; label: string; type?: 'textarea' | 'select'; options?: Option[] };

const labels: Record<Resource, string> = {
    penyakits: 'Data Penyakit',
    gejalas: 'Data Gejala',
    rules: 'Rules Diagnosis',
    synonyms: 'Sinonim Gejala',
};

const fieldSets = (resource: Resource, penyakits: Option[], gejalas: Option[]): Field[] => {
    if (resource === 'penyakits')
        return [
            { name: 'kode', label: 'Kode penyakit' },
            { name: 'nama', label: 'Nama penyakit' },
            { name: 'deskripsi', label: 'Deskripsi', type: 'textarea' },
            { name: 'penyebab', label: 'Penyebab', type: 'textarea' },
            { name: 'rekomendasi', label: 'Rekomendasi penanganan', type: 'textarea' },
        ];
    if (resource === 'gejalas')
        return [
            { name: 'kode', label: 'Kode gejala' },
            { name: 'nama', label: 'Nama gejala' },
        ];
    if (resource === 'rules')
        return [
            { name: 'penyakit_id', label: 'Penyakit', type: 'select', options: penyakits },
            { name: 'gejala_id', label: 'Gejala', type: 'select', options: gejalas },
            { name: 'cf_pakar', label: 'CF Pakar (0–1)' },
        ];
    return [];
};

function rowValue(row: Row, field: string): string {
    if (field === 'penyakit_id') return row.penyakit ? `${row.penyakit.kode} — ${row.penyakit.nama}` : '—';
    if (field === 'gejala_id') return row.gejala ? `${row.gejala.kode} — ${row.gejala.nama}` : '—';
    const value = row[field as keyof Row];
    return value === null || value === undefined ? '—' : String(value);
}

export default function KnowledgePage({
    resource,
    rows,
    penyakits,
    gejalas,
    canManage,
}: {
    resource: Resource;
    rows: Row[];
    penyakits: Option[];
    gejalas: Option[];
    canManage: boolean;
}) {
    const [editing, setEditing] = useState<number | null>(null);
    const [editingSynonymGroup, setEditingSynonymGroup] = useState<SynonymGroup | null>(null);
    const [selectedPenyakitFilter, setSelectedPenyakitFilter] = useState<string>('');
    const fields = fieldSets(resource, penyakits, gejalas);
    const form = useForm<Record<string, string>>(Object.fromEntries(fields.map(({ name }) => [name, ''])));
    const synonymForm = useForm<{
        gejala_id: string;
        kata_baku: string;
        kata_tidak_baku: string[];
        original_gejala_id: string;
        original_kata_baku: string;
    }>({
        gejala_id: '',
        kata_baku: '',
        kata_tidak_baku: [''],
        original_gejala_id: '',
        original_kata_baku: '',
    });

    const synonymGroups =
        resource === 'synonyms'
            ? Object.values(
                  rows.reduce<Record<string, SynonymGroup>>((groups, row) => {
                      const key = JSON.stringify([row.gejala_id ?? null, row.kata_baku ?? '']);
                      groups[key] ??= {
                          key,
                          gejala_id: row.gejala_id ?? null,
                          gejala: row.gejala ?? null,
                          kata_baku: row.kata_baku ?? '',
                          aliases: [],
                      };
                      if (row.kata_tidak_baku) groups[key].aliases.push(row.kata_tidak_baku);
                      return groups;
                  }, {}),
              )
            : [];

    const filteredRows =
        resource === 'rules' && selectedPenyakitFilter ? rows.filter((row) => String(row.penyakit_id) === selectedPenyakitFilter) : rows;

    const breadcrumbs: BreadcrumbItem[] = [
        { title: 'Dashboard', href: '/dashboard' },
        { title: labels[resource], href: `/dashboard/knowledge/${resource}` },
    ];

    const startEdit = (row: Row) => {
        setEditing(row.id);
        const values: Record<string, string> = {};
        fields.forEach(({ name }) => {
            const value = row[name as keyof Row];
            values[name] = value === null || value === undefined ? '' : String(value);
        });
        form.setData(values);
    };

    const clearForm = () => {
        setEditing(null);
        setEditingSynonymGroup(null);
        form.reset();
        form.clearErrors();
        synonymForm.reset();
        synonymForm.clearErrors();
    };

    const submit = (event: React.FormEvent) => {
        event.preventDefault();
        const options = { onSuccess: clearForm };
        if (resource === 'synonyms') {
            const data = {
                gejala_id: synonymForm.data.gejala_id || null,
                kata_baku: synonymForm.data.kata_baku,
                kata_tidak_baku: synonymForm.data.kata_tidak_baku.filter((alias) => alias.trim() !== ''),
                ...(editingSynonymGroup && {
                    original_gejala_id: editingSynonymGroup.gejala_id,
                    original_kata_baku: editingSynonymGroup.kata_baku,
                }),
            };
            if (editingSynonymGroup) {
                synonymForm.transform(() => data);
                synonymForm.put(route('dashboard.knowledge.synonyms.update-group'), options);
            } else {
                synonymForm.transform(() => data);
                synonymForm.post(route('dashboard.knowledge.synonyms.store-group'), options);
            }
            return;
        }
        if (editing) {
            form.put(route('dashboard.knowledge.update', { resource, id: editing }), options);
        } else {
            form.post(route('dashboard.knowledge.store', resource), options);
        }
    };

    const startEditSynonymGroup = (group: SynonymGroup) => {
        setEditing(null);
        setEditingSynonymGroup(group);
        synonymForm.clearErrors();
        synonymForm.setData({
            gejala_id: group.gejala_id ? String(group.gejala_id) : '',
            kata_baku: group.kata_baku,
            kata_tidak_baku: group.aliases.length ? [...group.aliases] : [''],
            original_gejala_id: group.gejala_id ? String(group.gejala_id) : '',
            original_kata_baku: group.kata_baku,
        });
    };

    const removeSynonymGroup = (group: SynonymGroup) => {
        if (window.confirm(`Hapus kelompok sinonim "${group.kata_baku}" beserta ${group.aliases.length} kata tidak bakunya?`)) {
            router.delete(route('dashboard.knowledge.synonyms.destroy-group'), {
                data: { gejala_id: group.gejala_id, kata_baku: group.kata_baku },
                preserveScroll: true,
            });
        }
    };

    const remove = (row: Row) => {
        if (window.confirm('Hapus data ini? Tindakan ini tidak dapat dibatalkan.')) {
            router.delete(route('dashboard.knowledge.destroy', { resource, id: row.id }));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={labels[resource]} />
            <main className="min-h-full bg-gradient-to-br from-green-50 via-white to-emerald-50 p-5 md:p-8 dark:from-[#0a0f0a] dark:via-[#101310] dark:to-[#0a0f0a]">
                <div className="mx-auto max-w-7xl">
                    <div className="mb-6 flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <p className="text-sm font-semibold text-green-700 dark:text-green-400">Basis Pengetahuan SiPakarCabai</p>
                            <h1 className="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{labels[resource]}</h1>
                            <p className="mt-2 text-sm text-gray-500">
                                {canManage ? 'Tambah, ubah, atau hapus data.' : 'Mode baca saja — perubahan hanya dapat dilakukan oleh pakar.'}
                            </p>
                        </div>
                        <div className="flex gap-2 text-xs">
                            {(['penyakits', 'gejalas', 'rules', 'synonyms'] as Resource[]).map((item) => (
                                <Link
                                    key={item}
                                    href={`/dashboard/knowledge/${item}`}
                                    preserveScroll
                                    className={`rounded-lg px-3 py-2 ${
                                        item === resource
                                            ? 'bg-green-700 text-white'
                                            : 'border bg-white text-gray-700 hover:bg-green-50 dark:border-gray-700 dark:bg-[#161a16] dark:text-gray-300'
                                    }`}
                                >
                                    {labels[item]}
                                </Link>
                            ))}
                        </div>
                    </div>

                    {canManage && resource === 'synonyms' && (
                        <form
                            onSubmit={submit}
                            className="mb-6 grid gap-4 rounded-2xl border border-green-100 bg-white p-5 shadow-sm md:grid-cols-2 dark:border-gray-800 dark:bg-[#161a16]"
                        >
                            <div className="md:col-span-2">
                                <h2 className="font-semibold text-gray-900 dark:text-white">
                                    {editingSynonymGroup ? 'Ubah kelompok sinonim' : 'Tambah kelompok sinonim'}
                                </h2>
                                <p className="mt-1 text-sm text-gray-500">
                                    Masukkan satu kata tidak baku di setiap kolom. Tekan tombol + untuk menambahkan alias sebelum menyimpan.
                                </p>
                            </div>
                            <label className="grid gap-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama gejala (opsional)
                                <select
                                    value={synonymForm.data.gejala_id}
                                    onChange={(event) => synonymForm.setData('gejala_id', event.target.value)}
                                    className="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                >
                                    <option value="">Tanpa gejala khusus</option>
                                    {gejalas.map((gejala) => (
                                        <option key={gejala.id} value={gejala.id}>
                                            {gejala.kode} — {gejala.nama}
                                        </option>
                                    ))}
                                </select>
                                {synonymForm.errors.gejala_id && <span className="text-xs text-red-600">{synonymForm.errors.gejala_id}</span>}
                            </label>
                            <label className="grid gap-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kata baku
                                <input
                                    value={synonymForm.data.kata_baku}
                                    onChange={(event) => synonymForm.setData('kata_baku', event.target.value)}
                                    placeholder="Contoh: busuk"
                                    className="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                />
                                {synonymForm.errors.kata_baku && <span className="text-xs text-red-600">{synonymForm.errors.kata_baku}</span>}
                            </label>
                            <div className="grid gap-2 md:col-span-2">
                                <span className="text-sm font-medium text-gray-700 dark:text-gray-300">Kata tidak baku</span>
                                {synonymForm.data.kata_tidak_baku.map((alias, index) => (
                                    <div key={index} className="flex items-start gap-2">
                                        <div className="flex-1">
                                            <input
                                                value={alias}
                                                onChange={(event) => {
                                                    const aliases = [...synonymForm.data.kata_tidak_baku];
                                                    aliases[index] = event.target.value;
                                                    synonymForm.setData('kata_tidak_baku', aliases);
                                                }}
                                                placeholder={index === 0 ? 'Contoh: busukan' : 'Kata tidak baku lainnya'}
                                                className="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                            />
                                            {synonymForm.errors[`kata_tidak_baku.${index}`] && (
                                                <span className="text-xs text-red-600">{synonymForm.errors[`kata_tidak_baku.${index}`]}</span>
                                            )}
                                        </div>
                                        {synonymForm.data.kata_tidak_baku.length > 1 && (
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    synonymForm.setData(
                                                        'kata_tidak_baku',
                                                        synonymForm.data.kata_tidak_baku.filter((_, itemIndex) => itemIndex !== index),
                                                    )
                                                }
                                                aria-label="Hapus input kata tidak baku"
                                                className="rounded-lg border p-2 text-gray-500 hover:bg-red-50 hover:text-red-600 dark:border-gray-700"
                                            >
                                                <X className="size-4" />
                                            </button>
                                        )}
                                    </div>
                                ))}
                                {synonymForm.errors.kata_tidak_baku && (
                                    <span className="text-xs text-red-600">{synonymForm.errors.kata_tidak_baku}</span>
                                )}
                                <button
                                    type="button"
                                    onClick={() => synonymForm.setData('kata_tidak_baku', [...synonymForm.data.kata_tidak_baku, ''])}
                                    className="inline-flex w-fit items-center gap-1 rounded-lg border border-green-200 px-3 py-2 text-sm font-medium text-green-800 hover:bg-green-50 dark:border-green-900 dark:text-green-300"
                                >
                                    <Plus className="size-4" /> Tambah kata tidak baku
                                </button>
                            </div>
                            <div className="flex items-center gap-2 md:col-span-2">
                                <button
                                    disabled={synonymForm.processing}
                                    className="rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800 disabled:opacity-50"
                                >
                                    {editingSynonymGroup ? 'Simpan perubahan' : 'Simpan kelompok sinonim'}
                                </button>
                                {editingSynonymGroup && (
                                    <button
                                        type="button"
                                        onClick={clearForm}
                                        className="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-800"
                                    >
                                        Batal
                                    </button>
                                )}
                            </div>
                        </form>
                    )}

                    {canManage && resource !== 'synonyms' && (
                        <form
                            onSubmit={submit}
                            className="mb-6 grid gap-4 rounded-2xl border border-green-100 bg-white p-5 shadow-sm md:grid-cols-2 dark:border-gray-800 dark:bg-[#161a16]"
                        >
                            <div className="md:col-span-2">
                                <h2 className="font-semibold text-gray-900 dark:text-white">
                                    {editing ? 'Ubah data' : `Tambah ${labels[resource].toLowerCase()}`}
                                </h2>
                            </div>
                            {fields.map((field) => (
                                <label key={field.name} className="grid gap-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {field.label}
                                    {field.type === 'textarea' ? (
                                        <textarea
                                            value={form.data[field.name] ?? ''}
                                            onChange={(event) => form.setData(field.name, event.target.value)}
                                            rows={3}
                                            className="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                        />
                                    ) : field.type === 'select' ? (
                                        <select
                                            value={form.data[field.name] ?? ''}
                                            onChange={(event) => form.setData(field.name, event.target.value)}
                                            className="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                        >
                                            <option value="">Pilih {field.label.toLowerCase()}</option>
                                            {field.options?.map((option) => (
                                                <option key={option.id} value={option.id}>
                                                    {option.kode} — {option.nama}
                                                </option>
                                            ))}
                                        </select>
                                    ) : (
                                        <input
                                            value={form.data[field.name] ?? ''}
                                            onChange={(event) => form.setData(field.name, event.target.value)}
                                            className="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                        />
                                    )}
                                    {form.errors[field.name] && <span className="text-xs text-red-600">{form.errors[field.name]}</span>}
                                </label>
                            ))}
                            <div className="flex items-center gap-2 md:col-span-2">
                                <button
                                    disabled={form.processing}
                                    className="rounded-lg bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-800 disabled:opacity-50"
                                >
                                    {editing ? 'Simpan perubahan' : 'Tambah data'}
                                </button>
                                {editing && (
                                    <button
                                        type="button"
                                        onClick={clearForm}
                                        className="rounded-lg border px-4 py-2 text-sm hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-800"
                                    >
                                        Batal
                                    </button>
                                )}
                            </div>
                        </form>
                    )}

                    <div className="overflow-hidden rounded-2xl border border-green-100 bg-white shadow-sm dark:border-gray-800 dark:bg-[#161a16]">
                        <div className="overflow-x-auto">
                            {resource === 'synonyms' ? (
                                <table className="w-full min-w-[640px] text-left text-sm">
                                    <thead className="bg-green-50 text-xs text-green-900 uppercase dark:bg-green-950/40 dark:text-green-200">
                                        <tr>
                                            <th className="px-4 py-3">Nama gejala</th>
                                            <th className="px-4 py-3">Kata baku</th>
                                            <th className="px-4 py-3">Kata tidak baku</th>
                                            {canManage && <th className="px-4 py-3 text-right">Aksi</th>}
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-100 dark:divide-gray-800">
                                        {synonymGroups.map((group) => (
                                            <tr key={group.key} className="align-top">
                                                <td className="px-4 py-4 text-gray-700 dark:text-gray-300">
                                                    {group.gejala ? `${group.gejala.kode} — ${group.gejala.nama}` : '—'}
                                                </td>
                                                <td className="px-4 py-4 font-medium text-gray-900 dark:text-white">{group.kata_baku || '—'}</td>
                                                <td className="px-4 py-4">
                                                    <div className="flex flex-wrap gap-2">
                                                        {group.aliases.map((alias) => (
                                                            <span
                                                                key={alias}
                                                                className="rounded-full border border-green-200 bg-green-50 px-2.5 py-1 text-xs text-green-800 dark:border-green-900 dark:bg-green-950/40 dark:text-green-200"
                                                            >
                                                                {alias}
                                                            </span>
                                                        ))}
                                                    </div>
                                                </td>
                                                {canManage && (
                                                    <td className="px-4 py-4 text-right whitespace-nowrap">
                                                        <button
                                                            onClick={() => startEditSynonymGroup(group)}
                                                            className="mr-2 rounded-md border px-2.5 py-1.5 text-xs hover:bg-green-50 dark:border-gray-700 dark:hover:bg-gray-800"
                                                        >
                                                            Ubah
                                                        </button>
                                                        <button
                                                            onClick={() => removeSynonymGroup(group)}
                                                            className="rounded-md border border-red-200 px-2.5 py-1.5 text-xs text-red-700 hover:bg-red-50 dark:border-red-900 dark:text-red-300"
                                                        >
                                                            Hapus
                                                        </button>
                                                    </td>
                                                )}
                                            </tr>
                                        ))}
                                        {synonymGroups.length === 0 && (
                                            <tr>
                                                <td colSpan={canManage ? 4 : 3} className="px-4 py-12 text-center text-gray-500">
                                                    Belum ada data sinonim.
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            ) : (
                                <table className="w-full min-w-[640px] text-left text-sm">
                                    <thead className="bg-green-50 text-xs text-green-900 uppercase dark:bg-green-950/40 dark:text-green-200">
                                        <tr>
                                            {fields.map((field) => (
                                                <th key={field.name} className="px-4 py-3">
                                                    {resource === 'rules' && field.name === 'penyakit_id' ? (
                                                        <div className="flex items-center gap-2">
                                                            <span>Penyakit:</span>
                                                            <select
                                                                value={selectedPenyakitFilter}
                                                                onChange={(event) => setSelectedPenyakitFilter(event.target.value)}
                                                                className="rounded-md border border-gray-300 bg-white px-2 py-1 text-xs font-normal text-gray-700 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                                            >
                                                                <option value="">Semua Penyakit</option>
                                                                {penyakits.map((p) => (
                                                                    <option key={p.id} value={p.id}>
                                                                        {p.nama}
                                                                    </option>
                                                                ))}
                                                            </select>
                                                        </div>
                                                    ) : (
                                                        field.label
                                                    )}
                                                </th>
                                            ))}
                                            {canManage && <th className="px-4 py-3 text-right">Aksi</th>}
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-100 dark:divide-gray-800">
                                        {filteredRows.map((row) => (
                                            <tr key={row.id} className="align-top">
                                                {fields.map((field) => (
                                                    <td
                                                        key={field.name}
                                                        className="max-w-sm px-4 py-3 whitespace-pre-wrap text-gray-700 dark:text-gray-300"
                                                    >
                                                        {rowValue(row, field.name)}
                                                    </td>
                                                ))}
                                                {canManage && (
                                                    <td className="px-4 py-3 text-right whitespace-nowrap">
                                                        <button
                                                            onClick={() => startEdit(row)}
                                                            className="mr-2 rounded-md border px-2.5 py-1.5 text-xs hover:bg-green-50 dark:border-gray-700 dark:hover:bg-gray-800"
                                                        >
                                                            Ubah
                                                        </button>
                                                        <button
                                                            onClick={() => remove(row)}
                                                            className="rounded-md border border-red-200 px-2.5 py-1.5 text-xs text-red-700 hover:bg-red-50 dark:border-red-900 dark:text-red-300"
                                                        >
                                                            Hapus
                                                        </button>
                                                    </td>
                                                )}
                                            </tr>
                                        ))}
                                        {filteredRows.length === 0 && (
                                            <tr>
                                                <td colSpan={fields.length + (canManage ? 1 : 0)} className="px-4 py-12 text-center text-gray-500">
                                                    {selectedPenyakitFilter ? 'Tidak ada rule untuk penyakit ini.' : 'Belum ada data.'}
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            )}
                        </div>
                        {resource === 'rules' && (
                            <p className="border-t px-4 py-3 text-xs text-gray-500 dark:border-gray-800">
                                CF Pakar menggunakan nilai 0 sampai 1. Setiap pasangan penyakit dan gejala hanya boleh memiliki satu rule.
                            </p>
                        )}
                    </div>
                </div>
            </main>
        </AppLayout>
    );
}
