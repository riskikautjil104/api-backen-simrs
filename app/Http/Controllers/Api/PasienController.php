<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Data Pasien (Master)", description: "Endpoint pencarian dan detail identitas master pasien")]
class PasienController extends Controller
{
    #[OA\Get(
        path: "/registrasi/get-pasien",
        summary: "Pencarian Master Data Pasien",
        description: "Mencari data pasien berdasarkan berbagai filter parameter (No Rekam Medis, Nama, NIK, No BPJS, Tanggal Lahir, Alamat, dll).",
        security: [["bearerAuth" => []]],
        tags: ["Data Pasien (Master)"],
        parameters: [
            new OA\Parameter(name: "norm", in: "query", description: "Nomor Rekam Medis (No CM)", required: false, schema: new OA\Schema(type: "string", example: "0487727")),
            new OA\Parameter(name: "namaPasien", in: "query", description: "Nama Lengkap Pasien", required: false, schema: new OA\Schema(type: "string", example: "ADITHA")),
            new OA\Parameter(name: "nik", in: "query", description: "Nomor KTP / NIK (16 digit)", required: false, schema: new OA\Schema(type: "string", example: "827101...")),
            new OA\Parameter(name: "bpjs", in: "query", description: "Nomor Kartu BPJS Kesehatan", required: false, schema: new OA\Schema(type: "string", example: "0001234567890")),
            new OA\Parameter(name: "tglLahir", in: "query", description: "Tanggal Lahir Pasien (Format: YYYY-MM-DD)", required: false, schema: new OA\Schema(type: "string", format: "date", example: "1995-08-17")),
            new OA\Parameter(name: "alamat", in: "query", description: "Alamat domisili pasien", required: false, schema: new OA\Schema(type: "string", example: "Ternate")),
            new OA\Parameter(name: "namaAyah", in: "query", description: "Nama Ayah Kandung", required: false, schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "Rows", in: "query", description: "Maksimal jumlah baris data yang diambil", required: false, schema: new OA\Schema(type: "integer", default: 10, example: 10))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Daftar pasien berhasil ditemukan",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "daftar",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "nocmfk", type: "integer", example: 10542),
                                    new OA\Property(property: "nocm", type: "string", example: "0487727"),
                                    new OA\Property(property: "namapasien", type: "string", example: "ADITHA BASRA NY"),
                                    new OA\Property(property: "tgllahir", type: "string", example: "1990-05-12 00:00:00"),
                                    new OA\Property(property: "jeniskelamin", type: "string", example: "PEREMPUAN"),
                                    new OA\Property(property: "noidentitas", type: "string", example: "8271015205900001"),
                                    new OA\Property(property: "nobpjs", type: "string", example: "0001423526171"),
                                    new OA\Property(property: "alamatlengkap", type: "string", example: "Kel. Kalumata RT 02 RW 01, Kota Ternate Selatan"),
                                    new OA\Property(property: "notelepon", type: "string", example: "08123456789"),
                                    new OA\Property(property: "namaayah", type: "string", example: "Basra")
                                ]
                            )
                        ),
                        new OA\Property(property: "message", type: "string", example: "ramdanegie")
                    ]
                )
            )
        ]
    )]
    public function getPasien() {}

    #[OA\Get(
        path: "/registrasi/get-pasienbynocm",
        summary: "Ambil Data Pasien Berdasarkan ID Pasien",
        description: "Mengambil data lengkap identitas dan foto profil pasien berdasarkan ID database (noCm parameter).",
        security: [["bearerAuth" => []]],
        tags: ["Data Pasien (Master)"],
        parameters: [
            new OA\Parameter(name: "noCm", in: "query", description: "ID Pasien (id di tabel pasien_m)", required: true, schema: new OA\Schema(type: "integer", example: 10542))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Detail identitas pasien",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items()),
                        new OA\Property(property: "message", type: "string", example: "ramdanegie")
                    ]
                )
            )
        ]
    )]
    public function getPasienByNoCm() {}

    #[OA\Get(
        path: "/registrasi/get-pasien-by-nocm-riwayat-regis",
        summary: "Ambil Profil Lengkap Pasien by No CM",
        description: "Mengambil profil data keluarga, agama, kebangsaan, dan kontak pasien berdasarkan string Nomor Rekam Medis (No CM).",
        security: [["bearerAuth" => []]],
        tags: ["Data Pasien (Master)"],
        parameters: [
            new OA\Parameter(name: "noCm", in: "query", description: "Nomor Rekam Medis (contoh: 0487727)", required: true, schema: new OA\Schema(type: "string", example: "0487727"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Profil biodata pasien lengkap",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "datas",
                            type: "object",
                            properties: [
                                new OA\Property(property: "nocm", type: "string", example: "0487727"),
                                new OA\Property(property: "namapasien", type: "string", example: "ADITHA BASRA NY"),
                                new OA\Property(property: "agama", type: "string", example: "ISLAM"),
                                new OA\Property(property: "jeniskelamin", type: "string", example: "PEREMPUAN"),
                                new OA\Property(property: "tempatlahir", type: "string", example: "Ternate"),
                                new OA\Property(property: "tgllahir", type: "string", example: "1990-05-12"),
                                new OA\Property(property: "alamatlengkap", type: "string", example: "Kalumata, Ternate Selatan"),
                                new OA\Property(property: "namaibu", type: "string", example: "Fatimah"),
                                new OA\Property(property: "namaayah", type: "string", example: "Basra"),
                                new OA\Property(property: "namakeluarga", type: "string", example: "Basra"),
                                new OA\Property(property: "kebangsaan", type: "string", example: "WNI")
                            ]
                        ),
                        new OA\Property(property: "message", type: "string", example: "er@epic")
                    ]
                )
            )
        ]
    )]
    public function getPasienByNoCmRiwayat() {}
}
