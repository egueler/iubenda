<?php
// exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Class ProductHelper
 */
class ProductHelper
{

    /**
     * @param $lang_id
     * @return string
     */
    public function get_cs_embed_code_by_lang($lang_id): string
    {
        $code = iub_array_get(iubenda()->options['cs'], "manual_code_{$lang_id}");
        if (!$code) {
            $code = iub_array_get(iubenda()->options['cs'], "code_{$lang_id}");
        }

        return html_entity_decode(iubenda()->parse_code($code));
    }

    /**
     * @param $lang_id
     * @return string
     */
    public function get_pp_embed_code_by_lang($lang_id): string
    {
        return $this->get_embed_code('pp', $lang_id);
    }

    /**
     * @param $lang_id
     * @return string
     */
    public function get_tc_embed_code_by_lang($lang_id): string
    {
        return $this->get_embed_code('tc', $lang_id);
    }

    /**
     * Get all languages if website is multilingual and return default if website is single language
     *
     * @return array|string[]
     */
    public function get_languages(): array
    {
        if (iubenda()->multilang && !empty(iubenda()->languages)) {
            return iubenda()->languages;
        }

        return ['default' => 'default_language'];
    }


    /**
     * @param $key
     * @param $lang_id
     * @return string
     */
    private function get_embed_code($key, $lang_id): string
    {
        $code = iub_array_get(iubenda()->options[$key], "code_{$lang_id}");

        return html_entity_decode(iubenda()->parse_code($code));
    }

    /**
     * Check Iubenda CS code exists on current lang or not
     *
     * @return bool
     */
    public function check_iub_cs_code_exists_current_lang(): bool
    {
        return $this->check_iub_code_exists_current_lang('cs');
    }

    /**
     * Check Iubenda $key code exists on current lang or not
     *
     * @param $key
     * @return bool
     */
    private function check_iub_code_exists_current_lang($key): bool
    {
        // Check if there is multi language plugin installed and activated
        if ( iubenda()->multilang === true && defined( 'ICL_LANGUAGE_CODE' ) && isset( iubenda()->options['cs']['code_' . ICL_LANGUAGE_CODE] ) ) {
            $iubenda_code = iubenda()->options[$key]['code_' . ICL_LANGUAGE_CODE];

            // no code for current language, use default
            if ( ! $iubenda_code ){
                $iubenda_code = iubenda()->options[$key]['code_default'];
            }
        } else{
            $iubenda_code = iubenda()->options[$key]['code_default'];
        }

        return boolval(trim($iubenda_code));
    }
}
