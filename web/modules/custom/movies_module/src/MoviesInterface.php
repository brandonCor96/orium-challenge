<?php

namespace Drupal\movies_module;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a movies entity type.
 */
interface MoviesInterface extends
    ContentEntityInterface,
    EntityOwnerInterface,
    EntityChangedInterface
{
}
