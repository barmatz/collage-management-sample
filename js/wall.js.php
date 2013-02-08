<?php 
header('content-type: text/javascript');
header('cache-control: no-cache');
require_once '../getConfig.php';
?>
var posts = [],
	newPosts = [],
	$wrapper,
	$container,
	gettingPosts,
	gettingNewPosts,
	transitionInterval,
	dataInterval,
	openingBubble;
	
$(function()
{
	$wrapper = $('#posts-wrapper');
	$container = $('#posts-container').css({fontSize: <?php echo $config['post_font_size']; ?> + 'px'});
	startDataInterval();
	startTransitionInterval();
});

function startDataInterval()
{
	getPosts();
	dataInterval = setInterval(onDataInterval, <?php echo intval($config['post_refresh_interval']) * 1000; ?>);
}

function stopDataInterval()
{
	clearInterval(dataInterval);
}

function onDataInterval()
{
	getPosts();
}

function startTransitionInterval()
{
	transitionInterval = setInterval(onTransitionInterval, <?php echo floor(1000 / $config['frame_rate']); ?>);
}

function stopTransitionInterval()
{
	clearInterval(transitionInterval);
}

function onTransitionInterval()
{
	addElement();
	position();
	removeElements();
	if(getContainerHeight() > $wrapper.height())
		$container.css('top', parseInt($container.css('top')) - <?php echo $config['transition_speed']; ?> + 'px');
}

function openBubble()
{
	var post;
	if(!openingBubble && newPosts.length > 0)
	{
		openingBubble = true;
		post = newPosts[0];
		$bubble = $('#bubble');
		$message = $(document.createElement('div')).addClass('wall-post-message')
												   .html(post.message);
		$by = $(document.createElement('div')).addClass('wall-post-by')
											  .html(post.first_name + ' ' + post.last_name);
		$post = $(document.createElement('div')).addClass('wall-post')
												.css({fontSize: <?php echo $config['bubble_font_size']; ?> + 'px'})
												.append($message)
												.append($by);
		
		$($bubble.find('#bubbleContent')[0]).html('').append($post);
		$bubble.css({display: 'block', opacity: 0})
			   .animate({opacity: 1}, 
			   {
			   		duration: <?php echo intval($config['bubble_transition_in_duration']) * 1000; ?>,
			   		complete: function()
			   		{
			   			setTimeout(function()
			   			{
							$bubble.hide(<?php echo intval($config['bubble_transition_out_duration']) * 1000; ?>);
							if(newPosts.length > 0)
								setTimeout(function()
								{
									openingBubble = false;
									openBubble();
								}, <?php echo intval($config['bubble_transition_delta']) * 1000; ?>);
							else
								openingBubble = false;
			   			}, <?php echo intval($config['bubble_hold_duration']) * 1000; ?>);
			   		}
			   });
		oldPost = newPosts.splice(0, 1)[0];
		if(oldPost)
			posts.push(oldPost);
		$.ajax({data: {id: post.id, new: false}, url: 'postNewHandler.php', method: 'POST'});
	}
}

function globalToLocal(context, globalX, globalY)
{
	var POSITION = context.offset();
	return {x: Math.floor(globalX - POSITION.left), y: Math.floor(globalY - POSITION.top)};
}
	 
	 
function localToGlobal(context, localX, localY)
{
	var POSITION = context.offset();
	return {x: Math.floor(localX + POSITION.left), y: Math.floor(localY + POSITION.top)};
}

function getPosts(type, callback)
{
	var url;
	switch(type)
	{
		default: 
			getPosts('old', onGetPostsOld);
			getPosts('new', onGetPostsNew);
			break;
		case 'new': 
			url = 'getPostsHandler.php?new';
			gettingPosts = true;
			break;
		case 'old': 
			url = 'getPostsHandler.php?old';
			gettingNewPosts = true;
			break;
	}
	
	$.ajax({success: callback, complete: function(){ type == 'new' ? gettingNewPosts = false : gettingPosts = false; }, url: url, method: 'GET'});
}

function onGetPostsOld(data, textStatus, jqXHR)
{
	var DATA = $.parseJSON(jqXHR.responseText);
	posts = DATA.posts;
	if(posts.length > 0)
		fillContainer();
}

function onGetPostsNew(data, textStatus, jqXHR)
{
	var DATA = $.parseJSON(jqXHR.responseText);
	newPosts = DATA.posts;
	if(newPosts.length > 0)
		openBubble();
}

function fillContainer()
{
	while(!isContainerFull())
	{
		addElement();
		position();
		if($container.children().length > <?php echo $config['max_posts_per_wall']; ?>)
			break;
	}
}

function position()
{
	var $children = $container.children();
	$children.each(function(i)
	{
		var $current = $($children[i]),
			$prev = $($children[i - 1]);
		if(i > 0 && !$current.attr('positioned'))
		{
			$current.css({right: parseInt($prev.css('right')) + $prev.outerWidth() + 'px', top: $prev.css('top')});
			if($current.position().left < 0)
				$current.css({right: 0, top: $prev.position().top + getFirstElementInRow(i).height() + 10});
			$current.attr('positioned', true);
		}
	});
}

function addElement()
{
	var post;
	
	if($container.children().length < <?php echo $config['max_posts_per_wall']; ?>)
	{
		post = getRandomPost();
		if(post)
			$container.append($ELEMENT = $(document.createElement('div')).addClass('wall-post')
																	 	 .css({fontSize: Math.min(Math.max(Math.random(), <?php echo intval($config['post_font_size_em_min']) / 100; ?>), <?php echo intval($config['post_font_size_em_max']) / 100; ?>) + 'em', opacity: 0})
																	 	 .html('<div class="wall-post-message">' + post.message + '</div><div class="wall-post-by">' + post.first_name + ' ' + post.last_name + '</div></div>')
																	 	 .animate({opacity: Math.min(Math.max(Math.random(), <?php echo intval($config['post_opacity_min']) / 100; ?>), <?php echo intval($config['post_opacity_max']) / 100; ?>)}, <?php echo intval($config['post_transition_in_duration']) * 1000; ?>));
	}
}

function removeElements()
{
	$container.children().each(function(i)
	{
		var $this = $(this);
		if($this.offset().top < 0)
			$this.animate({opacity: 0}, {duratrion: <?php echo intval($config['post_transition_out_duration']) * 1000; ?>, complete: function(){ $(this).remove(); }});
	});
}

function isContainerFull()
{
	return getContainerHeight() >= $wrapper.height();
}

function getFirstElementInRow(index)
{
	var top, currentTop, $element, $savedElement;
	for(; index >= 0; --index)
	{
		$element = $($container.children()[index]);
		currentTop = parseInt($element.css('top'));
		if(top && currentTop != top)
			break;
		top = currentTop;
		$savedElement = $element;
	}
	return $savedElement;
}

function getLastElementInRow(index)
{
	var top, currentTop, $element, $savedElement;
	for(; index < $container.children().length; ++index)
	{
		$element = $($container.children()[index]);
		currentTop = parseInt($element.css('top'));
		if(top && currentTop != top)
			break;
		top = currentTop;
		$savedElement = $element;
	}
	return $savedElement;
}

function getContainerHeight()
{
	var $element, offset = 0, top = 0;
	if($container.children().length > 0)
	{
		$element = getFirstElementInRow($container.children().length - 1);
		top = parseInt($($container.children()[0]).css('top'));
		if(top > 0)
			offset = top;
		return parseInt($element.css('top')) - offset + $element.outerHeight();
	}
	return 0;
}

function getRandomPost()
{
	return posts[Math.floor(Math.random() * posts.length)];
}