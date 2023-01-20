<?php if(isset($notices)){ ?>
<div class="alert alert--<?php echo ( $notice_type === 'error' ? 'failure' : 'success' ); ?> is-dismissible m-4">
    <div class="alert__icon p-4">
        <img src="<?php echo IUBENDA_PLUGIN_URL ?>/assets/images/banner_<?php echo ( $notice_type === 'error' ? 'failure' : 'success' ); ?>.svg">
    </div>
    <?php
        foreach ( $notices[$notice_type] as $key => $notice ) {
            echo '<p class="text-regular">'.wp_kses_post( $notice ).'</p>';
        }
    ?>
    <button class="btn-close mr-3 notice-dismiss">×</button>
</div>
<?php }?>