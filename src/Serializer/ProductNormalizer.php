<?php 

// Normalizer qui sert à définir le nom du path vers les images uploadées
// Voir védiéo Grafikart 
// https://youtu.be/fhdD7K5nZSA?t=817


namespace App\Serializer;

use App\Entity\Product;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Vich\UploaderBundle\Storage\StorageInterface;

class ProductNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{

    use NormalizerAwareTrait;

    private const ALREADY_CALLED = false;
    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = [])
    {
        return !isset($context[self::ALREADY_CALLED]) && $data instanceof Product;
    }

    /**
     *
     * @param Product $object
     */
    public function normalize($object, ?string $format = null, array $context = [])
    {
        if($object->getJpgPicture()) {
            $object->setJpgPicturePath($this->storage->resolveUri($object, 'jpgPicture'));
            $object->setWebpName('coucou');
            dump($this->storage->resolveUri($object, 'jpgPicture'));
            dump('Set le link');
        }
        if($object->getWebpPicture()){
            $object->setWebpPicturePath($this->storage->resolveUri($object, 'webpPicture'));
        }
        
        $context[self::ALREADY_CALLED] = true;

        return $this->normalizer->normalize($object, $format, $context);

    }
}