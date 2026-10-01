<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Pendaftaran & Antrian", description: "Endpoint pendaftaran pasien baru, antrian poliklinik, dan referensi master")]
class PendaftaranController extends Controller
{
    #[OA\Get(
        path: "/registrasi/get-data-combo",
        summary: "Data Master Combo Departemen & Ruangan",
        description: "Mengambil daftar master instalasi/departemen dan ruangan rawat jalan/rawat inap.",
        security: [["bearerAuth" => []]],
        tags: ["Pendaftaran & Antrian"],
        responses: [
            new OA\Response(response: 200, description: "Master data combo ruangan dan departemen")
        ]
    )]
    public function getDataCombo() {}

    #[OA\Get(
        path: "/registrasi/daftar-antrian-pasien/get-daftar-antrian-pasien",
        summary: "Daftar Antrian Pasien Poliklinik / Ruangan",
        description: "Mengambil daftar pasien yang sedang mengantri untuk diperiksa di poliklinik atau ruangan spesifik.",
        security: [["bearerAuth" => []]],
        tags: ["Pendaftaran & Antrian"],
        parameters: [
            new OA\Parameter(name: "tglAwal", in: "query", description: "Tanggal Awal (YYYY-MM-DD)", required: true, schema: new OA\Schema(type: "string", format: "date", example: "2026-05-04")),
            new OA\Parameter(name: "tglAkhir", in: "query", description: "Tanggal Akhir (YYYY-MM-DD)", required: true, schema: new OA\Schema(type: "string", format: "date", example: "2026-05-04")),
            new OA\Parameter(name: "idRuangan", in: "query", description: "ID Ruangan / Poliklinik", required: false, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Daftar antrian pasien")
        ]
    )]
    public function getDaftarAntrian() {}

    #[OA\Post(
        path: "/registrasi/save-pasien",
        summary: "Pendaftaran Pasien Baru",
        description: "Menyimpan data registrasi identitas pasien baru ke database SIMRS.",
        security: [["bearerAuth" => []]],
        tags: ["Pendaftaran & Antrian"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["namapasien", "jeniskelaminfk", "tgllahir", "alamatlengkap"],
                properties: [
                    new OA\Property(property: "namapasien", type: "string", example: "PASIEN BARU TEST"),
                    new OA\Property(property: "jeniskelaminfk", type: "integer", example: 1, description: "1: Laki-laki, 2: Perempuan"),
                    new OA\Property(property: "tgllahir", type: "string", format: "date", example: "1998-01-01"),
                    new OA\Property(property: "noidentitas", type: "string", example: "8271010101980001"),
                    new OA\Property(property: "nobpjs", type: "string", example: "0001234567890"),
                    new OA\Property(property: "alamatlengkap", type: "string", example: "Jl. Merdeka No. 10, Ternate"),
                    new OA\Property(property: "notelepon", type: "string", example: "081234567890")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Pasien baru berhasil didaftarkan")
        ]
    )]
    public function savePasien() {}
}
