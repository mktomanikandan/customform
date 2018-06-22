<?php

/**

 * @file

 * Contains \Drupal\appconfig\Form\appconfigForm.

 */

namespace Drupal\userregistration\Form;

use Drupal\Core\Controller\ControllerBase;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Drupal\Core\Url;

use Drupal\Core\Database\Database;

use Drupal\Core\Form\ConfigFormBase;

use Drupal\Core\Form\FormStateInterface;

class usereditForm extends ConfigFormBase {

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
    $request = \Drupal::request();
    $current_path = $request->getPathInfo();
    $path_args = explode('/', $current_path);
    if(count($path_args) < 5 && !empty($path_args[3])) {
      $connection = \Drupal::database();
      $result = $connection->query("SELECT id, username, email, mobnumber, gender, age FROM {userregistration} WHERE id = :id", [
        ':id' => $path_args[3],
      ]);

      $user_data = $result->fetchAssoc();
    }

    $form['user_name'] = array(
      '#type' => 'textfield',
      '#title' => t('User Name:'),
      '#required' => TRUE,
      '#default_value' => $user_data['username'],
    );

    $form['user_mail'] = array(
      '#type' => 'email',
      '#title' => t('Email ID:'),
      '#required' => TRUE,
      '#default_value' => $user_data['email'],
      '#attributes' => array('readonly' => 'readonly'),
    );

    $form['user_mob_number'] = array (
      '#type' => 'textfield',
      '#title' => t('Mobile no'),
      '#required' => TRUE,
      '#default_value' => $user_data['mobnumber'],
    );

    $form['age'] = array (
      '#type' => 'textfield',
      '#title' => t('Age'),
      '#required' => TRUE,
      '#default_value' => $user_data['age'],
    );

    $form['user_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'male' => t('Male'),
        'female' => t('Female'),
      ),
      '#default_value' => $user_data['gender'],
    );

    $form['id'] = array (
      '#type' => 'hidden',
      '#value' => $user_data['id'],
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
    if (isset($updated_values)) {
      $connection = \Drupal::database();
      $num_updated = $connection->update('userregistration')
        ->fields($updated_values)
        ->condition('id', $fields['id'], '=')
        ->execute();
      drupal_set_message("User details updated succesfully.");
      $response = new RedirectResponse("/user-details");
      $response->send();
    }
  }

  /**
   * {@inheritdoc}
   */

  protected function getEditableConfigNames() {

  }
}