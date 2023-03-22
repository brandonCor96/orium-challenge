<?php

namespace Drupal\movies_module\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the movies entity edit forms.
 */
class MoviesForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%title' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%title' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New movies %title has been created.', $message_arguments));
        $this->logger('movies_module')->notice('Created new movies %title', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The movies %title has been updated.', $message_arguments));
        $this->logger('movies_module')->notice('Updated movies %title.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.movies.canonical', ['movies' => $entity->id()]);

    return $result;
  }

}
