<?php
class Admin{

    /**
     * Renders Woocommerce Fields
     * @author : Tsviel Zaikman
     * @since : 1.0
     **/
    private function wcdcp_fields() {
        $fields = array(
            'section_title-enable' => array(
                'name'     => __( 'Disable cart page', 'disable-cart-page-for-woocommerce' ),
                'type'     => 'title',
                'desc'     => __( 'Enabling this option will delete the cart page and for each purchase customers will be redirected directly to the checkout. They will also be able to buy one type of product at a time.', 'disable-cart-page-for-woocommerce' )
            ),
            'wcdcp_enable' => array(
                'name' => __( 'Enable', 'disable-cart-page-for-woocommerce' ),
                'type' => 'checkbox',
                'desc' => __( 'Disable cart page and redirect directly to checkout', 'disable-cart-page-for-woocommerce' ),
                'id'   => 'wcdcp_enable'
            ),
            'section_end-enable' => array(
                'type' => 'sectionend'
            )
        );

        return apply_filters( 'wcdcp_fields', $fields );
    }
}

?>