<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  inspiredminds.at 2016
 * @author     Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @package    lazy_load_element
 */


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['simpleAjaxFrontend'][] = array('LazyLoad','lazyLoad');
