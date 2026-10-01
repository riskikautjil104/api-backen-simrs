<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Autentikasi (Auth)", description: "Endpoint login, logout, dan manajemen sesi pengguna")]
class AuthController extends Controller
{
    #[OA\Post(
        path: "/auth/sign-in",
        summary: "Login Pengguna SIMRS",
        description: "Autentikasi akun pengguna menggunakan namaUser dan kataSandi. Mengembalikan token X-AUTH-TOKEN, profil pegawai, dan ruangan mapping.",
        tags: ["Autentikasi (Auth)"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["namaUser", "kataSandi"],
                properties: [
                    new OA\Property(property: "namaUser", type: "string", example: "admin"),
                    new OA\Property(property: "kataSandi", type: "string", example: "admin123")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Login Berhasil",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "integer", example: 201),
                        new OA\Property(
                            property: "data",
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "namaUser", type: "string", example: "admin"),
                                new OA\Property(property: "kelompokUser", type: "object"),
                                new OA\Property(property: "pegawai", type: "object")
                            ]
                        ),
                        new OA\Property(
                            property: "messages",
                            type: "object",
                            properties: [
                                new OA\Property(property: "X-AUTH-TOKEN", type: "string", example: "eyJhbGciOiJIUzUxMiJ9...")
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(response: 400, description: "Username atau Password salah")
        ]
    )]
    public function signIn() {}

    #[OA\Post(
        path: "/auth/sign-out",
        summary: "Logout Pengguna SIMRS",
        description: "Mengakhiri sesi login pengguna aktif",
        tags: ["Autentikasi (Auth)"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["kdUser"],
                properties: [
                    new OA\Property(property: "kdUser", type: "string", example: "admin")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Logout Berhasil")
        ]
    )]
    public function signOut() {}

    #[OA\Post(
        path: "/auth/update-password-user",
        summary: "Ubah Kata Sandi Pengguna",
        description: "Mengganti password login user",
        security: [["bearerAuth" => []]],
        tags: ["Autentikasi (Auth)"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["id", "namaUser", "kataSandi", "kelompokUser"],
                properties: [
                    new OA\Property(property: "id", type: "integer", example: 1),
                    new OA\Property(property: "namaUser", type: "string", example: "admin"),
                    new OA\Property(property: "kataSandi", type: "string", example: "newpassword123"),
                    new OA\Property(
                        property: "kelompokUser",
                        type: "object",
                        properties: [
                            new OA\Property(property: "id", type: "integer", example: 1)
                        ]
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Password berhasil diubah"),
            new OA\Response(response: 400, description: "Gagal mengubah password")
        ]
    )]
    public function updatePassword() {}
}
