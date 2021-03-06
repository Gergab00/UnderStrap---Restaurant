<?php
/**
 * PRO Breadrumbs check for pages.
 *
 * @package understrap-builder
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
if(!is_user_logged_in() && get_option('usblkv')!='1'){return'';}

// Load Customizer breadrumbs display check before loading everything else
$understrap_builder_breadcrumbs_home_page = get_option( 'understrap_builder_breadcrumbs_home_page', '');
$understrap_builder_hero_layout = get_option( 'understrap_builder_hero_layout', 'disabled');

global $builder_default_spacings;
$understrap_builder_spacings_breadcrumbs_wrapper = get_option( 'understrap_builder_spacings_breadcrumbs_wrapper', $builder_default_spacings );
$understrap_builder_spacings_breadcrumbs_element = get_option( 'understrap_builder_spacings_breadcrumbs_element', $builder_default_spacings );

// Check to see if we should show breadcrumbs on this page
$us_b_show_below_nav_bread = true;
if(is_front_page() && $understrap_builder_breadcrumbs_home_page == 'hide'){ $us_b_show_below_nav_bread = false; } // Its home page and thats been disabled
if(is_front_page() && $understrap_builder_breadcrumbs_home_page == '' && $understrap_builder_hero_layout != 'disabled'){ $us_b_show_below_nav_bread = false; } // Home page and no hero


if($us_b_show_below_nav_bread){ /* PRO Breadcrumbs below navbar */
  
  // Load Customizer variables
  $understrap_builder_container_type = get_option( 'understrap_builder_container_type', 'container');
  $understrap_builder_container_page_type = get_option( 'understrap_builder_container_page_type', 'default');
  $understrap_builder_breadcrumbs_container = get_option( 'understrap_builder_breadcrumbs_container', 'default');
  $understrap_builder_breadcrumbs_page_bg = get_option( 'understrap_builder_breadcrumbs_page_bg', '');
  $understrap_builder_breadcrumbs_page_align = get_option( 'understrap_builder_breadcrumbs_page_align', 'left');

  
  // Handle container
  if($understrap_builder_container_page_type != 'default'){
    $understrap_builder_container_type = $understrap_builder_container_page_type;
  }
  $us_b_breadcrumbs_container = $understrap_builder_container_type;
  if($understrap_builder_breadcrumbs_container != 'default'){
    $us_b_breadcrumbs_container = $understrap_builder_breadcrumbs_container;
  }

  
  // Handle background color
  $us_b_override_bg_color = '';
  if($understrap_builder_breadcrumbs_page_bg != ''){
    $us_b_override_bg_color = ' bg-'.$understrap_builder_breadcrumbs_page_bg;
  }

  
  // Handle alignment
  $us_b_override_alignment = '';
  if($understrap_builder_breadcrumbs_page_align != ''){
    $us_b_override_alignment = ' justify-content-'.$understrap_builder_breadcrumbs_page_align;
  }

  
  // Open the breadcrumbs wrapper
  ?>
  <div class="wrapper <?php echo esc_attr(understrap_builder_spacings_handler($understrap_builder_spacings_breadcrumbs_wrapper)); ?>" id="breadcrumbs-wrapper">
    <div class="<?php echo esc_attr( $us_b_breadcrumbs_container ); ?>">
      <div class="row">
        <div class="col-12 <?php echo esc_attr(understrap_builder_spacings_handler($understrap_builder_spacings_breadcrumbs_element)); ?>" id="us_b_breadcrumbs">
        <?php

        // Handle showing and default message for breadcrumbs
        $us_b_breadcrumbs_show = false;


        // BUILDER - Check for Breadcrumb NavXT
        if(function_exists('bcn_display_list')){ $us_b_breadcrumbs_show = true; ?>
          <nav class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/" aria-label="breadcrumb">
            <ol class="breadcrumb<?php echo esc_attr($us_b_override_bg_color.$us_b_override_alignment); ?>">
              <?php bcn_display_list();?>
            </ol>
          </nav>
        <?php }


        // BUILDER - Check for Breadcrumb Yoast
        if(function_exists('yoast_breadcrumb') && function_exists('understrap_builder_yoast_breadcrumb')){ $us_b_breadcrumbs_show = true; ?>
          <ul class="breadcrumb<?php echo esc_attr($us_b_override_bg_color.$us_b_override_alignment); ?>"><?php
          understrap_builder_yoast_breadcrumb();
          ?></ul><?php
        }


        // BUILDER no breadrumb plugin active
        if(!$us_b_breadcrumbs_show){
          ?>
          <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">No Breadcrumbs Detected</h4>
            <hr>
            Be sure you have installed, activated and set up one of the supported breadcrumb plugins mentioned in the Customizer.
          </div>
          <?php
        }

       ?></div>
      </div>
    </div>
  </div>
<?php } ?>