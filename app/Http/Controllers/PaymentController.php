<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Konfigurasi SDK Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        try {
            // 2. Tangkap instance notifikasi dari Midtrans
            $notification = new Notification();
            
            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            
            // Format order_id: INV-[request_id]-[payment_phase]-[timestamp]
            // Contoh Skenario 1: INV-102-1-1718100000
            // Contoh Skenario 2: INV-102-2-1718100000
            $orderParts = explode('-', $orderId);
            $requestId = isset($orderParts[1]) ? $orderParts[1] : null;
            $paymentPhase = isset($orderParts[2]) ? $orderParts[2] : '1'; // Deteksi Pembayaran ke-1 atau ke-2

            if (!$requestId) {
                return response()->json(['message' => 'Format Order ID tidak valid'], 400);
            }

            // Cari permohonan uji di database
            $requestData = DB::table('requests')->where('id', $requestId)->first();

            if (!$requestData) {
                return response()->json(['message' => 'Data Permohonan tidak ditemukan'], 404);
            }

            // 3. Validasi status pembayaran dari Midtrans
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                // Tentukan status berdasarkan fase pembayaran (1 = Awal, 2 = Tambahan)
                $newStatus = ($paymentPhase == '2') ? 'Selesai' : 'Siap Diuji';
                $historyNote = ($paymentPhase == '2') ? "Pembayaran otomatis Midtrans (Tambahan) berhasil lunas." : "Pembayaran otomatis Midtrans (Awal) berhasil lunas.";

                DB::table('requests')->where('id', $requestId)->update([
                    'status' => $newStatus,
                    'paid_at' => now(),
                    'updated_at' => now()
                ]);

                // Opsional: Catat juga ke history agar admin tahu ini otomatis dari Midtrans
                DB::table('histories')->insert([
                    'id_cms_users' => 1, // Set id 1 (Superadmin/Sistem)
                    'request_id' => $requestId,
                    'notes' => $historyNote,
                    'created_at' => now()
                ]);

            } elseif ($transactionStatus == 'pending') {
                // Menunggu Pembayaran
                $newStatus = ($paymentPhase == '2') ? 'Menunggu Pembayaran Tambahan' : 'Menunggu Pembayaran';
                
                DB::table('requests')->where('id', $requestId)->update([
                    'status' => $newStatus,
                    'updated_at' => now()
                ]);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                // Pembayaran GAGAL/KADALUARSA
                DB::table('requests')->where('id', $requestId)->update([
                    'status' => 'Pembayaran Gagal',
                    'updated_at' => now()
                ]);
            }

            return response()->json(['message' => 'Callback Berhasil Diproses'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}