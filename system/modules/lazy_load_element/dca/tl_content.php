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
$GLOBALS['TL_DCA']['tl_content']['palettes']['lazyload'] = '{type_legend},type;{include_legend},lazyload_source,lazyload_reload,lazyload_viewport;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

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

$GLOBALS['TL_DCA']['tl_content']['fields']['lazyload_reload'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['lazyload_reload'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'natural', 'nospace'=>true, 'tl_class'=>'clr w50'),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['lazyload_viewport'] = array
(
    'label'         => &$GLOBALS['TL_LANG']['tl_content']['lazyload_viewport'],
    'exclude'       => true,
    'inputType'     => 'checkbox',
    'default'       => false,
    'eval'          => array('tl_class'=>'w50 m12'),
    'sql'           => "char(1) NOT NULL default ''"
);
