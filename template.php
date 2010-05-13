<?php
// $Id$

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 */

lullacog_init();

/**
 * Theme is first initialized. Add some conditional stylesheets.
 */
function lullacog_init() {
  global $theme;
  global $theme_info;
  global $theme_path;

  if (($skin = theme_get_setting('skin')) && $skin != 'default') {
    $file = $theme_path ."/skins/$skin.css";
    drupal_add_css($file, 'theme');
  }

  if (drupal_is_front_page()) {
    $file = $theme_path ."/styles/front.css";
    drupal_add_css($file, 'theme');
  }

  // Add follow module css, since we don't use the block.
  if (function_exists('follow_links_load')) {
    drupal_add_css(drupal_get_path('module', 'follow') .'/follow.css');
  }

  // Add some admin css files.
  if (user_access('access administration pages')) {
    drupal_add_css(drupal_get_path('theme', 'lullacog') .'/styles/cog_admin.css', 'theme');
  }
}

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */
function lullacog_preprocess_page(&$vars, $hook) {
  global $theme;
  global $user;

  _lullacog_add_body_classes($vars);

  // Add the primary links sub menu
  if (function_exists('context_get_plugin')) {
    $plugin = context_get_plugin('reaction', 'menu');
    $vars['primary_links_sub'] = $plugin->menu_navigation_links(variable_get('menu_primary_links_source', 'primary-links'), 1);
    $vars['secondary_links_sub'] = $plugin->menu_navigation_links(variable_get('menu_secondary_links_source', 'secondary-links'), 1);  
  }
  else {
    $vars['primary_links_sub'] = menu_navigation_links(variable_get('menu_primary_links_source', 'primary-links'), 1);
    $vars['secondary_links_sub'] = menu_navigation_links(variable_get('menu_secondary_links_source', 'secondary-links'), 1);  
  }
  
  // Add some footer links to the footer.
  $vars['footer_links'] = menu_navigation_links('menu-footer-links');

  // Re-add the site-name. For SEO purposes, we always want the site name in a 
  // hidden h1. We can then toggle a visible site name using the $toggle_name var.
  $vars['toggle_name'] = theme_get_setting('toggle_name');
  $vars['site_name'] = variable_get('site_name', 'Drupal');

  // If imagecache is enabled and we're using a custom logo, use our imagecache preset.
  if ($vars['logo'] && function_exists('imagecache_create_url') && !theme_get_setting('default_logo')) {
    $vars['logo'] = (strpos($vars['logo'], '/') == 0) ? substr($vars['logo'], 1) : $vars['logo'];
    $vars['logo'] = imagecache_create_url('header_logo', $vars['logo']);
  }

  // Load up the site follow links into a var so we can hard code them in the theme.
  if (function_exists('follow_links_load') && $links = follow_links_load()) {
    $vars['follow_site'] = theme('follow_links', $links, follow_networks_load());
  }
}

/**
 * Adds some conditional body classes.
 */
function _lullacog_add_body_classes(&$vars) {
  // Add node body class if we're on a page node.
  if ($vars['node']) {
    $vars['body_classes'] .= ' node-page';
  }

  // Add content-top body class.
  if ($vars['content_top']) {
    $vars['body_classes'] .= ' content-top';
  }
  
  // Add top body class.
  if ($vars['top']) {
    $vars['body_classes'] .= ' top';
  }
  else {
    $vars['body_classes'] .= ' no-top';
  }
  
  // Add sidebar right body class.
  if ($vars['right']) {
    $vars['body_classes'] .= ' sidebar-right';
  }
  
  // Add sidebar left body class.
  if ($vars['left']) {
    $vars['body_classes'] .= ' sidebar-left';
  }
  
  // Add sidebar right body class.
  if ($vars['bottom']) {
    $vars['body_classes'] .= ' bottom';
  }

  // Check if region_manager is hidden 
  if (!variable_get('webgear_region_manager_show', TRUE)) {
    $vars['body_classes'] .= ' region-manager-hide';
  }
}

/**
 * Override or insert variables into the node templates.
 */
function lullacog_preprocess_node(&$vars) {
  if ($vars['node']->type == 'media' && module_exists('swftools') && count($vars['field_media'])) {
    foreach ($vars['field_media'] as $file) {
      $vars['content'] .= swf($file['filepath']);
    }
  }
}

/**
 * Override or insert variables into views-view-unformatted.tpl.php.
 *
 * Add the 'clear-block' class to each row.
 */
function lullacog_preprocess_views_view_unformatted(&$vars) {
  foreach ($vars['rows'] as $id => $row) {
    $vars['classes'][$id] .= ' clear-block';
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function lullacog_breadcrumb($breadcrumb) {
  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('zen_breadcrumb');
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('zen_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $image_path = theme_get_setting('zen_breadcrumb_img');
      $use_image = (!empty($image_path) && is_file($image_path));
      $breadcrumb_separator = $use_image ? theme('image', $image_path) : theme_get_setting('zen_breadcrumb_separator');
      $trailing_separator = $title = '';
      if (theme_get_setting('zen_breadcrumb_title')) {
        $trailing_separator = $breadcrumb_separator;
        $title = '<span class="breadcrumb-title">'. menu_get_active_title() .'</span>';
      }
      elseif (theme_get_setting('zen_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }
      return '<div class="breadcrumb">' . implode($breadcrumb_separator, $breadcrumb) . "$trailing_separator$title</div>";
    }
  }
  // Otherwise, return an empty string.
  return '';
}

/**
 * Theme node administration overview. Moves the options to the bottom of the 
 * node admin form.
 *
 * @ingroup themeable
 */
function lullacog_node_admin_nodes($form) {
  // If there are rows in this form, then $form['title'] contains a list of
  // the title form elements.
  $has_posts = isset($form['title']) && is_array($form['title']);
  $select_header = $has_posts ? theme('table_select_header_cell') : '';
  $header = array($select_header, t('Title'), t('Type'), t('Author'), t('Status'));
  if (isset($form['language'])) {
    $header[] = t('Language');
  }
  $header[] = t('Operations');
  $output = '';

  if ($has_posts) {
    foreach (element_children($form['title']) as $key) {
      $row = array();
      $row[] = drupal_render($form['nodes'][$key]);
      $row[] = drupal_render($form['title'][$key]);
      $row[] = drupal_render($form['name'][$key]);
      $row[] = drupal_render($form['username'][$key]);
      $row[] = drupal_render($form['status'][$key]);
      if (isset($form['language'])) {
        $row[] = drupal_render($form['language'][$key]);
      }
      $row[] = drupal_render($form['operations'][$key]);
      $rows[] = $row;
    }

  }
  else {
    $rows[] = array(array('data' => t('No posts available.'), 'colspan' => '6'));
  }

  $output .= theme('table', $header, $rows);
  if ($form['pager']['#value']) {
    $output .= drupal_render($form['pager']);
  }
  $output .= drupal_render($form['options']);

  $output .= drupal_render($form);

  return $output;
}

/**
 * Format the "Submitted by username on date/time" for each node
 *
 * @ingroup themeable
 */
function lullacog_node_submitted($node, $date = NULL) {
  $teaser = isset($node->teaser) && $node->teaser;

  $output = '';
  if ($teaser) {
    $date = is_null($date) ? format_date($node->created, 'small') : $date;
    $output .= '<span class="username">'. t('By !username', array('!username' => theme('username', $node))) .'</span>';
  }
  else {
    $date = is_null($date) ? format_date($node->created, 'medium') : $date;
    $output .= '<span class="username">'. t('@type by !username', array('@type' => node_get_types('name', $node), '!username' => theme('username', $node))) .'</span>';
  }

  $output .= '<span class="submitted">'. $date .'</span>';

  if ($teaser) {
    $path = NULL;

    switch ($node->type) {
      case 'lblog':
      case 'news':
        $path = 'ideas/blog';
        break;
      case 'audio':
        $path = 'ideas/podcasts';
        break;
      case 'video':
        $path = 'ideas/videocasts';
        break;
    }

    $type = node_get_types('name', $node);
    $output .= '<span class="type">'. ($path ? l($type, $path) : $type) .'</span>';
    if ($node->comment_count) {
      $output .= '<span class="comments"><a href="'. url('node/'. $node->nid, array('fragment' => 'comments')) .'">'. format_plural($node->comment_count, '@count comment', '@count comments') . '</a></span>';
    }
  }
  return $output;
}

/**
 * Format a username.
 *
 * @param $object
 *   The user object to format, usually returned from user_load().
 * @return
 *   A string containing an HTML link to the user's page if the passed object
 *   suggests that this is a site user. Otherwise, only the username is returned.
 */
function lullacog_username($object) {

  if ($object->uid && $object->name) {
    // Shorten the name when it is too long or it will break many tables.
    if (function_exists('content_profile_load') && ($profile = content_profile_load('profile', $object->uid))) {
      if ($profile->title) {
        $object->name = $profile->title;
      }
    }
    if (drupal_strlen($object->name) > 20) {
      $name = drupal_substr($object->name, 0, 15) .'...';
    }
    else {
      $name = $object->name;
    }

    if (user_access('access user profiles')) {
      $path = $profile ? 'node/'. $profile->nid : 'user/'. $object->uid;
      $output = l($name, $path, array('attributes' => array('title' => t('View user profile.'))));
    }
    else {
      $output = check_plain($name);
    }
  }
  else if ($object->name) {
    // Sometimes modules display content composed by people who are
    // not registered members of the site (e.g. mailing list or news
    // aggregator modules). This clause enables modules to display
    // the true author of the content.
    if (!empty($object->homepage)) {
      $output = l($object->name, $object->homepage, array('attributes' => array('rel' => 'nofollow')));
    }
    else {
      $output = check_plain($object->name);
    }

    $output .= ' ('. t('not verified') .')';
  }
  else {
    $output = check_plain(variable_get('anonymous', t('Anonymous')));
  }

  return $output;
}

/**
 * Helper function that builds the nested lists of a nice menu.
 *
 * @param $menu
 *   Menu array from which to build the nested lists.
 */
function lullacog_nice_menu_build($menu) {
  // Retrieve original path so we can repair it after our hack.
  $original_path = $_GET['q'];

  if (function_exists('context_active_values')) {
    // Retrieve the first active menu path found.
    $active_paths = context_active_values('menu');
    if (!empty($active_paths)) {
      $path = current($active_paths);
      if (menu_get_item($path)) {
        menu_set_active_item($path);
      }
    }
  }

  $output = theme_nice_menu_build($menu);

  menu_set_active_item($original_path);

  return $output;
}
