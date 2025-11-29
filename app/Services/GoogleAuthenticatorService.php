<?php

namespace App\Services;

use PragmaRX\Google2FA\Google2FA;

class GoogleAuthenticatorService
{
    protected $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Generate a new secret key for Google Authenticator
     */
    public function generateSecretKey(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * Generate QR code URL for Google Authenticator
     */
    public function getQRCodeUrl(string $companyName, string $email, string $secret): string
    {
        return $this->google2fa->getQRCodeUrl(
            $companyName,
            $email,
            $secret
        );
    }

    /**
     * Generate QR code image URL using external service
     */
    public function getQRCodeImageUrl(string $companyName, string $email, string $secret): string
    {
        $otpauthUrl = $this->getQRCodeUrl($companyName, $email, $secret);
        
        // Using api.qrserver.com to generate QR code image
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($otpauthUrl);
    }

    /**
     * Verify the code provided by user
     */
    public function verifyKey(string $secret, string $code): bool
    {
        return $this->google2fa->verifyKey($secret, $code);
    }

    /**
     * Get current timestamp for verification
     */
    public function getCurrentOtp(string $secret): string
    {
        return $this->google2fa->getCurrentOtp($secret);
    }
}

