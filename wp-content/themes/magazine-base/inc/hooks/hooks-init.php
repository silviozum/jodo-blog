<?php
/**
 * Collection of other function file.
 */
require get_template_directory() . '/inc/ocdi-functions.php';

/*load tgm plugin activation*/
require get_template_directory() . '/assets/libraries/tgm/class-tgm-plugin-activation.php';

require get_template_directory() . '/inc/custom-functions.php';

/*widget init*/
require get_template_directory() . '/inc/widget-init.php';

/*layout meta*/
require get_template_directory() . '/inc/layout-meta/layout-meta.php';

/*header css*/
require get_template_directory() . '/inc/hooks/added-style.php';

/*widgets init*/
require get_template_directory() . '/inc/widgets/widgets.php';

/*sidebar init*/
require get_template_directory() . '/inc/hooks/slider.php';
require get_template_directory() . '/inc/hooks/trending-news.php';

/*section hook init*/
require get_template_directory() . '/inc/hooks/breadcrumb.php';
require get_template_directory() . '/inc/hooks/header-inner-page.php';
require get_template_directory() . '/inc/hooks/home-sidebar-layout.php';