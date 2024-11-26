<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *   description="Contoh API doc menggunakan OpenAPI/Swagger",
 *   version="0.0.1",
 *   title="Contoh API documentation",
 *   termsOfService="http://swagger.io/terms/",
 *   @OA\Contact(
 *     email="choirudin.emchagmail.com"
 *   ),
 *   @OA\License(
 *     name="Apache 2.0",
 *     url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *   )
 * )
 */



class greetController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/greet",
 *     tags={"greeting"},
 *     summary="Returns a Sample API response",
 *     description="A sample greeting to test out the API",
 *     operationId="greet",
 *     @OA\Parameter(
 *         name="firstname",
 *         description="nama depan",
 *         required=true,
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="lastname",
 *         description="nama belakang",
 *         required=true,
 *         in="query",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="successful operation",
 *         @OA\JsonContent(
 *             example={
 *                 "success": true,
 *                 "message": "Berhasil mengambil Kategori Berita",
 *                 "data": {
 *                     "output": "Hallo Jon Doe",
 *                     "firstname": "John",
 *                     "lastname": "Doe"
 *                 }
 *             }
 *         )
 *     )
 * )
 */

    public function index(Request $request) {
        $userdata = $request->only([
            'firstname',
            'lastname'
        ]);
        if (empty($userdata['firstname']) && empty($userdata['lastname'])) {
            return new \Exception('missing data ', 404);
        }
        return response()->json(['message', 'Berhasil memproses masukan user', 'success' => true, 'data' => [
            'output' => 'Halo ' . $userdata['firstname'] . ' ' . $userdata['lastname'], 'firstname' => $userdata['firstname'],
            'lastname' => $userdata['lastname']
        ]], 200);
    }
}
