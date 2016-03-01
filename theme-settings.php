<?php function physics_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {

    $form['msms'] = array(
       '#type' => 'fieldset',
       '#title' => t('Physics Settings'),
       '#group' => 'bootstrap',
       '#collapsible' => TRUE,
       '#collapsed' => TRUE,
       '#description' => t('Toggle various Material design settings on and off'),
     );

    $form['msms']['sidenav_admin'] = array(
      '#type' => 'checkbox',
      '#title' => t('Enable the side nav Administration menu'),
      '#default_value' => theme_get_setting('sidenav_admin'),
      '#description' => t('This requires a minimum jQuery version of 1.7 or higher and the Overlay module disabled'),
    );

}
