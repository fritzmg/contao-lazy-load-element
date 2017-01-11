<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  inspiredminds.at 2016
 * @author     Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @package    lazy_load_element
 */


/**
 * Front end modules
 */
//$GLOBALS['FE_MOD']['miscellaneous']['lazyload'] = 'LazyLoadElement';

/**
 * Content elements
 */
$GLOBALS['TL_CTE']['includes']['lazyload'] = 'LazyLoadElement';

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['simpleAjaxFrontend'][] = array('LazyLoadInterface','loadElement');
