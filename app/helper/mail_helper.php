<?php
// app/helpers/mail_helper.php

// Panggil file PHPMailer dari folder root app/PHPMailer/
require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOtpEmail($email_penerima, $otp_code) {
    $mail = new PHPMailer(true);

    try {
        // --- KONFIGURASI SMTP GMAIL ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        
        // GANTI DENGAN EMAIL GMAIL ANDA & APP PASSWORD 16 DIGIT
        $mail->Username   = 'email.anda@gmail.com'; 
        $mail->Password   = 'abcdefghijklmnop'; // 16 digit App Password (tanpa spasi)
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // --- PENGIRIM & PENERIMA ---
        $mail->setFrom('email.anda@gmail.com', 'BKK DOSQLA');
        $mail->addAddress($email_penerima);

        // --- KONTEN EMAIL ---
        $mail->isHTML(true);
        $mail->Subject = 'Kode Verifikasi OTP - BKK DOSQLA';
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4;'>
                <div style='max-width: 500px; margin: 0 auto; background: #ffffff; padding: 20px; border-radius: 10px; border-top: 5px solid #ff5722;'>
                    <h2 style='color: #111827; text-align: center;'>BKK DOSQLA</h2>
                    <p>Halo,</p>
                    <p>Terima kasih telah mendaftar. Gunakan kode OTP di bawah ini untuk mengonfirmasi akun Anda:</p>
                    <div style='text-align: center; margin: 25px 0;'>
                        <span style='font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #0d6efd; background: #e7f1ff; padding: 10px 20px; border-radius: 8px;'>{$otp_code}</span>
                    </div>
                    <p style='font-size: 0.85rem; color: #666;'>Kode ini hanya berlaku selama 10 menit. Jangan bagikan kode ini kepada siapapun.</p>
                </div>
            </div>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Bisa digunakan untuk melihat error jika gagal: $mail->ErrorInfo
        return false;
    }
}