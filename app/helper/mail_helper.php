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
            // Aktifkan SMTP Debug untuk melihat error detail di layar
            $mail->SMTPDebug = 0; // Set 0 jika sudah berjalan normal

            // --- KONFIGURASI SMTP GMAIL ---
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            
            $mail->Username   = 'razanrizqullah02@gmail.com'; // Ganti email asli
            $mail->Password   = 'ckcwuwqtoyylgewz';          // Ganti App Password asli
            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // --- PENGIRIM & PENERIMA ---
            $mail->setFrom('razanrizqullah02@gmail.com', 'BKK DOSQLA');
            $mail->addAddress($email_penerima);

            // --- KONTEN EMAIL ---
            $mail->isHTML(true);
            $mail->Subject = 'Kode Verifikasi OTP - BKK DOSQLA';

            // Loop untuk membuat digit box OTP
            $digits = str_split($otp_code);
            $otpBoxes = '';
            foreach ($digits as $digit) {
                $otpBoxes .= "
                <td style='padding: 0 4px;'>
                    <div style='width: 42px; height: 50px; line-height: 50px; background-color: #e0f2fe; border: 2px solid #0077b6; border-radius: 6px; font-size: 24px; font-weight: bold; color: #f77f00; text-align: center;'>
                        {$digit}
                    </div>
                </td>";
            }

           $mail->Body = "
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        </head>
                        <body style='margin: 0; padding: 20px 0; background-color: #f4f4f4; font-family: Arial, sans-serif;'>

                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td align='center'>
                                        <!-- Container Utama -->
                                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' width='600' style='max-width: 600px; background-color: #ff3333; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.15);'>
                                            
                                            <!-- Header Bar -->
                                            <tr>
                                                <td style='padding: 20px 20px 10px 20px; text-align: center;'>
                                                    <div style='background-color: #ff6633; padding: 15px 20px; border-radius: 20px 20px 10px 10px; display: inline-block; width: 85%; border: 2px solid #ff4400;'>
                                                        <h1 style='color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;'>Kode OTP Pendaftaran</h1>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Section Logo / Branding Background -->
                                            <tr>
                                                <td style='padding: 10px 20px; text-align: center;'>
                                                    <!-- Ganti URL gambar logo berikut dengan URL hosting logo SMK Muhammadiyah Lemahabang -->
                                                   <img src='https://i.ibb.co.com/vxXMTWDM/logo.png' alt='Logo SMK Muhammadiyah Lemahabang' style='max-width: 140px; height: auto; display: block; margin: 0 auto;'>
                                                </td>
                                            </tr>

                                            <!-- Box Angka OTP -->
                                            <tr>
                                                <td style='padding: 15px 20px; text-align: center;'>
                                                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' align='center'>
                                                        <tr>
                                                            {$otpBoxes}
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <!-- Body Content -->
                                            <tr>
                                                <td style='padding: 20px 40px; color: #ffffff; font-size: 15px; line-height: 1.6;'>
                                                    <p style='margin-top: 0; font-weight: bold; font-size: 18px; color: #ffffff;'>Hai pelamar ( {$username} )</p>
                                                    <p style='color: #ffffff; margin-bottom: 25px;'>Terima kasih, kamu telah melakukan pendaftaran di situs kami masukan kode OTP diatas karena akan kadaluarsa tiap 10 menit.</p>

                                                    <p style='margin: 0; font-size: 13px; color: #ffffff;'>BKK DOSQLA</p>
                                                </td>
                                            </tr>

                                            <!-- Divider Garis Kuning -->
                                            <tr>
                                                <td style='padding: 0 40px;'>
                                                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                        <tr>
                                                            <td width='12' style='color: #ffcc00; font-size: 14px;'>■</td>
                                                            <td><hr style='border: 0; border-top: 2px solid #ffcc00; margin: 0;'></td>
                                                            <td width='12' align='right' style='color: #ffcc00; font-size: 14px;'>■</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <!-- Footer -->
                                            <tr>
                                                <td style='padding: 20px 40px 30px 40px; text-align: center; color: #ffffff;'>
                                                    <h3 style='margin: 0 0 15px 0; color: #ffffff; font-size: 18px; font-weight: bold; font-family: cursive, Arial, sans-serif;'>SMK Muhammadiyah Lemahabang</h3>
                                                    
                                                    <!-- Ikon Sosial Media (Ganti URL gambar & tautannya sesuai kebutuhan) -->
                                                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' align='center'>
                                                        <tr>
                                                            <td style='padding: 0 6px;'>
                                                                <a href='#'><img src='https://cdn-icons-png.flaticon.com/512/174/174855.png' alt='Instagram' width='30' style='display: block;'></a>
                                                            </td>
                                                            <td style='padding: 0 6px;'>
                                                                <a href='#'><img src='https://cdn-icons-png.flaticon.com/512/733/733585.png' alt='WhatsApp' width='30' style='display: block;'></a>
                                                            </td>
                                                            <td style='padding: 0 6px;'>
                                                                <a href='#'><img src='https://cdn-icons-png.flaticon.com/512/3046/3046122.png' alt='TikTok' width='30' style='display: block;'></a>
                                                            </td>
                                                            <td style='padding: 0 6px;'>
                                                                <a href='#'><img src='https://cdn-icons-png.flaticon.com/512/733/733547.png' alt='Facebook' width='30' style='display: block;'></a>
                                                            </td>
                                                            <td style='padding: 0 6px;'>
                                                                <a href='#'><img src='https://cdn-icons-png.flaticon.com/512/5969/5969020.png' alt='X' width='30' style='display: block;'></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </body>
                        </html>
                        ";
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
}