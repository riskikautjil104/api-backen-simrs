<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Tagihan & Billing Kasir Pasien", description: "Endpoint rekap tagihan pasien, status pembayaran kasir, dan rincian struk biaya")]
class TagihanKasirController extends Controller
{
    #[OA\Get(
        path: "/kasir/daftar-tagihan-pasien",
        summary: "Daftar Tagihan & Rekap Billing Pasien",
        description: "Mengambil daftar tagihan pembayaran seluruh pasien yang teregistrasi. Menampilkan Nomor Registrasi, No CM, Nama Pasien, Tanggal Masuk, Tanggal Pulang, Ruangan, Kelas Perawatan, Penjamin (BPJS/Umum), Total Tagihan yang Harus Dibayar, dan Total Dijamin Rekanan/Asuransi.",
        security: [["bearerAuth" => []]],
        tags: ["Tagihan & Billing Kasir Pasien"],
        parameters: [
            new OA\Parameter(name: "noReg", in: "query", description: "Filter Nomor Registrasi Pasien", required: false, schema: new OA\Schema(type: "string", example: "2605000074")),
            new OA\Parameter(name: "noRm", in: "query", description: "Filter Nomor Rekam Medis (No CM)", required: false, schema: new OA\Schema(type: "string", example: "0487727")),
            new OA\Parameter(name: "tglAwal", in: "query", description: "Filter Tanggal Awal Struk / Masuk (YYYY-MM-DD)", required: false, schema: new OA\Schema(type: "string", format: "date", example: "2026-05-01")),
            new OA\Parameter(name: "tglAkhir", in: "query", description: "Filter Tanggal Akhir Struk / Masuk (YYYY-MM-DD)", required: false, schema: new OA\Schema(type: "string", format: "date", example: "2026-05-04")),
            new OA\Parameter(name: "instalasiId", in: "query", description: "Filter ID Instalasi / Departemen", required: false, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daftar tagihan pasien berhasil dimuat",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "noregistrasi", type: "string", example: "2605000074"),
                            new OA\Property(property: "nocm", type: "string", example: "0487727"),
                            new OA\Property(property: "namapasien", type: "string", example: "ADITHA BASRA NY"),
                            new OA\Property(property: "tglregistrasi", type: "string", example: "2026-05-04 02:47:00"),
                            new OA\Property(property: "tglpulang", type: "string", nullable: true),
                            new OA\Property(property: "namaruangan", type: "string", example: "IGD"),
                            new OA\Property(property: "namakelas", type: "string", example: "Kelas III"),
                            new OA\Property(property: "kelompokpasien", type: "string", example: "BPJS"),
                            new OA\Property(property: "norec", type: "string", example: "sp-772910", description: "No Rec Struk Pelayanan"),
                            new OA\Property(property: "nostruk", type: "string", example: "STRUK/2605/0001"),
                            new OA\Property(property: "totalharusdibayar", type: "number", format: "float", example: 350000),
                            new OA\Property(property: "totalprekanan", type: "number", format: "float", example: 350000)
                        ]
                    )
                )
            )
        ]
    )]
    public function getDaftarTagihan() {}

    #[OA\Get(
        path: "/kasir/detail-tagihan-pasien",
        summary: "Rincian Tagihan Biaya Tindakan & Struk Pelayanan",
        description: "Mengambil rincian per baris item tindakan, obat, dan layanan yang ditagihkan beserta harga, diskon, deposit, dan subtotal per struk pelayanan kasir.",
        security: [["bearerAuth" => []]],
        tags: ["Tagihan & Billing Kasir Pasien"],
        parameters: [
            new OA\Parameter(
                name: "noRecStrukPelayanan",
                in: "query",
                description: "No Rec Struk Pelayanan Pasien (sp.norec)",
                required: true,
                schema: new OA\Schema(type: "string", example: "sp-772910")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Rincian tagihan tindakan pasien",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "noRegistrasi", type: "string", example: "2605000074"),
                        new OA\Property(property: "noCm", type: "string", example: "0487727"),
                        new OA\Property(property: "namaPasien", type: "string", example: "ADITHA BASRA NY"),
                        new OA\Property(property: "jenisPenjamin", type: "string", example: "BPJS"),
                        new OA\Property(property: "totalDeposit", type: "number", example: 0),
                        new OA\Property(property: "jumlahBayar", type: "number", example: 350000),
                        new OA\Property(property: "totalPenjamin", type: "number", example: 350000),
                        new OA\Property(
                            property: "detailTagihan",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "namaLayanan", type: "string", example: "Pemeriksaan Dokter IGD"),
                                    new OA\Property(property: "ruangan", type: "string", example: "IGD"),
                                    new OA\Property(property: "jumlah", type: "number", example: 1),
                                    new OA\Property(property: "harga", type: "number", example: 150000),
                                    new OA\Property(property: "diskon", type: "number", example: 0),
                                    new OA\Property(property: "total", type: "number", example: 150000)
                                ]
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function getDetailTagihan() {}

    #[OA\Get(
        path: "/kasir/daftar-pasien-aktif",
        summary: "Daftar Pasien Aktif Dirawat (Billing Terbuka)",
        description: "Mengambil daftar pasien yang masih aktif menjalani perawatan di rumah sakit dan belum menyelesaikan pembayaran billing kasir.",
        security: [["bearerAuth" => []]],
        tags: ["Tagihan & Billing Kasir Pasien"],
        responses: [
            new OA\Response(response: 200, description: "Daftar pasien aktif dirawat")
        ]
    )]
    public function getDaftarPasienAktif() {}
}
