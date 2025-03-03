<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SerializerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Serializer::class, function ($app) {
            $encoders = [new JsonEncoder(), new XmlEncoder()];
            $normalizers = [new ObjectNormalizer()];

            return new Serializer($normalizers, $encoders);
        });
    }
}
