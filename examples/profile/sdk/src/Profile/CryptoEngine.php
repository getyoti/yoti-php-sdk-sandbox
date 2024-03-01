<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Str;
use phpseclib\Crypt\RSA;
use phpseclib\Crypt\AES;
use phpseclib\Math\BigInteger;
use Yoti\Profile\Util\Attribute\AttributeConverter;

class CryptoEngine
{
    private const DIGEST_ALGORITHM = 'sha256';

    public static function loadRsaKey(string $keyPath): RSA
    {
        $key = File::get($keyPath);
        $rsa = new RSA();
        $rsa->loadKey($key);
        return $rsa;
    }

    public static function decipherAes(string $key, string $iv, string $cipherBytes): string
    {
        $aes = new AES(AES::MODE_CBC);
        $aes->setKey($key);
        $aes->setIV($iv);
        return $aes->decrypt($cipherBytes);
    }

    public static function decryptRsa(string $cipherBytes, RSA $rsa): string
    {
        return $rsa->decrypt($cipherBytes);
    }

    public static function signDigest(string $digestBytes, RSA $rsa): string
    {
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1);
        return $rsa->sign($digestBytes);
    }

    public static function generateNonce(): string
    {
        return Str::uuid()->toString();
    }

    public static function decryptToken(string $encryptedConnectToken, RSA $rsa): string
    {
        $cipherBytes = base64_decode($encryptedConnectToken);
        $decipheredBytes = self::decryptRsa($cipherBytes, $rsa);
        return $decipheredBytes;
    }

    public static function unwrapKey(string $wrappedKey, RSA $rsa): string
    {
        $cipherBytes = base64_decode($wrappedKey);
        $decipheredBytes = self::decryptRsa($cipherBytes, $rsa);
        return $decipheredBytes;
    }

    public static function decryptAttributeList(string $wrappedReceiptKey, string $profileContent, RSA $rsa): string
    {
        $unwrappedKey = self::unwrapKey($wrappedReceiptKey, $rsa);
        $contentBytes = base64_decode($profileContent);
        $encryptedData = json_decode($contentBytes, true);
        $iv = base64_decode($encryptedData['iv']);
        $cipherText = base64_decode($encryptedData['cipherText']);
        $decipheredBytes = self::decipherAes($unwrappedKey, $iv, $cipherText);
        return $decipheredBytes;
    }

    public static function getAuthKey(RSA $rsa): string
    {
        return base64_encode($rsa->getPublicKey());
    }

    private static function parseProfileContent($keyPair, string $wrappedReceiptKey, string $profileContent): array
    {
        $parsedAttributes = [];

        if (!empty($profileContent)) {
            $profileAttributeList = CryptoEngine::decryptAttributeList($wrappedReceiptKey, $profileContent, $keyPair);
            $parsedAttributes = null; //AttributeConverter::convertToBaseAttributes($profileAttributeList);
        }

        return $parsedAttributes;
    }
}
