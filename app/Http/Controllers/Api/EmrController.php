<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Rekam Medis Elektronik (EMR)", description: "Endpoint dokumen klinis rekam medis, CPPT, diagnosa ICD, tanda vital, dan resep")]
class EmrController extends Controller
{
    #[OA\Get(
        path: "/emr/get-emr-transaksi",
        summary: "Riwayat Transaksi Form & Pengkajian EMR Pasien",
        description: "Mengambil seluruh riwayat formulir rekam medis elektronik (EMR/CPPT/Resume/Pengkajian) yang pernah diisi untuk pasien tertentu.",
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
        path: "/emr/get-emr-riwayat-vitalsign",
        summary: "Riwayat Tanda-Tanda Vital (TTV) Pasien",
        description: "Mengambil data rekam tanda vital pasien (tekanan darah, nadi, suhu, pernapasan, SpO2, berat/tinggi badan) pada kunjungan tertentu.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noReg", in: "query", description: "Nomor Registrasi Kunjungan Pasien", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Data Tanda Vital berhasil dimuat")
        ]
    )]
    public function getVitalSign() {}

    #[OA\Get(
        path: "/emr/get-emr-riwayat-resep",
        summary: "Riwayat Terapi & Resep Obat Kunjungan",
        description: "Mengambil riwayat pemberian obat dan resep dalam episode kunjungan pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noReg", in: "query", description: "Nomor Registrasi Kunjungan", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar obat dalam resep pasien")
        ]
    )]
    public function getRiwayatResep() {}

    #[OA\Get(
        path: "/emr/get-riwayat-order-penunjang",
        summary: "Riwayat Order Pemeriksaan Penunjang (Lab & Rad)",
        description: "Mengambil riwayat order laboratorium dan radiologi pada kunjungan pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noReg", in: "query", description: "Nomor Registrasi Kunjungan", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar order pemeriksaan penunjang")
        ]
    )]
    public function getOrderPenunjang() {}

    #[OA\Get(
        path: "/registrasi/get-diagnosa-10-by-noreg",
        summary: "Riwayat Diagnosa ICD-10 Pasien",
        description: "Mengambil daftar diagnosa utama dan sekunder berdasarkan standar ICD-10 untuk kunjungan pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noReg", in: "query", description: "Nomor Registrasi Kunjungan", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar kode dan nama diagnosa ICD-10")
        ]
    )]
    public function getDiagnosa10() {}

    #[OA\Get(
        path: "/registrasi/get-diagnosa-9-by-noreg",
        summary: "Riwayat Prosedur & Tindakan ICD-9-CM Pasien",
        description: "Mengambil daftar prosedur medis / tindakan berdasarkan standar ICD-9-CM untuk kunjungan pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Rekam Medis Elektronik (EMR)"],
        parameters: [
            new OA\Parameter(name: "noReg", in: "query", description: "Nomor Registrasi Kunjungan", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar kode dan nama tindakan ICD-9-CM")
        ]
    )]
    public function getDiagnosa9() {}
}
