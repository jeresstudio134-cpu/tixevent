<?php
/**
 * index.php - Sistem Tiket Event Nusantara Music Festival 2026
 * Entry point utama: routing view + render layout.
 * Semua logika berat sudah dipisah ke folder includes/.
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/actions.php';
require_once __DIR__ . '/includes/export.php';
require_once __DIR__ . '/includes/components/landing.php';
require_once __DIR__ . '/includes/components/modal_purchase.php';
require_once __DIR__ . '/includes/components/ticket.php';
require_once __DIR__ . '/includes/components/admin.php';
require_once __DIR__ . '/includes/components/scanner.php';

// --- ROUTING & DATA SESSION ---
$view = $_GET['view'] ?? 'home';

$participants  = $_SESSION['participants'] ?? [];
$currentTicket = $_SESSION['currentTicket'] ?? null;
$message       = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

// Export CSV harus jalan SEBELUM ada output HTML apapun
handleExportCSV($participants, $view);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIXEVENT - Sistem Tiket Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-slate-50 font-sans text-slate-800 min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-indigo-900 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="?view=home" class="flex items-center">
                    <i class="fas fa-ticket-alt text-pink-500 text-2xl mr-2"></i>
                    <span class="font-bold text-xl tracking-wider">TIX<span class="text-pink-500">EVENT</span></span>
                </a>
                <div class="flex space-x-4">
                    <a href="?view=home" class="px-3 py-2 rounded-md text-sm font-medium <?= $view === 'home' ? 'bg-indigo-800' : 'hover:bg-indigo-800' ?>">Beranda</a>
                    <a href="?view=admin" class="px-3 py-2 rounded-md text-sm font-medium <?= $view === 'admin' ? 'bg-indigo-800' : 'hover:bg-indigo-800' ?>">Admin</a>
                    <a href="?view=scanner" class="px-3 py-2 rounded-md text-sm font-medium <?= $view === 'scanner' ? 'bg-indigo-800' : 'hover:bg-indigo-800' ?>">Scanner</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main>
        <?php if ($view === 'home'): ?>
            <?php include_component_landing_page(); ?>
        <?php elseif ($view === 'ticket'): ?>
            <?php include_component_ticket(); ?>
        <?php elseif ($view === 'admin'): ?>
            <?php include_component_admin(); ?>
        <?php elseif ($view === 'scanner'): ?>
            <?php include_component_scanner(); ?>
        <?php else: ?>
            <div class="text-center py-20"><p class="text-xl text-slate-500">Halaman tidak ditemukan.</p></div>
        <?php endif; ?>
    </main>

    <!-- FOOTER -->
    <footer class="bg-indigo-900 text-indigo-200 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2026 TIXEVENT. All rights reserved. | Nusantara Music Festival</p>
        </div>
    </footer>

    <!-- MODAL PEMBELIAN -->
    <?php if (isset($_GET['buy']) && $_GET['buy'] === 'true'): ?>
        <?php include_modal_purchase(); ?>
    <?php endif; ?>

    <script>
        // Dikirim ke script.js eksternal untuk dipakai oleh countdown live
        const EVENT_DATE_ISO = "<?= EVENT_DATE ?>";
    </script>
    <script src="assets/js/script.js"></script>
</body>
</html>
