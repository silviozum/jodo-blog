<?php
global $yotuwp;

$settings = $yotuwp->data['settings'];
$data = $yotuwp->data['data'];
$thumb_type = $yotuwp->data['settings']['thumb_type'];

?>
<div class="yotu-videos yotu-mode-grid <?php echo isset($settings['column'])? 'yotu-column-' . $settings['column'] : '';?>" data-thumb="<?php echo $thumb_type;?>">
	
	<ul>
		<?php

		if(is_object($data) && count($data->items) >0):

			foreach($data->items as $video){
				$thumb = $video->snippet->thumbnails->$thumb_type->url;
				$videoId = $yotuwp->getVideoId($video);
			?>
			<li>
				<a href="#" class="yotu-video" data-videoid="<?php echo $videoId;?>" data-title="<?php echo $yotuwp->encode($video->snippet->title);?>">
					<div class="yotu-video-thumb-wrp">
						<div>
							<img class="yotu-video-thumb" src="<?php echo $thumb;?>" alt="<?php echo $video->snippet->title;?>">	
						</div>
					</div>
					<?php if(isset($settings['title']) && $settings['title'] == 'on'):?>
						<h3 class="yotu-video-title"><?php echo $video->snippet->title;?></h3>
					<?php endif;?>
					<?php if(isset($settings['description']) && $settings['description'] == 'on'):?>
						<p class="yotu-video-description"><?php echo $yotuwp->description($video);?></p>
					<?php endif;?>
				</a>
			</li>
				
			<?php
			}
		endif;	
		?>
	</ul>
</div>