<div class="wrap derc-wrapper">
    <div class="derc-header">
        <h1 class="wp-heading-inline"><?php esc_html_e('DE Radius Checker Setting', 'derc'); ?></h1><span><?php esc_html_e(sprintf('v%s', DERC_VERSION), 'thor'); ?></span>
        <hr class="wp-header-end">
    </div>
    <div class="derc-content">
        <div class="derc-note">
            <?php esc_html_e('To use this, please insert shortcode [derc-radius-checker] to any page. ', 'derc'); ?>
        </div>

        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="derc-setting-form">
            <div class="derc-row">
                <label for="derc-apikey" class="required"><?php esc_html_e('Google Map API key:', 'derc'); ?></label>
                <input type="text" name="apikey" id="derc-apikey" value="<?php esc_attr_e($setting['apikey']); ?>" required>
            </div>
            <div class="derc-row">
                <label for="derc-zone-url" class="required"><?php esc_html_e('Google Map Zone URL:', 'derc'); ?></label>
                <input type="text" name="zone_url" id="derc-zone-url" value="<?php esc_attr_e($setting['zone_url']); ?>" required>
            </div>
            <div class="derc-row">
                <label for="derc-action-url-inradius" class="required"><?php esc_html_e('Action URL Inradius:', 'derc'); ?></label>
                <input type="text" name="inradius_url" id="derc-action-url-inradius" value="<?php esc_attr_e($setting['inradius_url']); ?>" required>
            </div>
            <div class="derc-row">
                <label for="derc-action-url-outradius" class="required"><?php esc_html_e('Action URL Outradius:', 'derc'); ?></label>
                <input type="text" name="outradius_url" id="derc-action-url-outradius" value="<?php esc_attr_e($setting['outradius_url']); ?>" required>
            </div>

            <div class="derc-row">
                <input type="hidden" name="action" value="<?php esc_attr_e('derc_save_setting', 'derc'); ?>">
                <?php wp_nonce_field('derc_save_setting', 'derc_save_setting_nonce'); ?>
                <input type="submit" name="save" value="<?php esc_attr_e('Save Setting', 'derc'); ?>" class="button button-primary">
            </div>
        </div>
    </div>
</div>