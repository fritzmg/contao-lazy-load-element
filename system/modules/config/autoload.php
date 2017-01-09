<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  inspiredminds.at 2016
 * @author     Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @package    lazy_load_element
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'LazyLoad'        => 'system/modules/news_facebook/classes/LazyLoad.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_lazy_load'  => 'system/modules/lazy_load_element/templates',
	'mod_lazy_load' => 'system/modules/lazy_load_element/templates',
));
