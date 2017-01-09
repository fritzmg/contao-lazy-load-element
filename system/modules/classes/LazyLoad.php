<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  inspiredminds.at 2016
 * @author     Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @package    lazy_load_element
 */


class LazyLoad extends \Hybrid
{
	public static function lazyLoad()
	{
		if( !\Environment::get('isAjaxRequest') || \Input::get('action') != 'lazyLoad' )
		{
			return;
		}

		global $objPage;

		if( !$objPage && ( $pageId = intval( \Input::get('page') ) ) )
		{
			$objPage = \PageModel::findWithDetails( $pageId );
		}
		
		$GLOBALS['TL_LANGUAGE'] = ( null !== $objPage ) ? $objPage->language : $GLOBALS['TL_LANGUAGE'];

		$strType = \Input::get('type');
		$intId = intval( \Input::get('id') );

		$objElement = null;

		if( $strType == 'mod' )
		{
			$objElement = \ModuleModel::findByPk( $intId );
		}
		elseif( $strType == 'ce' )
		{
			$objElement = \ContentModel::findByPk( $intId );
		}

		if( null === $objElement )
		{
			return;
		}

		if( !\Controller::isVisibleElement( $objElement ) )
		{
			return;
		}

		$strHtml = '';

		if( $objElement->lazyload_type == 'mod' )
		{
			$strHtml = \Controller::getFrontendModule( $objElement->lazyload_module );
		}
		elseif( $objElement->lazyload_type == 'ce' )
		{
			$strHtml = \Controller::getContentElement( $objElement->lazyload_element );
		}
		else
		{
			return;
		}

		$objResponse = new Haste\Http\Response\HtmlResponse( $strHtml );
		$objResponse->send();
	}
}
