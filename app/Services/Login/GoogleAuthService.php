<?php

namespace App\Services\Login;

class GoogleAuthService
{
    public function check($secret, $code)
    {
        $t = floor(time() / 30);
        return $code == $this->totp($secret, $t)
            || $code == $this->totp($secret, $t - 1)
            || $code == $this->totp($secret, $t + 1);
    }

    private function totp($secret, $time)
    {
        // Decode Base32 encoded secret key to binary
        $secret = $this->base32Decode($secret);
        
        // Convert timestamp to 8-byte big-endian
        $time = pack('N*', 0) . pack('N*', $time);
        
        // Calculate HMAC-SHA1
        $hash = hash_hmac('sha1', $time, $secret, true);
        
        // Dynamic truncation
        $offset = ord(substr($hash, -1)) & 0x0F;
        $binary = substr($hash, $offset, 4);
        
        // Convert to integer and modulo
        $code = unpack('N', $binary)[1] & 0x7FFFFFFF;
        $code = $code % 1000000;
        
        // Return 6-digit code, pad with zeros if needed
        return str_pad($code, 6, '0', STR_PAD_LEFT);
    }

    // Base32 decode, compatible with keys without padding
    private function base32Decode(string $secret): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = strtoupper($secret);
        $secret = preg_replace('/[^A-Z2-7]/', '', $secret);
        $bits = '';
        $output = '';

        for ($i = 0; $i < strlen($secret); $i++) {
            $val = strpos($alphabet, $secret[$i]);
            if ($val === false) {
                continue;
            }
            $bits .= str_pad(decbin($val), 5, '0', STR_PAD_LEFT);
        }

        $chunks = str_split($bits, 8);
        foreach ($chunks as $chunk) {
            if (strlen($chunk) === 8) {
                $output .= chr(bindec($chunk));
            }
        }

        return $output;
    }
}
