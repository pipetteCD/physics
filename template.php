<?php
function physics_preprocess_page(&$variables) {
  $variables['navbar_classes_array'] = array('navbar');

  if (theme_get_setting('bootstrap_navbar_position') !== '') {
    $variables['navbar_classes_array'][] = 'navbar-' . theme_get_setting('bootstrap_navbar_position');
  }
  else {
    $variables['navbar_classes_array'][] = 'navbar-container';
  }
  if (theme_get_setting('bootstrap_navbar_inverse')) {
    $variables['navbar_classes_array'][] = 'navbar-inverse';
  }
  else {
    $variables['navbar_classes_array'][] = 'navbar-default';
  }
  if (theme_get_setting('sidenav_admin')) {
      drupal_add_css(path_to_theme() . '/css/side-toolbar.css', array('type' => 'file'));
      drupal_add_js(path_to_theme() . '/js/plugins/sidenav.js', array('type' => 'file'));
  }




}

function physics_preprocess_toolbar(&$variables) {
  if (theme_get_setting('sidenav_admin')) {
    $variables['classes_array'][] = "sidenav";

    // Get the entire main menu tree
    $management_menu_tree = menu_tree_all_data('management', NULL, 10);

    // Add the rendered output to the $main_menu_expanded variable
    $admin_second_level = menu_tree_output($management_menu_tree);
    $variables['management_menu_expanded'] = $admin_second_level[1]['#below'];
  }
}

function physics_css_alter(&$css) {
  if (theme_get_setting('sidenav_admin')) {
      unset($css[drupal_get_path('module','toolbar').'/toolbar.css']);
  }
}

/**
 * Changing checkbox markup.
 *
 * @see theme_checkbox().
 */
function physics_checkbox(&$variables) {
  $element = $variables ['element'];
  $element ['#attributes']['type'] = 'checkbox';
  element_set_attributes($element, array('id', 'name', '#return_value' => 'value'));
  // Unchecked checkbox has #value of integer 0.
  if (!empty($element ['#checked'])) {
    $element ['#attributes']['checked'] = 'checked';
  }
  _form_set_class($element, array('form-checkbox'));
  return '<label><input' . drupal_attributes($element ['#attributes']) . ' /></label>';
}
/**
 * Changing radio markup.
 *
 * @see theme_radio().
 */
function physics_radio($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'radio';
  element_set_attributes($element, array('id', 'name', '#return_value' => 'value'));
  if (isset($element['#return_value']) && $element['#value'] !== FALSE && $element['#value'] == $element['#return_value']) {
    $element['#attributes']['checked'] = 'checked';
  }
  _form_set_class($element, array('form-radio'));
  return '<label><input' . drupal_attributes($element['#attributes']) . ' /></label>';
}


function physics_menu_local_action($variables) {
  $link = $variables ['element']['#link'];
  $link_class = substr($link['href'], strrpos($link['href'], '/') + 1);

  $output = '<li>';
  if (isset($link ['href'])) {
    $output .= l($link ['title'], $link ['href'], array('attributes' => array('class' => 'btn-floating mdi-action-'. $link_class)), isset($link ['localized_options']) ? $link ['localized_options'] : array());
  }
  elseif (!empty($link ['localized_options']['html'])) {
    $output .= $link ['title'];

  }
  else {
    $output .= check_plain($link ['title']);
  }
  $output .= "</li>\n";

  return $output;
}

function physics_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if ( !($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar')) ) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] >= 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      $element['#title'] .= ' <span data-toggle="dropdown" class="caret"></span>';
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle disabled';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
