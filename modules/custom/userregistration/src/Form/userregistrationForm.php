<?php

/**

 * @file

 * Contains \Drupal\appconfig\Form\appconfigForm.

 */

namespace Drupal\userregistration\Form;

use Drupal\Core\Database\Database;

use Drupal\Core\Form\ConfigFormBase;

use Drupal\Core\Form\FormStateInterface;

class userregistrationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */

  public function getFormId() {

    return 'user_registration_form';

  }

  /**
   * {@inheritdoc}
   */

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['user_name'] = array(
      '#type' => 'textfield',
      '#title' => t('User Name:'),
      '#required' => TRUE,
    );

    $form['user_mail'] = array(
      '#type' => 'email',
      '#title' => t('Email ID:'),
      '#required' => TRUE,
    );

    $form['user_mob_number'] = array (
      '#type' => 'textfield',
      '#title' => t('Mobile no'),
      '#required' => TRUE,
    );

    $form['age'] = array (
      '#type' => 'textfield',
      '#title' => t('Age'),
      '#required' => TRUE,
    );

    $form['user_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'male' => t('Male'),
        'female' => t('Female'),
      ),
    );

    $form['submit'] = array (
      '#type' => 'submit',
      '#title' => t('Save'),
      '#value' => t('save'),
      '#button_type' => 'primary',
    );

    return $form;

  }

  /**
   * {@inheritdoc}
   */

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $fields = $form_state->getValues();
    $updated_values = array(
      'username' => $fields['user_name'],
      'mobnumber' => $fields['user_mob_number'],
      'email' => $fields['user_mail'],
      'age' => $fields['age'],
      'gender' => $fields['user_gender'],
    );
    if (isset($name)) {
      $query = \Drupal::database();
      $query ->insert('userregistration')
        ->fields($updated_values)
        ->execute();
      drupal_set_message("User details succesfully saved.");
    }
  }

  /**
   * {@inheritdoc}
   */

  protected function getEditableConfigNames() {

  }

}