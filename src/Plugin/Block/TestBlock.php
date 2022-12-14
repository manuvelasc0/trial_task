<?php

namespace Drupal\cheppers_test\Plugin\Block;

use Drupal\cheppers_test\TestService;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a list of titles Block from the newest Test content type.
 *
 * @Block(
 *   id = "test_block",
 *   admin_label = @Translation("Test block"),
 * )
 */
class TestBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $testService;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\cheppers_test\TestService $testService
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TestService $testService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->testService = $testService;
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('cheppers_test.test_services')
    );
  }

  /**
   *
   * @return array
   *   A simple renderable array.
   */
  public function build() {
    $titles_list = $this->testService->titleList();
    return [$titles_list];
  }

}
