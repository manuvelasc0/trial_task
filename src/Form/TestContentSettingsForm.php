<?php

namespace Drupal\cheppers_test\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure cheppers_test settings for the test content page.
 */
class TestContentSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'cheppers_test.settings';

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'cheppers_test_content_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['contents_number'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Choose a number'),
      '#options' => [
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
      ],
      '#default_value' => $config->get('number_content'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->config(static::SETTINGS)
      // Set the submitted configuration setting.
      ->set('number_content', $form_state->getValue('contents_number'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
