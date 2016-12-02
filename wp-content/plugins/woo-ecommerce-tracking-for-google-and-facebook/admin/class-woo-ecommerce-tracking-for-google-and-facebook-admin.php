<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Ecommerce_Tracking_For_Google_And_Facebook
 * @subpackage Woo_Ecommerce_Tracking_For_Google_And_Facebook/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Ecommerce_Tracking_For_Google_And_Facebook
 * @subpackage Woo_Ecommerce_Tracking_For_Google_And_Facebook/admin
 * @author     Multidots <wordpress@multidots.com>
 */
class Woo_Ecommerce_Tracking_For_Google_And_Facebook_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Ecommerce_Tracking_For_Google_And_Facebook_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Ecommerce_Tracking_For_Google_And_Facebook_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		

		if( !empty( $_GET['page']) && $_GET['page'] === 'woo-ecommerce-tracking-for-google-and-facebook' ){
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
		}
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-ecommerce-tracking-for-google-and-facebook-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-pointer' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Ecommerce_Tracking_For_Google_And_Facebook_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Ecommerce_Tracking_For_Google_And_Facebook_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-ecommerce-tracking-for-google-and-facebook-admin.js', array( 'jquery','jquery-ui-dialog' ), $this->version, false );
		//enqueue script for notice pointer
		wp_enqueue_script( 'wp-pointer' );

	}
	
	/**
	 * Ecommerce Tracking code settings
	 *
	 * @since    1.0.0
	 */
	public function woo_ecommerce_tracking_settings(){
		
		require_once 'partials/woo-ecommerce-tracking-for-google-and-facebook-admin-display.php';
	}
	
	public function wp_add_plugin_userfn() {
    	$email_id= $_POST['email_id'];
    	$log_url = $_SERVER['HTTP_HOST'];
    	$cur_date = date('Y-m-d');
    	$url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/wp-add-plugin-users.php';
    	$response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('user'=>array('user_email'=>$email_id,'plugin_site' => $log_url,'status' => 1,'plugin_id' => '8','activation_date'=>$cur_date)),
    	'cookies' => array()));
		update_option('wetfgf_plugin_notice_shown', 'true');
    }
    
    public function hide_subscribe_wetfgffn() {
    	$email_id= $_POST['email_id'];
    	update_option('wetfgf_plugin_notice_shown', 'true');
    }
    
    
    // Function for welocme screen page
    
    public function welcome_woocommerce_ecommerce_tracking_for_google_and_facebook_screen_do_activation_redirect (){ 
    	
    	 
    	if (!get_transient('_welcome_screen_woocommerce_ecommerce_tracking_for_google_and_facebook_activation_redirect_data')) {
			return;
		}
		
		// Delete the redirect transient
		delete_transient('_welcome_screen_woocommerce_ecommerce_tracking_for_google_and_facebook_activation_redirect_data');

		// if activating from network, or bulk
		if (is_network_admin() || isset($_GET['activate-multi'])) {
			return;
		}
		// Redirect to extra cost welcome  page
		wp_safe_redirect(add_query_arg(array('page' => 'woo-ecommerce-tracking-for-google-and-facebook&tab=about'), admin_url('index.php')));
    } 
    
    
    public function welcome_pages_screen_woocommerce_ecommerce_tracking_for_google_and_facebook () {
		add_dashboard_page(
		'Woocommerce-Ecommerce-Conversion-Tracking-for-Google-and-Facebook-Dashboard', 'Woocommerce Ecommerce Conversion Tracking for Google and Facebook Dashboard', 'read', 'woo-ecommerce-tracking-for-google-and-facebook', array(&$this, 'welcome_screen_content_woocommerce_ecommerce_conversion')
		);
	}
	
	
	public function welcome_screen_content_woocommerce_ecommerce_conversion() {
        ?>
        
         <div class="wrap about-wrap">
            <h1 style="font-size: 2.1em;"><?php printf(__('Woocommerce Ecommerce Conversion Tracking for Google and Facebook', 'woo-ecommerce-tracking-for-google-and-facebook')); ?></h1>

            <div class="about-text woocommerce-about-text">
        <?php
        $message = '';
        printf(__('%s Wooommerce Ecommerce Conversion Tracking for Google and Facebook plugin is tracking order using Ecommerce tracking and boost your Marketing.', 'woo-ecommerce-tracking-for-google-and-facebook'), $message, $this->version);
        ?>
                <img class="version_logo_img" src="<?php echo plugin_dir_url(__FILE__) . 'images/woo-ecommerce-tracking-for-google-and-facebook.png'; ?>">
            </div>

        <?php
        $setting_tabs_wc = apply_filters('woocommerce_ecommerce_tracking_fields_setting_tab', array("about" => "Overview", "other_plugins" => "Checkout our other plugins"));
        $current_tab_wc = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';
        $aboutpage = isset($_GET['page'])
        ?>
            <h2 id="woo-extra-cost-tab-wrapper" class="nav-tab-wrapper">
            <?php
            foreach ($setting_tabs_wc as $name => $label)
            echo '<a  href="' . home_url('wp-admin/index.php?page=woo-ecommerce-tracking-for-google-and-facebook&tab=' . $name) . '" class="nav-tab ' . ( $current_tab_wc == $name ? 'nav-tab-active' : '' ) . '">' . $label . '</a>';
            ?>
            </h2>

                <?php
                foreach ($setting_tabs_wc as $setting_tabkey_wc => $setting_tabvalue) {
                	switch ($setting_tabkey_wc) {
                		case $current_tab_wc:
                			do_action('woocommerce_ecommerce_tracking_for_google_and_facebook_' . $current_tab_wc);
                			break;
                	}
                }
                ?>
            <hr />
            <div class="return-to-dashboard">
                <a href="<?php echo home_url('/wp-admin/admin.php?page=wc-settings&tab=ecommerce_tracking_settings'); ?>"><?php _e('Go to Wooommerce Ecommerce Conversion Tracking for Google and Facebook Settings', 'woo-ecommerce-tracking-for-google-and-facebook'); ?></a>
            </div>
        </div>
        
        
        
        <?php
	}
    
	/**
     * woocommerce ecommerce tracking overview welcome page content function
     *
     */
	public function woocommerce_ecommerce_tracking_for_google_and_facebook_about() {
		//do_action('my_own');
		$current_user = wp_get_current_user();

    	?>
        <div class="changelog">
            </br>
           	<style type="text/css">
				p.woocommerce_ecommerce_tracking_overview {max-width: 100% !important;margin-left: auto;margin-right: auto;font-size: 15px;line-height: 1.5;}.woocommerce_ecommerce_tracking_content_ul ul li {margin-left: 3%;list-style: initial;line-height: 23px;}
			</style>  
            <div class="changelog about-integrations">
                <div class="wc-feature feature-section col three-col">
                    <div>
                        <p class="woocommerce_ecommerce_tracking_overview"><?php _e('Wooommerce Ecommerce Conversion Tracking for Google and Facebook plugin is for these who wants to use Ecommerce tracking, Facebook Conversion, Google Conversion into your WooCommerce site. This plugin is boost your business and Enhance your marketing. This plugin adds settings tab (Ecommerce Tracking Settings) in WooCommerce setting section. This plugin gives you the option to track your order in Google using Ecommerce tracking code.', 'woo-ecommerce-tracking-for-google-and-facebook'); ?></p>
                        
                        <p class="woocommerce_ecommerce_tracking_overview"><strong>Features of Plugin: </strong></p>  
                        <div class="woocommerce_ecommerce_tracking_content_ul">
                        	<ul>
								<li>WooCommerce Ecommerce tracking functionlity.</li>
								<li>Google Conversion tracking functionlity.</li>
								<li>Facebook Conversion tracking functionlity.</li>
							</ul>
                        </div>
                        
                        <p class="woocommerce_ecommerce_tracking_overview"><strong>Features of Plugin: </strong></p>  
                        <p class="woocommerce_ecommerce_tracking_overview">1. For Ecommerce Tracking</p>  
                        <div class="woocommerce_ecommerce_tracking_content_ul">
                        	<ul>
								<li>Make sure you have enabled GA tracking code in you website.</li>
								<li>Activate Ecommerce tracking from the Settings page. You can access the setting page from here WooCommerce -> Settings -> Ecommerce Tracking Settings.</li>
								<li>Before Activate Ecommerce tracking, Setup goal for Ecommerce in your Google profile. Please Setup Goal by click on this link Setup Goal for reference.</li>
								<li>After done all Ecommerce settings, "Enable Ecommerce Setting" Option from Our plugin.</li>
							</ul>
                        </div>
                        
                        
                        <p class="woocommerce_ecommerce_tracking_overview">2. For Facebook conversion</p>  
                        <div class="woocommerce_ecommerce_tracking_content_ul">
                        	<ul>
								<li>Before Enable Facebook Conversion from our plugin Please follow steps and create "Facebook Track Id" from this link <a target="_blank" href="https://www.facebook.com/business/help/435189689870514?locale=en_GB" rel="nofollow">https://www.facebook.com/business/help/435189689870514?locale=en_GB</a> and enter "Facebook Track id" to our Plugin settings and boost your store marketing.</li>
							</ul>
                        </div>
                        
                         <p class="woocommerce_ecommerce_tracking_overview">3. For Google conversion</p>  
                        <div class="woocommerce_ecommerce_tracking_content_ul">
                        	<ul>
								<li>Before Enable Google Conversion from our plugin Please follow steps and create Google conversion from this link <a target="_blank" href="https://support.bigcommerce.com/articles/Public/How-do-I-add-Google-Adwords-Conversion-Tracking" rel="nofollow">https://support.bigcommerce.com/articles/Public/How-do-I-add-Google-Adwords-Conversion-Tracking</a> and enter "Google conversion id" and "Google conversion lable" to our plugin settings section then you are ready to boost your AdWords in your WooCommerce store.</li>
							</ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <?php	
		if (!get_option('wetfgf_plugin_notice_shown')) {
				echo '<div id="wetfgf_dialog" title="Basic dialog"> <p> Subscribe for latest plugin update and get notified when we update our plugin and launch new products for free! </p> <p><input type="text" id="txt_user_sub_wetfgf" class="regular-text" name="txt_user_sub_wetfgf" value="'.$current_user->user_email.'"></p></div>'; ?>
			
			<script type="text/javascript">
			
				jQuery( document ).ready(function() {
					jQuery( "#wetfgf_dialog" ).dialog({
						modal: true, title: 'Subscribe Now', zIndex: 10000, autoOpen: true,
						width: '500', resizable: false,
						position: {my: "center", at:"center", of: window },
						dialogClass: 'dialogButtons',
						buttons: {
							Yes: function () {
								// $(obj).removeAttr('onclick');
								// $(obj).parents('.Parent').remove();
								var email_id = jQuery('#txt_user_sub_wetfgf').val();
								
								var data = {
								'action': 'add_plugin_user_wetfgf',
								'email_id': email_id
								};
								
								// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
								jQuery.post(ajaxurl, data, function(response) {
								jQuery('#wetfgf_dialog').html('<h2>You have been successfully subscribed');
								jQuery(".ui-dialog-buttonpane").remove();
								});
							},
							No: function () {
								var email_id = jQuery('#txt_user_sub_wetfgf').val();
								
								var data = {
									'action': 'hide_subscribe_wetfgf',
									'email_id': email_id
								};
								
								// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
								jQuery.post(ajaxurl, data, function(response) {
								
								});
								
								jQuery(this).dialog("close");
								
							}
						},
						close: function (event, ui) {
							jQuery(this).remove();
						}
					});
					
					jQuery("div.dialogButtons .ui-dialog-buttonset button").removeClass('ui-state-default');
					jQuery("div.dialogButtons .ui-dialog-buttonset button").addClass("button-primary woocommerce-save-button");
					jQuery("div.dialogButtons .ui-dialog-buttonpane .ui-button").css("width","80px");
				});
			</script>
			
		<?php }
        
	 }
 
	
	public function woocommerce_ecommerce_tracking_for_google_and_facebook_other_plugins() { 
		global $wpdb;
         $url = 'http://www.multidots.com/store/wp-content/themes/business-hub-child/API/checkout_other_plugin.php';
    	 $response = wp_remote_post( $url, array('method' => 'POST',
    	'timeout' => 45,
    	'redirection' => 5,
    	'httpversion' => '1.0',
    	'blocking' => true,
    	'headers' => array(),
    	'body' => array('plugin' => 'advance-flat-rate-shipping-method-for-woocommerce'),
    	'cookies' => array()));
    	
    	$response_new = array();
    	$response_new = json_decode($response['body']);
		$get_other_plugin = maybe_unserialize($response_new);
		
		$paid_arr = array();
		?>

        <div class="plug-containter">
        	<div class="paid_plugin">
        	<h3>Paid Plugins</h3>
	        	<?php foreach ($get_other_plugin as $key=>$val) { 
	        		if ($val['plugindesc'] =='paid') {?>
	        			
	        			
	        		   <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>	
	        			
	        		<?php }else {
	        			
	        			$paid_arry[$key]['plugindesc']= $val['plugindesc'];
	        			$paid_arry[$key]['pluginimage']= $val['pluginimage'];
	        			$paid_arry[$key]['pluginurl']= $val['pluginurl'];
	        			$paid_arry[$key]['pluginname']= $val['pluginname'];
	        		
	        	?>
	        	
	         
	            <?php } }?>
           </div>
           <?php if (isset($paid_arry) && !empty($paid_arry)) {?>
           <div class="free_plugin">
           	<h3>Free Plugins</h3>
                <?php foreach ($paid_arry as $key=>$val) { ?>  	
	            <div class="contain-section">
	                <div class="contain-img"><img src="<?php echo $val['pluginimage']; ?>"></div>
	                <div class="contain-title"><a target="_blank" href="<?php echo $val['pluginurl'];?>"><?php echo $key;?></a></div>
	            </div>
	            <?php } }?>
           </div>
          
        </div>

    <?php
	}

	/**
     * Remove the Extra flate rate menu in dashboard
     *
     */
	public function welcome_screen_woocommerce_ecommerce_tracking_for_google_and_facebook_remove_menus() {
		remove_submenu_page('index.php', 'woo-ecommerce-tracking-for-google-and-facebook');
	}

    
    
    public function woo_advance_tracking_custom_admin_pointers_footer(){ 
    	$admin_pointers = woo_advance_tracking_custom_admin_pointers();
	    ?>
	    <script type="text/javascript">
	        /* <![CDATA[ */
	        ( function($) {
	            <?php
	            foreach ( $admin_pointers as $pointer => $array ) {
	               if ( $array['active'] ) {
	                  ?>
	            $( '<?php echo $array['anchor_id']; ?>' ).pointer( {
	                content: '<?php echo $array['content']; ?>',
	                position: {
	                    edge: '<?php echo $array['edge']; ?>',
	                    align: '<?php echo $array['align']; ?>'
	                },
	                close: function() {
	                    $.post( ajaxurl, {
	                        pointer: '<?php echo $pointer; ?>',
	                        action: 'dismiss-wp-pointer'
	                    } );
	                }
	            } ).pointer( 'open' );
	            <?php
	         }
	      }
	      ?>
	        } )(jQuery);
	        /* ]]> */
	    </script>
	    <?php
    }
}

/**
 * Function for add custom pointer
 *
 * @return unknown
 */
function woo_advance_tracking_custom_admin_pointers(){ 
	$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
    $version = '1_0'; // replace all periods in 1.0 with an underscore
    $prefix = 'woo_advance_tracking_custom_admin_pointers' . $version . '_';

    $new_pointer_content = '<h3>' . __( 'Woocommerce Ecommerce Conversion Tracking for Google and Facebook' ) . '</h3>';
    $new_pointer_content .= '<p>' . __( 'Plugin help for Ecommerce tracking, Facebook Conversion, Google Conversion into your WooCommerce site.' ) . '</p>';

    return array(
        $prefix . 'woo_advance_tracking_notice_view' => array(
            'content' => $new_pointer_content,
            'anchor_id' => '#toplevel_page_woocommerce',
            'edge' => 'left',
            'align' => 'left',
            'active' => ( ! in_array( $prefix . 'woo_advance_tracking_notice_view', $dismissed ) )
        )
    );
}