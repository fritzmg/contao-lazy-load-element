Contao Lazy Load Element
=====================

Contao extension to allow lazy loading of content elements or modules.

When installed, this extension provides an additional content element and module, where you can define another content element or module to be lazy loaded on page load. You also have the possibility to let the element reload periodically, once it has been loaded for the first time. And you are able to define, whether the element should only load once it is in the viewport.

To enable this functionality you must enable __jQuery__ in the page layout.

When an element gets loaded or reloaded, either the event `lazyload` or `lazyload-reload` will be triggered on that element. This way you can execute your own JavaScript, once an element got loaded (for example to initialize other scripts on the loaded content).

```JavaScript
$('#myLazyLoadElement').on('lazyload', function(event)
{
	// …
});
```
