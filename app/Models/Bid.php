<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['bidamount', 'user_memberships_id', 'auctions_id', 'biddatetime'];
    protected $encrypt = ['bidamount'];

    private function encrypt($value)
    {
        $key = hex2bin(Config::get('app.aes_key'));
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($value, 'aes-256-cbc', $key, 0, $iv);
        if ($encrypted === false) {
            throw new Exception('Encryption failed');
        }
        return base64_encode($iv . $encrypted);
    }

    private function decrypt($value)
    {
        $key = hex2bin(Config::get('app.aes_key'));
        $data = base64_decode($value);
        $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = substr($data, openssl_cipher_iv_length('aes-256-cbc'));
        $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
        if ($decrypted === false) {
            throw new Exception('Decryption failed');
        }
        return intval($decrypted);
    }

    public function getBidamountAttribute($value)
    {
        return $this->decrypt($value);
    }

    public function setBidamountAttribute($value)
    {
        $this->attributes['bidamount'] = $this->encrypt($value);
    }
}
