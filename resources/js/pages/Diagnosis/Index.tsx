import { Head, Link, usePage } from '@inertiajs/react';
import type { SharedData } from '@/types';
import type { FormEvent, ChangeEvent, KeyboardEvent } from 'react';
import { useRef, useEffect, useState } from 'react';
import axios from 'axios';

// ============ Tipe Data ============
interface Gejala {
    kode: string;
    nama: string;
    sesuai?: boolean;
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
}

interface ChatMessage {
    id: string;
    role: 'user' | 'ai';
    type: 'text' | 'konfirmasi' | 'hasil';
    content?: string;
    gejala?: Gejala[];
    hasil?: HasilItem[];
    top?: HasilItem | null;
    penjelasan?: string;
}

// ============ Quick Prompts ============
const QUICK_PROMPTS = [
    'Daun cabai saya bercak-bercak coklat dan buahnya keriput',
    'Tanaman cabai saya layu padahal tanahnya basah',
    'Daun menguning, pertumbuhan terhambat, ada kutu putih',
    'Buah cabai ada bercak hitam dan membusuk',
    'Akar tanaman cabai membusuk dan berwarna coklat',
];

export default function Index() {
    const { auth } = usePage<SharedData>().props;
    // ============ State ============
    const [messages, setMessages] = useState<ChatMessage[]>([
        {
            id: 'welcome',
            role: 'ai',
            type: 'text',
            content:
                'Halo! 👋 Saya SiPakarCabai, asisten diagnosis penyakit tanaman cabai Anda.\n\nCeritakan kondisi tanaman cabai Anda dengan bahasa sehari-hari. Saya akan membantu mengidentifikasi kemungkinan penyakitnya berdasarkan gejala yang Anda sebutkan.',
        },
    ]);
    const [input, setInput] = useState('');
    const [loading, setLoading] = useState(false);
    const [step, setStep] = useState<'input' | 'konfirmasi' | 'hasil'>('input');
    const [currentGejala, setCurrentGejala] = useState<Gejala[]>([]);
    const [currentTeksAsli, setCurrentTeksAsli] = useState('');

    const textareaRef = useRef<HTMLTextAreaElement>(null);
    const chatEndRef = useRef<HTMLDivElement>(null);

    // Auto-scroll ke bawah saat pesan baru
    useEffect(() => {
        chatEndRef.current?.scrollIntoView({ behavior: 'smooth' });
    }, [messages, loading]);

    // Auto-resize textarea
    useEffect(() => {
        if (textareaRef.current) {
            textareaRef.current.style.height = 'auto';
            textareaRef.current.style.height =
                Math.min(textareaRef.current.scrollHeight, 200) + 'px';
        }
    }, [input]);

    // ============ Kirim teks → panggil LLM (ekstrak gejala) ============
    const handleSubmitTeks = async (e?: FormEvent) => {
        e?.preventDefault();
        const teks = input.trim();
        if (!teks || loading) return;

        // Tambah pesan user
        const userMsg: ChatMessage = {
            id: 'u-' + Date.now(),
            role: 'user',
            type: 'text',
            content: teks,
        };
        setMessages((prev) => [...prev, userMsg]);
        setInput('');
        setLoading(true);
        setStep('konfirmasi');

        try {
            const res = await axios.post('/diagnosis/ekstrak', { teks });
            const { gejala, fallbackLokal } = res.data;

            if (!gejala || gejala.length === 0) {
                // Tidak menemukan gejala
                setMessages((prev) => [
                    ...prev,
                    {
                        id: 'a-' + Date.now(),
                        role: 'ai',
                        type: 'text',
                        content:
                            fallbackLokal
                                ? 'Layanan AI sedang tidak tersedia dan pencocokan lokal belum menemukan gejala yang cocok. Coba ceritakan lebih detail, misalnya bagian mana yang bermasalah dan seperti apa bentuknya.'
                                : 'Maaf, saya tidak menemukan gejala yang cocok dari deskripsi Anda. Coba ceritakan lebih detail, misalnya bagian mana yang bermasalah dan seperti apa bentuknya.',
                    },
                ]);
                setStep('input');
            } else {
                // Simpan untuk konfirmasi
                setCurrentGejala(
                    gejala.map((g: Gejala) => ({ ...g, sesuai: true }))
                );
                setCurrentTeksAsli(teks);

                // Tampilkan bubble konfirmasi
                setMessages((prev) => [
                    ...prev,
                    {
                        id: 'a-' + Date.now(),
                        role: 'ai',
                        type: 'konfirmasi',
                        content:
                            'Saya mendeteksi beberapa gejala dari deskripsi Anda. Mohon konfirmasi gejala yang **benar-benar ada** pada tanaman Anda:' +
                            (fallbackLokal
                                ? '\n\nCatatan: layanan AI sedang tidak tersedia. Gejala dicocokkan secara lokal berdasarkan kata kunci, jadi mohon periksa kembali hasilnya.'
                                : ''),
                        gejala: gejala.map((g: Gejala) => ({
                            ...g,
                            sesuai: true,
                        })),
                    },
                ]);
            }
        } catch {
            setMessages((prev) => [
                ...prev,
                {
                    id: 'a-' + Date.now(),
                    role: 'ai',
                    type: 'text',
                    content:
                        'Terjadi kesalahan saat memproses. Silakan coba lagi.',
                },
            ]);
            setStep('input');
        } finally {
            setLoading(false);
        }
    };

    // ============ Toggle checkbox konfirmasi ============
    const toggleGejala = (kode: string) => {
        setCurrentGejala((prev) =>
            prev.map((g) =>
                g.kode === kode ? { ...g, sesuai: !g.sesuai } : g
            )
        );
        // Update juga di message bubble
        setMessages((prev) =>
            prev.map((m) =>
                m.type === 'konfirmasi' && m.gejala
                    ? {
                          ...m,
                          gejala: m.gejala.map((g) =>
                              g.kode === kode
                                  ? { ...g, sesuai: !g.sesuai }
                                  : g
                          ),
                      }
                    : m
            )
        );
    };

    // ============ Kirim konfirmasi → hitung CF ============
    const handleSubmitKonfirmasi = async () => {
        const dipilih = currentGejala.filter((g) => g.sesuai);
        if (dipilih.length === 0) return;

        setLoading(true);
        setStep('hasil');

        try {
            const res = await axios.post('/diagnosis/proses', {
                teks_asli: currentTeksAsli,
                gejala: currentGejala,
            });
            const { hasil, top, penjelasan } = res.data;

            // Tambah bubble hasil
            setMessages((prev) => [
                ...prev,
                {
                    id: 'a-' + Date.now(),
                    role: 'ai',
                    type: 'hasil',
                    hasil,
                    top,
                    penjelasan,
                },
            ]);
        } catch {
            setMessages((prev) => [
                ...prev,
                {
                    id: 'a-' + Date.now(),
                    role: 'ai',
                    type: 'text',
                    content: 'Terjadi kesalahan saat menghitung diagnosis.',
                },
            ]);
        } finally {
            setLoading(false);
        }
    };

    // ============ Reset untuk diagnosis baru ============
    const resetChat = () => {
        setMessages([
            {
                id: 'welcome-' + Date.now(),
                role: 'ai',
                type: 'text',
                content:
                    'Baik, mari mulai diagnosis baru. Ceritakan kondisi tanaman cabai Anda.',
            },
        ]);
        setStep('input');
        setCurrentGejala([]);
        setCurrentTeksAsli('');
    };

    const handleKeyDown = (e: KeyboardEvent<HTMLTextAreaElement>) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            handleSubmitTeks();
        }
    };

    const pickPrompt = (p: string) => {
        setInput(p);
        textareaRef.current?.focus();
    };

    // ============ Render ============
    return (
        <>
            <Head title="Diagnosis Penyakit Cabai" />

            <div className="flex h-screen flex-col bg-gradient-to-br from-green-50 via-white to-emerald-50 dark:from-[#0a0f0a] dark:via-[#0a0a0a] dark:to-[#0a0f0a]">
                {/* Header */}
                <header className="border-b border-green-100 bg-white/80 backdrop-blur-sm dark:border-gray-800 dark:bg-[#0a0a0a]/80">
                    <div className="mx-auto flex max-w-4xl items-center justify-between px-4 py-3">
                        <div className="flex items-center gap-3">
                            <div className="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-lg shadow-md">
                                🌶️
                            </div>
                            <div>
                                <h1 className="text-sm font-bold text-gray-900 dark:text-white">
                                    SiPakarCabai AI
                                </h1>
                            </div>
                        </div>
                    <div className="flex items-center gap-2 text-xs">
                        <button
                            onClick={resetChat}
                            className="rounded-full border border-green-200 px-3 py-1 text-xs text-green-700 hover:bg-green-50 dark:border-gray-700 dark:text-green-400 dark:hover:bg-gray-800"
                        >
                            🔄 Diagnosis Baru
                        </button>
                        <Link href="/diagnosis/history" className="rounded-full border border-green-200 px-3 py-1 text-green-700 hover:bg-green-50 dark:border-gray-700 dark:text-green-400">
                            Riwayat
                        </Link>
                        {auth.user.role !== 'user' && (
                            <Link href="/dashboard" className="rounded-full bg-green-700 px-3 py-1 text-white hover:bg-green-800">
                                Dashboard
                            </Link>
                        )}
                    </div>
                    </div>
                </header>

                {/* Chat area */}
                <main className="flex-1 overflow-y-auto px-4 py-6">
                    <div className="mx-auto max-w-3xl space-y-4">
                        {messages.map((m) => (
                            <MessageBubble
                                key={m.id}
                                message={m}
                                onToggleGejala={toggleGejala}
                                onSubmitKonfirmasi={handleSubmitKonfirmasi}
                                loading={loading}
                            />
                        ))}

                        {/* Typing indicator */}
                        {loading && (
                            <div className="flex gap-3">
                                <AiAvatar />
                                <div className="rounded-2xl rounded-tl-sm bg-white px-5 py-4 shadow-sm ring-1 ring-green-100 dark:bg-[#161615] dark:ring-gray-800">
                                    <div className="flex items-center gap-2">
                                        <span className="text-sm text-gray-600 dark:text-gray-300">
                                            Sedang menganalisis
                                        </span>
                                        <span className="flex gap-1">
                                            {[0, 150, 300].map((d) => (
                                                <span
                                                    key={d}
                                                    className="h-1.5 w-1.5 animate-bounce rounded-full bg-green-500"
                                                    style={{
                                                        animationDelay: `${d}ms`,
                                                    }}
                                                />
                                            ))}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        )}

                        <div ref={chatEndRef} />
                    </div>
                </main>

                {/* Quick prompts (hanya saat step input) */}
                {step === 'input' && messages.length <= 1 && (
                    <div className="px-4 pb-2">
                        <div className="mx-auto max-w-3xl">
                            <p className="mb-2 text-xs text-gray-500">
                                💡 Coba salah satu contoh:
                            </p>
                            <div className="flex flex-wrap gap-2">
                                {QUICK_PROMPTS.map((p, i) => (
                                    <button
                                        key={i}
                                        onClick={() => pickPrompt(p)}
                                        className="rounded-full border border-green-200 bg-white px-3 py-1.5 text-left text-xs text-gray-700 transition hover:border-green-400 hover:bg-green-50 dark:border-gray-700 dark:bg-[#161615] dark:text-gray-300 dark:hover:border-green-600"
                                    >
                                        {p}
                                    </button>
                                ))}
                            </div>
                        </div>
                    </div>
                )}

                {/* Input box */}
                <div className="border-t border-green-100 bg-white/80 px-4 py-3 backdrop-blur-sm dark:border-gray-800 dark:bg-[#0a0a0a]/80">
                    <form
                        onSubmit={handleSubmitTeks}
                        className="mx-auto max-w-3xl"
                    >
                        <div className="relative flex items-end gap-2 rounded-3xl border border-green-200 bg-white p-2 shadow-lg transition focus-within:border-green-400 focus-within:ring-2 focus-within:ring-green-100 dark:border-gray-700 dark:bg-[#161615]">
                            <textarea
                                ref={textareaRef}
                                rows={1}
                                value={input}
                                onChange={(
                                    e: ChangeEvent<HTMLTextAreaElement>
                                ) => setInput(e.target.value)}
                                onKeyDown={handleKeyDown}
                                placeholder={
                                    step === 'input'
                                        ? 'Ceritakan gejala tanaman cabai Anda...'
                                        : 'Selesaikan konfirmasi di atas...'
                                }
                                disabled={loading || step !== 'input'}
                                className="flex-1 resize-none border-0 bg-transparent px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0 disabled:opacity-50 dark:text-white dark:placeholder-gray-500"
                            />
                            <button
                                type="submit"
                                disabled={
                                    loading ||
                                    step !== 'input' ||
                                    !input.trim()
                                }
                                className="mb-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-md transition hover:from-green-600 hover:to-emerald-700 disabled:cursor-not-allowed disabled:opacity-40"
                            >
                                <svg
                                    className="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="M5 12h14M12 5l7 7-7 7"
                                    />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}

// ============ Sub-components ============
function AiAvatar() {
    return (
        <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-emerald-600 text-sm shadow">
            🌶️
        </div>
    );
}

function MessageBubble({
    message,
    onToggleGejala,
    onSubmitKonfirmasi,
    loading,
}: {
    message: ChatMessage;
    onToggleGejala: (kode: string) => void;
    onSubmitKonfirmasi: () => void;
    loading: boolean;
}) {
    // User bubble
    if (message.role === 'user') {
        return (
            <div className="flex justify-end gap-3">
                <div className="max-w-[85%] rounded-2xl rounded-tr-sm bg-green-600 px-5 py-3 text-sm text-white shadow-sm">
                    {message.content}
                </div>
                <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-300 text-sm dark:bg-gray-700">
                    👤
                </div>
            </div>
        );
    }

    // AI bubble
    return (
        <div className="flex gap-3">
            <AiAvatar />
            <div className="max-w-[85%] flex-1">
                {/* Teks biasa */}
                {message.type === 'text' && (
                    <div className="whitespace-pre-line rounded-2xl rounded-tl-sm bg-white px-5 py-4 text-sm leading-relaxed text-gray-800 shadow-sm ring-1 ring-green-100 dark:bg-[#161615] dark:text-gray-200 dark:ring-gray-800">
                        {message.content}
                    </div>
                )}

                {/* Konfirmasi gejala */}
                {message.type === 'konfirmasi' && message.gejala && (
                    <div className="rounded-2xl rounded-tl-sm bg-white p-5 shadow-sm ring-1 ring-green-100 dark:bg-[#161615] dark:ring-gray-800">
                        <p className="mb-3 text-sm text-gray-800 dark:text-gray-200">
                            {message.content}
                        </p>
                        <div className="space-y-2">
                            {message.gejala.map((g) => (
                                <label
                                    key={g.kode}
                                    className="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 p-3 transition hover:bg-green-50 dark:border-gray-700 dark:hover:bg-green-900/20"
                                >
                                    <input
                                        type="checkbox"
                                        checked={!!g.sesuai}
                                        onChange={() => onToggleGejala(g.kode)}
                                        className="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                    />
                                    <span className="flex-1 text-sm text-gray-800 dark:text-gray-200">
                                        {g.nama}
                                    </span>
                                    <span className="text-xs text-gray-400">
                                        {g.kode}
                                    </span>
                                </label>
                            ))}
                        </div>
                        <button
                            onClick={onSubmitKonfirmasi}
                            disabled={loading}
                            className="mt-4 w-full rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-green-700 disabled:opacity-50"
                        >
                            {loading ? 'Menghitung...' : 'Proses Diagnosis'}
                        </button>
                    </div>
                )}

                {/* Hasil diagnosis */}
                {message.type === 'hasil' && message.top && (
                    <div className="rounded-2xl rounded-tl-sm bg-white p-5 shadow-sm ring-1 ring-green-100 dark:bg-[#161615] dark:ring-gray-800">
                        <div className="mb-4 rounded-lg border-l-4 border-green-600 bg-green-50 p-4 dark:bg-green-900/20">
                            <p className="text-xs text-gray-600 dark:text-gray-400">
                                Diagnosis Utama
                            </p>
                            <p className="text-lg font-bold text-green-800 dark:text-green-300">
                                {message.top.penyakit.nama}
                            </p>
                            <p className="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                Tingkat keyakinan:{' '}
                                <strong>
                                    {(message.top.cf_akhir * 100).toFixed(2)}%
                                </strong>
                            </p>
                        </div>

                        <div className="whitespace-pre-line text-sm text-gray-800 dark:text-gray-200">
                            {message.penjelasan}
                        </div>

                        {message.hasil && message.hasil.length > 1 && (
                            <>
                                <h3 className="mt-4 mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                    Kemungkinan Lain
                                </h3>
                                <ul className="divide-y divide-gray-100 dark:divide-gray-800">
                                    {message.hasil.slice(1).map((h) => (
                                        <li
                                            key={h.penyakit_id}
                                            className="flex justify-between py-2 text-sm"
                                        >
                                            <span className="text-gray-800 dark:text-gray-200">
                                                {h.penyakit.nama}
                                            </span>
                                            <span className="text-gray-500">
                                                {(h.cf_akhir * 100).toFixed(2)}
                                                %
                                            </span>
                                        </li>
                                    ))}
                                </ul>
                            </>
                        )}
                    </div>
                )}
            </div>
        </div>
    );
}