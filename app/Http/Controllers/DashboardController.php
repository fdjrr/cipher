<?php

namespace App\Http\Controllers;

use App\Http\Requests\DecryptDataRequest;
use App\Http\Requests\EncryptDataRequest;
use App\Http\Requests\GeneratePrivateKeyRequest;
use App\Http\Requests\GeneratePublicKeyRequest;
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
        Storage::put("private_keys/{$fileName}", $privateKey);

        return response()->download(Storage::path("private_keys/{$fileName}"))->deleteFileAfterSend(true);
    }

    public function generatePublicKey(GeneratePublicKeyRequest $request)
    {
        $privateKeyPath = $request->file('private_key')->getRealPath();
        $privateKey = file_get_contents($privateKeyPath);

        $res = openssl_pkey_get_private($privateKey);

        if (!$res) {
            return redirect()->route('dashboard')->with('error', "Failed to generate public key")->withInput();
        }

        $publicKey = openssl_pkey_get_details($res)['key'];

        $fileName = 'public_key_' . now()->timestamp . '.pem';
        Storage::put("public_keys/{$fileName}", $publicKey);

        return response()->download(Storage::path("public_keys/{$fileName}"))->deleteFileAfterSend(true);
    }

    public function encrypt(EncryptDataRequest $request)
    {
        $publicKeyPath = $request->file('public_key')->getRealPath();
        $publicKey = file_get_contents($publicKeyPath);

        openssl_public_encrypt($request->data, $encrypted, $publicKey);

        return redirect()->route('dashboard')->with([
            'encrypted' => base64_encode($encrypted)
        ]);
    }

    public function decrypt(DecryptDataRequest $request)
    {
        $privateKeyPath = $request->file('private_key')->getRealPath();
        $privateKey = file_get_contents($privateKeyPath);

        openssl_private_decrypt(base64_decode($request->data), $decrypted, $privateKey);

        return redirect()->route('dashboard')->with([
            'decrypted' => $decrypted
        ]);
    }
}
