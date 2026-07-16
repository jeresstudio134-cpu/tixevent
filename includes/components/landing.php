<?php
/**
 * includes/components/landing.php
 * Komponen halaman beranda (hero, deskripsi, jingle, pilihan tiket).
 */

function include_component_landing_page() {
    global $TICKET_TYPES;
    $timeLeft = getTimeLeft();
?>
<div class="pb-12">

    <!-- Hero Banner -->
    <div class="relative bg-indigo-900 text-white py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-20 pattern-dots"></div>

        <div class="relative max-w-7xl mx-auto px-4 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-pink-500 text-sm font-semibold mb-4 tracking-wider">OFFICIAL EVENT TICKET
            </span>

            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-4"><?= EVENT_NAME ?>
            </h1>

            <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0 md:space-x-8 text-lg mt-6">
                <div class="flex items-center"><i class="fas fa-calendar-alt mr-2"></i> 31 Desember 2026</div>
                <div class="flex items-center"><i class="fas fa-map-marker-alt mr-2"></i> <?= EVENT_LOCATION ?></div>
            </div>

            <!-- Countdown -->
            <div class="mt-12 flex justify-center space-x-4 flex-wrap gap-2">
                <?php foreach ($timeLeft as $unit => $value): ?>
                <div class="bg-white/10 backdrop-blur-md rounded-lg p-4 min-w-[70px] md:min-w-[80px]">
                    <div class="text-2xl md:text-3xl font-bold" data-countdown="<?= $unit ?>"><?= $value ?></div>
                    <div class="text-xs uppercase tracking-widest text-indigo-200"><?= $unit ?></div>
                </div>
                <?php endforeach; ?>
            </div>

            <a href="?view=home&buy=true" class="inline-block mt-12 bg-pink-500 hover:bg-pink-600 text-white font-bold py-4 px-10 rounded-full text-lg shadow-[0_0_15px_rgba(236,72,153,0.5)] transition-all transform hover:scale-105">
                Beli Tiket Sekarang
            </a>
        </div>
    </div>

    <!-- Deskripsi & Media -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div>
                <h2 class="text-3xl font-bold mb-6 text-indigo-900">Tentang Event</h2>
                <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                    Bergabunglah dalam perayaan musik terbesar tahun ini! <?= EVENT_NAME ?> menghadirkan musisi papan atas nasional dan internasional. Nikmati pengalaman audio visual yang belum pernah Anda rasakan sebelumnya.
                </p>
                <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 flex items-start gap-4">
                    <i class="fas fa-music text-indigo-600 text-2xl flex-shrink-0 mt-1"></i>
                    <div class="flex-1">
                        <h3 class="font-bold text-indigo-900 mb-2">Dengarkan Jingle Resmi</h3>
                        <audio controls class="w-full" id="jingle" controls autoplay muted>
                        <source src="assets/audio/KICAU MANIA.mp3" type="audio/mpeg">
                        </audio>
                    </div>
                </div>
            </div>
            <div>
                <div class="relative rounded-2xl overflow-hidden shadow-xl bg-slate-900 aspect-video">
                    <iframe
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/ftC6Y8IU3Cg?autoplay=1&mute=1&loop=1&playlist=ftC6Y8IU3Cg"
                    title="Highlight Video Promosi"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                    </iframe>

                    <div class="absolute bottom-4 left-4 text-white font-bold bg-black/50 px-3 py-1 rounded">
                    Highlight Video Promosi
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pilihan Tiket -->
    <div class="bg-slate-100 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-10 text-center text-indigo-900">Pilihan Tiket</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($TICKET_TYPES as $ticket): ?>
                <div class="bg-white rounded-2xl shadow-lg p-8 border-t-4 border-pink-500 hover:shadow-xl transition-shadow flex flex-col">
                    <h3 class="text-2xl font-bold text-slate-800"><?= $ticket['name'] ?></h3>
                    <p class="text-4xl font-extrabold text-indigo-600 my-4"><?= formatRupiah($ticket['price']) ?></p>
                    <p class="text-slate-500 mb-8 flex-grow"><?= $ticket['desc'] ?></p>
                    <a href="?view=home&buy=true&type=<?= $ticket['id'] ?>" class="w-full bg-indigo-900 hover:bg-indigo-800 text-white font-bold py-3 rounded-lg transition-colors text-center">
                        Pilih <?= $ticket['name'] ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php
}
