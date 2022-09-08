<?php
/**
 * WooCommerce Options for Astra Theme.
 *
 * @package     Astra
 * @author      Astra
 * @copyright   Copyright (c) 2020, Astra
 * @link        https://wpastra.com/
 * @since       Astra 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Astra_Woo_Shop_Layout_Configs' ) ) {

	/**
	 * Customizer Sanitizes Initial setup
	 */
	class Astra_Woo_Shop_Layout_Configs extends Astra_Customizer_Config_Base {

		/**
		 * Register Astra-WooCommerce Shop Layout Customizer Configurations.
		 *
		 * @param Array                $configurations Astra Customizer Configurations.
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @since 1.4.3
		 * @return Array Astra Customizer Configurations with updated configurations.
		 */
		public function register_configuration( $configurations, $wp_customize ) {

			/** @psalm-suppress UndefinedClass */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort
			$astra_addon_with_woo = ( astra_has_pro_woocommerce_addon() ) ? true : false;
			/** @psalm-suppress UndefinedClass */ // phpcs:ignore Generic.Commenting.DocComment.MissingShort

			if ( $astra_addon_with_woo ) {
				$current_shop_layouts = array(
					'shop-page-grid-style'   => array(
						'label' => __( 'Design 1', 'astra' ),
						'path'  => ( class_exists( 'Astra_Builder_UI_Controller' ) ) ? Astra_Builder_UI_Controller::fetch_svg_icon( 'shop-grid-view', false ) : '',
					),
					'shop-page-modern-style' => array(
						'label' => __( 'Design 2', 'astra' ),
						'path'  => ( class_exists( 'Astra_Builder_UI_Controller' ) ) ? Astra_Builder_UI_Controller::fetch_svg_icon( 'shop-modern-view', false ) : '',
					),
					'shop-page-list-style'   => array(
						'label' => __( 'Design 3', 'astra' ),
						'path'  => ( class_exists( 'Astra_Builder_UI_Controller' ) ) ? Astra_Builder_UI_Controller::fetch_svg_icon( 'shop-list-view', false ) : '',
					),
				);
			} else {
				$current_shop_layouts = array(
					'shop-page-grid-style'   => array(
						'label' => __( 'Design 1', 'astra' ),
						'path'  => ( class_exists( 'Astra_Builder_UI_Controller' ) ) ? Astra_Builder_UI_Controller::fetch_svg_icon( 'shop-grid-view', false ) : '',
					),
					'shop-page-modern-style' => array(
						'label' => __( 'Design 2', 'astra' ),
						'path'  => ( class_exists( 'Astra_Builder_UI_Controller' ) ) ? Astra_Builder_UI_Controller::fetch_svg_icon( 'shop-modern-view', false ) : '',
					),
				);
			}

			$_configs = array(

				/**
				 * Option: Context for shop archive section.
				 */
				array(
					'name'        => 'section-woocommerce-shop-context-tabs',
					'section'     => 'woocommerce_product_catalog',
					'type'        => 'control',
					'control'     => 'ast-builder-header-control',
					'priority'    => 0,
					'description' => '',
				),

				/**
				* Option: Divider
				*/
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[shop-box-styling]',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Shop Card Styling', 'astra' ),
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 229,
					'settings' => array(),
					'context'  => array(
						Astra_Builder_Helper::$design_tab_config,
					),
					'divider'  => array( 'ast_class' => 'ast-section-spacing' ),
				),

				/**
				 * Option: Content Alignment
				 */
				array(
					'name'       => ASTRA_THEME_SETTINGS . '[shop-product-align-responsive]',
					'default'    => astra_get_option( 'shop-product-align-responsive' ),
					'type'       => 'control',
					'control'    => 'ast-selector',
					'section'    => 'woocommerce_product_catalog',
					'priority'   => 229,
					'title'      => __( 'Horizontal Content Alignment', 'astra' ),
					'responsive' => true,
					'choices'    => array(
						'align-left'   => 'align-left',
						'align-center' => 'align-center',
						'align-right'  => 'align-right',
					),
					'context'    => array(
						Astra_Builder_Helper::$design_tab_config,
					),
					'divider'    => ! defined( 'ASTRA_EXT_VER' ) ? array( 'ast_class' => 'ast-section-spacing' ) : array( 'ast_class' => 'ast-bottom-section-divider ast-section-spacing' ),
				),

				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[woo-shop-structure-divider]',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Shop Card Structure', 'astra' ),
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 15,
					'settings' => array(),
					'divider'  => array( 'ast_class' => 'ast-section-spacing' ),
				),

				/**
				 * Option: Single Post Meta
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[shop-product-structure]',
					'type'              => 'control',
					'control'           => 'ast-sortable',
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_multi_choices' ),
					'section'           => 'woocommerce_product_catalog',
					'default'           => astra_get_option( 'shop-product-structure' ),
					'priority'          => 15,
					'choices'           => array(
						'title'      => __( 'Title', 'astra' ),
						'price'      => __( 'Price', 'astra' ),
						'ratings'    => __( 'Ratings', 'astra' ),
						'short_desc' => __( 'Short Description', 'astra' ),
						'add_cart'   => __( 'Add To Cart', 'astra' ),
						'category'   => __( 'Category', 'astra' ),
					),
					'divider'           => array( 'ast_class' => 'ast-section-spacing' ),
				),


				/**
				 * Option: Divider
				 */
				array(
					'name'     => ASTRA_THEME_SETTINGS . '[woo-shop-skin-divider]',
					'section'  => 'woocommerce_product_catalog',
					'title'    => __( 'Shop Layout', 'astra' ),
					'type'     => 'control',
					'control'  => 'ast-heading',
					'priority' => 7,
					'settings' => array(),
					'divider'  => array( 'ast_class' => 'ast-section-spacing' ),
				),

				/**
				 * Option: Choose Product Style
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[shop-style]',
					'default'           => astra_get_option( 'shop-style' ),
					'type'              => 'control',
					'section'           => 'woocommerce_product_catalog',
					'title'             => __( 'Shop Card Design', 'astra' ),
					'control'           => 'ast-radio-image',
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_choices' ),
					'priority'          => 8,
					'choices'           => $current_shop_layouts,
					'divider'           => array( 'ast_class' => 'ast-section-spacing ast-bottom-section-divider' ),
				),

				/**
				 * Option: Shop Columns
				 */
				array(
					'name'              => ASTRA_THEME_SETTINGS . '[shop-grids]',
					'type'              => 'control',
					'control'           => 'ast-responsive-slider',
					'sanitize_callback' => array( 'Astra_Customizer_Sanitizes', 'sanitize_responsive_slider' ),
					'section'           => 'woocommerce_product_catalog',
					'default'           => astra_get_option(
						'shop-grids',
						array(
							'desktop' => 4,
							'tablet'  => 3,
							'mobile'  => 2,
						)
					),
					'priority'          => 9,
					'title'             => __( 'Shop Columns', 'astra' ),
					'input_attrs'       => array(
						'step' => 1,
						'min'  => 1,
						'max'  => 6,
					),
					'divider'           => array( 'ast_class' => 'ast-bottom-section-divider' ),
				),

				/**
				 * Option: Products Per Page
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-no-of-products]',
					'type'        => 'control',
					'section'     => 'woocommerce_product_catalog',
					'title'       => __( 'Products Per Page', 'astra' ),
					'default'     => astra_get_option( 'shop-no-of-products' ),
					'control'     => 'number',
					'priority'    => 9,
					'input_attrs' => array(
						'min'  => 1,
						'step' => 1,
						'max'  => 100,
					),
				),

				/**
				 * Option: Shop Archive Content Width
				 */
				array(
					'name'       => ASTRA_THEME_SETTINGS . '[shop-archive-width]',
					'type'       => 'control',
					'control'    => 'ast-selector',
					'section'    => 'woocommerce_product_catalog',
					'default'    => astra_get_option( 'shop-archive-width' ),
					'priority'   => 9,
					'title'      => __( 'Shop Archive Content Width', 'astra' ),
					'choices'    => array(
						'default' => __( 'Default', 'astra' ),
						'custom'  => __( 'Custom', 'astra' ),
					),
					'transport'  => 'refresh',
					'renderAs'   => 'text',
					'responsive' => false,
					'divider'    => $astra_addon_with_woo ? array( 'ast_class' => 'ast-top-section-divider' ) : array( 'ast_class' => 'ast-section-spacing' ),
				),

				/**
				 * Option: Enter Width
				 */
				array(
					'name'        => ASTRA_THEME_SETTINGS . '[shop-archive-max-width]',
					'type'        => 'control',
					'control'     => 'ast-slider',
					'section'     => 'woocommerce_product_catalog',
					'default'     => astra_get_option( 'shop-archive-max-width' ),
					'priority'    => 9,
					'title'       => __( 'Custom Width', 'astra' ),
					'transport'   => 'postMessage',
					'suffix'      => 'px',
					'input_attrs' => array(
						'min'  => 768,
						'step' => 1,
						'max'  => 1920,
					),
					'context'     => array(
						Astra_Builder_Helper::$general_tab_config,
						array(
							'setting'  => ASTRA_THEME_SETTINGS . '[shop-archive-width]',
							'operator' => '===',
							'value'    => 'custom',
						),
					),
					'divider'     => array( 'ast_class' => 'ast-top-dotted-divider' ),
				),
			);

			// Learn More link if Astra Pro is not activated.
			if ( ! defined( 'ASTRA_EXT_VER' ) && astra_showcase_upgrade_notices() ) {
				$_configs[] = array(
					'name'     => ASTRA_THEME_SETTINGS . '[ast-woo-shop-pro-items]',
					'type'     => 'control',
					'control'  => 'ast-upgrade',
					'renderAs' => 'list',
					'choices'  => array(
						'two'   => array(
							'title' => __( 'Shop Design Layout 3', 'astra' ),
						),
						'three' => array(
							'title' => __( 'Shop Toolbar Structure', 'astra' ),
						),
						'five'  => array(
							'title' => __( 'Offcanvas Filter Sidebar', 'astra' ),
						),
						'six'   => array(
							'title' => __( 'Products Quick View', 'astra' ),
						),
						'seven' => array(
							'title' => __( 'Shop Pagination', 'astra' ),
						),
						'eight' => array(
							'title' => __( 'More Typography Options', 'astra' ),
						),
						'nine'  => array(
							'title' => __( 'More Color Options', 'astra' ),
						),
						'ten'   => array(
							'title' => __( 'More Spacing Options', 'astra' ),
						),
						'four'  => array(
							'title' => __( 'Box Shadow Design Options', 'astra' ),
						),
						'one'   => array(
							'title' => __( 'More Design Controls', 'astra' ),
						),
					),
					'section'  => 'woocommerce_product_catalog',
					'default'  => '',
					'priority' => 999,
					'title'    => __( 'With Astra Pro get more features for your Ecommerce Shop!', 'astra' ),
					'divider'  => array( 'ast_class' => 'ast-top-section-divider' ),
					'context'  => array(),
				);
			}

			$configurations = array_merge( $configurations, $_configs );

			return $configurations;

		}
	}
}

new Astra_Woo_Shop_Layout_Configs();

