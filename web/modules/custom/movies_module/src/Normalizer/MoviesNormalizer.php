<?php

namespace Drupal\movies_module\Normalizer;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\TypedData\TypedDataManagerInterface;
use Drupal\serialization\Normalizer\EntityNormalizer;
use Drupal\movies_module\Entity\Movies;

/**
 * Custom normalization class for the movies entity.
 */
class MoviesNormalizer extends EntityNormalizer
{
    /**
     * The entity type manager service.
     *
     * @var \Drupal\Core\Entity\EntityTypeManagerInterface
     */
    protected $entityTypeManager;

    /**
     * Constructs a MoviesNormalizer object.
     *
     * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
     *   The entity type manager service.
     */
    public function __construct(EntityTypeManagerInterface $entity_type_manager)
    {
        $this->entityTypeManager = $entity_type_manager;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($entity, $format = null, array $context = [])
    {
        // Call the parent normalize() method to get the default normalization output.
        $attributes = parent::normalize($entity, $format, $context);

        // Customize the output of your Movies entity.
        $attributes["id"] = $entity->id();
        $attributes['title'] = $entity->get('title')->value;
        
        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        // Only support normalization for Movies entities.
        return $data instanceof Movies;
    }
}
