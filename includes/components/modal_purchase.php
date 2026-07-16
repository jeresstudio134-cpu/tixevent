<?php
/**
 * includes/components/modal_purchase.php
 * Komponen modal form pembelian tiket (step 1: data diri, step 2: pembayaran).
 */

function include_modal_purchase() {
    global $TICKET_TYPES, $PAYMENT_METHODS;
    $selectedType = $_GET['type'] ?? 'reguler';
    $step = $_GET['step'] ?? 1;
?>
<div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden my-8">
        <div class="bg-indigo-900 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold">Formulir Pembelian Tiket</h2>
            <a href="?view=home" class="hover:text-pink-400"><i class="fas fa-times"></i></a>
        </div>

        <div class="p-6">
            <!-- Step Indicator -->
            <div class="flex mb-8 items-center justify-center space-x-4">
                <div class="flex items-center <?= $step >= 1 ? 'text-indigo-600' : 'text-slate-400' ?>">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold mr-2 <?= $step >= 1 ? 'bg-indigo-600' : 'bg-slate-300' ?>">1</div>
                    <span>Data Diri</span>
                </div>
                <div class="w-12 h-1 bg-slate-200"><div class="h-full <?= $step >= 2 ? 'bg-indigo-600' : '' ?>"></div></div>
                <div class="flex items-center <?= $step >= 2 ? 'text-indigo-600' : 'text-slate-400' ?>">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold mr-2 <?= $step >= 2 ? 'bg-indigo-600' : 'bg-slate-300' ?>">2</div>
                    <span>Pembayaran</span>
                </div>
            </div>

            <?php if ($step == 3): ?>
                <div class="text-center py-12">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-indigo-600 mx-auto mb-4"></div>
                    <h3 class="text-xl font-bold text-slate-800">Memproses Pembayaran...</h3>
                    <p class="text-slate-500">Mohon tunggu sebentar, tiket sedang dibuat.</p>
                    <meta http-equiv="refresh" content="2; url=index.php?view=home">
                </div>
            <?php else: ?>
                <form method="POST" action="index.php?view=home">
                    <input type="hidden" name="action" value="buy_ticket">
                    <input type="hidden" name="step" value="<?= $step ?>">

                    <?php if ($step == 1): ?>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Tiket</label>
                                <select name="ticketType" class="w-full border border-slate-300 rounded-lg p-3 focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50">
                                    <?php foreach ($TICKET_TYPES as $t): ?>
                                    <option value="<?= $t['id'] ?>" <?= $selectedType === $t['id'] ? 'selected' : '' ?>>
                                        <?= $t['name'] ?> - <?= formatRupiah($t['price']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                                    <input required type="text" name="name" class="w-full border border-slate-300 rounded-lg p-3" placeholder="Sesuai KTP" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp</label>
                                    <input required type="tel" name="whatsapp" class="w-full border border-slate-300 rounded-lg p-3" placeholder="08123456789" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir</label>
                                <input required type="date" name="dob" class="w-full border border-slate-300 rounded-lg p-3" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Kota</label>
                                    <input required type="text" name="city" class="w-full border border-slate-300 rounded-lg p-3" placeholder="Contoh: Jakarta Selatan" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Provinsi</label>
                                    <input required type="text" name="province" class="w-full border border-slate-300 rounded-lg p-3" placeholder="Contoh: DKI Jakarta" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end space-x-3 border-t pt-4">
                            <a href="?view=home" class="px-6 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">Batal</a>
                            <button type="submit" name="next_step" value="2" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg">
                                Lanjut Pembayaran
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if ($step == 2): ?>
                        <?php
                        $selectedTicket = null;
                        foreach ($TICKET_TYPES as $t) {
                            if ($t['id'] === $selectedType) $selectedTicket = $t;
                        }
                        ?>
                        <div>
                            <div class="bg-indigo-50 p-4 rounded-lg mb-6 border border-indigo-100">
                                <h4 class="font-bold text-indigo-900 text-lg mb-2">Ringkasan Pesanan</h4>
                                <div class="flex justify-between text-sm mb-1"><span>Tiket:</span> <span><?= $selectedTicket ? $selectedTicket['name'] : '' ?></span></div>
                                <div class="flex justify-between font-bold text-lg mt-3 pt-3 border-t border-indigo-200">
                                    <span>Total Bayar:</span> <span class="text-pink-600"><?= $selectedTicket ? formatRupiah($selectedTicket['price']) : '' ?></span>
                                </div>
                            </div>

                            <label class="block text-sm font-bold text-slate-700 mb-3">Pilih Metode Pembayaran</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <?php foreach ($PAYMENT_METHODS as $method): ?>
                                <label class="cursor-pointer border rounded-lg p-4 text-center hover:border-indigo-300 hover:bg-slate-50 has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50 has-[:checked]:text-pink-700 has-[:checked]:font-bold has-[:checked]:shadow-md">
                                    <input type="radio" name="paymentMethod" value="<?= $method ?>" class="sr-only" required>
                                    <?= $method ?>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end space-x-3 border-t pt-4">
                            <a href="?view=home&buy=true&step=1&type=<?= $selectedType ?>" class="px-6 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">Kembali</a>
                            <button type="submit" name="next_step" value="3" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg">
                                Bayar Sekarang
                            </button>
                        </div>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
}
