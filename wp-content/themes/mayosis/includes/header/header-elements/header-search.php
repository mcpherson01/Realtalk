<?php
defined('ABSPATH') or die();
$searchstylemain= get_theme_mod( 'search_style','one' ); ?>

<ul id="search-menu" class="mayosis-option-menu">
<?php if($searchstylemain== 'one') :?>

<?php get_template_part( 'searchform', 'download'); ?>

<?php else: ?>

<?php get_template_part( 'searchform', 'download-style-two'); ?>

<?php endif; ?>

</ul>