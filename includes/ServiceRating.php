<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;


/**
 * Class ServiceRating
 */
class ServiceRating {
    public $radarApiConfiguration = [];

    public function __construct(){
        $this->radarApiConfiguration = get_option('iubenda_radar_api_configuration', []) ?: [];
    }

    public function isCookieSolutionActivated(){
        if(iub_array_get(iubenda()->settings->services, 'cs.status') == 'true'){
            return true;
        }

        if($this->isServiceInstalledByRadar('cp') == true){
            return true;
        }
        return false;
    }

    public function isCookieSolutionConfigured(){
        if(iub_array_get(iubenda()->settings->services, 'cs.configured') == 'true'){
            return true;
        }

        if($this->isServiceInstalledByRadar('cp') == true){
            return true;
        }
        return false;
    }

    public function isPrivacyPolicyActivated(){
        if(iub_array_get(iubenda()->settings->services, 'pp.status') == 'true'){
            return true;
        }

        if($this->isServiceInstalledByRadar('pp') == true){
            return true;
        }
        return false;
    }

    public function isTermsConditionsActivated(){
        if(iub_array_get(iubenda()->settings->services, 'tc.status') == 'true'){
            return true;
        }

        if($this->isServiceInstalledByRadar('tc') == true){
            return true;
        }
        return false;
    }

    private function isServiceInstalledByRadar($service){
        if(iub_array_get($this->radarApiConfiguration, 'status') == 'completed'){
            return iub_array_get($this->radarApiConfiguration, 'result.meta.'.$service.'_installed');
        }
        return false;
    }

    public function checkServiceStatus($service){
        if($service == 'cs'){
            return $this->isCookieSolutionActivated();
        }
        if($service == 'cons'){
            return $this->isCookieSolutionConfigured();
        }
        if($service == 'pp'){
            return $this->isPrivacyPolicyActivated();
        }
        if($service == 'tc'){
            return $this->isTermsConditionsActivated();
        }

        return false;
    }

    public function servicesPercentage(){
        $services['pp'] = $this->isPrivacyPolicyActivated();
        $services['cs'] = $this->isCookieSolutionActivated();
        $services['cons'] = $this->isCookieSolutionActivated() ? $this->isCookieSolutionConfigured() : false;
        $services['tc'] = $this->isTermsConditionsActivated();

        return (count(array_filter($services)) / count($services)) * 100;
    }

}
