<?php

/**
 * @file
 * Contains Drupal\akv_pagepeels\Form\DefaultForm.
 */

namespace Drupal\akv_pagepeels\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DefaultForm.
 *
 * @package Drupal\akv_pagepeels\Form
 */
class DefaultForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'akv_pagepeels.default_config'
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'akv_pagepeels_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('akv_pagepeels.default_config');
    $form['akv_pagepeels_type'] = array(
      '#type' => 'radios',
      '#required' => true,
      '#title' => $this->t('Pagepeel type'),
      '#description' => $this->t('Choose the type of collapsed pagepeel'),
      '#options' => array(
        'latest' => $this->t('Latest pagepeel from AKV'),
        // http://wiki.vorratsdatenspeicherung.de/images/archive/20101110133306%21Akvse.gif
        'de_maiziere' => $this->t('Thomas de Maizière'),
        'schaeuble' => $this->t('Stasi 2.0 classic (Schäublone)'),
        'schaeuble_green' => $this->t('Stasi 2.0 green (Schäublone)'),
        'cam' => $this->t('Surveilance camera(2D)'),
        '3d_cam' => $this->t('Surveilance camera(3D)'),
        'ani_cam' => $this->t('Surveilance camera(3D + animated)'),
        'trauer' => $this->t('Condolement, 1949 - 2007 t'),
      ),
      '#default_value' => $config->get('akv_pagepeels_type'),
    );
    $form['akv_pagepeels_info'] = array(
      '#type' => 'radios',
      '#required' => true,
      '#title' => $this->t('Show info'),
      '#description' => t('Show info icon under the pagepeel'),
      '#options' => array(
        'on' => $this->t('Show'),
        'off' => $this->t('Don´t show')
      ),
      '#default_value' => $config->get('akv_pagepeels_info'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    switch ($form_state->getValue('akv_pagepeels_type')) {
      case "latest":
        $akv_css = '/css/akv_pagepeels_latest.css';
        break;
      case "schaeuble":
        variable_set('akv_css', '/css/akv_pagepeels_schaeuble.css');
        break;
      case "schaeuble_green":
        variable_set('akv_css', '/css/akv_pagepeels_schaeuble_green.css');
        break;
      case "cam":
        variable_set('akv_css', '/css/akv_pagepeels_cam.css');
        break;
      case "3d_cam":
        variable_set('akv_css', '/css/akv_pagepeels_3d_cam.css');
        break;
      case "ani_cam":
        variable_set('akv_css', '/css/akv_pagepeels_ani_cam.css');
        break;
      case "trauer":
        variable_set('akv_css', '/css/akv_pagepeels_trauer.css');
    }

    $this->config('akv_pagepeels.default_config')
      ->set('akv_pagepeels_type', $form_state->getValue('akv_pagepeels_type'))
      ->set('akv_pagepeels_info', $form_state->getValue('akv_pagepeels_info   '))
      ->save();
  }
}
