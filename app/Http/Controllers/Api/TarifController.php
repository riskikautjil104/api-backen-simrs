<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Master Tarif & Harga Tindakan per Kelas", description: "Endpoint tarif tindakan rumah sakit per kelas perawatan (Kelas 1, 2, 3, VIP, VVIP) dan komponen biaya")]
class TarifController extends Controller
{
    #[OA\Get(
        path: "/kiosk/get-tarif",
        summary: "Daftar Tarif & Harga Tindakan Lengkap per Kelas",
        description: "Mengambil daftar seluruh tarif tindakan rumah sakit yang dikelompokkan berdasarkan Kelas Perawatan (Kelas 1, 2, 3, VIP, VVIP, Non Kelas), Ruangan/Poli, dan Jenis Pelayanan. Mendukung pencarian nama tindakan, filter produk, ruangan, kelas, dan jenis pelayanan.",
        security: [["bearerAuth" => []]],
        tags: ["Master Tarif & Harga Tindakan per Kelas"],
        parameters: [
            new OA\Parameter(name: "namaproduk", in: "query", description: "Cari berdasarkan nama tindakan / layanan (contoh: EKG, Konsul, USG)", required: false, schema: new OA\Schema(type: "string", example: "EKG")),
            new OA\Parameter(name: "kelasId", in: "query", description: "Filter ID Kelas Perawatan (1: Kelas 1, 2: Kelas 2, 3: Kelas 3, 4: VIP, 5: VVIP, 6: Non Kelas)", required: false, schema: new OA\Schema(type: "integer", example: 3)),
            new OA\Parameter(name: "ruanganId", in: "query", description: "Filter ID Ruangan Pelayanan", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "produkId", in: "query", description: "Filter ID Produk / Tindakan Spesifik", required: false, schema: new OA\Schema(type: "integer")),
            new OA\Parameter(name: "jenispelayananId", in: "query", description: "Filter ID Jenis Pelayanan", required: false, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daftar tarif tindakan berhasil dimuat",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer", example: 2041, description: "ID Tindakan (produk_m)"),
                            new OA\Property(property: "namaproduk", type: "string", example: "Elektrokardiogram (EKG)"),
                            new OA\Property(property: "hargalayanan", type: "number", format: "float", example: 65000, description: "Harga / Tarif Layanan"),
                            new OA\Property(property: "idkelas", type: "integer", example: 3, description: "ID Kelas"),
                            new OA\Property(property: "namakelas", type: "string", example: "Kelas III", description: "Nama Kelas Perawatan"),
                            new OA\Property(property: "jenispelayananid", type: "integer", example: 1),
                            new OA\Property(property: "jenispelayanan", type: "string", example: "Rawat Jalan"),
                            new OA\Property(property: "ruid", type: "integer", example: 45),
                            new OA\Property(property: "namaruangan", type: "string", example: "Poli Jantung")
                        ]
                    )
                )
            )
        ]
    )]
    public function getDaftarTarifKiosk() {}

    #[OA\Get(
        path: "/humas/get-daftar-tarif-layanan",
        summary: "Informasi Publik Tarif Layanan Rumah Sakit",
        description: "Menampilkan informasi tarif layanan dan tindakan untuk keperluan informasi publik dan humas rumah sakit.",
        security: [["bearerAuth" => []]],
        tags: ["Master Tarif & Harga Tindakan per Kelas"],
        parameters: [
            new OA\Parameter(name: "namaproduk", in: "query", description: "Nama tindakan yang dicari", required: false, schema: new OA\Schema(type: "string", example: "Darah Lengkap")),
            new OA\Parameter(name: "kelasId", in: "query", description: "ID Kelas Perawatan", required: false, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar tarif layanan humas")
        ]
    )]
    public function getDaftarTarifHumas() {}

    #[OA\Get(
        path: "/sysadmin/general/get-komponenharga",
        summary: "Rincian Komponen Harga & Tarif Tindakan",
        description: "Mengambil pecahan rincian komponen pembentuk harga tindakan (Jasa Medis Dokter, Jasa Perawat/Paramedis, Jasa Sarana Rumah Sakit, Bahan Habis Pakai/BHP, Administrasi) berdasarkan ID Tindakan, ID Kelas, ID Ruangan, dan ID Jenis Pelayanan.",
        security: [["bearerAuth" => []]],
        tags: ["Master Tarif & Harga Tindakan per Kelas"],
        parameters: [
            new OA\Parameter(name: "idProduk", in: "query", description: "ID Tindakan / Produk (produk_m)", required: true, schema: new OA\Schema(type: "integer", example: 1042)),
            new OA\Parameter(name: "idKelas", in: "query", description: "ID Kelas Perawatan", required: true, schema: new OA\Schema(type: "integer", example: 3)),
            new OA\Parameter(name: "idRuangan", in: "query", description: "ID Ruangan Pelayanan", required: true, schema: new OA\Schema(type: "integer", example: 1)),
            new OA\Parameter(name: "idJenisPelayanan", in: "query", description: "ID Jenis Pelayanan", required: true, schema: new OA\Schema(type: "integer", example: 1))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Rincian komponen harga tindakan",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "objectkomponenhargafk", type: "integer", example: 25),
                            new OA\Property(property: "komponenharga", type: "string", example: "Jasa Medis Spesialis"),
                            new OA\Property(property: "hargasatuan", type: "number", format: "float", example: 50000),
                            new OA\Property(property: "iscito", type: "boolean", example: false)
                        ]
                    )
                )
            )
        ]
    )]
    public function getKomponenHarga() {}
}
