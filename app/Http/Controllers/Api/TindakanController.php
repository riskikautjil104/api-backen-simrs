<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Riwayat Tindakan & Pelayanan Pasien", description: "Endpoint riwayat tindakan medis, kuantiti, harga satuan, dan rincian pelayanan pasien")]
class TindakanController extends Controller
{
    #[OA\Get(
        path: "/registrasi/get-pelayanan-pasien",
        summary: "Riwayat Tindakan Medis Pasien per Kunjungan",
        description: "Mengambil daftar seluruh tindakan, prosedur, konsultasi, dan pelayanan yang telah diberikan kepada pasien pada satu episode kunjungan pendaftaran (pasiendaftar_t). Menampilkan nomor rekam tindakan, tanggal tindakan, ID produk, nama tindakan, harga satuan, harga netto, kuantiti (jumlah), kategori jenis produk, dan nama ruangan tempat tindakan dilakukan.",
        security: [["bearerAuth" => []]],
        tags: ["Riwayat Tindakan & Pelayanan Pasien"],
        parameters: [
            new OA\Parameter(
                name: "norec_pd",
                in: "query",
                description: "No Rec Pendaftaran Pasien (norec di pasiendaftar_t)",
                required: true,
                schema: new OA\Schema(type: "string", example: "2c90e482755259cf01755259cf2b0000")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daftar tindakan medis pasien berhasil diambil",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "noRec", type: "string", example: "pp-829104", description: "No Rec Pelayanan Pasien"),
                                    new OA\Property(property: "noRecStruk", type: "string", nullable: true, example: "sp-109283"),
                                    new OA\Property(property: "tglPelayanan", type: "string", example: "2026-05-04 09:15:00"),
                                    new OA\Property(property: "produkId", type: "integer", example: 1042),
                                    new OA\Property(property: "namaProduk", type: "string", example: "Konsultasi / Pemeriksaan Dokter Spesialis"),
                                    new OA\Property(property: "hargaSatuan", type: "number", format: "float", example: 75000),
                                    new OA\Property(property: "hargaNetto", type: "number", format: "float", example: 75000),
                                    new OA\Property(property: "jumlah", type: "number", example: 1),
                                    new OA\Property(property: "detailJenisProduk", type: "string", example: "Jasa Konsultasi / Visite"),
                                    new OA\Property(property: "namaRuangan", type: "string", example: "Poli Penyakit Dalam")
                                ]
                            )
                        ),
                        new OA\Property(property: "message", type: "string", example: "inhuman")
                    ]
                )
            )
        ]
    )]
    public function getPelayananPasien() {}

    #[OA\Get(
        path: "/tatarekening/tindakan/get-pelayanan-pasien",
        summary: "Riwayat Pelayanan & Tindakan Pasien (Tata Rekening / Kasir)",
        description: "Mengambil daftar rincian tindakan dan pelayanan pasien dari modul billing / tata rekening berdasarkan No Rec pendaftaran.",
        security: [["bearerAuth" => []]],
        tags: ["Riwayat Tindakan & Pelayanan Pasien"],
        parameters: [
            new OA\Parameter(
                name: "norec_pd",
                in: "query",
                description: "No Rec Pendaftaran Pasien",
                required: true,
                schema: new OA\Schema(type: "string", example: "2c90e482755259cf01755259cf2b0000")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daftar pelayanan tindakan dari tata rekening",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items()),
                        new OA\Property(property: "message", type: "string", example: "inhuman")
                    ]
                )
            )
        ]
    )]
    public function getPelayananTataRekening() {}

    #[OA\Get(
        path: "/sysadmin/general/get-tindakan",
        summary: "Daftar Tindakan Medis yang Tersedia per Ruangan",
        description: "Mengambil master tindakan dan tarif pelayanan yang dipetakan untuk ruangan/poliklinik tertentu.",
        security: [["bearerAuth" => []]],
        tags: ["Riwayat Tindakan & Pelayanan Pasien"],
        parameters: [
            new OA\Parameter(name: "idRuangan", in: "query", description: "ID Ruangan / Poliklinik", required: true, schema: new OA\Schema(type: "integer", example: 1))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daftar tindakan medis ruangan",
                content: new OA\JsonContent(type: "array", items: new OA\Items())
            )
        ]
    )]
    public function getMasterTindakanRuangan() {}

    #[OA\Get(
        path: "/radiologi/get-rincian-pelayanan-radiologi",
        summary: "Riwayat Rincian Tindakan Radiologi Pasien",
        description: "Mengambil daftar tindakan foto rontgen, CT Scan, USG, atau pemeriksaan radiologi yang dilakukan pada pasien.",
        security: [["bearerAuth" => []]],
        tags: ["Riwayat Tindakan & Pelayanan Pasien"],
        parameters: [
            new OA\Parameter(name: "norec_pd", in: "query", description: "No Rec Pendaftaran Pasien", required: false, schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "noReg", in: "query", description: "Nomor Registrasi Pasien", required: false, schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Rincian tindakan radiologi")
        ]
    )]
    public function getRiwayatRadiologi() {}
}
