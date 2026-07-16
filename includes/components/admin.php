<?php
/**
 * includes/components/admin.php
 * Komponen dashboard admin: statistik, filter, dan tabel database peserta.
 */

function include_component_admin() {
    global $participants;

    $totalTerjual = count($participants);
    $totalHadir = 0;
    $totalBelum = 0;
    $countReguler = 0;
    $countVIP = 0;
    $countVVIP = 0;

    foreach ($participants as $p) {
        if ($p['isCheckedIn']) $totalHadir++;
        if ($p['ticketType'] === 'reguler') $countReguler++;
        elseif ($p['ticketType'] === 'vip') $countVIP++;
        elseif ($p['ticketType'] === 'vvip') $countVVIP++;
    }
    $totalBelum = $totalTerjual - $totalHadir;

    // Filter
    $filterName = $_GET['filterName'] ?? '';
    $filterType = $_GET['filterType'] ?? 'all';
    $filterStatus = $_GET['filterStatus'] ?? 'all';

    $filteredData = array_filter($participants, function($p) use ($filterName, $filterType, $filterStatus) {
        $matchName = stripos($p['name'], $filterName) !== false || stripos($p['id'], $filterName) !== false;
        $matchType = $filterType === 'all' ? true : $p['ticketType'] === $filterType;
        $matchStatus = $filterStatus === 'all' ? true : ($filterStatus === 'hadir' ? $p['isCheckedIn'] : !$p['isCheckedIn']);
        return $matchName && $matchType && $matchStatus;
    });
?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Dashboard Admin</h1>
            <p class="text-slate-500">Kelola Event, Tiket, dan Peserta</p>
        </div>
        <div>
            <button onclick="window.location.href='?view=admin&export=true'" class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg font-medium hover:bg-emerald-200 inline-flex items-center">
                <i class="fas fa-download mr-2"></i> Export Excel
            </button>
        </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200 flex items-center">
            <div class="p-4 rounded-full bg-indigo-500 text-white mr-4"><i class="fas fa-ticket-alt text-xl"></i></div>
            <div><p class="text-sm font-medium text-slate-500 mb-1">Total Tiket Terjual</p><p class="text-2xl font-bold text-slate-800"><?= $totalTerjual ?></p></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200 flex items-center">
            <div class="p-4 rounded-full bg-green-500 text-white mr-4"><i class="fas fa-check-circle text-xl"></i></div>
            <div><p class="text-sm font-medium text-slate-500 mb-1">Peserta Hadir</p><p class="text-2xl font-bold text-slate-800"><?= $totalHadir ?></p></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200 flex items-center">
            <div class="p-4 rounded-full bg-amber-500 text-white mr-4"><i class="fas fa-users text-xl"></i></div>
            <div><p class="text-sm font-medium text-slate-500 mb-1">Belum Hadir</p><p class="text-2xl font-bold text-slate-800"><?= $totalBelum ?></p></div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
            <h3 class="text-sm font-medium text-slate-500 mb-2">Penjualan per Tipe</h3>
            <div class="space-y-2 text-sm font-bold text-slate-700">
                <div class="flex justify-between"><span>Reguler:</span> <span><?= $countReguler ?></span></div>
                <div class="flex justify-between"><span>VIP:</span> <span class="text-pink-500"><?= $countVIP ?></span></div>
                <div class="flex justify-between"><span>VVIP:</span> <span class="text-amber-500"><?= $countVVIP ?></span></div>
            </div>
        </div>
    </div>

    <!-- Database Peserta -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-200 bg-slate-50 flex flex-col md:flex-row gap-4 items-center justify-between">
            <h2 class="font-bold text-lg text-slate-800">Database Peserta</h2>
            <form method="GET" class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <input type="hidden" name="view" value="admin">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="filterName" placeholder="Cari Nama / ID Tiket..." value="<?= htmlspecialchars($filterName) ?>" class="pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-sm w-full focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                <select name="filterType" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-indigo-500">
                    <option value="all">Semua Tipe</option>
                    <option value="reguler" <?= $filterType === 'reguler' ? 'selected' : '' ?>>Reguler</option>
                    <option value="vip" <?= $filterType === 'vip' ? 'selected' : '' ?>>VIP</option>
                    <option value="vvip" <?= $filterType === 'vvip' ? 'selected' : '' ?>>VVIP</option>
                </select>
                <select name="filterStatus" class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-indigo-500">
                    <option value="all">Semua Status</option>
                    <option value="hadir" <?= $filterStatus === 'hadir' ? 'selected' : '' ?>>Hadir (Checked-in)</option>
                    <option value="belum" <?= $filterStatus === 'belum' ? 'selected' : '' ?>>Belum Hadir</option>
                </select>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">Filter</button>
                <a href="?view=admin" class="text-slate-500 hover:text-slate-700 px-3 py-2 text-sm">Reset</a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-slate-700 uppercase font-semibold text-xs">
                    <tr>
                        <th class="px-6 py-4">ID Tiket</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">WhatsApp / Asal</th>
                        <th class="px-6 py-4">Tipe & Pembayaran</th>
                        <th class="px-6 py-4">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php if (count($filteredData) > 0): ?>
                        <?php foreach ($filteredData as $p): ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-mono font-bold text-slate-800"><?= $p['id'] ?></td>
                            <td class="px-6 py-4 font-medium text-slate-900"><?= htmlspecialchars($p['name']) ?></td>
                            <td class="px-6 py-4">
                                <div><?= htmlspecialchars($p['whatsapp']) ?></div>
                                <div class="text-xs text-slate-400"><?= htmlspecialchars($p['city'] ?? '') ?>, <?= htmlspecialchars($p['province'] ?? '') ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 rounded text-xs font-bold uppercase mb-1 <?= getTicketTypeClass($p['ticketType']) ?>">
                                    <?= getTicketTypeLabel($p['ticketType']) ?>
                                </span>
                                <div class="text-xs text-slate-500"><?= $p['paymentMethod'] ?? '-' ?> - <?= $p['statusPembayaran'] ?? 'Lunas' ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($p['isCheckedIn']): ?>
                                    <span class="flex items-center text-green-600 font-medium">
                                        <i class="fas fa-check-circle mr-1"></i> Hadir
                                        <span class="text-xs text-slate-400 ml-2">(<?= date('H:i', strtotime($p['checkInTime'])) ?>)</span>
                                    </span>
                                <?php else: ?>
                                    <span class="text-slate-400">Belum Hadir</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">Tidak ada data peserta yang sesuai filter.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
}
