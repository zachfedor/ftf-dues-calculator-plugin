<?php
/*
Plugin Name: FTF Dues Calculator
Plugin URI: https://github.com/zachfedor/ftf-dues-calculator
Description: An embedded calculator to show a member's dues based on their yearly sales.
Version: 1.0.0
Author: Zach Fedor
Author URI: https://zachfedor.me/
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
GitHub Plugin URI: https://github.com/zachfedor/ftf-dues-calculator
GitHub Branch: main
*/

/**
 * custom option and settings
 */
function ftfdc_settings_init() {
    // Register Dues Calculator Settings
    register_setting( 'ftfdc', 'ftfdc_options' );

    // Register Appearance Section
    add_settings_section(
        'ftfdc_section_appearance',
        __( 'Appearance', 'ftfdc' ), 'ftfdc_section_appearance_callback',
        'ftfdc'
    );

    // Register Hide Widget Field
    add_settings_field(
        'ftfdc_field_hide', // As of WP 4.6 this value is used only internally.
                                // Use $args' label_for to populate the id inside the callback.
            __( 'Hide Widget', 'ftfdc' ),
        'ftfdc_field_hide_cb',
        'ftfdc',
        'ftfdc_section_appearance',
        array(
            'label_for'         => 'ftfdc_field_hide',
            'class'             => 'ftfdc_row',
        )
    );

    // Register Input Label Field
    add_settings_field(
        'ftfdc_field_input_label',
            __( 'Input Label', 'ftfdc' ),
        'ftfdc_field_input_label_cb',
        'ftfdc',
        'ftfdc_section_appearance',
        array(
            'label_for'         => 'ftfdc_field_input_label',
            'class'             => 'ftfdc_row',
        )
    );

    // Register Output Label Field
    add_settings_field(
        'ftfdc_field_output_label',
            __( 'Output Label', 'ftfdc' ),
        'ftfdc_field_output_label_cb',
        'ftfdc',
        'ftfdc_section_appearance',
        array(
            'label_for'         => 'ftfdc_field_output_label',
            'class'             => 'ftfdc_row',
        )
    );

    // Register Equation Section
    add_settings_section(
        'ftfdc_section_equation',
        __( 'Equation', 'ftfdc' ), 'ftfdc_section_equation_callback',
        'ftfdc'
    );


    // Register Hide Widget Field
    add_settings_field(
        'ftfdc_field_equation',
            __( 'Calculate Dues', 'ftfdc' ),
        'ftfdc_field_equation_cb',
        'ftfdc',
        'ftfdc_section_equation',
        array(
            'label_for'         => 'ftfdc_field_equation',
        )
    );
}

/**
 * Register our ftfdc_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'ftfdc_settings_init' );


/**
 * Appearance section callback function.
 * @param array $args  The settings array, defining title, id, callback.
 */
function ftfdc_section_appearance_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Customize the appearance of the dues calculator widget.', 'ftfdc' ); ?></p>
    <?php
}

/**
 * Callback function for Hide Widget field
 * @param array $args
 */
function ftfdc_field_hide_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'ftfdc_options' );
    ?>
    <input type="checkbox"
           id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="ftfdc_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="1"
           <?php echo isset( $options[ $args['label_for'] ] ) ? ( checked( $options[ $args['label_for'] ], 1, false ) ) : ( '' ); ?>
    />
    <p class="description">
        <?php esc_html_e( 'If checked, the widget will be hidden from users. This is helpful for maintenance without needing to deactivate the plugin.', 'ftfdc' ); ?>
    </p>
    <?php
}

/**
 * Callback function for Input Label field
 * @param array $args
 */
function ftfdc_field_input_label_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'ftfdc_options' );
    ?>
    <input type="text"
           id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="ftfdc_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo isset( $options[ $args['label_for'] ] ) ? ( $options[ $args['label_for'] ] ) : ( '' ); ?>"
    />
    <p class="description">
        <?php esc_html_e( 'Text shown above the sales input field.', 'ftfdc' ); ?>
    </p>
    <?php
}

/**
 * Callback function for Output Label field
 * @param array $args
 */
function ftfdc_field_output_label_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'ftfdc_options' );
    ?>
    <input type="text"
           id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="ftfdc_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo isset( $options[ $args['label_for'] ] ) ? ( $options[ $args['label_for'] ] ) : ( '' ); ?>"
    />
    <p class="description">
        <?php esc_html_e( 'Text shown above the dues output field.', 'ftfdc' ); ?>
    </p>
    <?php
}

/**
 * Equation section callback function.
 * @param array $args  The settings array, defining title, id, callback.
 */
function ftfdc_section_equation_callback( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Change the dues calculator equation.', 'ftfdc' ); ?></p>
    <?php
}

/**
 * Callback function for Equation field
 * @param array $args
 */
function ftfdc_field_equation_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'ftfdc_options' );
    ?>
    <textarea id="<?php echo esc_attr( $args['label_for'] ); ?>"
              name="ftfdc_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
              cols="50" rows="10"
              style="font-family:monospace;"
    >
    <?php echo isset( $options[ $args['label_for'] ] ) ? ( $options[ $args['label_for'] ] ) : ( '' ); ?>
    </textarea>
    <p class="description">
        This must be a valid JavaScript function body that returns a number
        which will be formatted and inserted into the page. The variable <code>sales</code> is the
        user entered number value.
    </p>
    <p class="description">
        <strong>WARNING:</strong> If this equation is not formed correctly, the Dues Calculator will
        output an &quot;Error Message&quot;. You can copy and paste the code below to return to the original
        equation.</em>
    </p>
    <details>
        <summary>Code Sample</summary>
        <pre><code style="border:1px solid #8c8f94;border-radius:4px;display:block;padding:1rem;">let dues;
if (sales < 125000) {
  dues = 400;
} else if (sales < 2000000) {
  dues = (sales * 0.0015) + 250;
} else {
  dues = ((sales - 2000000) * 0.0001) + 3000;
}

return Math.min(10000, dues);</code></pre>
    </details>
    <?php
}

if ( ! function_exists( 'ftfdc_options_page_html' ) ) {
    function ftfdc_options_page_html() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output security fields for the registered setting "ftfdc_options"
                settings_fields( 'ftfdc' );
                // output setting sections and their fields
                // (sections are registered for "ftfdc", each field is registered to a specific section)
                do_settings_sections( 'ftfdc' );
                // output save settings button
                submit_button( __( 'Save Settings', 'textdomain' ) );
                ?>
            </form>
        </div>
        <?php
    }
}

if ( ! function_exists( 'ftfdc_options_page' ) ) {
    function ftfdc_options_page() {
        add_submenu_page(
            'tools.php',
            'Dues Calculator',
            'Dues Calculator',
            'manage_options',
            'ftfdc',
            'ftfdc_options_page_html'
        );
    }

    add_action('admin_menu', 'ftfdc_options_page');
}


if ( ! function_exists( 'ftfdc_shortcode' ) ) {
    function ftfdc_shortcode() {
        $options = get_option( 'ftfdc_options' );
        var_dump($options);
        if (isset( $options['ftfdc_field_hide'] )) {
           return '<div class="ftfdc-container-hidden" style="display:none;"></div>';
        }

        $_return = '<div class="ftfdc-container">
        <div class="ftfdc-input_container">
            <label class="ftfdc-input_label">
' . ( isset( $options["ftfdc_field_input_label"] ) ? $options["ftfdc_field_input_label"] : "Annual Gross Sales" ) .'
            </label>
            <div class="ftfdc-input_group">
                <span class="ftfdc-input_pre">$</span>
                <input class="ftfdc-input" placeholder="100,000.00"/>
            </div>
        </div>
        <div class="ftfdc-input_container">
            <label class="ftfdc-input_label">
'. ( isset( $options["ftfdc_field_output_label"] ) ? $options["ftfdc_field_output_label"] : "Estimated Dues" ) .'
            </label>
            <p class="ftfdc-dues">$0.00</p>
        </div>
    </div>
    <script type="text/javascript">
    (function() {
    function calculateDues(sales) {
        /**
         * Original Equation
        let dues;
        if (sales < 125000) dues = 400;
        else if (sales < 2000000) {
        dues = (sales * 0.0015) + 250;
        } else {
        dues = ((sales - 2000000) * 0.0001) + 3000;
        }

        return Math.min(10000, dues);
        */
'. ( isset( $options["ftfdc_field_equation"] ) ? $options["ftfdc_field_equation"] : "" ) .'
    }

    function updateDues(event) {
        const sales = Number(event.target.value.replaceAll(",", ""));
        const formatter = Intl.NumberFormat("en-US", {style: "currency", currency: "USD"});

        const dues = Number.isNaN(sales)
            ? "Please enter a valid number"
            : formatter.format(calculateDues(sales));

        document.querySelector(".ftfdc-dues").textContent = dues === "$NaN" ? "Error" : dues;
    }

    document.querySelector(".ftfdc-input").addEventListener("input", updateDues);
    })()
    </script>';

        return $_return;
    }

    add_shortcode('dues_calculator', 'ftfdc_shortcode');
}


// Add styles to head
if ( ! function_exists( 'ftfdc_css' ) ) {
    function ftfdc_css() {
        echo "
        <style type='text/css'>
        .ftfdc-container {
            font-size: 1.3rem;
            margin: 2rem auto;
            max-width: 400px;
            text-align: center;
        }
        .ftfdc-container .ftfdc-input_container {
            margin-bottom: 1rem;
        }
        .ftfdc-container .ftfdc-input_label {
            display: block;
            font-weight: bold;
            margin: 0;
            padding-bottom: 0.5rem;
        }
        .ftfdc-container .ftfdc-input_group {
            position: relative;
        }
        .ftfdc-container .ftfdc-input_pre {
            line-height: 48px;
            opacity: 0.5;
            position: absolute;
            width: 60px;
            z-index: 1;
        }
        .ftfdc-container .ftfdc-input {
            background: #fff;
            border: 1px solid #f2f2f2;
            border-radius: 40px;
            box-shadow: 0 1px 1px rgb(0 0 0 / 20%);
            font-size: 1.1rem;
            font-family: open sans, Arial, Helvetica, sans-serif;
            height: 48px;
            padding: 0 40px;
            width: 100%;
            text-align: center;
        }
        </style>
        ";
    }

    add_action( 'wp_head', 'ftfdc_css' );
}
