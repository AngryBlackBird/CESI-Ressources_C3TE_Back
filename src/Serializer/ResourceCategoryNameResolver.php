<?php

namespace App\Serializer;

use App\Entity\Resource;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ResourceCategoryNameResolver implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {

        return $data instanceof Resource;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        /** @var Resource $object */
        $categoryName = $object->getCategory()->getName();
        $author = $object->getAuthor()->getFirstName()." ". $object->getAuthor()->getLastName();
        return [
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'content' => $object->getContent(),
            'publish_date' => $object->getPublishDate(),
            // Other fields you want to include...
            'author' => $author,
            // Replace the category URL with its name
            'category' => $categoryName,
        ];
    }
}