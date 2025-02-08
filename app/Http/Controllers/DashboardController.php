<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneratePrivateKeyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard', [
            "digest_alg" => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => "OPENSSL_KEYTYPE_RSA",
        ]);
    }

    public function generatePrivateKey(GeneratePrivateKeyRequest $request)
    {
        $config = [
            "digest_alg" => $request->digest_alg,
            "private_key_bits" => (int) $request->private_key_bits,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];

        $res = openssl_pkey_new($config);

        if (!$res) {
            $errorMessage = openssl_error_string();
            return redirect()->route('dashboard')->with('error', "Failed to generate private key: $errorMessage")->withInput();
        }

        openssl_pkey_export($res, $privateKey);

        $fileName = 'private_key_' . now()->timestamp . '.pem';
        Storage::put("keys/{$fileName}", $privateKey);

        return response()->download(storage_path("app/keys/{$fileName}"))->deleteFileAfterSend(true);
    }
}
