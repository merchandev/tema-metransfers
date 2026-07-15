<?php
$page_content = file_get_contents('page.php');

$start_destinations_hub = strpos($page_content, 'if ( me_transfers_is_destinations_hub( $current_post ) ) :');
$start_faq = strpos($page_content, 'elseif ( me_transfers_is_faq_page( $current_post ) ) :');
$start_legal = strpos($page_content, 'elseif ( \'legal\' === get_post_meta( $current_post->ID, \'_me_transfers_page_role\', true )');
$start_destination = strpos($page_content, 'elseif ( $current_destination ) :');
$start_tour = strpos($page_content, 'elseif ( $tour = me_transfers_get_current_tour( $current_post ) ) :');
$start_service = strpos($page_content, 'elseif ( $service = me_transfers_get_current_service( $current_post ) ) :');
$start_default = strpos($page_content, 'else :');
$end_while = strpos($page_content, 'endif;', $start_default);

// Extract parts
$part_destinations_hub = substr($page_content, $start_destinations_hub + strlen('if ( me_transfers_is_destinations_hub( $current_post ) ) :'), $start_faq - ($start_destinations_hub + strlen('if ( me_transfers_is_destinations_hub( $current_post ) ) :')));
$part_faq = substr($page_content, $start_faq + strlen('elseif ( me_transfers_is_faq_page( $current_post ) ) :'), $start_legal - ($start_faq + strlen('elseif ( me_transfers_is_faq_page( $current_post ) ) :')));
$part_legal = substr($page_content, $start_legal + strlen('elseif ( \'legal\' === get_post_meta( $current_post->ID, \'_me_transfers_page_role\', true ) || is_page( array( \'privacidad\', \'politica-de-privacidad\', \'cookie\', \'cookies\', \'terminos-y-condiciones\', \'aviso-legal\' ) ) ) :'), $start_destination - ($start_legal + strlen('elseif ( \'legal\' === get_post_meta( $current_post->ID, \'_me_transfers_page_role\', true ) || is_page( array( \'privacidad\', \'politica-de-privacidad\', \'cookie\', \'cookies\', \'terminos-y-condiciones\', \'aviso-legal\' ) ) ) :')));
$part_destination = substr($page_content, $start_destination + strlen('elseif ( $current_destination ) :'), $start_tour - ($start_destination + strlen('elseif ( $current_destination ) :')));
$part_tour = substr($page_content, $start_tour + strlen('elseif ( $tour = me_transfers_get_current_tour( $current_post ) ) :'), $start_service - ($start_tour + strlen('elseif ( $tour = me_transfers_get_current_tour( $current_post ) ) :')));
$part_service = substr($page_content, $start_service + strlen('elseif ( $service = me_transfers_get_current_service( $current_post ) ) :'), $start_default - ($start_service + strlen('elseif ( $service = me_transfers_get_current_service( $current_post ) ) :')));
$part_default = substr($page_content, $start_default + strlen('else :'), $end_while - ($start_default + strlen('else :')));

// Save to template-parts
file_put_contents('template-parts/page/content-destinations-hub.php', "<?php\n" . trim($part_destinations_hub));
file_put_contents('template-parts/page/content-faq.php', "<?php\n" . trim($part_faq));
file_put_contents('template-parts/page/content-legal.php', "<?php\n" . trim($part_legal));
file_put_contents('template-parts/page/content-destination.php', "<?php\n" . trim($part_destination));
file_put_contents('template-parts/page/content-tour.php', "<?php\n" . trim($part_tour));
file_put_contents('template-parts/page/content-service.php', "<?php\n" . trim($part_service));
file_put_contents('template-parts/page/content-default.php', "<?php\n" . trim($part_default));

$new_page_php = substr($page_content, 0, $start_destinations_hub) . '
		if ( me_transfers_is_destinations_hub( $current_post ) ) :
			get_template_part( \'template-parts/page/content\', \'destinations-hub\' );
		elseif ( me_transfers_is_faq_page( $current_post ) ) :
			get_template_part( \'template-parts/page/content\', \'faq\' );
		elseif ( \'legal\' === get_post_meta( $current_post->ID, \'_me_transfers_page_role\', true ) || is_page( array( \'privacidad\', \'politica-de-privacidad\', \'cookie\', \'cookies\', \'terminos-y-condiciones\', \'aviso-legal\' ) ) ) :
			get_template_part( \'template-parts/page/content\', \'legal\' );
		elseif ( $current_destination ) :
			get_template_part( \'template-parts/page/content\', \'destination\' );
		elseif ( $tour = me_transfers_get_current_tour( $current_post ) ) :
			get_template_part( \'template-parts/page/content\', \'tour\' );
		elseif ( $service = me_transfers_get_current_service( $current_post ) ) :
			get_template_part( \'template-parts/page/content\', \'service\' );
		else :
			get_template_part( \'template-parts/page/content\', \'default\' );
		endif;
' . substr($page_content, $end_while + strlen('endif;'));

file_put_contents('page.php', $new_page_php);
echo "Done split";
