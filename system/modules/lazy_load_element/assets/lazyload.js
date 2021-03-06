
(function($)
{
	"use strict";

	var $window = $(window);

	var inViewPort = function( $element )
	{
		var vpTop = $window.scrollTop();
		var vpBot = $window.scrollTop() + $window.height();
		var elTop = $element.offset().top;
		var elBot = $element.offset().top + $element.outerHeight();
		return elTop <= vpBot && elBot >= vpTop;
	}

	var loadElement = function( $element, isReload )
	{
		isReload = typeof isReload !== 'undefined' ? isReload : false;

		var data = {
			action: 'lazyload',
			element: $element.data('element')
		};

		if( typeof $element.data('page') !== 'undefined' )
		{
			data.page = $element.data('page');
		}

		$.ajax({
			url: 'SimpleAjaxFrontend.php',
			data: data,
			beforeSend: function()
			{
				if( isReload )
				{
					$element.addClass('reloading')
				}
				else
				{
					$element.addClass('loading');
				}
			},
			success: function( response )
			{
				$element.html( response ).trigger( isReload ? 'lazyload-reload' : 'lazyload' );
			},
			complete: function()
			{
				$element.removeClass('loading reloading');
			}
		})
	};

	var initElement = function( $element )
	{
		if( typeof $element.data('element') !== 'undefined' && !$element.data('loaded') && ( typeof $element.data('viewport') === 'undefined' || ( $element.data('viewport') && inViewPort( $element ) ) ) )
		{
			// load the element
			loadElement( $element );

			// reload periodically?
			if( typeof $element.data('reload') !== 'undefined' )
			{
				// reload periodically
				setInterval( function() { loadElement( $element, true ) }, $element.data('reload') );
			}

			// set element to loaded
			$element.data('loaded', true);
		}
	};

	$(document).ready( function()
	{
		$('.ce_lazyload, .mod_lazyload').each( function()
		{
			initElement( $(this) );
		});
	});

	$window.scroll( function()
	{
		$('.ce_lazyload, .mod_lazyload').filter('[data-viewport="1"]').each( function()
		{
			initElement( $(this) );
		});
	});

})(jQuery);
