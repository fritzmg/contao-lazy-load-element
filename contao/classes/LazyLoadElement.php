<?php

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\FormModel;
use Contao\Hybrid;
use Contao\ModuleModel;

/**
 * Contao Open Source CMS
 *
 * @copyright inspiredminds.at 2017
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   LGPL-3.0+
 * @package   lazy_load_element
 */


class LazyLoadElement extends Hybrid
{
	/**
	 * Key
	 * @var string
	 */
	protected $strKey = 'id';

	/**
	 * Table
	 * @var string
	 */
	protected $strTable = 'tl_content';


	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'lazyload';


	/**
	 * Initialize the object
	 *
	 * @param ContentModel|ModuleModel|FormModel $objElement
	 * @param string                                $strColumn
	 */
	public function __construct($objElement, $strColumn='main')
	{
		if( $objElement instanceof ModuleModel )
		{
			$this->strTable = 'tl_module';
		}

		parent::__construct($objElement, $strColumn);

		$this->strKey = 'lazyload';
	}


	/**
	 * Generate method.
	 *
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			/** @var BackendTemplate|object $objTemplate */
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['CTE']['lazyload'][0]) . ' ###';
			$objTemplate->id = $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}

	public function compile()
	{
		$arrAtributes = array();

		global $objPage;

		if( null !== $objPage )
		{
			$arrAtributes['data-page'] = $objPage->id;
		}

		if( $this->lazyload_source && ( $this->module || $this->cteAlias ) )
		{
			switch( $this->strTable )
			{
				case 'tl_module' : $arrAtributes['data-element'] = 'mod::'.$this->id; break;
				case 'tl_content': $arrAtributes['data-element'] = 'cte::'.$this->id; break;
			}
		} 

		if( $this->lazyload_reload )
		{
			$arrAtributes['data-reload'] = intval( floatval( $this->lazyload_reload ) * 1000 );
		}

		if( $this->lazyload_viewport )
		{
			$arrAtributes['data-viewport'] = '1';
		}

		if( $arrAtributes )
		{
			$this->Template->attributes = '';
			foreach( $arrAtributes as $k => $v )
			{
				$this->Template->attributes .= ' '.$k.'="'.$v.'"';
			}

			$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/contaolazyloadelement/lazyload.js';
			$GLOBALS['TL_CSS'][] = 'bundles/contaolazyloadelement/lazyload.css';
		}
	}
}
