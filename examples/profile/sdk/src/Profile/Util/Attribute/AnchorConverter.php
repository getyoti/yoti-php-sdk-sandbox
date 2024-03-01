<?php

declare(strict_types=1);

namespace Yoti\Profile\Util\Attribute;

use phpseclib3\File\ASN1;
use phpseclib3\File\X509;
use Yoti\Profile\Attribute\Anchor;
use Yoti\Profile\Attribute\SignedTimeStamp;
use Yoti\Protobuf\Attrpubapi\Anchor as ProtobufAnchor;
use Yoti\Util\DateTime;
use Yoti\Util\Json;

class AnchorConverter
{
    /**
     * Convert Protobuf Anchor to Yoti Anchor
     *
     * @param \Yoti\Protobuf\Attrpubapi\Anchor $protobufAnchor
     *
     * @return \Yoti\Profile\Attribute\Anchor
     */
    public static function convert(ProtobufAnchor $protobufAnchor): Anchor
    {

        $anchorSubType = $protobufAnchor->getSubType();

        $yotiSignedTimeStamp = self::convertToYotiSignedTimestamp($protobufAnchor);

        $X509CertsList = self::convertCertsListToX509($protobufAnchor->getOriginServerCerts());
        dump("anchorSubType:");

        dump("$anchorSubType:");
        dump($anchorSubType );

        foreach ($X509CertsList as $certX509Obj) {
            foreach ($certX509Obj->tbsCertificate->extensions as $extObj) {
                $anchorType = self::getAnchorTypeByOid($extObj->extnId);
                if ($anchorType !== Anchor::TYPE_UNKNOWN_NAME) {
                    return new Anchor(
                        self::decodeAnchorValue($extObj->extnValue),
                        $anchorType,
                        $anchorSubType,
                        $yotiSignedTimeStamp,
                        $X509CertsList
                    );
                }
            }
        }

        return new Anchor(
            '',
            Anchor::TYPE_UNKNOWN_NAME,
            $anchorSubType,
            $yotiSignedTimeStamp,
            $X509CertsList
        );
    }

    /**
     * @param string $extEncodedValue
     *
     * @return string
     */
    private static function decodeAnchorValue(string $extEncodedValue): string
    {
        $encodedBER = ASN1::extractBER($extEncodedValue);
        $decodedValArr = ASN1::decodeBER($encodedBER);
        if (isset($decodedValArr[0]['content'][0]['content'])) {
            return $decodedValArr[0]['content'][0]['content'];
        }
        return '';
    }

    /**
     * @param \Yoti\Protobuf\Attrpubapi\Anchor $anchor
     *
     * @return \Yoti\Profile\Attribute\SignedTimeStamp
     */
    private static function convertToYotiSignedTimestamp(ProtobufAnchor $anchor): SignedTimeStamp
    {
        $signedTimeStamp = new \Yoti\Protobuf\Compubapi\SignedTimestamp();
        $signedTimeStamp->mergeFromString($anchor->getSignedTimeStamp());

        return new SignedTimeStamp(
            $signedTimeStamp->getVersion(),
            DateTime::timestampToDateTime((int) $signedTimeStamp->getTimestamp())
        );
    }

    /**
     * @param \Traversable<string> $certificateList
     *
     * @return \stdClass[]
     */
    private static function convertCertsListToX509(\Traversable $certificateList): array
    {

        $certsList = [];
        foreach ($certificateList as $certificate) {
            $certsList[] = self::convertCertToX509($certificate);
        }
        return $certsList;
    }

    /**
     * Return X509 Cert Object.
     *
     * @param string $certificate
     *
     * @return \stdClass
     */
     private static function convertCertToX509(string $certificate): \stdClass
     {
         $X509 = new X509();
         $X509Data = $X509->loadX509($certificate);
         dump("---X509Data--");
             
        dump($X509Data);

         $decodedX509Data = Json::decode(Json::encode(self::convert_from_latin1_to_utf8_recursively($X509Data)), false);

         // Ensure serial number is cast to string.
         // @see \phpseclib\Math\BigInteger::__toString()
         $decodedX509Data
             ->tbsCertificate
             ->serialNumber
             ->value = (string) $X509Data['tbsCertificate']['serialNumber'];

         return $decodedX509Data;
     }

    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) $ret[ $i ] = self::convertFromLatin1ToUtf8Recursively($d);

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) $dat->$i = self::convertFromLatin1ToUtf8Recursively($d);

            return $dat;
        } else {
            return $dat;
        }
    }

//    private static function convertCertToX509(string $certificate): \stdClass
//    {
//        $X509 = new X509();
//        $X509Data = $X509->loadX509($certificate);
//
//
//        // Check if $X509Data is an array
//        if (is_array($X509Data)) {
//            $X509Data = (object)$X509Data;
//        }
//
//        // Encode the data as JSON
//        $jsonEncodedData = json_encode($X509Data);
//        if ($jsonEncodedData === false) {
//            // Handle JSON encoding error
//            // Maybe log the error or throw an exception
//            throw new \RuntimeException('JSON encoding failed');
//        }
//
//        // Decode the JSON back to stdClass
//        $decodedX509Data = json_decode($jsonEncodedData);
//
//        // Ensure serial number is cast to string.
//        // @see \phpseclib\Math\BigInteger::__toString()
//        $decodedX509Data
//            ->tbsCertificate
//            ->serialNumber
//            ->value = (string) $X509Data->tbsCertificate->serialNumber;
//
//        return $decodedX509Data;
//    }
private static function handleBinaryData($data)
{
    if (is_object($data)) {
        foreach ($data as $key => $value) {
            $data->$key = self::handleBinaryData($value);
        }
    } elseif (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = self::handleBinaryData($value);
        }
    } elseif (is_string($data)) {
        // Check if the string contains binary data
        if (!mb_check_encoding($data, 'UTF-8')) {
            // Convert binary data to base64 encoding
            $data = base64_encode($data);
        }
    }
    return $data;
}
    private static function base64_decode_if_needed($str)
    {
        $decoded = base64_decode($str, true);
        if($str === base64_encode($decoded)) {
            return $decoded;
        }
        return $str;
    }
    /**
     * Get anchor type by OID.
     *
     * @param string $oid
     *
     * @return string
     */
    private static function getAnchorTypeByOid(string $oid): string
    {
        $anchorTypesMap = self::getAnchorTypesMap();
        return isset($anchorTypesMap[$oid]) ? $anchorTypesMap[$oid] : Anchor::TYPE_UNKNOWN_NAME;
    }

    /**
     * @return array<string, string>
     */
    private static function getAnchorTypesMap(): array
    {
        return [
            Anchor::TYPE_SOURCE_OID => Anchor::TYPE_SOURCE_NAME,
            Anchor::TYPE_VERIFIER_OID => Anchor::TYPE_VERIFIER_NAME,
        ];
    }
}
