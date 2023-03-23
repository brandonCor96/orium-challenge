<?php

namespace Drupal\movies_module;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\taxonomy\TermInterface;

/**
 * Provides a list controller for the movies entity type.
 */
class MoviesListBuilder extends EntityListBuilder
{
    /**
     * The date formatter service.
     *
     * @var \Drupal\Core\Datetime\DateFormatterInterface
     */
    protected $dateFormatter;

    /**
     * Constructs a new MoviesListBuilder object.
     *
     * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
     *   The entity type definition.
     * @param \Drupal\Core\Entity\EntityStorageInterface $storage
     *   The entity storage class.
     * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
     *   The date formatter service.
     */
    public function __construct(
        EntityTypeInterface $entity_type,
        EntityStorageInterface $storage,
        DateFormatterInterface $date_formatter
    ) {
        parent::__construct($entity_type, $storage);
        $this->dateFormatter = $date_formatter;
    }

    /**
     * {@inheritdoc}
     */
    public static function createInstance(
        ContainerInterface $container,
        EntityTypeInterface $entity_type
    ) {
        return new static(
            $entity_type,
            $container
                ->get("entity_type.manager")
                ->getStorage($entity_type->id()),
            $container->get("date.formatter")
        );
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $build["table"] = parent::render();

        $total = $this->getStorage()
            ->getQuery()
            ->accessCheck(false)
            ->count()
            ->execute();

        $build["summary"]["#markup"] = $this->t("Total moviess: @total", [
            "@total" => $total,
        ]);
        return $build;
    }

    /**
     * {@inheritdoc}
     */
    public function buildHeader()
    {
        $header["id"] = $this->t("ID");
        $header["title"] = $this->t("Title");
        $header["genre"] = $this->t("Genre");
        $header["status"] = $this->t("Status");
        $header["uid"] = $this->t("Author");
        $header["release_date"] = $this->t("Release date");
        $header["changed"] = $this->t("Updated");
        return $header + parent::buildHeader();
    }

    /**
     * {@inheritdoc}
     */
    public function buildRow(EntityInterface $entity)
    {
        /** @var \Drupal\movies_module\MoviesInterface $entity */
        $row["id"] = $entity->id();
        $row["title"] = $entity->get("title")->value;

        // Get the value of the Genre field.
        $genre = $entity->get("genre")->getValue();
        $genre_names = [];

        // Iterate through the referenced terms and get their names.
        foreach ($genre as $term) {
            $term_entity = \Drupal::entityTypeManager()
                ->getStorage("taxonomy_term")
                ->load($term["target_id"]);
            if ($term_entity instanceof TermInterface) {
                $genre_names[] = $term_entity->getName();
            }
        }
        // Concatenate the names of the terms into a string and add it to the row array.
        $row["genre"] = implode(",", $genre_names);
        $row["status"] = $entity->get("status")->value
            ? $this->t("Enabled")
            : $this->t("Disabled");
        $row["uid"]["data"] = [
            "#theme" => "username",
            "#account" => $entity->getOwner(),
        ];
        $row["release_date"] = $this->dateFormatter->format(
            $entity->get("release_date")->value
        );
        $row["changed"] = $this->dateFormatter->format(
            $entity->getChangedTime()
        );

        return $row + parent::buildRow($entity);
    }
}
