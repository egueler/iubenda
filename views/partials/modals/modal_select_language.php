<div class="modalSync">
    <img src="<?php echo IUBENDA_PLUGIN_URL ?>/assets/images/modals/modal_sync.svg" alt="" />
    <h1 class="text-lg mb-4">
        <?php _e('Now, select your website language', 'iubenda') ?>
    </h1>
    <div>
        <?php
            $iubenda_intersect_supported_langs = [];
            $selected_language = '';

            if (iubenda()->multilang && ! empty( iubenda()->languages )) {
                $local_languages = array_keys(iubenda()->languages_locale) ?? [];
                $local_languages = iubenda()->language_unification_locale_to_iub($local_languages);

                $iubenda_intersect_supported_langs = array_intersect($local_languages, array_keys(iubenda()->supported_languages)) ?: [];
            } else {
                $iubenda_intersect_supported_langs = array_intersect([iub_array_get(iubenda()->lang_mapping, get_locale())], array_values(iubenda()->lang_mapping)) ?: [];
            }

            // Check if the current language is supported from Iubenda or not
            if(in_array(iubenda()->lang_current, $iubenda_intersect_supported_langs)){
                $selected_language = iubenda()->lang_current;
            }
        ?>
        <select class="custom-script-field" id="iub-website-language" name="website-language" required>
            <?php foreach (iubenda()->supported_languages as $key => $label): ?>
                <option <?php echo ($selected_language == $key) ? 'selected' : ''; ?> <?php echo (!in_array($key, $iubenda_intersect_supported_langs)) ?'disabled' : ''; ?> value=<?php echo $key; ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    <div id="iubenda-policy-config-start"></div>
</div>
<script>
    var _iub = _iub || [];

    _iub.quick_generator = {
        input:{
            privacy_policy:{
                type: 'web_site',
                cookie_solution: true,
                url: '<?php echo get_site_url() ?>',
                langs: ['<?php echo $selected_language ?>']
            },
            user:{
                email: '<?php echo get_bloginfo( "admin_email" ) ?>',
            },
        },
        no_style:true,
        css:"background-color:#e7e7e7;cursor:pointer;color: #585858;padding: 0.5rem 1.7rem;font-size: .95rem;border: 0;border-radius: 3rem;font-weight: bold;width: 100%;",
        placeholder:document.getElementById("iubenda-policy-config-start"),
        callback:iubendaQuickGeneratorCallback,
        api_key:"c52997770b2613f6b0d8b6becffeff8d8071a6ab",
        caption:"<?php echo __('Continue' ,'iubenda')?>"
    };

    function iubendaQuickGeneratorCallback(payload) {
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: iub_js_vars['site_url'] + "/wp-admin/admin-ajax.php",
            data : {action: "quick_generator_api", payload: payload},
            success: function(result){
                if (result.status === 'done') {
                    window.location = result.redirect
                }else{

                }
            },
            error: function(response) { // if error occured
                jQuery("#alert-div").addClass("alert--failure");
                jQuery("#alert-image").attr('src',iub_js_vars['site_url'] + '/wp-content/plugins/iubenda-cookie-wp-solution/assets/images/banner_failure.svg');
                jQuery("#alert-message").text(response.responseText);

                jQuery("#alert-div").removeClass("hidden");
            },
        });
    }

</script>