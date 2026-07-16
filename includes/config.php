<?php
/**
 * includes/config.php
 * Konfigurasi event, konstanta, data mockup, session, dan fungsi-fungsi helper.
 */

// --- KONFIGURASI EVENT ---
define('EVENT_NAME', 'Nusantara Music Festival 2026');
define('EVENT_DATE', '2026-06-18T18:00:00');
define('EVENT_LOCATION', 'Stadion Utama Gelora Bung Karno, Jakarta');

// --- DATA MOCKUP ---
$TICKET_TYPES = [
    ['id' => 'reguler', 'name' => 'Reguler', 'price' => 150000, 'desc' => 'Akses masuk area festival, standing area.'],
    ['id' => 'vip',     'name' => 'VIP',     'price' => 350000, 'desc' => 'Akses area depan panggung, jalur masuk khusus.'],
    ['id' => 'vvip',    'name' => 'VVIP',    'price' => 750000, 'desc' => 'Area tribun VIP duduk, merchandise eksklusif, meet & greet.'],
];

$PAYMENT_METHODS = ['DANA', 'OVO', 'GoPay', 'ShopeePay', 'Transfer Bank', 'QRIS'];

// --- SESSION & DATABASE SIMULASI ---
session_start();

if (!isset($_SESSION['participants'])) {
    $_SESSION['participants'] = [];
}

// --- FUNGSI HELPERS ---

function generateTicketId() {
    return 'TKT-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 9));
}

function formatRupiah($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function getTicketTypeLabel($type) {
    $labels = ['reguler' => 'Reguler', 'vip' => 'VIP', 'vvip' => 'VVIP'];
    return $labels[$type] ?? $type;
}

function getTicketTypeClass($type) {
    $classes = [
        'reguler' => 'bg-indigo-100 text-indigo-700',
        'vip'     => 'bg-pink-100 text-pink-700',
        'vvip'    => 'bg-amber-100 text-amber-700',
    ];
    return $classes[$type] ?? 'bg-gray-100 text-gray-700';
}

function getTimeLeft() {
    $diff = strtotime(EVENT_DATE) - time();
    if ($diff <= 0) return ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0];
    return [
        'days'    => floor($diff / 86400),
        'hours'   => floor(($diff % 86400) / 3600),
        'minutes' => floor(($diff % 3600) / 60),
        'seconds' => $diff % 60,
    ];
}
