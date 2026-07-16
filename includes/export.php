<?php
/**
 * includes/export.php
 * Menangani export data peserta ke file CSV.
 *
 * PENTING: dipanggil SEBELUM ada output HTML apapun, karena header()
 * untuk download file tidak bisa dikirim setelah ada output lain.
 */

function handleExportCSV($participants, $view) {
    if (isset($_GET['export']) && $_GET['export'] === 'true' && $view === 'admin') {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="data_peserta_event.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID Tiket', 'Nama', 'WhatsApp', 'Kota', 'Provinsi', 'Tipe Tiket', 'Metode Pembayaran', 'Status', 'Waktu Check-in']);

        foreach ($participants as $p) {
            fputcsv($output, [
                $p['id'],
                $p['name'],
                $p['whatsapp'],
                $p['city'] ?? '',
                $p['province'] ?? '',
                getTicketTypeLabel($p['ticketType']),
                $p['paymentMethod'] ?? '-',
                $p['isCheckedIn'] ? 'Hadir' : 'Belum Hadir',
                $p['isCheckedIn'] ? ($p['checkInTime'] ?? '') : '',
            ]);
        }

        fclose($output);
        exit;
    }
}
