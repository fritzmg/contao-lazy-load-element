<?php

/**
 * Contao Open Source CMS
 *
 * @copyright inspiredminds.at 2017
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   LGPL-3.0+
 * @package   lazy_load_element
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'LazyLoadElement' => 'system/modules/lazy_load_element/classes/LazyLoadElement.php',
	'LazyLoadInterface' => 'system/modules/lazy_load_element/classes/LazyLoadInterface.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'lazyload' => 'system/modules/lazy_load_element/templates',
));
