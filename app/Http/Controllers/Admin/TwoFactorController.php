<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function setup()
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        // 1. Generate or retrieve the secret key
        if (!$user->google2fa_secret) {
            $user->update([
                'google2fa_secret' => $google2fa->generateSecretKey(),
            ]);
        }

        $secretKey = $user->google2fa_secret;

        // 2. Generate the URL that the Authenticator app needs
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name', 'Tourism Permit System'),
            $user->email,
            $secretKey
        );

        // 3. Generate the QR Code as an SVG string
        $qrCodeSvg = QrCode::size(220)
            ->color(30, 41, 59) // Dark Navy
            ->margin(1)
            ->generate($qrCodeUrl);

        return view('auth.2fa_setup', [
            'qrCodeSvg' => $qrCodeSvg,
            'secret' => $secretKey
        ]);
    }

    public function challenge()
    {
        return view('auth.2fa_challenge');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|digits:6',
        ]);

        $google2fa = new Google2FA();
        $user = Auth::user();

        // Verify the 6-digit code against the stored secret
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->one_time_password);

        if ($valid) {
            session(['2fa_verified' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['one_time_password' => 'Invalid code. Please check your authenticator app.']);
    }
}