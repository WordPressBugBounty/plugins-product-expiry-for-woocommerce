<div class="wrap woope-settings">
	<?php
        $default = array(
            'single_hook'   =>  '',
            'archive_hook'  =>  '',
            'date_format'   =>  get_option( 'date_format' ),
            'notify_emails' =>  '',
            'display'   	=>  'enable',
            'orderdetails'   	=>  'disable',
            'markup'   =>  __( 'Expiry Date: {expiry_date}', 'product-expiry-for-woocommerce' ),
            'notify_on_expired'  => 'enable',
            'notify_before_days' => '',
            'email_subject'      => '',
            'email_body'         => '',
        );
		$savedSettings = get_option( 'woope_admin_settings', $default );
	?>	
    <h1><?php _e( 'Woo Product Expiry Settings', 'product-expiry-for-woocommerce' ); ?></h1>

    <form action="#" class="woope-form">

        <input type="hidden" name="action" value="woope_save_admin_settings">
        <?php wp_nonce_field('woope_save_admin_settings_nonce', 'woope_save_admin_settings_nonce'); ?>

        <!-- General Settings -->
        <div class="woope-card">
            <h2><?php _e( 'Display Settings', 'product-expiry-for-woocommerce' ); ?></h2>
            <table class="form-table">
            	<tr>
            		<th><?php _e( 'Display on Frontend', 'product-expiry-for-woocommerce' ); ?></th>
            		<td>
            			<select name="display">
            				<option value="enable" <?php echo ($savedSettings['display'] == 'enable') ? 'selected' : '' ?>><?php _e( 'Enable', 'product-expiry-for-woocommerce' ) ?></option>
            				<option value="disable" <?php echo ($savedSettings['display'] == 'disable') ? 'selected' : '' ?>><?php _e( 'Disable', 'product-expiry-for-woocommerce' ) ?></option>
            			</select>
            		</td>
            		<td>
            			<?php _e( 'Display the expiry date on single product page.', 'product-expiry-for-woocommerce' ); ?>
            		</td>
            	</tr>

            	<tr>
            		<th><?php _e( 'Expiry Text Markup', 'product-expiry-for-woocommerce' ); ?></th>
            		<td>
            			<input type="text" name="markup" class="widefat" value="<?php echo esc_attr( $savedSettings['markup'] ) ?>">
            		</td>
            		<td>
            			<?php _e( 'Provide text to show on frontend. Use {expiry_date} for expiry date', 'product-expiry-for-woocommerce' ); ?>
            		</td>
            	</tr>

            	<tr>
            		<th><?php _e( 'Position of Date on single product page', 'product-expiry-for-woocommerce' ); ?></th>
            		<td>
            			<input type="text" name="single_hook" class="widefat" value="<?php echo esc_attr( $savedSettings['single_hook'] ) ?>">
            		</td>
            		<td>
            			<?php _e( 'Provide hook name here.', 'product-expiry-for-woocommerce' ); ?>
            		</td>
            	</tr>

            	<tr>
            		<th><?php _e( 'Position of Date on shop archive page', 'product-expiry-for-woocommerce' ) ?></th>
            		<td>
            			<input type="text" name="archive_hook" class="widefat" value="<?php echo esc_attr( $savedSettings['archive_hook'] ) ?>">
            		</td>
            		<td>
            			<?php _e( 'Provide hook name here.', 'product-expiry-for-woocommerce' ) ?>
            		</td>
            	</tr>

            	<tr>
            		<th><?php _e( 'Date Format', 'product-expiry-for-woocommerce' ) ?></th>
            		<td>
            			<input type="text" name="date_format" value="<?php echo esc_attr( $savedSettings['date_format'] ) ?>">
            		</td>
            		<td>
            			<?php _e( 'Provide format for date.', 'product-expiry-for-woocommerce' ) ?>
            		</td>
            	</tr>

            	<tr>
            		<th><?php _e( 'Display in Emails', 'product-expiry-for-woocommerce' ); ?></th>
            		<td>
            			<select name="orderdetails">
            				<option value="enable" <?php echo (isset($savedSettings['orderdetails']) && $savedSettings['orderdetails'] == 'enable') ? 'selected' : '' ?>><?php _e( 'Enable', 'product-expiry-for-woocommerce' ) ?></option>
            				<option value="disable" <?php echo (isset($savedSettings['orderdetails']) && $savedSettings['orderdetails'] == 'disable') ? 'selected' : '' ?>><?php _e( 'Disable', 'product-expiry-for-woocommerce' ) ?></option>
            			</select>
            		</td>
            		<td>
            			<?php _e( 'Display the expiry date in order details email.', 'product-expiry-for-woocommerce' ); ?>
            		</td>
            	</tr>

            	<tr>
            		<th><?php _e( 'Display in Order Details', 'product-expiry-for-woocommerce' ); ?></th>
            		<td>
            			<select name="orderdetailsadmin">
            				<option value="enable" <?php echo (isset($savedSettings['orderdetailsadmin']) && $savedSettings['orderdetailsadmin'] == 'enable') ? 'selected' : '' ?>><?php _e( 'Enable', 'product-expiry-for-woocommerce' ) ?></option>
            				<option value="disable" <?php echo (isset($savedSettings['orderdetailsadmin']) && $savedSettings['orderdetailsadmin'] == 'disable') ? 'selected' : '' ?>><?php _e( 'Disable', 'product-expiry-for-woocommerce' ) ?></option>
            			</select>
            		</td>
            		<td>
            			<?php _e( 'Display the expiry date in order details admin and front.', 'product-expiry-for-woocommerce' ); ?>
            		</td>
            	</tr>
            </table>
        </div>

        <!-- Notification Settings -->
        <div class="woope-card">
            <h2><?php _e( 'Notification Settings', 'product-expiry-for-woocommerce' ); ?></h2>
            <table class="form-table">
            	<tr>
            		<th><?php _e( 'Notification Emails', 'product-expiry-for-woocommerce' ) ?></th>
            		<td>
            			<input type="text" class="widefat" name="notify_emails" value="<?php echo esc_attr( $savedSettings['notify_emails'] ) ?>">
            		</td>
            		<td>
            			<?php _e( 'Provide comma separated email addresses for expiry notification.', 'product-expiry-for-woocommerce' ) ?>
            		</td>
            	</tr>
            	<tr>
            	    <th><?php _e( 'Send Email When Expired', 'product-expiry-for-woocommerce' ); ?></th>
            	    <td>
            	        <select name="notify_on_expired">
            	            <option value="enable" <?php isset($savedSettings['notify_on_expired']) ? selected( $savedSettings['notify_on_expired'], 'enable' ) : ''; ?>>
            	                <?php _e( 'Enable', 'product-expiry-for-woocommerce' ); ?>
            	            </option>
            	            <option value="disable" <?php isset($savedSettings['notify_on_expired']) ? selected( $savedSettings['notify_on_expired'], 'disable' ) : ''; ?>>
            	                <?php _e( 'Disable', 'product-expiry-for-woocommerce' ); ?>
            	            </option>
            	        </select>
            	    </td>
            	    <td>
            	        <?php _e( 'Send notification email when product expires.', 'product-expiry-for-woocommerce' ); ?>
            	    </td>
            	</tr>
            	<tr>
            	    <th><?php _e( 'Email Subject', 'product-expiry-for-woocommerce' ); ?></th>
            	    <td>
            	        <input type="text"
            	                   name="email_subject"
            	                   value="<?php echo isset($savedSettings['email_subject']) ?  esc_attr( $savedSettings['email_subject'] ) : ''; ?>"
            	                   class="widefat">
            	    </td>
            	    <td>
            	        <?php _e( 'Available placeholders: {product_name}, {expiry_date}, {product_url}', 'product-expiry-for-woocommerce' ); ?>
            	    </td>
            	</tr>

            	<tr>
            	    <th><?php _e( 'Email Body Template', 'product-expiry-for-woocommerce' ); ?></th>
            	    <td>
            	        <textarea name="email_body"
            	                      class="widefat"
            	                      rows="4"><?php echo isset($savedSettings['email_body']) ? esc_textarea( $savedSettings['email_body'] ) : ''; ?></textarea>
            	    </td>
            	    <td>
            	        <?php _e( 'Customize email message sent for expiry notification.', 'product-expiry-for-woocommerce' ); ?>
            	    </td>
            	</tr>
            	<tr>
            	    <th><?php _e( 'Reminder Before Expiry (Days)', 'product-expiry-for-woocommerce' ); ?></th>
            	    <td>
            	        <?php if ( ! defined( 'WOOPE_PRO_VERSION' ) ) : ?>
            	            <input type="number"
            	                   value="3"
            	                   class="small-text"
            	                   readonly
            	                   style="opacity:0.6;">
            	        <?php else : ?>
            	            <input type="number"
            	                   name="notify_before_days"
            	                   value="<?php echo isset($savedSettings['notify_before_days']) ?  esc_attr( $savedSettings['notify_before_days'] ) : ''; ?>"
            	                   class="small-text">
            	        <?php endif; ?>
            	    </td>
            	    <td>
            	        <?php
            	        if ( ! defined( 'WOOPE_PRO_VERSION' ) ) {
            	            echo sprintf(
            	                __( 'Send reminder email X days before expiry. Available in <strong>Pro version</strong>. <a href="%s" target="_blank">Learn more</a>', 'product-expiry-for-woocommerce' ),
            	                esc_url( 'https://webcodingplace.com/product-expiry-for-woocommerce/' )
            	            );
            	        } else {
            	            _e( 'Send reminder email before days product expires.', 'product-expiry-for-woocommerce' );
            	        }
            	        ?>
            	    </td>
            	</tr>
            </table>
        </div>

        <p class="submit">
            <button type="submit" class="button button-primary">
                <?php _e( 'Save Settings', 'product-expiry-for-woocommerce' ); ?>
            </button>
            <span class="spinner"></span>
            <span class="success-text"></span>
        </p>

    </form>
</div>