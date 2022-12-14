<?php

namespace Drupal\cheppers_test;

use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 *
 */
class TestService {
  protected $entityTypeManager;

  /**
   * CustomService constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Lists the title of the N newest test content.
   *
   * @return array
   *   Render array containing the titles.
   */
  public function titleList(int $limit_titles = 10) {
    // Getting nids.
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $nids = $query->condition('status', 1)
      ->condition('type', 'test')
      ->range(0, $limit_titles)
      ->sort('created', 'DESC')
      ->execute();

    // Loading nodes entyties by nid.
    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
    $titles = [];

    // Getting the titles.
    foreach ($nodes as $node) {
      $titles[] = $node->getTitle();
    }

    $content = [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#title' => 'The newest test content',
      '#items' => $titles,
      '#attributes' => ['class' => 'mylist'],
      '#wrapper_attributes' => ['class' => 'container'],
    ];

    return $content;
  }

}
