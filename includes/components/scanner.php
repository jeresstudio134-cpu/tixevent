<?php
/**
 * includes/components/scanner.php
 * Komponen gate scanner: input/scan ID tiket dan konfirmasi check-in.
 */

function include_component_scanner() {
    global $participants;
    $scanInput = $_POST['scanInput'] ?? '';
    $scanResult = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'scan') {
        $code = strtoupper(trim($scanInput));
        $found = null;
        foreach ($participants as $p) {
            if ($p['id'] === $code) {
                $found = $p;
                break;
            }
        }

        if (!$found) {
            $scanResult = ['status' => 'error', 'message' => 'Tiket tidak ditemukan / tidak valid!'];
        } elseif ($found['isCheckedIn']) {
            $scanResult = ['status' => 'already_in', 'data' => $found, 'message' => 'Peserta sudah Check-in sebelumnya!'];
        } else {
            $scanResult = ['status' => 'success', 'data' => $found];
        }
    }

    // Handle check-in via form
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'checkin_scan') {
        $ticketId = $_POST['ticketId'] ?? '';
        foreach ($_SESSION['participants'] as &$p) {
            if ($p['id'] === $ticketId && !$p['isCheckedIn']) {
                $p['isCheckedIn'] = true;
                $p['checkInTime'] = date('Y-m-d H:i:s');
                $scanResult = ['status' => 'already_in', 'data' => $p, 'message' => 'Check-in Berhasil!'];
                break;
            }
        }
        unset($p);
        // Refresh data
        $participants = $_SESSION['participants'] ?? [];
    }
?>
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">Gate Scanner System</h1>
        <p class="text-slate-500">Arahkan QR Code peserta ke kamera atau ketik ID Tiket manual.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Scanner Area -->
        <div class="bg-slate-900 rounded-2xl overflow-hidden shadow-2xl border-4 border-slate-800 relative aspect-square flex flex-col items-center justify-center">
            <div class="absolute inset-10 border-2 border-indigo-500/50 rounded-lg"></div>
            <div class="absolute top-1/4 w-3/4 h-0.5 bg-red-500 shadow-[0_0_8px_rgba(239,68,68,1)] animate-pulse-slow"></div>

            <i class="fas fa-qrcode text-6xl text-slate-600 mb-4"></i>
            <p class="text-slate-400 text-sm">Kamera Aktif</p>

            <div class="absolute bottom-0 left-0 w-full bg-slate-800 p-4">
                <form method="POST" class="flex gap-2">
                    <input type="hidden" name="action" value="scan">
                    <input type="text" name="scanInput" value="" placeholder="ID Tiket (TKT-...)" class="flex-1 bg-slate-900 border border-slate-600 rounded px-3 py-2 text-white font-mono uppercase focus:outline-none focus:border-indigo-500" autofocus />
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded font-bold">Cek</button>
                </form>
            </div>
        </div>

        <!-- Hasil Scan -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 flex flex-col">
            <h2 class="text-lg font-bold text-slate-800 border-b pb-3 mb-4">Hasil Scan</h2>

            <?php if (!$scanResult): ?>
                <div class="flex-1 flex flex-col items-center justify-center text-slate-400">
                    <i class="fas fa-expand text-5xl mb-3 opacity-20"></i>
                    <p>Menunggu hasil scan...</p>
                </div>
            <?php elseif ($scanResult['status'] === 'error'): ?>
                <div class="flex-1 flex flex-col items-center justify-center text-center">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4 text-red-500">
                        <i class="fas fa-times text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Akses Ditolak</h3>
                    <p class="text-red-500 font-medium"><?= $scanResult['message'] ?></p>
                </div>
            <?php else: ?>
                <div class="flex-1 flex flex-col">
                    <div class="p-4 rounded-xl mb-6 text-center <?= $scanResult['status'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' ?>">
                        <div class="flex justify-center mb-2">
                            <i class="fas <?= $scanResult['status'] === 'success' ? 'fa-check-circle' : 'fa-times-circle' ?> text-4xl"></i>
                        </div>
                        <p class="font-bold text-lg"><?= $scanResult['message'] ?? 'Tiket Valid' ?></p>
                    </div>

                    <div class="space-y-4 flex-1">
                        <div>
                            <p class="text-sm text-slate-500">Nama Peserta</p>
                            <p class="text-xl font-bold text-slate-800"><?= htmlspecialchars($scanResult['data']['name']) ?></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-slate-500">ID Tiket</p>
                                <p class="font-mono font-bold text-slate-700"><?= $scanResult['data']['id'] ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Tipe Tiket</p>
                                <p class="font-bold text-indigo-600 uppercase"><?= getTicketTypeLabel($scanResult['data']['ticketType']) ?></p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Status Pembayaran</p>
                            <p class="font-bold text-green-600"><?= $scanResult['data']['statusPembayaran'] ?? 'Lunas' ?></p>
                        </div>
                    </div>

                    <?php if ($scanResult['status'] === 'success'): ?>
                        <form method="POST" class="mt-6">
                            <input type="hidden" name="action" value="checkin_scan">
                            <input type="hidden" name="ticketId" value="<?= $scanResult['data']['id'] ?>">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl text-lg shadow-lg flex justify-center items-center">
                                <i class="fas fa-check-circle mr-2"></i> Konfirmasi Check-in
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
}
