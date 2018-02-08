<?php 
$buton_style = ' yotu-button-prs '.(isset($settings['styling']['button'])? 'yotu-button-prs-' . $settings['styling']['button'] : ' yotu-button-prs');
$buton_layout = isset($settings['styling']['button'])? ' yotu-pager_layout-' . $settings['styling']['pager_layout'] : '';
if($settings['pagitype'] == 'pager'):

?>
<div class="yotu-pagination<?php echo ($data->totalPage == 1)? ' yotu-hide' : ''; echo $buton_layout;?>">
<a href="#" class="yotu-pagination-prev<?php echo $buton_style;?>" data-page="prev"><?php _e('Prev', 'yotu');?></a>
<span class="yotu-pagination-current">1</span> <?php _e('of', 'yotu');?> <span class="yotu-pagination-total"><?php echo $data->totalPage;?></span>
<a href="#" class="yotu-pagination-next<?php echo $buton_style;?>" data-page="next"><?php _e('Next', 'yotu');?></a>
</div>
<?php else:?>
<div class="yotu-pagination<?php echo ($data->totalPage == 1)? ' yotu-hide' : '';?>">
	<a href="#" class="yotu-pagination-more<?php echo $buton_style;?>" data-page="more"><?php _e('Load more', 'yotu');?></a>
</div>
<?php endif;?>