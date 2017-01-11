<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  inspiredminds.at 2016
 * @author     Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @package    lazy_load_element
 */


/**
 * Add palettes to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'lazyload_source';
$GLOBALS['TL_DCA']['tl_content']['palettes']['lazyload'] = '{type_legend},type;{include_legend},lazyload_source;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['lazyload_source_mod'] = 'module';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['lazyload_source_cte'] = 'cteAlias';


/**
 * Add fields to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['lazyload_source'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['lazyload_source'],
	'default'                 => '',
	'exclude'                 => true,
	'inputType'               => 'radio',
	'options'                 => array('mod','cte'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_content']['lazyload_source_options'],
	'eval'                    => array('submitOnChange'=>true, 'mandatory'=>true),
	'sql'                     => "varchar(8) NOT NULL default ''"
);
