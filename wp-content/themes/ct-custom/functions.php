<?php
/**
 * CT Custom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CT_Custom
 */

if ( ! function_exists( 'ct_custom_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ct_custom_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CT Custom, use a find and replace
		 * to change 'ct-custom' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ct-custom', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ct-custom' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ct_custom_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ct_custom_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ct_custom_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ct_custom_content_width', 640 );
}
add_action( 'after_setup_theme', 'ct_custom_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ct_custom_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ct-custom' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ct-custom' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ct_custom_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ct_custom_scripts() {
	wp_enqueue_style( 'ct-custom-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ct-custom-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'ct-custom-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_custom_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            'Theme Settings',
            'manage_options',
            'my-setting-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1>Theme Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Coalition Test Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );

        add_settings_field(
            'phone_number', // ID
            'Phone Number', // Title
            array( $this, 'phone_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'address',
            'Address Information',
            array( $this, 'address_callback' ),
            'my-setting-admin',
            'setting_section_id'
        );
				add_settings_field(
            'fax_number', // ID
            'Fax Number', // Title
            array( $this, 'fax_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );
				add_settings_field(
            'facebook_link', // ID
            'Facebook Link', // Title
            array( $this, 'facebook_link_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );
				add_settings_field(
            'twitter_link', // ID
            'Twitter Link', // Title
            array( $this, 'twitter_link_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );
				add_settings_field(
            'linkedin_link', // ID
            'Linkedin Link', // Title
            array( $this, 'linkedin_link_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );
				add_settings_field(
            'pinterest_link', // ID
            'Pinterest Link', // Title
            array( $this, 'pinterest_link_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['phone_number'] ) )
            $new_input['phone_number'] = sanitize_text_field( $input['phone_number'] );

        if( isset( $input['address'] ) )
            $new_input['address'] = ( $input['address'] );

				if( isset( $input['fax_number'] ) )
		            $new_input['fax_number'] = sanitize_text_field( $input['fax_number'] );

				if( isset( $input['facebook_link'] ) )
										$new_input['facebook_link'] = sanitize_text_field( $input['facebook_link'] );

				if( isset( $input['twitter_link'] ) )
												$new_input['twitter_link'] = sanitize_text_field( $input['twitter_link'] );

				if( isset( $input['linkedin_link'] ) )
														$new_input['linkedin_link'] = sanitize_text_field( $input['linkedin_link'] );

				if( isset( $input['pinterest_link'] ) )
																$new_input['pinterest_link'] = sanitize_text_field( $input['pinterest_link'] );
        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function phone_number_callback()
    {
        printf(
            '<input type="text" id="phone_number" name="my_option_name[phone_number]" value="%s" />',
            isset( $this->options['phone_number'] ) ? esc_attr( $this->options['phone_number']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function address_callback()
    {
        printf(
            '<input type="text" id="address" name="my_option_name[address]" value="%s" />',
            isset( $this->options['address'] ) ? ( $this->options['address']) : ''
        );
    }

		public function fax_number_callback()
    {
        printf(
            '<input type="text" id="fax_number" name="my_option_name[fax_number]" value="%s" />',
            isset( $this->options['fax_number'] ) ? esc_attr( $this->options['fax_number']) : ''
        );
    }

		public function facebook_link_callback()
		{
				printf(
						'<input type="text" id="facebook_link" name="my_option_name[facebook_link]" value="%s" />',
						isset( $this->options['facebook_link'] ) ? esc_attr( $this->options['facebook_link']) : ''
				);
		}

		public function twitter_link_callback()
    {
        printf(
            '<input type="text" id="twitter_link" name="my_option_name[twitter_link]" value="%s" />',
            isset( $this->options['twitter_link'] ) ? esc_attr( $this->options['twitter_link']) : ''
        );
    }

		public function linkedin_link_callback()
    {
        printf(
            '<input type="text" id="linkedin_link" name="my_option_name[linkedin_link]" value="%s" />',
            isset( $this->options['linkedin_link'] ) ? esc_attr( $this->options['linkedin_link']) : ''
        );
    }

		public function pinterest_link_callback()
    {
        printf(
            '<input type="text" id="pinterest_link" name="my_option_name[pinterest_link]" value="%s" />',
            isset( $this->options['pinterest_link'] ) ? esc_attr( $this->options['pinterest_link']) : ''
        );
    }

}

if( is_admin() )
    $my_settings_page = new MySettingsPage();

		add_theme_support( 'custom-logo' );

		function themename_custom_logo_setup() {
    $defaults = array(
        'height'               => 40,
        'width'                => 175,
        'flex-height'          => true,
        'flex-width'           => true,
        'header-text'          => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo' => true,
    );

    add_theme_support( 'custom-logo', $defaults );
}
