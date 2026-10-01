<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Riwayat Pasien (Kunjungan & Registrasi)", description: "Endpoint riwayat kunjungan rawat jalan, rawat inap, dan IGD pasien")]
class RiwayatPasienController extends Controller
{
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
