<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    // Properti atau konstanta untuk konfigurasi
    private const API_URL_VALIDATE = 'https://api.fonnte.com/validate';
    private const API_URL_SEND = 'https://api.fonnte.com/send';
    private const AUTH_TOKEN = 'Kv7WRpN2LTasUECK5zb9';

    /**
     * Validasi nomor WhatsApp.
     */
    public function validateNumber($phone)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => self::API_URL_VALIDATE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target' => $phone,
                'countryCode' => '62',
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . self::AUTH_TOKEN,
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($httpCode !== 200) {
            return response()->json(['error' => 'Gagal memvalidasi nomor WhatsApp.'], 500);
        }

        return json_decode($response, true); // Return response as array
    }

    /**
     * Kirim pesan WhatsApp.
     */
    public function sendWhatsappMessage($phone, $name, $otp)
    {
        // Validasi OTP
        if (!$otp) {
            return response()->json(['error' => 'Kode OTP tidak ditemukan.'], 400);
        }

        // Format nomor telepon
        $phone = $this->formatPhoneNumber($phone);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => self::API_URL_SEND,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target' => $phone,
                'message' => "Halo $name, kode OTP Anda adalah $otp.",
                'url' => 'https://md.fonnte.com/images/wa-logo.png',
                'schedule' => 0,
                'typing' => false,
                'delay' => '2',
                'countryCode' => '62',
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . self::AUTH_TOKEN,
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($httpCode === 200) {
            return response()->json(['success' => 'OTP berhasil dikirim.', 'phone' => $phone]);
        } else {
            return response()->json(['error' => 'Gagal mengirim pesan WhatsApp.'], 500);
        }
    }

    /**
     * Format nomor telepon ke format internasional.
     */
    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone); // Hapus karakter non-angka
        if (substr($phone, 0, 1) == '0') {
            $phone = '62' . substr($phone, 1); // Tambahkan kode negara jika diawali 0
        }

        return $phone;
    }
}
