<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: DataEntry.proto

namespace Yoti\Protobuf\Sharepubapi\GPBMetadata;

class DataEntry
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
DataEntry.protosharepubapi_v1"�
	DataEntry,
type (2.sharepubapi_v1.DataEntry.Type
value ("�
Type
	UNDEFINED 
INVOICE
PAYMENT_TRANSACTION
LOCATION
TRANSACTION
AGE_VERIFICATION_SECRET
THIRD_PARTY_ATTRIBUTEB�
$com.yoti.api.client.spi.remote.protoBDataEntryProtoZ0github.com/getyoti/yoti-go-sdk/v3/yotiprotoshare�Yoti.Auth.ProtoBuf.Share�Yoti\\Protobuf\\Sharepubapi�%Yoti\\Protobuf\\Sharepubapi\\GPBMetadata�Yoti::Protobuf::Sharepubapibproto3'
        , true);

        static::$is_initialized = true;
    }
}

