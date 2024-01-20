<?php
function vadi_faq_shortcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
		"limit" => '',
		"category" => '',
		"morethenoneopen"   => '',
		"transition_speed" => '',
		"transition_type" => '',
		"orderby" => '',
		"order" => '',
		"design" => '',
		"background_color" => '',
		"border_color" => '',
		"font_color" => '',
		"active_bg_color" => '',
		"active_title_color" => '',
		"icon_type" => '',
		"icon_position" => '',
		"icon_color" => '',
		"qa" => '',
		"q_text" => '',
		"q_text_bg" => '',
		"q_font_color" => '',
		"a_text" => '',
		"a_text_bg" => '',
		"a_font_color" => '',
	), $atts));

	if( $limit ) { 
		$posts_per_page = $limit; 
	} else {
		$posts_per_page = '-1';
	}

	if( $category ) { 
		$cat = $category; 
	} else {
		$cat = '';
	}
	
	if( $orderby != '' ) { 
		if( $orderby == 'date' ) { $orderby = 'post_date';} elseif( $orderby == 'order' )  {$orderby = 'faq_order';}
		$faqorderby = $orderby; 
	} else {
		$faqorderby = 'post_date';
	}
	
	if( $order != '' ) { 
		$faqorder = $order; 
	} else {
		$faqorder = 'DESC';
	}

	if( $morethenoneopen != ''  ) { 
		if( $morethenoneopen == 'true' ) { $faqopen = 'false';} elseif( $morethenoneopen == 'false' )  {$faqopen = 'true';}
	} else {
		$faqopen = 'true';
	}
	if( $transition_speed != '' ) { 
		$faqtransitionSpeed = $transition_speed;
	} else {
		$faqtransitionSpeed = 300;
	}
	if( $transition_type != '' ) { 
		$transition_type = $transition_type;
	} else {
		$transition_type = 'ease';
	}
	if( $design != '' ) {  
		$faqdesign =  "vfq_accordion_design$design"; 
	} else {
		$faqdesign =  ""; 
	}
	if( $active_bg_color != '' ) {  
		$faqactive_bg_color =  "$active_bg_color"; 
	} else {
		$faqactive_bg_color =  "#fff"; 
	}
	if( $active_title_color != '' ) {  
		$faqactive_title_color =  "$active_title_color"; 
	} else {
		$faqactive_title_color =  "#333"; 
	}
	$icontypecolor = ' '; 
	if( $icon_type == 'plus') { 
		$icontypecolor .= ' icon-plus '; 
	}
	if( $icon_color == 'white') { 
		$icontypecolor .= ' icon-white '; 
	}
	if( $icon_position == 'left') { 
		$iconposition = ' icon-left-position '; 
	} else{
		$iconposition = ' '; 
	}

	if( $q_text ) { $qtext = $q_text; } else {$qtext = 'Q'; }
	if( $q_text_bg ) { $qtextbg = $q_text_bg; } else {$qtextbg = '#c43c35'; }
	if( $q_font_color ) { $qfontcolor = $q_font_color; } else {$qfontcolor = '#000'; }

	if( $a_text ) { $atext = $a_text; } else {$atext = 'A'; }
	if( $a_text_bg ) { $atextbg = $a_text_bg; } else {$atextbg = '##008800'; }
	if( $a_font_color ) { $afontcolor = $a_font_color; } else {$afontcolor = '#000'; }
	
	ob_start();
	// Create the Query
	
	$post_type 		= 'vadi_faq';
				 
        $args = array ( 
		'post_status' => 'publish',
            'post_type'      => $post_type, 
            'posts_per_page' => $posts_per_page,           
            );
		if($faqorderby == 'faq_order'){
			$args['orderby']  = array( 'meta_value_num' => $faqorder );
			$args['meta_key'] = 'faq_order';
		} else {
            $args['orderby'] = $faqorderby; 
            $args['order']   = $faqorder;
		}	
		//echo '<pre>'; print_r($args); exit;	

	if($cat != ""){
            	$args['tax_query'] = array( array( 'taxonomy' => 'vadi_faq_cat', 'field' => 'term_id', 'terms' => $cat) );
            }        
      $query = new WP_Query($args);
	//Get post type count
	$post_count = $query->post_count;
		STATIC $i = 1;
	// Displays Custom post info
	if( $post_count > 0) :
?>
	<style>
    #vadi_faq<?php echo $i;?> .vfq_main {
	<?php if($border_color != '') echo "border-color:$border_color;";?>	
	<?php if($background_color != '') echo "background-color:$background_color;";?>	
	}
	#vadi_faq<?php echo $i;?> .vfq_main .vfq_title{ <?php if($font_color != '') echo "color:$font_color;";?>}

	#vadi_faq<?php echo $i;?> .vfq_main.open{
		<?php if($faqactive_bg_color != '') echo "background:$faqactive_bg_color;"; else echo "background:#fff"; ?> }
	#vadi_faq<?php echo $i;?> .vfq_main.open .vfq_title{
		<?php if($faqactive_title_color != '') echo "color:$faqactive_title_color;"; else echo "color:#333"; ?> }
	<?php if($qa == 'yes'){?>
	#vadi_faq<?php echo $i;?> .vfq_main .question{ background:<?php echo $qtextbg;?>; color:<?php echo $qfontcolor;?>;}
	#vadi_faq<?php echo $i;?> .vfq_main .answer{ background:<?php echo $atextbg;?>; color:<?php echo $afontcolor;?>;}
	<?php } ?>

    </style>
<?php
$customdesign ='';
if($border_color != '' or $background_color != '' or $font_color != '' or $faqactive_bg_color != '' or $faqactive_title_color != ''){ $customdesign = 'custom';}
	
	?>
	<div id="vfq_accordion" vfq_group class="<?php  echo $icontypecolor;?>">
      <div id="vadi_faq<?php echo $i;?>" class="vadi_faq<?php echo $i;?>  <?php  echo $faqdesign. $iconposition;?>" >
	<?php while ($query->have_posts()) : $query->the_post();?>			  
      <div class="vfq_main <?php echo $customdesign;?>" vfq_accordion >
        <div vfq_control><h3 class="vfq_title"><?php if($qa == 'yes') echo "<span class='queans question'>".$qtext."</span>"; ?><?php the_title(); ?></h3></div>
      
       
       <div vfq_content class="vfq_container">
        <div class="vfq_content"> <?php if($qa == 'yes') echo "<span class='queans answer'>".$atext."</span>"; ?><?php
                  if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { 
				  
                    the_post_thumbnail('thumbnail'); 
                  }
                  ?>
				  
          
        <?php the_content(); ?></div>
      
        </div>
	  </div>
		<?php
		endwhile; $i++; ?>
      </div>
		</div>
<?php	endif;
	// Reset query to prevent conflicts
	wp_reset_query();
	?>
	    <script type="text/javascript">
      jQuery(document).ready(function() {
        jQuery('#vfq_accordion [vfq_accordion]').vadiaccordionfaq({
			singleOpen: <?php echo $faqopen; ?>,
		 transitionEasing: '<?php echo $transition_type;?>',
          transitionSpeed: <?php echo $faqtransitionSpeed; ?>
		});        
    
      });
    </script>
	<?php
	return ob_get_clean();
}
add_shortcode("vadi_faq", "vadi_faq_shortcode");
?>