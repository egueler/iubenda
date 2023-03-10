<?php require_once IUBENDA_PLUGIN_PATH . '/views/partials/header.php'; ?>
<div class="main-box">
    <?php require_once IUBENDA_PLUGIN_PATH . '/views/partials/siteInfo.php'; ?>
    <?php require_once IUBENDA_PLUGIN_PATH . '/views/partials/breadcrumb.php'; ?>
    <form class="ajax-form-to-options">
        <input hidden name="iubenda_section_name" value="iubenda_terms_conditions_solution">
        <input hidden name="iubenda_section_key" value="tc">
        <input hidden name="action" value="ajax_save_options">
        <input hidden name="_redirect" value="<?php echo esc_url(add_query_arg(['view' => 'products-page'], iubenda()->base_url)) ?>">
        <div class="mx-4 mx-lg-5">
            <div class="py-4 py-lg-5 text-gray">
                <p class=""><?php _e('Configure your terms and conditions on our website and paste here the embed code to integrate the button on your website.', 'iubenda') ?></p>
                <div class="d-flex align-items-center ">
                    <div class="steps flex-shrink mr-2">1</div>
                    <p class="text-bold"> <?php _e('Configure terms and conditions by', 'iubenda') ?>
                        <a target="_blank" href="<?php echo iubenda()->settings->links['about_tc']; ?>" class="link-underline text-gray-lighter"> <?php _e('clicking here', 'iubenda') ?></a>
                    </p>
                </div>
                <div class="d-flex align-items-center ">
                    <div class="steps flex-shrink mr-2">2</div>
                    <p class="text-bold"> <?php _e('Paste your terms and conditions embed code here', 'iubenda') ?>
                    </p>
                </div>
                <div class="ml-5 mt-3">
                    <?php require_once IUBENDA_PLUGIN_PATH . '/views/partials/languagesTabs.php'; ?>
                </div>
            </div>
            <hr>
            <div class="py-5">
                <h3 class="m-0 mb-4"><?php _e('Integration', 'iubenda') ?></h3>
                <!-- Button Style -->
                <h4><?php _e('Button style', 'iubenda') ?></h4>
                <div class="scrollable gap-fixer">
                    <div class="button-style mb-3 d-flex">
                        <div class="m-1 mr-2">
                            <label class="radio-btn-style radio-btn-style-light">
                                <input type="radio" class="update-button-style" name="iubenda_terms_conditions_solution[button_style]" value="white" <?php echo checked( 'white', iub_array_get(iubenda()->options['tc'], 'button_style'), false) ?>>
                                <div>
                                    <div class="btn-fake"></div>
                                </div>
                                <p class="text-xs text-center"><?php _e('Light', 'iubenda') ?></p>
                            </label>
                        </div>
                        <div class="m-1 mr-2">
                            <label class="radio-btn-style radio-btn-style-dark">
                                <input type="radio" class="update-button-style" name="iubenda_terms_conditions_solution[button_style]" value="black" <?php echo checked( 'black', iub_array_get(iubenda()->options['tc'], 'button_style'), false) ?>>
                                <div>
                                    <div class="btn-fake"></div>
                                </div>
                                <p class="text-xs text-center"><?php _e('Dark', 'iubenda') ?></p>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Button Position -->
                <h4><?php _e('Button position', 'iubenda') ?></h4>
                <div class="mb-2 d-flex align-items-center flex-wrap">
                    <label class="radio-regular mr-3">
                        <input type="radio" name="iubenda_terms_conditions_solution[button_position]" value="automatic" class="mr-2 section-radio-control" data-section-group=".tc_button_position" data-section-name="#tc_button_position_automatic" <?php checked( 'automatic', iub_array_get(iubenda()->options['tc'], 'button_position')) ?>>
                        <span><?php _e('Add to the footer automatically', 'iubenda') ?></span>
                    </label>
                    <label class="mr-4 radio-regular text-xs">
                        <input type="radio" name="iubenda_terms_conditions_solution[button_position]" value="manual" class="mr-2 section-radio-control" data-section-group=".tc_button_position" data-section-name="#tc_button_position_manually" <?php checked( 'manual', iub_array_get(iubenda()->options['tc'], 'button_position')) ?>>
                        <span><?php _e('Integrate manually', 'iubenda') ?></span>
                    </label>
                </div>
                <?php
                    global $wp_registered_sidebars;

                    // If sidebar-1 not registered or not activated
                    if (!boolval(iub_array_get($wp_registered_sidebars, 'sidebar-1'))){
                    ?>
                        <section id="tc_button_position_automatic" class="tc_button_position <?php echo iub_array_get(iubenda()->options['tc'], 'button_position') == 'automatic' ?:'hidden' ; ?>">
                            <div class="notice notice--warning mt-2 mb-4 p-3 d-flex align-items-center text-warning text-xs">
                                <img class="mr-2" src="<?php echo IUBENDA_PLUGIN_URL ?>/assets/images/warning-icon.svg">
                                <p><?php echo sprintf( __( 'We were not able to add a "Legal" widget to the footer as your theme is not compatible, you can position the "Legal" widget manually from <a href="%s" target="_blank">here</a>.', 'iubenda' ), esc_url( admin_url( 'widgets.php' ) ) ) ?></p>
                            </div>
                        </section>
                    <?php
                    }
                ?>
                <section id="tc_button_position_manually" class="tc_button_position <?php echo iub_array_get(iubenda()->options['tc'], 'button_position') == 'manual' ?:'hidden' ; ?>">
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
                                $languages = (new ProductHelper())->get_languages();
                                foreach($languages as $lang_id => $v):
                                    $code = iub_array_get(iubenda()->options['tc'], "code_{$lang_id}");
                                    $code = html_entity_decode(iubenda()->parse_code($code));
                                    ?>
                                    <div data-target="tab-<?php echo $lang_id ; ?>" class="tabs__target <?php echo $lang_id == iubenda()->lang_default || $lang_id == 'default'? 'active': '' ; ?>" data-group="language-tabs">
                                        <textarea readonly class='form-control text-sm m-0 iub-tc-code' id="iub-tc-code-<?php echo $lang_id; ?>" placeholder='<?php _e('Your embed code', 'iubenda') ?>' rows='4'><?php echo $code ?></textarea>
                                    </div>
                                <?php endforeach; ?>

                            </fieldset>
                        </div>
                    </div>
                    <div class="mb-3 p-0">
                        <div class="my-5">
                            <h4><?php _e('Shortcode', 'iubenda') ?></h4>
                            <p>A shortcode is a tiny bit of code that allows embedding interactive elements or creating complex page layouts with a minimal effort.<br>Just copy and paste the shortcode where you want the button to appear.</p>
                            <fieldset class="paste_embed_code">
                                <div class="notice notice--general mt-2 mb-4 p-3 d-flex text-lg-bold">
                                    <span>[iub-tc-button]</span>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <hr>
        <div class="p-4 d-flex justify-content-end">
            <input class="btn btn-gray-lighter btn-sm mr-2" type="button" value="<?php _e('Cancel', 'iubenda') ?>" onclick="window.location.href = '<?php echo esc_url(add_query_arg(array('view' => 'products-page'), iubenda()->base_url)) ?>'"/>
            <button type="submit" class="btn btn-green-primary btn-sm" value="Save" name="save">
                <span class="button__text"><?php _e('Save settings', 'iubenda') ?></span>
            </button>
        </div>
    </form>
</div>

<?php require_once IUBENDA_PLUGIN_PATH . '/views/partials/modals/modal_ops_embed_invalid.php'; ?>
<?php require_once IUBENDA_PLUGIN_PATH . '/views/partials/footer.php'; ?>

