<div class="siteinfo p-4 d-block d-lg-flex justify-content-between">
  <div class="d-block d-lg-flex align-items-center text-center text-lg-left">
    <div class="siteinfo--icon"><img src="<?php echo IUBENDA_PLUGIN_URL ?>/assets/images/pc_screen_icon.svg"></div>
      <?php
      $url = 'https://www.iubenda.com/account';

      if (!empty(iubenda()->settings->links['privacy_policy_generator_edit'])) {
          $url = iubenda()->settings->links['privacy_policy_generator_edit'];
      }
      ?>
    <div>
      <h1 class="text-bold text-lg m-0"><?php echo parse_url(home_url())['host']; ?></h1>
    </div>
  </div>
  <div class="d-block d-lg-flex align-items-center text-center text-lg-right">
    <p class="mr-lg-3"><?php _e('Your rating', 'iubenda') ?> </p>
    <div class="circularBar sm" id="iubendaRadarCircularBar" data-perc="<?php echo iubenda()->serviceRating->servicesPercentage() ?>"></div>
  </div>
</div>
<hr>
