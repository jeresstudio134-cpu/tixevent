<?php
/**
 * includes/components/ticket.php
 * Komponen tampilan tiket digital setelah pembelian berhasil.
 */

function include_component_ticket() {
    global $TICKET_TYPES;
    $ticket = $_SESSION['currentTicket'] ?? null;
    if (!$ticket) {
        header('Location: index.php?view=home');
        exit;
    }

    $selectedTicket = null;
    foreach ($TICKET_TYPES as $t) {
        if ($t['id'] === $ticket['ticketType']) $selectedTicket = $t;
    }
?>
<div class="py-12 px-4 flex justify-center items-center min-h-[calc(100vh-64px)] bg-slate-200">
    <div class="max-w-md w-full">
        <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-6 flex items-center shadow-sm">
            <i class="fas fa-check-circle mr-3 text-xl flex-shrink-0"></i>
            <div>
                <p class="font-bold">Pembayaran Berhasil!</p>
                <p class="text-sm">Tiket digital Anda telah diterbitkan.</p>
            </div>
        </div>

        <!-- Tiket -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden relative border border-slate-100">
            <div class="bg-indigo-900 text-white p-6 text-center relative border-b-4 border-pink-500">
                <h2 class="text-2xl font-bold uppercase tracking-wider"><?= EVENT_NAME ?></h2>
                <p class="text-indigo-200 mt-2 text-sm"><?= EVENT_LOCATION ?></p>
                <p class="text-indigo-200 text-sm">31 Des 2026 | 18:00 WIB</p>
            </div>

            <div class="p-6 border-b-2 border-dashed border-slate-300 relative">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-widest">Nama Peserta</p>
                        <p class="font-bold text-lg text-slate-800 uppercase"><?= htmlspecialchars($ticket['name']) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-400 uppercase tracking-widest">Kategori</p>
                        <p class="font-bold text-lg uppercase <?= $ticket['ticketType'] === 'vvip' ? 'text-amber-500' : ($ticket['ticketType'] === 'vip' ? 'text-pink-500' : 'text-indigo-600') ?>">
                            <?= getTicketTypeLabel($ticket['ticketType']) ?>
                        </p>
                    </div>
                </div>

                <div class="flex justify-between items-center bg-slate-50 p-4 rounded-xl">
                    <div class="text-center">
                        <p class="text-xs text-slate-400 mb-2">QR Code Gate</p>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= urlencode($ticket['id']) ?>" alt="QR Code" class="w-24 h-24 mx-auto rounded border border-slate-200 p-1 bg-white" />
                    </div>
                    <div class="text-right flex flex-col justify-between h-full">
                        <div>
                            <p class="text-xs text-slate-400">No. Tiket / ID</p>
                            <p class="font-mono font-bold text-slate-700"><?= $ticket['id'] ?></p>
                        </div>
                        <div class="mt-4">
                            <p class="text-xs text-slate-400">Status Pembayaran</p>
                            <p class="text-sm font-bold text-green-600"><?= $ticket['statusPembayaran'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 text-center">
                <div class="w-full h-12 bg-[repeating-linear-gradient(90deg,#1e293b_0,#1e293b_2px,transparent_2px,transparent_4px,#1e293b_4px,#1e293b_8px,transparent_8px,transparent_12px)] opacity-50 mb-2"></div>
                <p class="font-mono text-xs text-slate-500 tracking-widest"><?= $ticket['id'] ?></p>
            </div>
        </div>

        <div class="mt-8 flex space-x-4">
            <button onclick="window.print()" class="flex-1 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 py-3 rounded-xl flex items-center justify-center font-medium shadow-sm">
                <i class="fas fa-download mr-2"></i> Cetak / PDF
            </button>
            <a href="https://wa.me/62<?= preg_replace('/[^0-9]/', '', $ticket['whatsapp']) ?>?text=Halo%20<?= urlencode($ticket['name']) ?>%2C%20berikut%20tiket%20Anda%3A%20<?= urlencode($ticket['id']) ?>" target="_blank" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl flex items-center justify-center font-medium shadow-sm shadow-green-500/30">
                <i class="fab fa-whatsapp mr-2"></i> Kirim ke WA
            </a>
        </div>
        <a href="?view=home" class="w-full block mt-4 text-slate-500 hover:text-slate-800 text-sm font-medium text-center">Kembali ke Beranda</a>
    </div>
</div>
<?php
}
