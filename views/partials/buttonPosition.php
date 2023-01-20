<h4><?php _e('Button position', 'iubenda') ?></h4>
<div class="mb-2 d-flex align-items-center flex-wrap">
  <label class="radio-regular mr-3">
      <input type="radio" name="iubenda_privacy_policy_solution[button_position]" value="automatic" class="mr-2 section-radio-control" data-section-group=".pp_button_position" data-section-name="#pp_button_position_automatically" <?php checked( 'automatic', iub_array_get(iubenda()->options['pp'], 'button_position')) ?>>
      <span><?php _e('Add to the footer automatically', 'iubenda') ?></span>
  </label>
  <label class="mr-4 radio-regular text-xs">
      <input type="radio" name="iubenda_privacy_policy_solution[button_position]" value="manual" class="mr-2 section-radio-control" data-section-group=".pp_button_position" data-section-name="#pp_button_position_manually" <?php checked( 'manual', iub_array_get(iubenda()->options['pp'], 'button_position')) ?>>

      <span><?php _e('Integrate manually', 'iubenda') ?></span>
  </label>
</div>
<?php
global $wp_registered_sidebars;

// If sidebar-1 not registered or not activated
if (!boolval(iub_array_get($wp_registered_sidebars, 'sidebar-1'))) {
    ?>
    <section id="pp_button_position_automatically" class="pp_button_position <?php echo iub_array_get(iubenda()->options['pp'], 'button_position') == 'automatic' ?:'hidden' ; ?>">
        <div class="notice notice--warning mt-2 mb-4 p-3 d-flex align-items-center text-warning text-xs">
            <img class="mr-2" src="<?php echo IUBENDA_PLUGIN_URL ?>/assets/images/warning-icon.svg">
            <p><?php echo sprintf( __( 'We were not able to add a "Legal" widget to the footer as your theme is not compatible, you can position the "Legal" widget manually from <a href="%s" target="_blank">here</a>.', 'iubenda' ), esc_url( admin_url( 'widgets.php' ) ) ) ?></p>
        </div>
    </section>
    <?php
}
?>
<section id="pp_button_position_manually" class="pp_button_position <?php echo iub_array_get(iubenda()->options['pp'], 'button_position') == 'manual' ?:'hidden' ; ?>">
    <div class="mb-3 p-0">
        <div class="my-5">
            <h4><?php _e('HTML', 'iubenda') ?></h4>
            <fieldset class="paste_embed_code tabs tabs--style2">
                <ul class="tabs__nav">
                    <?php foreach(iubenda()->languages as $k => $v): ?>
                        <li class="tabs__nav__item <?php echo $k == iubenda()->lang_default?'active':false ; ?>" data-target="tab-<?php echo $k ; ?>"  data-group="language-tabs">
                            <?php echo strtoupper($k) ; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php
                $privacyPolicyGenerator = new PrivacyPolicyGenerator();
                $globalOptions = get_option('iubenda_global_options');

                $languages = (new ProductHelper())->get_languages();
                foreach($languages as $lang_id => $v):
                    $code = iub_array_get(iubenda()->options['pp'], "code_{$lang_id}");

                    // if there is no embed code saved generate embed code
                    if(!$code){
                        $publicIds = iub_array_get($globalOptions, 'public_ids');
                        $publicId = iub_array_get($publicIds, $lang_id);

                        $code = $privacyPolicyGenerator->handle($lang_id, $publicId, 'white');
                    }
                    $code = html_entity_decode(iubenda()->parse_code($code));
                    ?>
                    <div data-target="tab-<?php echo $lang_id ; ?>" class="tabs__target <?php echo $lang_id == iubenda()->lang_default || $lang_id == 'default'? 'active': '' ; ?>" data-group="language-tabs">
                        <textarea readonly class='form-control text-sm m-0 iub-pp-code' placeholder='<?php _e('Your embed code', 'iubenda') ?>' rows='4'><?php echo $code ?></textarea>
                    </div>
                <?php endforeach; ?>

            </fieldset>
        </div>
    </div>
    <div class="mb-3 p-0">
        <div class="my-5">
            <h4><?php _e('Shortcode', 'iubenda') ?></h4>
            <p><?php _e('A shortcode is a tiny bit of code that allows embedding interactive elements or creating complex page layouts with a minimal effort.<br>Just copy and paste the shortcode where you want the button to appear.', 'iubenda') ?></p>
            <p></p>
            <fieldset class="paste_embed_code">
                <div class="notice notice--general mt-2 mb-4 p-3 d-flex text-lg-bold">
                    <span>[iub-pp-button]</span>
                </div>
            </fieldset>
        </div>
    </div>
</section>