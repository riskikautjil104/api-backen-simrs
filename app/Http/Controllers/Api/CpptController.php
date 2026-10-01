<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "CPPT Pasien (Catatan Perkembangan Terintegrasi)", description: "Endpoint Catatan Perkembangan Pasien Terintegrasi (CPPT) dengan format SOAP (Subjektif, Objektif, Asesmen, Planning)")]
class CpptController extends Controller
{
    #[OA\Get(
        path: "/emr/get-riwayatcppt-rajalranap",
        summary: "Riwayat Lengkap CPPT Rawat Jalan & Rawat Inap (Rekomendasi Utama)",
        description: "Mengambil riwayat akumulatif seluruh catatan CPPT dari berbagai episode rawat jalan dan rawat inap pasien. Menampilkan No EMR, judul form CPPT, tanggal EMR, data pasien, ruangan, kelas, dan dokter penanggung jawab.",
        security: [["bearerAuth" => []]],
        tags: ["CPPT Pasien (Catatan Perkembangan Terintegrasi)"],
        parameters: [
            new OA\Parameter(
                name: "nocm",
                in: "query",
                description: "Nomor Rekam Medis Pasien (No CM)",
                required: true,
                schema: new OA\Schema(type: "string", example: "0611944")
            ),
            new OA\Parameter(
                name: "noregistrasifk",
                in: "query",
                description: "Nomor Registrasi Kunjungan Pasien",
                required: false,
                schema: new OA\Schema(type: "string", example: "2609008289")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Riwayat catatan CPPT pasien berhasil diambil",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "reportdisplay", type: "string", example: "RekamMedis.AsesmenMedis.MenuCPPTRawatInap.CpptNew"),
                                    new OA\Property(property: "caption", type: "string", example: "CPPT Rawat Inap"),
                                    new OA\Property(property: "emrid", type: "integer", example: 443),
                                    new OA\Property(property: "norec", type: "string", example: "4874dd70-b746-11f1-8816-2308182e"),
                                    new OA\Property(property: "noemr", type: "string", example: "MR2609/00016860"),
                                    new OA\Property(property: "noregistrasifk", type: "string", example: "2609008289"),
                                    new OA\Property(property: "nocm", type: "string", example: "0611944"),
                                    new OA\Property(property: "namapasien", type: "string", example: "FATHAN ANDARA ADITYA AN"),
                                    new OA\Property(property: "jeniskelamin", type: "string", example: "LAKI-LAKI"),
                                    new OA\Property(property: "umur", type: "string", example: "0thn 3bln 27hr"),
                                    new OA\Property(property: "kelompokpasien", type: "string", example: "BPJS"),
                                    new OA\Property(property: "tglregistrasi", type: "string", example: "2026-09-24 07:30:00"),
                                    new OA\Property(property: "norec_apd", type: "string", example: "10ce0a10-b7c3-11f1-8e3b-a54d9ba5"),
                                    new OA\Property(property: "namakelas", type: "string", example: "Kelas III"),
                                    new OA\Property(property: "namaruangan", type: "string", example: "ANAK"),
                                    new OA\Property(property: "tglemr", type: "string", example: "2026-10-01 07:02:05")
                                ]
                            )
                        ),
                        new OA\Property(property: "message", type: "string", example: "as@epic")
                    ]
                )
            )
        ]
    )]
    public function getRiwayatCpptRajalRanap() {}

    #[OA\Get(
        path: "/emr/get-emr-transaksi-detail",
        summary: "Isi Rincian Jawaban CPPT / Asesmen EMR Pasien (Content & Detail SOAP)",
        description: "Mengambil seluruh isi rincian catatan medis yang diisi oleh dokter dan perawat dalam dokumen CPPT atau asesmen EMR (termasuk isi SOAP, perkembangan kondisi, instruksi PPA, aplosan jaga dinas perawat, jam observasi, dan nama PPA pengisi). Gunakan parameter 'noemr' yang didapat dari get-riwayatcppt-rajalranap.",
        security: [["bearerAuth" => []]],
        tags: ["CPPT Pasien (Catatan Perkembangan Terintegrasi)"],
        parameters: [
            new OA\Parameter(
                name: "noemr",
                in: "query",
                description: "Nomor Dokumen EMR (contoh: MR2609/00016860 dari riwayat CPPT)",
                required: true,
                schema: new OA\Schema(type: "string", example: "MR2609/00016860")
            ),
            new OA\Parameter(
                name: "emrfk",
                in: "query",
                description: "ID Formulir EMR. Gunakan 443 untuk formulir CPPT Rawat Inap (CpptNew / SOAP Dokter & Perawat), atau 290007 untuk formulir Catatan Perawat/Bidan (Aplosan Shift Jaga).",
                required: false,
                schema: new OA\Schema(type: "integer", example: 443)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Rincian isi jawaban CPPT / formulir EMR berhasil diambil",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "norec", type: "string", example: "d18de5e0-bcd5-11f1-a8ce-e719684c"),
                                    new OA\Property(property: "emrpasienfk", type: "string", example: "MR2609/00016860", description: "Nomor EMR Dokumen"),
                                    new OA\Property(property: "emrdfk", type: "integer", example: 1901300472, description: "ID Komponen / Pertanyaan"),
                                    new OA\Property(property: "emrfk", type: "integer", example: 290007, description: "ID Form EMR"),
                                    new OA\Property(property: "value", type: "string", example: "aplos dengan petugas siang, kel: batuk, terpasang venvlon, terpasang NGT, th/lanjut", description: "Isi teks catatan / SOAP / jawaban medis"),
                                    new OA\Property(property: "type", type: "string", example: "textarea", description: "Tipe input (textarea, combobox, datetime, textbox, checkbox)"),
                                    new OA\Property(property: "caption", type: "string", example: "Catatan Perkembangan Pasien"),
                                    new OA\Property(property: "namalengkap", type: "string", example: "NURLITA ABDULLAH, Amd.Kep", description: "Nama Tenaga Medis / PPA / Dokter"),
                                    new OA\Property(property: "tgl", type: "string", example: "2026-09-30 20:49:55", description: "Waktu Pengisian Catatan"),
                                    new OA\Property(property: "pegawaifk", type: "integer", example: 101361)
                                ]
                            )
                        ),
                        new OA\Property(property: "message", type: "string", example: "as@epic")
                    ]
                )
            )
        ]
    )]
    public function getEmrTransaksiDetail() {}

    #[OA\Get(
        path: "/emr/get-cppt",
        summary: "Daftar Catatan CPPT SOAP Pasien",
        description: "Mengambil daftar catatan perkembangan pasien terintegrasi (CPPT) lengkap dengan rincian SOAP (Subjektif, Objektif, Asesmen, Planning), dokter/PPA penulis, ruangan perawatan, dan status verifikasi DPJP. Catatan: Gunakan parameter 'nocm' sebagai filter utama.",
        security: [["bearerAuth" => []]],
        tags: ["CPPT Pasien (Catatan Perkembangan Terintegrasi)"],
        parameters: [
            new OA\Parameter(
                name: "nocm",
                in: "query",
                description: "Nomor Rekam Medis Pasien (No CM)",
                required: true,
                schema: new OA\Schema(type: "string", example: "0611944")
            ),
            new OA\Parameter(
                name: "noregistrasifk",
                in: "query",
                description: "No Registrasi Kunjungan Pasien (Opsional)",
                required: false,
                schema: new OA\Schema(type: "string", example: "2609008289")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Catatan CPPT pasien berhasil diambil",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                properties: [
                                    new OA\Property(property: "norec", type: "string", example: "cppt-001239"),
                                    new OA\Property(property: "nocppt", type: "string", example: "1"),
                                    new OA\Property(property: "tglinput", type: "string", example: "2026-10-01 07:02:05"),
                                    new OA\Property(property: "noregistrasi", type: "string", example: "2609008289"),
                                    new OA\Property(property: "nocm", type: "string", example: "0611944"),
                                    new OA\Property(property: "namapasien", type: "string", example: "FATHAN ANDARA ADITYA AN"),
                                    new OA\Property(property: "namaruangan", type: "string", example: "ANAK"),
                                    new OA\Property(property: "namalengkap", type: "string", example: "Dr. FAJRIAH A SUMADAYO", description: "Nama Dokter / PPA pembuat CPPT"),
                                    new OA\Property(property: "s", type: "string", example: "Keluhan pasien / anamnesis", description: "Subjektif (Keluhan Pasien)"),
                                    new OA\Property(property: "o", type: "string", example: "Pemeriksaan fisik dan tanda vital", description: "Objektif (Pemeriksaan Fisik & TTV)"),
                                    new OA\Property(property: "a", type: "string", example: "Diagnosa kerja / asesmen", description: "Asesmen (Analisis / Diagnosa Kerja)"),
                                    new OA\Property(property: "p", type: "string", example: "Rencana terapi dan instruksi", description: "Planning (Rencana Tindakan & Terapi)"),
                                    new OA\Property(property: "isverifikasi", type: "boolean", example: true, description: "Status Verifikasi DPJP")
                                ]
                            )
                        ),
                        new OA\Property(property: "message", type: "string", example: "Inhuman")
                    ]
                )
            )
        ]
    )]
    public function getCppt() {}

    #[OA\Post(
        path: "/emr/post-cppt/{method}",
        summary: "Simpan / Perbarui Catatan CPPT Pasien",
        description: "Menyimpan catatan CPPT SOAP baru (method=save) atau memperbarui catatan yang sudah ada (method=update).",
        security: [["bearerAuth" => []]],
        tags: ["CPPT Pasien (Catatan Perkembangan Terintegrasi)"],
        parameters: [
            new OA\Parameter(
                name: "method",
                in: "path",
                description: "Operasi: save / update / delete",
                required: true,
                schema: new OA\Schema(type: "string", enum: ["save", "update", "delete"], example: "save")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["noregistrasifk", "pasienfk", "s", "o", "a", "p"],
                properties: [
                    new OA\Property(property: "norec", type: "string", nullable: true, description: "Diisi saat method=update"),
                    new OA\Property(property: "noregistrasifk", type: "string", example: "apd-102934"),
                    new OA\Property(property: "pasienfk", type: "integer", example: 10542),
                    new OA\Property(property: "ruanganfk", type: "integer", example: 45),
                    new OA\Property(property: "pegawaifk", type: "integer", example: 12),
                    new OA\Property(property: "s", type: "string", example: "Keluhan nyeri kepala berkurang"),
                    new OA\Property(property: "o", type: "string", example: "TD: 120/80, N: 80, S: 36.5"),
                    new OA\Property(property: "a", type: "string", example: "Cephalgia perbaikan"),
                    new OA\Property(property: "p", type: "string", example: "Paracetamol 500mg prn")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Catatan CPPT berhasil disimpan"),
            new OA\Response(response: 400, description: "Gagal menyimpan CPPT")
        ]
    )]
    public function postCppt() {}

    #[OA\Post(
        path: "/emr/save-verif-cppt-dokter",
        summary: "Verifikasi Catatan CPPT oleh DPJP",
        description: "Melakukan verifikasi dan tanda tangan elektronik/validasi DPJP pada catatan perkembangan pasien terintegrasi.",
        security: [["bearerAuth" => []]],
        tags: ["CPPT Pasien (Catatan Perkembangan Terintegrasi)"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["norec_cppt", "dokterfk"],
                properties: [
                    new OA\Property(property: "norec_cppt", type: "string", example: "cppt-001239"),
                    new OA\Property(property: "dokterfk", type: "integer", example: 12)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Verifikasi CPPT berhasil disimpan")
        ]
    )]
    public function saveVerifCppt() {}
}
