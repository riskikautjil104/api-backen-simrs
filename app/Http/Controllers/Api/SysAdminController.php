<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Sistem & Notifikasi (SysAdmin)", description: "Endpoint notifikasi realtime antar ruangan dan manajemen sistem")]
class SysAdminController extends Controller
{
    #[OA\Post(
        path: "/sysadmin/store-notif",
        summary: "Kelola Notifikasi Realtime",
        description: "Mengambil daftar notifikasi aktif (method=get), menyimpan notifikasi baru (method=save), atau menandai notifikasi telah dibaca/dihapus (method=delete).",
        security: [["bearerAuth" => []]],
        tags: ["Sistem & Notifikasi (SysAdmin)"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["method"],
                properties: [
                    new OA\Property(property: "method", type: "string", enum: ["get", "save", "delete"], example: "get"),
                    new OA\Property(property: "norec", type: "string", description: "Diisi saat method=delete atau method=save"),
                    new OA\Property(property: "judul", type: "string", example: "RESEP BARU: R/2605/0001"),
                    new OA\Property(property: "jenis", type: "string", example: "Resep Farmasi"),
                    new OA\Property(property: "kelompokUser", type: "string", example: "Farmasi"),
                    new OA\Property(property: "idRuanganTujuan", type: "integer", example: 94)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Respon notifikasi",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "integer", example: 201),
                        new OA\Property(property: "message", type: "string", example: "Sukses"),
                        new OA\Property(property: "data", type: "array", items: new OA\Items())
                    ]
                )
            )
        ]
    )]
    public function storeNotif() {}
}
