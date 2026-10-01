<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "SIMRS RSUD Dr. H. Chasan Boesoirie Ternate - API Documentation",
    description: "Dokumentasi OpenAPI / Swagger REST API SIMRS RSUD Dr. H. Chasan Boesoirie Ternate (MediFirst 2000).\n\n" .
        "### Server Target:\n" .
        "- **Proxy Anti-CORS (Default Browser):** `/service/medifirst2000`\n" .
        "- **Direct Production Server:** `https://chasanboesoirie.id/service/medifirst2000`\n\n" .
        "### Default Authorization Token:\n" .
        "Swagger ini sudah di-pre-authorize dengan token aktif (User: his.jkn):\n" .
        "```text\n" .
        "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJoaXMuamtuIn0.FhnuCCWQx9SOMwBcLx3NFMPH45-KUwkblNKQY9Debm26PJ7ygt4-1z7oSMrefb0qfJwKtp02kS1O0lupFcMz1Q\n" .
        "```\n" .
        "Header yang digunakan pada setiap request: `X-AUTH-TOKEN: {token}`\n\n" .
        "### Modul Layanan yang Terdokumentasi:\n" .
        "1. Autentikasi (Auth): Login, Logout, Ganti Password\n" .
        "2. Data Pasien (Master): Pencarian Pasien, Biodata, Profil Lengkap\n" .
        "3. Riwayat Pasien (Kunjungan & Registrasi): Episode Rawat Jalan, IGD, Rawat Inap\n" .
        "4. CPPT Pasien (Catatan Perkembangan Terintegrasi): Catatan SOAP (Subjektif, Objektif, Asesmen, Planning), Riwayat CPPT Rawat Jalan & Inap, Verifikasi DPJP\n" .
        "5. Riwayat Tindakan & Pelayanan Pasien: Rincian tindakan medis, kuantiti, harga satuan, dan ruangan pelaksana\n" .
        "6. Master Tarif & Harga Tindakan per Kelas: Tarif tindakan per kelas (1, 2, 3, VIP, VVIP, Non-Kelas) & Komponen Harga (Jasa Medis, Sarana, BHP, CITO)\n" .
        "7. Tagihan & Billing Kasir Pasien: Rekap tagihan pasien, status pembayaran, dan rincian struk biaya tindakan\n" .
        "8. Farmasi & E-Resep: Antrian resep, detail obat, status pengerjaan resep elektronik\n" .
        "9. Rekam Medis Elektronik (EMR): Dokumen EMR, Tanda-Tanda Vital (TTV), Riwayat Terapi Obat, Diagnosa ICD-10 & ICD-9-CM, Order Penunjang\n" .
        "10. Pendaftaran & Antrian: Registrasi pasien baru, antrian poliklinik\n" .
        "11. Sistem & Notifikasi (SysAdmin): Notifikasi real-time antar ruangan",
    contact: new OA\Contact(
        name: "IT SIMRS RSUD Dr. H. Chasan Boesoirie",
        url: "https://chasanboesoirie.id"
    )
)]
#[OA\Server(
    url: "/service/medifirst2000",
    description: "Server SIMRS (Proxy Anti-CORS - Aktif Otomatis)"
)]
#[OA\Server(
    url: "https://chasanboesoirie.id/service/medifirst2000",
    description: "Server Langsung (chasanboesoirie.id - Butuh Postman/No-CORS)"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "apiKey",
    name: "X-AUTH-TOKEN",
    in: "header",
    description: "Token otorisasi SIMRS Ternate. Default token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJoaXMuamtuIn0.FhnuCCWQx9SOMwBcLx3NFMPH45-KUwkblNKQY9Debm26PJ7ygt4-1z7oSMrefb0qfJwKtp02kS1O0lupFcMz1Q"
)]
class OpenApi
{
}
