<?php
/*
  Plugin Name: Woo Bulk Products
  Plugin URI: https://github.com/casserlyprogramming/woobulk
  Description: Bulk products for Woocommerce
  Version: 1.0.0
  Author: Daniel Casserly
  Author URI: http://dandalfprogramming.blogspot.co.uk/
 */


if (!defined('ABSPATH'))
    exit; // Exit 

// Actions
add_action('init', 'wbp_register_bulk_product_type');
add_action('product_type_selector', 'wbp_add_bulk_product_to_list');
add_action('admin_footer', 'wbp_bulk_product_js');

// Filters
add_filter('woocommerce_product_data_tabs', 'wpb_custom_product_tabs');


// Functions

// The new product type...
function wbp_register_bulk_product_type() {

    class WPB_Product_Bulk extends WC_Product_Simple {
        public function __construct( $product ) {
            $this->product_type = 'bulk_product';
            parent::__construct( $product );
        }
    }

}

// Add the new product to the product selector
function wbp_add_bulk_product_to_list( $types ) {
    $types[ 'bulk_product' ] = __( 'Bulk Product', 'wbp');
    return $types;
}

function wbp_bulk_product_js() {
    if( 'product' != get_post_type() ){
        return;
    }
?>
    <script type='text/javascript'>
    jQuery(document).ready(function(){
        jQuery('.options_group.pricing').addClass('show_if_bulk_product').show();
    });
    </script>

<?php
}

function wbp_custom_product_tabs( $tabs ) {
    $tabs['bulk'] = array(
        'label' => __('Bulk', 'wpb'),
        'target' => 'wpb_options',
        'class' => array('show_if_bulk_product'),
    );
}


function wpb_custom_admin_style() {
?>
<style>
    #woocommerce-product-data ul.wc-tabs li.wpb_options a:before
    {   
        font-family: WooCommerce; content: '\e002';
    }
</style>
<?php
}

// 










