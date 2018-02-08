jQuery(document).ready(function($) {
	function dadGetVideoID(youtube) {
		/*Check if input is YouTube URL*/
		var DADcekUrl = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
		if(!DADcekUrl.test(youtube)){ /* Jika Bukan */
			return youtube;
		}else{ /* Jika Iya */
			var regex = new RegExp('[\\?&]v=([^&#]*)');
			var results = regex.exec(youtube);
			return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
		}
	}
    tinymce.create('tinymce.plugins.dad_youtube_responsive', {
        init : function(ed, url) {
                // Register command for when button is clicked
                ed.addCommand('dad_youtube_responsive_insert_shortcode', function() {
                    var dad_insert_youtube_video = window.prompt('Insert YouTube video URL or Video ID');
                    if( dad_insert_youtube_video ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[youtube v="'+dadGetVideoID(dad_insert_youtube_video)+'"]';
                    }else{
                        content =  '[youtube v="INSERT-VIDEO-ID-HERE"]';
                    }

                    tinymce.execCommand('mceInsertContent', false, content);
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('dad_youtube_responsive', {
				title : 'Add YouTube Video (Responsive!)', cmd : 'dad_youtube_responsive_insert_shortcode', image: url + '/../img/tinymce-button.png' });
        },   
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('dad_youtube_responsive', tinymce.plugins.dad_youtube_responsive);
});