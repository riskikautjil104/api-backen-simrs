<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Rekam Medis Elektronik (EMR)", description: "Endpoint dokumen klinis rekam medis, CPPT, diagnosa ICD, tanda vital, anamnesis, pemeriksaan fisik, alergi, penunjang, dan resume medis")]
class EmrController extends Controller
{
    #[OA\Get(
        path: "/emr/riwayat-emr",
        summary: "Daftar Riwayat Berkas Dokumen EMR Pasien",
        description: "Mengambil daftar lengkap seluruh berkas rekam medis elektronik (EMR) yang pernah diterbitkan untuk pasien berdasarkan No CM.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "nocm", in: "query", description: "Nomor Rekam Medis Pasien (No CM)", required: true, schema: new OA\Schema(type: "string", example: "0487727")),
            new OA\Parameter(name: "namaPasien", in: "query", description: "Filter nama pasien", required: false, schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "tglAwal", in: "query", description: "Filter rentang tanggal awal dokumen (YYYY-MM-DD)", required: false, schema: new OA\Schema(type: "string", example: "2026-01-01")),
            new OA\Parameter(name: "tglAkhir", in: "query", description: "Filter rentang tanggal akhir dokumen (YYYY-MM-DD)", required: false, schema: new OA\Schema(type: "string", example: "2026-12-31"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar riwayat dokumen rekam medis pasien berhasil diambil")
        ]
    )]
    public function getRiwayatEmr() {}

    #[OA\Get(
        path: "/emr/get-emr-transaksi",
        summary: "Riwayat Transaksi Form & Pengkajian EMR Pasien",
        description: "Mengambil seluruh riwayat formulir rekam medis elektronik (CPPT, Resume, Pengkajian Awal, Triase) yang pernah diisi untuk pasien tertentu.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "nocm", in: "query", description: "Nomor Rekam Medis (No CM)", required: true, schema: new OA\Schema(type: "string", example: "0487727")),
            new OA\Parameter(name: "jenisEmr", in: "query", description: "Filter jenis modul form EMR (contoh: rajal, ranap, igd, bedah)", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar transaksi rekam medis pasien")
        ]
    )]
    public function getEmrTransaksi() {}

    #[OA\Get(
        path: "/emr/get-emr-transaksi-by-emrid-pasien",
        summary: "Riwayat Transaksi Form EMR Spesifik per Form ID Pasien",
        description: "Mengambil data riwayat form EMR spesifik pasien berdasarkan emrid / nomor EMR tertentu.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "nocm", in: "query", description: "Nomor Rekam Medis (No CM)", required: true, schema: new OA\Schema(type: "string", example: "0487727")),
            new OA\Parameter(name: "emrid", in: "query", description: "ID Form EMR yang Dicari", required: false, schema: new OA\Schema(type: "integer", example: 443))
        ],
        responses: [
            new OA\Response(response: 200, description: "Data transaksi form EMR pasien berhasil diambil")
        ]
    )]
    public function getEmrTransaksiByEmridPasien() {}

    #[OA\Get(
        path: "/emr/get-info-emr-pasien",
        summary: "Informasi Identitas & Status Berkas EMR Pasien",
        description: "Mengambil profil singkat pasien beserta status rekam medis aktif dan riwayat kelengkapan berkas EMR.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "nocm", in: "query", description: "Nomor Rekam Medis Pasien", required: true, schema: new OA\Schema(type: "string", example: "0487727"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Informasi EMR pasien berhasil diambil")
        ]
    )]
    public function getInfoEmrPasien() {}

    #[OA\Get(
        path: "/emr/get-vital-sign",
        summary: "Data Tanda-Tanda Vital (TTV) Terakhir Pasien",
        description: "Mengambil data tanda-tanda vital (Tensi, Nadi, Pernapasan, Suhu, SpO2) terakhir pada episode rawat pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "norec", in: "query", description: "No Record Antrian / Registrasi Pelayanan", required: false, schema: new OA\Schema(type: "string", example: "apd-12345")),
            new OA\Parameter(name: "noregistrasifk", in: "query", description: "No Registrasi Kunjungan Pasien", required: false, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Data TTV pasien berhasil dimuat")
        ]
    )]
    public function getVitalSignDirect() {}

    #[OA\Get(
        path: "/emr/get-emr-riwayat-vitalsign",
        summary: "Riwayat Serial Grafik Tanda-Tanda Vital (TTV)",
        description: "Mengambil serial histori tanda vital pasien (tekanan darah, MAP, nadi, suhu, respiratory rate, SpO2, berat badan) selama episode rawat untuk pemantauan klinis.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noReg", in: "query", description: "Nomor Registrasi Kunjungan Pasien", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Riwayat serial tanda vital berhasil dimuat")
        ]
    )]
    public function getVitalSign() {}

    #[OA\Get(
        path: "/emr/get-anamnesis",
        summary: "Riwayat Anamnesis & Keluhan Pasien",
        description: "Mengambil data anamnesis, keluhan utama (chief complaint), riwayat penyakit sekarang (RPS), riwayat penyakit keluarga, dan telaah medis.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "norec", in: "query", description: "No Record Antrian Pasien Diperiksa", required: true, schema: new OA\Schema(type: "string", example: "apd-12345"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Data anamnesis pasien berhasil diambil")
        ]
    )]
    public function getAnamnesis() {}

    #[OA\Get(
        path: "/emr/get-riwayat-alergi",
        summary: "Riwayat Alergi Pasien (Obat, Makanan, Udara)",
        description: "Mengambil daftar alergi pasien terhadap obat-obatan, makanan, lateks, atau alergen lainnya beserta tingkat reaksi yang ditimbulkan.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "nocm", in: "query", description: "Nomor Rekam Medis Pasien", required: false, schema: new OA\Schema(type: "string", example: "0487727")),
            new OA\Parameter(name: "norm", in: "query", description: "Nomor RM Alternatif", required: false, schema: new OA\Schema(type: "string", example: "0487727"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Data riwayat alergi pasien")
        ]
    )]
    public function getRiwayatAlergi() {}

    #[OA\Get(
        path: "/emr/get-riwayat",
        summary: "Riwayat Pengobatan & Penyakit Terdahulu",
        description: "Mengambil riwayat penyakit dahulu (RPD), riwayat operasi, riwayat rawat inap sebelumnya, serta daftar obat rutin yang dikonsumsi pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "norec", in: "query", description: "No Record Antrian Pelayanan", required: true, schema: new OA\Schema(type: "string", example: "apd-12345"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Riwayat penyakit & pengobatan terdahulu berhasil diambil")
        ]
    )]
    public function getRiwayatPengobatan() {}

    #[OA\Get(
        path: "/emr/get-pemeriksaanumum",
        summary: "Hasil Pemeriksaan Fisik & Keadaan Umum",
        description: "Mengambil data hasil pemeriksaan fisik head-to-toe (keadaan umum, kesadaran GCS, kepala, mata, THT, leher, thoraks, abdomen, ekstremitas).",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "norec", in: "query", description: "No Record Antrian Pelayanan", required: true, schema: new OA\Schema(type: "string", example: "apd-12345"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Pemeriksaan umum dan fisik pasien berhasil diambil")
        ]
    )]
    public function getPemeriksaanUmum() {}

    #[OA\Get(
        path: "/emr/get-data-riwayat-pengkajiankeperawatan",
        summary: "Riwayat Pengkajian Awal Keperawatan",
        description: "Mengambil lembar pengkajian awal keperawatan (status fungsional barthel index, resiko jatuh morse/humpty dumpty, nutrisi MST, dan nyeri NRS/VAS).",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "norec", in: "query", description: "No Record Antrian / Registrasi Pelayanan", required: true, schema: new OA\Schema(type: "string", example: "apd-12345"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Data pengkajian keperawatan berhasil diambil")
        ]
    )]
    public function getPengkajianKeperawatan() {}

    #[OA\Get(
        path: "/emr/get-diagnosapasienbynoreg",
        summary: "Riwayat Diagnosa Medis ICD-10 Kunjungan",
        description: "Mengambil daftar diagnosa ICD-10 yang ditegakkan dokter (diagnosa utama/primer dan sekunder/komorbiditas) pada kunjungan pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noreg", in: "query", description: "Nomor Registrasi Kunjungan Pasien", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar kode dan deskripsi diagnosa ICD-10")
        ]
    )]
    public function getDiagnosaPasienByNoreg() {}

    #[OA\Get(
        path: "/emr/get-data-dg-primary/{Noregistrasi}",
        summary: "Diagnosa Utama / Primer Kunjungan Pasien",
        description: "Mengambil diagnosa primer (ICD-10) yang menjadi alasan utama pasien dirawat atau diperiksa.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "Noregistrasi", in: "path", description: "Nomor Registrasi Kunjungan", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Data diagnosa primer kunjungan berhasil diambil")
        ]
    )]
    public function getDiagnosaPrimary() {}

    #[OA\Get(
        path: "/emr/get-diagnosapasienbynoregicd9",
        summary: "Riwayat Tindakan & Prosedur Medis ICD-9-CM Kunjungan",
        description: "Mengambil daftar prosedur medis operatif dan non-operatif berdasarkan standar ICD-9-CM pada kunjungan pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noreg", in: "query", description: "Nomor Registrasi Kunjungan Pasien", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar tindakan / prosedur ICD-9-CM berhasil diambil")
        ]
    )]
    public function getDiagnosaPasienByNoregIcd9() {}

    #[OA\Get(
        path: "/emr/get-lab-by-no-transaksi",
        summary: "Riwayat & Hasil Pemeriksaan Laboratorium Pasien",
        description: "Mengambil rincian hasil pemeriksaan laboratorium (parameter tes, nilai hasil, nilai rujukan normal, satuan, status abnormal/kritis) berdasarkan nomor transaksi.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "notransaksi", in: "query", description: "Nomor Transaksi Order Laboratorium", required: true, schema: new OA\Schema(type: "string", example: "LAB-202605040001")),
            new OA\Parameter(name: "norec", in: "query", description: "No Record Order Lab Alternatif", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Hasil pemeriksaan laboratorium berhasil dimuat")
        ]
    )]
    public function getLabByNoTransaksi() {}

    #[OA\Get(
        path: "/emr/get-radiologi-by-no-transaksi",
        summary: "Riwayat & Hasil Pemeriksaan Radiologi Pasien",
        description: "Mengambil hasil ekspertise dan bacaan dokter spesialis radiologi (X-Ray, USG, CT-Scan, MRI) beserta kesimpulan klinis berdasarkan nomor transaksi order.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "notransaksi", in: "query", description: "Nomor Transaksi Order Radiologi", required: true, schema: new OA\Schema(type: "string", example: "RAD-202605040001"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Hasil ekspertise radiologi berhasil dimuat")
        ]
    )]
    public function getRadiologiByNoTransaksi() {}

    #[OA\Get(
        path: "/emr/get-riwayat-order-penunjang",
        summary: "Riwayat Order Pemeriksaan Penunjang (Lab & Rad)",
        description: "Mengambil seluruh riwayat order penunjang diagnostik (laboratorium, radiologi, bank darah) yang dipesan dokter selama episode kunjungan pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noReg", in: "query", description: "Nomor Registrasi Kunjungan Pasien", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar order pemeriksaan penunjang")
        ]
    )]
    public function getOrderPenunjang() {}

    #[OA\Get(
        path: "/emr/get-daftar-detail-order",
        summary: "Rincian Item Tindakan pada Order Penunjang",
        description: "Mengambil rincian item-item pemeriksaan klinis yang tercakup dalam satu nomor order penunjang medis.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "norec_order", in: "query", description: "No Record Header Order Penunjang", required: true, schema: new OA\Schema(type: "string", example: "ord-12345"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Rincian item pemeriksaan order berhasil dimuat")
        ]
    )]
    public function getDetailOrderPenunjang() {}

    #[OA\Get(
        path: "/emr/get-emr-riwayat-resep",
        summary: "Riwayat Terapi & Resep Obat Kunjungan",
        description: "Mengambil daftar lengkap resep obat (nama obat, dosis, aturan pakai/signa, jumlah, dan rute pemberian) yang diresepkan selama kunjungan pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noReg", in: "query", description: "Nomor Registrasi Kunjungan Pasien", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar resep obat pasien berhasil dimuat")
        ]
    )]
    public function getRiwayatResep() {}

    #[OA\Get(
        path: "/emr/get-data-riwayat-emr",
        summary: "Riwayat Pengkajian & Formulir EMR Lengkap Pasien",
        description: "Mengambil data riwayat formulir dan dokumen EMR lengkap pasien berdasarkan nomor rekam medis.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "nocm", in: "query", description: "Nomor Rekam Medis Pasien", required: true, schema: new OA\Schema(type: "string", example: "0487727")),
            new OA\Parameter(name: "noregistrasi", in: "query", description: "Nomor Registrasi Kunjungan", required: false, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Riwayat berkas formulir rekam medis elektronik")
        ]
    )]
    public function getDataRiwayatEmr() {}

    #[OA\Get(
        path: "/emr/get-resume-medis/{nocm}",
        summary: "Riwayat Resume Medis / Ringkasan Pulang Pasien Rawat Jalan",
        description: "Mengambil ringkasan resume medis pasien rawat jalan/IGD yang memuat keluhan, diagnosa akhir, tindakan, dan instruksi kontrol lanjutan.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "nocm", in: "path", description: "Nomor Rekam Medis Pasien", required: true, schema: new OA\Schema(type: "string", example: "0487727"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Resume medis pasien rawat jalan")
        ]
    )]
    public function getResumeMedis() {}

    #[OA\Get(
        path: "/emr/get-resume-medis-inap/{nocm}",
        summary: "Riwayat Resume Medis Pasien Rawat Inap (Discharge Summary)",
        description: "Mengambil ringkasan kepulangan pasien rawat inap (indikasi MRS, riwayat penyakit, hasil penunjang penting, diagnosis akhir, terapi pulang, kondisi waktu pulang).",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "nocm", in: "path", description: "Nomor Rekam Medis Pasien", required: true, schema: new OA\Schema(type: "string", example: "0487727"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Discharge summary rawat inap berhasil diambil")
        ]
    )]
    public function getResumeMedisInap() {}

    #[OA\Get(
        path: "/emr/get-resume-medis-db-lama/{notransaksi}",
        summary: "Riwayat Resume Medis Pasien (Arsip Database Lama)",
        description: "Mengambil arsip resume medis riwayat perawatan pasien terdahulu berdasarkan nomor transaksi.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "notransaksi", in: "path", description: "Nomor Transaksi Pelayanan Pasien", required: true, schema: new OA\Schema(type: "string", example: "TRX-HIST-0981"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Arsip resume medis berhasil diambil")
        ]
    )]
    public function getResumeMedisDbLama() {}

    #[OA\Get(
        path: "/emr/get-rencana",
        summary: "Rencana Asuhan & Terapi Medis Pasien (Care Plan)",
        description: "Mengambil rencana tatalaksana, rencana konsultasi, tindakan medis lanjutan, dan target luaran klinis pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "norec", in: "query", description: "No Record Antrian / Registrasi Pelayanan", required: true, schema: new OA\Schema(type: "string", example: "apd-12345"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Rencana asuhan pasien berhasil diambil")
        ]
    )]
    public function getRencanaAsuhan() {}

    #[OA\Get(
        path: "/emr/get-edukasi",
        summary: "Catatan Edukasi Pasien & Keluarga Terintegrasi",
        description: "Mengambil rekaman edukasi yang telah diberikan kepada pasien/keluarga (pemahaman penyakit, kepatuhan obat, resiko tindakan, diet nutrisi).",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "norec", in: "query", description: "No Record Pelayanan Pasien", required: true, schema: new OA\Schema(type: "string", example: "apd-12345"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Data catatan edukasi terintegrasi berhasil dimuat")
        ]
    )]
    public function getEdukasiPasien() {}

    #[OA\Get(
        path: "/emr/get-perjanjian",
        summary: "Jadwal Perjanjian & Kontrol Ulang Pasien",
        description: "Mengambil riwayat surat kontrol atau jadwal perjanjian kunjungan kembali pasien ke poliklinik atau dokter spesialis.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "nocm", in: "query", description: "Nomor Rekam Medis Pasien", required: true, schema: new OA\Schema(type: "string", example: "0487727")),
            new OA\Parameter(name: "tglAwal", in: "query", description: "Tanggal Awal Filter (YYYY-MM-DD)", required: false, schema: new OA\Schema(type: "string", example: "2026-05-01")),
            new OA\Parameter(name: "tglAkhir", in: "query", description: "Tanggal Akhir Filter (YYYY-MM-DD)", required: false, schema: new OA\Schema(type: "string", example: "2026-06-01"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar jadwal perjanjian dan kontrol ulang pasien")
        ]
    )]
    public function getPerjanjianKontrol() {}
}
