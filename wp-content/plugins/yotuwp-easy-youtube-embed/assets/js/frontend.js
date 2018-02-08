(function($){
	"use strict";

	$.fn.hook = function(data) {

		for(var ev in data.actions){
			var func;
			if( typeof data.actions[ev] == 'function' )
				func = data.actions[ev];
			else if( typeof data[data.actions[ev]] == 'function' )
				func = data[data.actions[ev]];
			else continue;

			ev = ev.split(':');

			if(ev[0] === '')
				this.on(ev[1], data, func);
			else
				this.find(ev[0]).off(ev[1]).on(ev[1], data, func);
		}
		return this;
	};

	window.yotu_check = null;
	window.yotuwp = {
		data : {
			ready : false,
			players : {},
			videos : {}
		},

		init : function (){
			yotuwp.data.ready = true;
			clearInterval(yotu_check);

			$( document ).ready(function() {
				$('.yotu-playlist').each(function (ind){

					let that = $(this),
						player = that.data('yotu'),
						settings = yotuwp.helper.settings(that),
						loaded_ids = [],
						loaded_page = [1],
						firstId = that.find('.yotu-videos li:first-child a').data('videoid');

					if(player !== 'modal' && firstId !== false && typeof yotuwp.data.players[player] === 'undefined'){
						yotuwp.data.players[player] = new YT.Player('yotu-player-' + player, {
							width: 1000,
							height: 600,
							playerVars: settings.player,
							videoId: firstId
						});
					}

					//find thumbs
					that.find('.yotu-videos a').each(function (ind){
						var video = $(this),
							videoId = video.data('videoid'),
							thumb = video.find('img').attr('src');
						if(typeof yotuwp.data.videos[videoId] === 'undefined')
							yotuwp.data.videos[videoId] = [];
						yotuwp.data.videos[videoId].push(thumb);
						loaded_ids.push(videoId);
					});

					that.data('loaded', loaded_ids);
					that.data('loaded_page', loaded_page);
					that.data('last_token', settings.next);

				});

				$('body').hook({
					actions : {
						'.yotu-pagination a:click' : 'load_more',
						'.yotu-videos a:click' : yotuwp.list.events
					},
					load_more : function (e){
						e.preventDefault();
						var target = $(e.target),
							wrp = target.closest('.yotu-playlist');

						if(target.hasClass('yotu-active')) return;

						target.addClass('yotu-active');

						yotuwp.list.load(
							wrp,
							yotuwp.list.update,
							{
								page : target.data('page'),
								current : wrp.data('page'),
								func : 'pagination'
							}
						);
					}
				});
			});
			

		},

		helper : {
			decode: function (str){
				return JSON.parse(window.atob(str));
			},
			encode: function (obj){
				return window.btoa(JSON.stringify(obj));
			},
			settings : function (elm){
				return JSON.parse(window.atob(elm.data('settings')));
			}
		},

		player : {

			data : {
			},
			current : {
				'player' : null,	
				'video' : null,
				'list' : null
			},

			play : function (video, list){

				var player = list.data('yotu'),
					settings = yotuwp.helper.settings(list);

				if(
					typeof yotuwp.data.players[player] !== 'undefined' ||
					player == 'modal'
				){

					if(player === 'modal'){
						yotuwp.player.lightbox.open(
							video,
							settings,
							list
						);
					}
					else{
						yotuwp.data.players[player].loadVideoById(video);
						$('html, body').animate({
							scrollTop: list.offset().top - settings.player.scrolling
						}, 1000);
					}

					this.current = {
						'player' : player,	
						'video' : video,
						'list' : list
					};

					this.info();
					this.pause();
				}
			},

			pause : function (){
				for(var p in yotuwp.data.players){
					if(
						p !== yotuwp.player.current.player &&
						typeof yotuwp.data.players[p] !== 'undefined'
					)
						yotuwp.data.players[p].pauseVideo();
				}
			},

			gen_thumbs : {},

			info : function (){
				var wrp = $('#yotu-player-' + yotuwp.player.current.player).closest('.yotu-wrapper-player');

				wrp.find('.yotu-playing').html(yotuwp.data.videos[this.current.video][0]);
				wrp.find('.yotu-playing-description').html(yotuwp.data.videos[this.current.video][1]);
			},

			lightbox : {

				loaded : false,

				render : function (){
					var elm = jQuery(
						['<div class="yotu-lightbox">',
							'<div class="yotu-lightbox-body">',
								'<div class="yotu-lightbox-content yotu-wrapper-player">',
									'<div class="yotu-playing"></div>',
									'<div class="yotu-player"><div id="yotu-player-modal"></div></div>',
									'<div class="yotu-playing-status"></div>',
									

								'</div></div>',
							'<div class="yotu-thumbnails-wrp" data-yotu="modal"><div id="yotu-thumbnails" class="yotu-thumbnails owl-carousel"></div></div>',
							'<a href="#" class="yotu-lightbox-close" title=""><span class="yotuicon-close"></span></a>',
							'<div class="yotu-copyright"><a href="http://bit.ly/2kNoL2K" target="_blank">Power by YoutuWP</a></div>',
							'<div class="yotu-lightbox-overlay"></div>',
						'</div>'].join('')).appendTo('body');

					elm.hook({
						actions : {
							'.yotu-lightbox-overlay, .yotu-lightbox-close:click' : yotuwp.player.lightbox.close,
						}
					});

					this.loaded = true;
				},

				open : function (video, settings, list){
					if(!this.loaded){
						this.render();
					}

					if(
						!list.is( yotuwp.player.current.list )
					){
						settings.player['enablejsapi'] = 1;

						$('#yotu-player-modal').replaceWith('<div id="yotu-player-modal"></div>');
						yotuwp.data.players['modal'] = new YT.Player('yotu-player-modal', {
							width: 1000,
							height: 600,
							playerVars: settings.player,
							videoId: video
						});
					}else{
						yotuwp.data.players['modal'].loadVideoById(video);
					}

					if(settings.player.playing){
						$('.yotu-lightbox').addClass('yotu-show-title')
					}

					if(
						settings.player.thumbnails && 
						settings.pagination
					){
						var loaded_ids = list.data('loaded'),
							thumbs = $('#yotu-thumbnails'),
							loaded_page = list.data('loaded_page'),
							current = Math.max.apply(Math, loaded_page),
							total = list.data('total');
							
						if(
							current < total && 
							settings.pagination == 'on'
						){
							var load_more = jQuery('<a href="#" class="yotu-lightbox-more"><span class="yotuicon-more"></span></a>');

							load_more.hook({
								actions : {
									':click' : 'load_more_thumbs'
								},
								load_more_thumbs : function (e){
									e.preventDefault();
									var loaded_page = list.data('loaded_page'),
										current = Math.max.apply(Math, loaded_page);

									if(load_more.hasClass('yotu-loading')) return;

									load_more.addClass('yotu-loading');

									if(current + 1 == total)
										load_more.remove();

									yotuwp.list.load(
										list,
										function (wrp, res, data){
											var loaded_ids = wrp.data('loaded');

											load_more.removeClass('yotu-loading');

											if(res.settings.next === '')
												load_more.remove();

											if(res.items.length > 0){
												res.items.map(function (item){
													thumbs.owlCarousel().trigger(
														'add.owl.carousel',
														[jQuery('<img data-videoid="'+item.videoId+'" src="'+item.thumb+'"/>')]
													);
												});
												thumbs.hook({
													actions : {
														'img:click' : yotuwp.player.lightbox.play_video
													}
												}).trigger('refresh.owl.carousel');
												setTimeout(function () {
													thumbs.trigger('to.owl.carousel', [loaded_ids.length - 1, 300]);
												}, 600);
											}
										},
										{
											page : 'next',
											current : current,
											func : 'load_thumb',
											next : list.data('last_token')
										}
									);
								}
							}).appendTo($('.yotu-thumbnails-wrp'));

						}

						loaded_ids.map(function (video){
							thumbs.append('<img data-videoid="'+video+'" src="'+yotuwp.data.videos[video][2]+'"/>');
						});

						thumbs.hook({
							actions : {
								'img:click' : yotuwp.player.lightbox.play_video
							}
						});

						thumbs.owlCarousel({
							nav: true,
							center:false,
							loop:false,
							margin:10,
							startPosition: 0,
							responsiveClass:true,

							responsive:{
								0:{items:2, nav:true},
								600:{items:4, nav:true},
								1000:{items:6, nav:true},
								1440:{items:8, nav:true}
							},
							onRefreshed: function (event){
								
								setTimeout(function () {

									var stage = thumbs.find('.owl-stage'),
										fw = thumbs.find('.owl-stage-outer').outerWidth(),
										iw = stage.outerWidth(),
										pos = (fw-iw)/2;

									pos = (pos< 0)? 0: pos;

									if(fw>iw){
										stage.css({'transform':'translate3d('+pos+'px,0,0)'});
									}
									setTimeout(function () {
										$('.yotu-thumbnails-wrp').addClass('yotu-active');
									}, 200);

								}, 50);
								
							}
						});
					}

					$('.yotu-lightbox').show();
				},

				play_video : function (e){
					e.preventDefault();
					var video = $(e.target).data('videoid');
					yotuwp.data.players['modal'].loadVideoById(video);
					yotuwp.player.current.video = video;
					yotuwp.player.info();
				},

				close : function (e){
					e.preventDefault();

					if(typeof yotuwp.data.players['modal'] !== 'undefined')
						yotuwp.data.players['modal'].stopVideo();

					$('#yotu-thumbnails').html('').trigger('destroy.owl.carousel');
					$('.yotu-thumbnails-wrp').removeClass('yotu-active');
					$('.yotu-lightbox').hide().removeClass('yotu-active yotu-has-thumbs yotu-has-loadmore yotu-show-title');
				},
			}
		},

		list : {
			load : function (wrp, func, atts){

				let settings = yotuwp.helper.settings(wrp),
					loaded_page = wrp.data('loaded_page'),
					loaded_ids = wrp.data('loaded'),
					load_more = wrp.find('.yotu-pagination a'),
					data = {},
					error = function (code){
						var text = '';
						switch(code) {
							case 403:
								text = yotujs.lang['01'];
								break;
							case 404:
								text = yotujs.lang['03'];
							case 500:
								text = yotujs.lang['06'];
							case 504:
								text = yotujs.lang['05'];
								break;
						}

						if(text !== '') alert(text);

						load_more.removeClass('yotu-active');
					};

				delete settings['player'];
				delete settings['pagination'];
				delete settings['pagitype'];

				if(typeof atts.next !== 'undefined'){
					settings['next'] = atts.next;
				}

				data = {
					'page': atts.page,
					'settings': yotuwp.helper.encode(settings),
					'action': 'yotu_pagination'
				};

				$.ajax({
					url: yotujs.ajax_url + '?'+Math.random(),
					type: 'POST',
					dataType: 'json',
					data: data,
					statusCode : {
						403: function (){
							error(403);
						},
						404: function(){
							error(404);
						},
						200: function(res) {
							if(res.error){
								error(504);
								return;
							}

							atts.current += (data.page == 'next' || data.page == 'more')? 1 : -1;
							wrp.data('page', atts.current);
							switch(atts.func) {
								case 'pagination':
									wrp.find('.yotu-pagination-current').html(atts.current);
									load_more.removeClass('yotu-active');
									break;
								case 'load_thumb':
									break;
							}

							if(
								loaded_page.indexOf(atts.current) === -1
							){
								loaded_page.push(atts.current);
								wrp.data('loaded_page', loaded_page);
								if(res.settings.next !== ""){
									wrp.data('last_token', res.settings.next);
								}
							}

							Object.keys(res.items).map(function (ind){
								if(loaded_ids.indexOf(res.items[ind].videoId) == -1)
									loaded_ids.push(res.items[ind].videoId);

								if(typeof yotuwp.data.videos[res.items[ind].videoId] === 'undefined'){
									yotuwp.data.videos[res.items[ind].videoId] = [
										res.items[ind].title,
										res.items[ind].description,
										res.items[ind].thumb
									];
								}
								
							});
							wrp.data('loaded', loaded_ids);

							if(typeof func === 'function'){
								func(wrp, res, data);
							}
						}
					}
				});

			},

			events : function (e){
				e.preventDefault();
				var target = $(e.target);
				yotuwp.player.play(
					(typeof target.data('videoid') == 'undefined') ? target.closest('.yotu-video').data('videoid') : target.data('videoid'),
					target.closest('.yotu-playlist')
				);
			},

			update : function (wrp, res, data){

				var settings = yotuwp.helper.settings(wrp),
					current = wrp.data('page'),
					loaded_ids = wrp.data('loaded'),
					loaded_page = wrp.data('loaded_page'),
					html = jQuery(res.html);

				Object.keys(res.settings).map(function (key){
					settings[key] = res.settings[key];
				});

				wrp.data('settings', yotuwp.helper.encode(settings));

				if( data.page !== 'more' )
					wrp.find('.yotu-videos').replaceWith(html);
				else{
					wrp.find('.yt_loading').remove();
					wrp.find('.yotu-videos ul').append(html.find('ul').html());
					if(res.settings.next === "") wrp.find('.yotu-pagination').addClass('yotu-hide');
				}

				wrp.hook({
					actions : {
						'.yotu-videos a:click' : yotuwp.list.events
					}
				});

				if( current == wrp.data('total') )
					wrp.removeClass('yotu-limit-min').addClass('yotu-limit-max');
				else if( current == 1 )
					wrp.addClass('yotu-limit-min').removeClass('yotu-limit-max');
				else
					wrp.removeClass('yotu-limit-min yotu-limit-max');
			}
		}
	}

	


})(jQuery);


if (typeof window.YT === 'undefined')
{
	var tag = document.createElement('script');

	tag.src = "https://www.youtube.com/iframe_api";

	var firstScriptTag = document.getElementsByTagName('script')[0];

	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

window.onYouTubeIframeAPIReady = (typeof window.onYouTubeIframeAPIReady !== 'undefined') ? window.onYouTubeIframeAPIReady : function ()
{
	yotuwp.init();
};

yotu_check = setInterval(function (){
	if (typeof window.YT !== 'undefined' && window.YT.loaded)
	{
		if(!yotuwp.ready) yotuwp.init();
	}
}, 10);