<?php

namespace Drupal\cheppers_test\Controller;

use Drupal\cheppers_test\TestService;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides route responses for the Cheppers Test module.
 */
class TestController extends ControllerBase {

  /**
   * @var \Drupal\cheppers_test\TestService
   */
  protected $testService;

  /**
   * Constructs a TestController object.
   *
   * @param \\Drupal\cheppers_test\TestService $testService
   *   The cheppers test service.
   */
  public function __construct(TestService $testService) {
    $this->testService = $testService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
    $container->get('cheppers_test.test_services')
    );
  }

  /**
   * Returns a list of newest test content.
   *
   * @return array
   *   A simple renderable array.
   */
  public function testContents() {
    $config = $this->config('cheppers_test.settings');
    $number_contents = intval($config->get('number_content'));
    $titles_list = $this->testService->titleList($number_contents);

    // Adds Cache dependency with the config form.
    $renderer = \Drupal::service('renderer');
    $config = $this->config('cheppers_test.settings');
    $renderer->addCacheableDependency($titles_list, $config);
    return [$titles_list];
  }

}
