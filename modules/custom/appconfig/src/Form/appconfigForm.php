<?php

/**

 * @file

 * Contains \Drupal\appconfig\Form\appconfigForm.

 */

namespace Drupal\appconfig\Form;

use Drupal\Core\Form\ConfigFormBase;

use Drupal\Core\Form\FormStateInterface;

class appconfigForm extends ConfigFormBase {

  /**

   * {@inheritdoc}

   */

  public function getFormId() {

    return 'app_config_form';

  }

  /**

   * {@inheritdoc}

   */

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

    $config = $this->config('appconfig.settings');

    $form['appconfig'] = array(

      '#type' => 'textfield',

      '#title' => $this->t('App Secret Key'),

      '#default_value' => $config->get('appkey'),

      '#required' => TRUE,

    );

    return $form;

  }

  /**

   * {@inheritdoc}

   */

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->config('appconfig.settings');

    $config->set('appkey', $form_state->getValue('appconfig'));

    $config->save();

    return parent::submitForm($form, $form_state);

  }

  /**

   * {@inheritdoc}

   */

  protected function getEditableConfigNames() {

    return [

      'appconfig.settings',

    ];

  }

}