<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Farmasi & E-Resep", description: "Endpoint antrian dan manajemen resep elektronik (E-Resep) serta pelayanan obat")]
class FarmasiController extends Controller
{
    #[OA\Get(
        path: "/farmasi/get-daftar-order",
        summary: "Daftar Order Resep Elektronik (E-Resep)",
        description: "Mengambil daftar pesanan/order resep elektronik dari dokter untuk farmasi. Mendukung filter tanggal awal/akhir dan status (0: Menunggu, 1: Produksi, 2: Packaging, 3: Selesai, 4: Sudah Di Ambil, 5: Verifikasi).",
        security: [["bearerAuth" => []]],
        tags: ["Farmasi & E-Resep"],
        parameters: [
            new OA\Parameter(name: "tglAwal", in: "query", description: "Tanggal Awal (YYYY-MM-DD)", required: true, schema: new OA\Schema(type: "string", format: "date", example: "2026-05-04")),
            new OA\Parameter(name: "tglAkhir", in: "query", description: "Tanggal Akhir (YYYY-MM-DD)", required: true, schema: new OA\Schema(type: "string", format: "date", example: "2026-05-04")),
            new OA\Parameter(name: "statusId", in: "query", description: "Status Resep (0: Menunggu, 1: Produksi, 2: Packaging, 3: Selesai, 4: Penyerahan Obat, 5: Verifikasi)", required: false, schema: new OA\Schema(type: "string", example: "0")),
            new OA\Parameter(name: "nocm", in: "query", description: "Nomor Rekam Medis Pasien", required: false, schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "noPesanan", in: "query", description: "Nomor Order Resep", required: false, schema: new OA\Schema(type: "string", example: "2605000074")),
            new OA\Parameter(name: "ruanganId", in: "query", description: "ID Ruangan Asal Pembuat Resep", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "depoId", in: "query", description: "ID Ruangan Depo Farmasi Tujuan", required: false, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daftar antrian resep berhasil dimuat",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "noantri", type: "string", example: "001"),
                            new OA\Property(property: "noorder", type: "string", example: "2605000074"),
                            new OA\Property(property: "nocm", type: "string", example: "LB01910"),
                            new OA\Property(property: "namapasien", type: "string", example: "TESTING"),
                            new OA\Property(property: "namaruanganrawat", type: "string", example: "RADIOLOGI"),
                            new OA\Property(property: "tglorder", type: "string", example: "2026-05-04 03:28:14"),
                            new OA\Property(property: "namalengkap", type: "string", example: "Dr. FAJRIAH A SUMADAYO"),
                            new OA\Property(property: "statusorder", type: "string", example: "Menunggu", description: "Menunggu / Produksi / Packaging / Selesai / Sudah Di Ambil")
                        ]
                    )
                )
            )
        ]
    )]
    public function getDaftarOrder() {}

    #[OA\Get(
        path: "/farmasi/get-detail-order",
        summary: "Detail Item Obat dalam Resep",
        description: "Mengambil rincian obat, dosis, aturan pakai, dan racikan dalam satu nomor order resep.",
        security: [["bearerAuth" => []]],
        tags: ["Farmasi & E-Resep"],
        parameters: [
            new OA\Parameter(name: "noorder", in: "query", description: "Nomor Order Resep", required: true, schema: new OA\Schema(type: "string", example: "2605000074"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Detail obat berhasil diambil",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "strukorder", type: "object"),
                        new OA\Property(property: "orderpelayanan", type: "array", items: new OA\Items())
                    ]
                )
            )
        ]
    )]
    public function getDetailOrder() {}

    #[OA\Post(
        path: "/farmasi/save-status-resepelektonik",
        summary: "Update Status Pengerjaan Resep Elektronik",
        description: "Memperbarui status pengerjaan resep (1: Produksi, 2: Packaging, 3: Selesai, 4: Sudah Di Ambil).",
        security: [["bearerAuth" => []]],
        tags: ["Farmasi & E-Resep"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["noorder", "statusorder"],
                properties: [
                    new OA\Property(property: "noorder", type: "string", example: "2605000074"),
                    new OA\Property(property: "statusorder", type: "integer", example: 1, description: "1 = Produksi, 2 = Packaging, 3 = Selesai, 4 = Sudah Di Ambil"),
                    new OA\Property(property: "tglambil", type: "string", nullable: true),
                    new OA\Property(property: "namapengambil", type: "string", nullable: true)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Status resep berhasil diubah")
        ]
    )]
    public function saveStatusResep() {}
}
