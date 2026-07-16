<?php
/**
 * includes/actions.php
 * Menangani aksi-aksi POST global: pembelian tiket dan check-in.
 * Wajib di-require SEBELUM ada output HTML apapun karena memakai header(redirect).
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // --- Aksi: Beli Tiket ---
    if ($_POST['action'] === 'buy_ticket') {
        $newParticipant = [
            'id'               => generateTicketId(),
            'ticketType'       => $_POST['ticketType'] ?? 'reguler',
            'name'             => $_POST['name'] ?? '',
            'whatsapp'         => $_POST['whatsapp'] ?? '',
            'dob'              => $_POST['dob'] ?? '',
            'city'             => $_POST['city'] ?? '',
            'province'         => $_POST['province'] ?? '',
            'paymentMethod'    => $_POST['paymentMethod'] ?? '',
            'statusPembayaran' => 'Lunas',
            'purchaseDate'     => date('Y-m-d H:i:s'),
            'isCheckedIn'      => false,
            'checkInTime'      => null,
        ];

        $_SESSION['participants'][] = $newParticipant;
        $_SESSION['currentTicket']  = $newParticipant;
        $_SESSION['message']        = 'Pembayaran berhasil! Tiket telah diterbitkan.';

        header('Location: index.php?view=ticket');
        exit;
    }

    // --- Aksi: Check-in (umum) ---
    if ($_POST['action'] === 'checkin') {
        $ticketId = $_POST['ticketId'] ?? '';
        foreach ($_SESSION['participants'] as &$p) {
            if ($p['id'] === $ticketId && !$p['isCheckedIn']) {
                $p['isCheckedIn'] = true;
                $p['checkInTime'] = date('Y-m-d H:i:s');
                $_SESSION['message'] = 'Check-in berhasil untuk ' . $p['name'];
                break;
            }
        }
        unset($p);

        header('Location: index.php?view=scanner');
        exit;
    }
}
