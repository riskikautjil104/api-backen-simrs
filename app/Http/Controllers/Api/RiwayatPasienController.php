<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Riwayat Pasien (Kunjungan & Registrasi)", description: "Endpoint riwayat kunjungan rawat jalan, rawat inap, dan IGD pasien")]
class RiwayatPasienController extends Controller
{
    #[OA\Get(
        path: "/registrasi/daftar-registrasi/get-daftar-registrasi-pasien",
        summary: "Daftar Registrasi / Kunjungan Pasien RS (Berdasarkan Rentang Tanggal)",
        description: "Mengambil daftar seluruh kunjungan dan registrasi pasien ke rumah sakit dalam rentang tanggal dan jam tertentu. Menampilkan data lengkap seperti noregistrasi, no CM, nama pasien, ruangan/poli tujuan, dokter penanggung jawab, penjamin/BPJS, No SEP, No BPJS, status checkin Mobile JKN, dan jenis pelayanan.",
        security: [["bearerAuth" => []]],
        tags: ["Riwayat Pasien (Kunjungan & Registrasi)"],
        parameters: [
            new OA\Parameter(name: "tglAwal", in: "query", description: "Tanggal dan jam awal (format: YYYY-MM-DD HH:mm:ss)", required: true, schema: new OA\Schema(type: "string", example: "2026-10-02 00:00:00")),
            new OA\Parameter(name: "tglAkhir", in: "query", description: "Tanggal dan jam akhir (format: YYYY-MM-DD HH:mm:ss)", required: true, schema: new OA\Schema(type: "string", example: "2026-10-02 23:59:00")),
            new OA\Parameter(name: "jmlRows", in: "query", description: "Jumlah batas baris data (limit)", required: false, schema: new OA\Schema(type: "integer", example: 50)),
            new OA\Parameter(name: "norm", in: "query", description: "Filter Nomor Rekam Medis (No CM)", required: false, schema: new OA\Schema(type: "string", example: "0512301")),
            new OA\Parameter(name: "noreg", in: "query", description: "Filter Nomor Registrasi", required: false, schema: new OA\Schema(type: "string", example: "2609008682")),
            new OA\Parameter(name: "nama", in: "query", description: "Filter Nama Pasien", required: false, schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "ruangId", in: "query", description: "Filter ID Ruangan", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "deptId", in: "query", description: "Filter ID Departemen/Instalasi (contoh: 18 untuk Rawat Jalan)", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "kelId", in: "query", description: "Filter Kelompok Pasien (contoh: 2/BPJS)", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "dokId", in: "query", description: "Filter ID Dokter", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "jenisPel", in: "query", description: "Filter Jenis Pelayanan", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daftar registrasi pasien berhasil dimuat",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "norec", type: "string", example: "4034d010-b859-11f1-a617-11a8515f"),
                            new OA\Property(property: "tglregistrasi", type: "string", example: "2026-10-02 08:00:00"),
                            new OA\Property(property: "nocm", type: "string", example: "0512301"),
                            new OA\Property(property: "noregistrasi", type: "string", example: "2609008682"),
                            new OA\Property(property: "namapasien", type: "string", example: "FAREL ABDI PUTRA SUPARMIN AN"),
                            new OA\Property(property: "namaruangan", type: "string", example: "Poli Jantung"),
                            new OA\Property(property: "namadokter", type: "string", example: "dr. FIKRI, Sp.JP"),
                            new OA\Property(property: "kelompokpasien", type: "string", example: "BPJS"),
                            new OA\Property(property: "namarekanan", type: "string", example: "BPJS KESEHATAN"),
                            new OA\Property(property: "nosep", type: "string", example: "2506R0031026V000392"),
                            new OA\Property(property: "nobpjs", type: "string", example: "0001106946415"),
                            new OA\Property(property: "statusjkn", type: "string", example: "Sudah Checkin"),
                            new OA\Property(property: "ismobilejkn", type: "boolean", example: true),
                            new OA\Property(property: "statuspasien", type: "string", example: "LAMA")
                        ]
                    )
                )
            )
        ]
    )]
    public function getDaftarRegistrasiPasienOperator() {}

    #[OA\Get(
        path: "/registrasi/daftar-riwayat-registrasi",
        summary: "Daftar Riwayat Kunjungan / Registrasi Pasien",
        description: "Menampilkan daftar seluruh episode kunjungan/pendaftaran pasien ke rumah sakit (Rawat Jalan, IGD, Rawat Inap). Menampilkan tanggal pendaftaran, nomor registrasi, ruangan/poli tujuan, dokter penanggung jawab, tipe penjamin (BPJS/Umum), tanggal pulang, serta status rawat inap (1: Inap, 0: Jalan/IGD).",
        security: [["bearerAuth" => []]],
        tags: ["Riwayat Pasien (Kunjungan & Registrasi)"],
        parameters: [
            new OA\Parameter(name: "norm", in: "query", description: "Nomor Rekam Medis (No CM Pasien)", required: false, schema: new OA\Schema(type: "string", example: "0487727")),
            new OA\Parameter(name: "namaPasien", in: "query", description: "Filter nama pasien", required: false, schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "noReg", in: "query", description: "Filter nomor registrasi kunjungan tertentu", required: false, schema: new OA\Schema(type: "string", example: "2605000074")),
            new OA\Parameter(name: "idRuangan", in: "query", description: "Filter ID ruangan/poli", required: false, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Riwayat registrasi pasien berhasil diambil",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "daftar",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "norec", type: "string", example: "a1b2c3d4..."),
                                    new OA\Property(property: "tglregistrasi", type: "string", example: "2026-05-04 02:47:00"),
                                    new OA\Property(property: "nocm", type: "string", example: "0487727"),
                                    new OA\Property(property: "noregistrasi", type: "string", example: "2605000074"),
                                    new OA\Property(property: "namapasien", type: "string", example: "ADITHA BASRA NY"),
                                    new OA\Property(property: "namaruangan", type: "string", example: "IGD"),
                                    new OA\Property(property: "namadokter", type: "string", example: "Dr. FAJRIAH A SUMADAYO"),
                                    new OA\Property(property: "kelompokpasien", type: "string", example: "BPJS"),
                                    new OA\Property(property: "tglpulang", type: "string", nullable: true, example: "2026-05-04 08:30:00"),
                                    new OA\Property(property: "statusinap", type: "integer", example: 0, description: "1 = Rawat Inap, 0 = Rawat Jalan / IGD")
                                ]
                            )
                        ),
                        new OA\Property(property: "message", type: "string", example: "ea@epic")
                    ]
                )
            )
        ]
    )]
    public function getDaftarRiwayatRegistrasi() {}

    #[OA\Get(
        path: "/registrasi/get-detail-registrasi-pasien",
        summary: "Detail Kunjungan & Antrian Registrasi Pasien",
        description: "Mengambil data detail kunjungan meliputi ruangan/kamar, nomor tempat tidur, jam panggil dokter/perawat, dan status antrian periksa.",
        security: [["bearerAuth" => []]],
        tags: ["Riwayat Pasien (Kunjungan & Registrasi)"],
        parameters: [
            new OA\Parameter(name: "noregistrasi", in: "query", description: "Nomor Registrasi Kunjungan Pasien", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Detail data registrasi berhasil diambil",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "norec", type: "string", example: "apd-12345"),
                        new OA\Property(property: "tglregistrasi", type: "string", example: "2026-05-04 02:47:00"),
                        new OA\Property(property: "namaruangan", type: "string", example: "Poli Penyakit Dalam"),
                        new OA\Property(property: "namakelas", type: "string", example: "Kelas III"),
                        new OA\Property(property: "namakamar", type: "string", nullable: true),
                        new OA\Property(property: "nobed", type: "string", nullable: true),
                        new OA\Property(property: "namadokter", type: "string", example: "Dr. FAJRIAH A SUMADAYO"),
                        new OA\Property(property: "statusantrian", type: "string", example: "SELESAI_DIPERIKSA")
                    ]
                )
            )
        ]
    )]
    public function getDetailRegistrasiPasien() {}

    #[OA\Get(
        path: "/registrasi/get-antrian-by-nocm-rev",
        summary: "Riwayat Antrian & Diagnosa Pasien by No CM",
        description: "Mengambil data rekam antrian poli dan diagnosa ICD yang pernah ditegakkan pada pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Riwayat Pasien (Kunjungan & Registrasi)"],
        parameters: [
            new OA\Parameter(name: "noCm", in: "query", description: "Nomor Rekam Medis (No CM)", required: true, schema: new OA\Schema(type: "string", example: "0487727"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar antrian dan diagnosa riwayat pasien")
        ]
    )]
    public function getAntrianByNoCmRev() {}
}
