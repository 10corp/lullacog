<?php
// $Id: theme-settings.php,v 1.7 2008/09/11 09:36:50 johnalbin Exp $

// Include the definition of zen_settings() and zen_theme_get_default_settings().
include_once './' . drupal_get_path('theme', 'zen') . '/theme-settings.php';


/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @return
 *   A form array.
 */
function lullacog_settings($saved_settings) {

  // Get the default values from the .info file.
  $defaults = zen_theme_get_default_settings('lullacog');

  // Merge the saved variables and their default values.
  $settings = array_merge($defaults, $saved_settings);

  // Add the base theme's settings.
  $form = zen_settings($saved_settings, $defaults);

  $form['breadcrumb']['zen_breadcrumb_img'] = array(
    '#type'          => 'textfield',
    '#length'        => 60,
    '#title'         => t('Breadcrumb image'),
    '#default_value' => $settings['zen_breadcrumb_img'],
    '#description'   => t("The path to the image file you would like to use as your breadcrumb separator.  If you specify a file here, whatever text is specified in 'Breadcrumb Separator' above will be ignored."),
  );

  if ($theme_info->info['skins']) {
    $skins = array('default' => t('Default'));
    $skins = $skins + $theme_info->info['skins'];

    $form['skin'] = array(
      '#type'          => 'radios',
      '#title'         => t('Select a skin'),
      '#default_value' => $settings['skin'] ? $settings['skin'] : 'default',
      '#options'       => $skins,
    );
  }

  // Remove some of the base theme's settings.
  unset($form['themedev']['zen_layout']); // We don't need to select the base stylesheet.

  // Return the form
  return $form;
}
