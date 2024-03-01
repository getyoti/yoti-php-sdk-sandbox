<?php

declare(strict_types=1);

namespace Yoti\Profile\Util;

use Yoti\Exception\EncryptedDataException;
use Yoti\Protobuf\Compubapi\EncryptedData as EncryptedDataProto;
use Yoti\Util\PemFile;
use Yoti\Protobuf\Attrpubapi\AttributeList;

class EncryptedData
{

    /**
     * @param string $data
     * @param string $wrappedKey
     * @param \Yoti\Util\PemFile $pemFile
     *
     * @return string
     */
    public static function decrypt(string $data, string $wrappedKey, PemFile $pemFile): string
    {
        $decodedProto = base64_decode($data, true);
        if ($decodedProto === false) {
            throw new EncryptedDataException('Could not decode data');
        }

        $encryptedDataProto = new EncryptedDataProto();
        $encryptedDataProto->mergeFromString($decodedProto);

        $decodedWrappedKey = base64_decode($wrappedKey, true);
        if ($decodedWrappedKey === false) {
            throw new EncryptedDataException('Could not decode wrapped key');
        }

        openssl_private_decrypt(
            $decodedWrappedKey,
            $unwrappedKey,
            (string) $pemFile
        );

        $decrypted = openssl_decrypt(
            $encryptedDataProto->getCipherText(),
            'aes-256-cbc',
            $unwrappedKey,
            OPENSSL_RAW_DATA,
            $encryptedDataProto->getIv()
        );
        dump("------------");
        dump($decrypted);

        if ($decrypted !== false) {
            return $decrypted;
        }

        throw new EncryptedDataException('Could not decrypt data');
    }

    /**
     * @param string $data
     * @param string $wrappedKey
     * @param \Yoti\Util\PemFile $pemFile
     *
     * @return string
     */
    public static function decrypt2(string $data, string $wrappedKey, PemFile $pemFile): string
    {
        
        $decodedProto = base64_decode($data, false);
        dump("MASSSS");
        
        if ($decodedProto === false) {
            throw new EncryptedDataException('Could not decode data');
        }
        
        $encryptedDataProto = new EncryptedDataProto();
        $encryptedDataProto->mergeFromString($decodedProto);
        dump($encryptedDataProto);
        $decodedWrappedKey = base64_decode($wrappedKey, true);
        if ($decodedWrappedKey === false) {
            throw new EncryptedDataException('Could not decode wrapped key');
        }

        //$contentBytes = self::Base64ToBytes($data);
        //$encryptedData = self::parseEncryptedData($contentBytes);
        //$iv = $encryptedData['Iv'];
        //$cipherText = $encryptedData['CipherText'];

        $unwrappedKey = self::UnwrapKey($wrappedKey, $pemFile);
        
        $contentBytes = self::Base64ToBytes($data);
        $encryptedData = self::parseEncryptedData($contentBytes);
    
        $iv = $encryptedData['Iv'];
        $cipherText = $encryptedData['CipherText'];
        //$decipheredBytes = openssl_decrypt($cipherText, 'aes-256-cbc', $pemFile, OPENSSL_RAW_DATA, $iv);

        //dump($cipherText);
        $decipheredBytes = self::DecipherAes($unwrappedKey, $iv, $cipherText);

        
         openssl_private_decrypt
             ($decodedWrappedKey,
             $unwrappedKey,
             (string) $pemFile
         );

        
        
        $decipheredBytes = openssl_decrypt($data, 'aes-256-cbc', (string) $pemFile, OPENSSL_RAW_DATA, $iv);
        //dump($decipheredBytes);
        if ($decipheredBytes !== false) {
            return $decipheredBytes;
        }
        throw new EncryptedDataException('Could not decrypt data');
    }


    public static function DecipherContent($wrappedReceiptKey, $content,PemFile $keyPair) {
        $unwrappedKey = self::UnwrapKey($wrappedReceiptKey, $keyPair);
        
        $contentBytes = self::Base64ToBytes($content);
        $encryptedData = self::parseEncryptedData($contentBytes);
    
        $iv = $encryptedData['Iv'];
        $cipherText = $encryptedData['CipherText'];
    
        $decipheredBytes = self::DecipherAes($unwrappedKey, $iv, $cipherText);
        return $decipheredBytes;
    }
    
    public static function Base64ToBytes($base64) {
        return base64_decode($base64);
    }
    
    public static function DecryptRsa($cipherBytes, Pemfile $keypair) {
        // Decrypt using RSA with private key and PKCS 1 v1.5 padding
        $decrypted = '';
        openssl_private_decrypt($cipherBytes, $decrypted, $keypair);
        return $decrypted;
    }
    
    public static function DecipherAes($key, $iv, $cipherBytes) {
        // Decrypt using AES with private key and PKCS5/PKCS7
        $decipheredBytes = openssl_decrypt($cipherBytes, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return $decipheredBytes;
    }
    
    // Helper function to parse EncryptedData
    public static function parseEncryptedData($contentBytes) {
        $data = unpack('C*', $contentBytes);
        $ivLength = $data[1];
        $iv = array_slice($data, 2, $ivLength);
        $cipherText = array_slice($data, $ivLength + 2);
    
        return ['Iv' => $iv, 'CipherText' => $cipherText];
    }
    
    public static function UnwrapKey($wrappedKey, Pemfile $keyPair) {
        $cipherBytes = self::Base64ToBytes($wrappedKey);
        return self::DecryptRsa($cipherBytes, $keyPair);
    }
    
    public static function DecryptAttributeList($wrappedReceiptKey, $profileContent, PemFile $keyPair) {
        $decipheredBytes = self::DecipherContent($wrappedReceiptKey, $profileContent, $keyPair);
        
        return self::parseAttributeList($decipheredBytes);
    }
    
    // Helper function to parse AttributeList
    public static function parseAttributeList($decipheredBytes) {
        
        $attributeList = new AttributeList();
        $attributeList->mergeFromString($decipheredBytes);
        
        return $attributeList;
    }

    
}
