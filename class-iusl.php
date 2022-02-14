<?php

namespace IUSL;

// No, Direct access Sir !!!
if (!defined('ABSPATH')) exit;

if (!class_exists('JLT_IUSL')) {
	
	class JLT_IUSL {

		const VERSION = IUSL_VER;
        private static $instance = null;

        public function __construct()
        {
        	add_action('admin_menu', [$this, 'jltiusl_register_submenu']);
        	add_action('admin_init', [$this, 'jltiusl_display_options']);

        	$this->jltiusl_init();
        }

        public function jltiusl_init(){
        	$settings = (array) get_option( 'jlt-iusl-settings' );
			$field = "jltiusl_in_mb";
			$value = esc_attr( $settings[$field] );        	
			if(!empty($value)){
				add_filter('upload_size_limit', [$this, 'jltiusl_value']);
			}
        }

        public function jltiusl_register_submenu(){
			add_submenu_page(
				'tools.php', 
				__('Increase Upload Size Limit', IUSL_TD),
				__('Increase Upload Size', IUSL_TD),
				apply_filters('jltiusl_capability', 'manage_options'),
				'increase-upload-size-limit', 
				[$this, 'jltiusl_options_settings_content']
			);
        }

        // IUSL
        public function jltiusl_display_options(){
			/* 
			* http://codex.wordpress.org/Function_Reference/register_setting
			* register_setting( $option_group, $option_name, $sanitize_callback );
			* The second argument ($option_name) is the option name. It’s the one we use with functions like get_option() and update_option()
			* */
		  	# With input validation:
		  	# register_setting( 'my-settings-group', 'jlt-iusl-settings', 'my_settings_validate_and_sanitize' );           	
        	register_setting( 'jlt-iusl-form-data', 'jlt-iusl-settings' );


		  	/* 
			 * http://codex.wordpress.org/Function_Reference/add_settings_section
			 * add_settings_section( $id, $title, $callback, $page ); 
			 * */	 
		  	add_settings_section( 'jlt-iusl-form-section', '', [$this, 'section_1_callback'], 'increase-upload-size-limit' );
			
			/* 
			 * http://codex.wordpress.org/Function_Reference/add_settings_field
			 * add_settings_field( $id, $title, $callback, $page, $section, $args );
			 * */
		  	add_settings_field( 'iusl-in-mb', __( 'Upload File Size', IUSL_TD ), [$this, 'jltiusl_in_mb_callback'], 'increase-upload-size-limit', 'jlt-iusl-form-section' );        	
        }

        public function section_1_callback() {
			// _e( 'Some help text regarding Section One goes here.', IUSL_TD );
		}

        // IUSL Settings Content
        public function jltiusl_options_settings_content(){?>
			  <div class="wrap">
			      <h2><?php _e('Increase Upload Size Limit', IUSL_TD); ?></h2>
			      <form action="options.php" method="POST">
			        <?php settings_fields('jlt-iusl-form-data'); ?>
			        <?php do_settings_sections('increase-upload-size-limit'); ?>
			        <?php submit_button(); ?>
			      </form>
			  </div>
        <?php }


        public function jltiusl_in_mb_callback() {
	
			$settings = (array) get_option( 'jlt-iusl-settings' );
			$field = "jltiusl_in_mb";
			$value = !empty($settings[$field]) ? esc_attr( $settings[$field] ) : '';
			
			echo "<input type='number' name='jlt-iusl-settings[$field]' value='$value' /> MB <br>";
			printf('(Enter the numeric value in MB(Megabytes). Example - 512MB, for 2GB - 2048MB) ','');
		}


		// IUSL Settings Data 
        public function jltiusl_value(){
        	$settings = (array) get_option( 'jlt-iusl-settings' );
			$field = "jltiusl_in_mb";
			
			$value = esc_attr( $settings[$field] );

			$memory_usage_convert = round($value * 1024 * 1024 * 10);
        	return $this->convert_memory_size($memory_usage_convert);
        }



	    /**
	     * Convert Memory Size
	     *
	     * @param [type] $size
	     *
	     * @return void
	     */
	    public function convert_memory_size($size)
	    {

	        $l = substr($size, -1);
	        $ret = substr($size, 0, -1);

	        switch (strtoupper($l)) {
	            case 'P':
	                $ret *= 1024;
	            case 'T':
	                $ret *= 1024;
	            case 'G':
	                $ret *= 1024;
	            case 'M':
	                $ret *= 1024;
	            case 'K':
	                $ret *= 1024;
	        }

	        return $ret;
	    }



        /**
         * Returns the singleton instance of the class.
         */

        public static function get_instance()
        {
            if (!isset(self::$instance) && !(self::$instance instanceof JLT_IUSL)) {
                self::$instance = new JLT_IUSL();
            }

            return self::$instance;
        }        
    }


    JLT_IUSL::get_instance();
}
