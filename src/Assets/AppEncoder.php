<?php
namespace App\Assets;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Serializer\CircularReferenceHandler;

class AppEncoder {
    public function encoder ($data) {
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];
        $encoders = [new JsonEncoder()];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $normalizers = [$normalizer];



        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($data, 'json');

        return $jsonContent;
    }
}
