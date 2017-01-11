<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  inspiredminds.at 2016
 * @author     Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @package    lazy_load_element
 */


class LazyLoadInterface
{
	public static function loadElement()
	{
		// check for ajax response and action
		if( !\Environment::get('isAjaxRequest') || \Input::get('action') != 'lazyload' )
		{
			return;
		}

		// get the page object
		global $objPage;

		if( !$objPage && ( $pageId = intval( \Input::get('page') ) ) )
		{
			$objPage = \PageModel::findWithDetails( $pageId );
		}
		
		// set the language, if page object is available
		$GLOBALS['TL_LANGUAGE'] = ( null !== $objPage ) ? $objPage->language : $GLOBALS['TL_LANGUAGE'];

		list( $strType, $intId ) = trimsplit('::', \Input::get('element'));

		$objElement = null;

		// determine the type
		if( $strType == 'mod' )
		{
			$objElement = \ModuleModel::findByPk( $intId );
		}
		elseif( $strType == 'cte' )
		{
			$objElement = \ContentModel::findByPk( $intId );
		}
		else
		{
			return;
		}

		// check if lazy load element was found
		if( null === $objElement )
		{
			return;
		}

		// check if element is of type lazyload
		if( $objElement->type != 'lazyload' )
		{
			return;
		}

		// check if lazy load element is visible
		if( !\Controller::isVisibleElement( $objElement ) )
		{
			return;
		}

		// generate html of lazy loaded element
		$strHtml = '';

		if( $objElement->lazyload_source == 'mod' )
		{
			$strHtml = \Controller::getFrontendModule( $objElement->module );
		}
		elseif( $objElement->lazyload_source == 'cte' )
		{
			$strHtml = \Controller::getContentElement( $objElement->cteAlias );
		}
		else
		{
			return;
		}

		// send html to browser
		$objResponse = new Haste\Http\Response\HtmlResponse( $strHtml );
		$objResponse->send();
	}
}
