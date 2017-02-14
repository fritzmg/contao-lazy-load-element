<?php

/**
 * Contao Open Source CMS
 *
 * @copyright inspiredminds.at 2017
 * @author    Fritz Michael Gschwantner <fmg@inspiredminds.at>
 * @license   LGPL-3.0+
 * @package   lazy_load_element
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

		// check for page object
		if( null !== $objPage )
		{
			// set the language
			$GLOBALS['TL_LANGUAGE'] = $objPage->language;

			// Get the page layout
			$blnMobile = ($objPage->mobileLayout && \Environment::get('agent')->mobile);

			// Override the autodetected value
			if (\Input::cookie('TL_VIEW') == 'mobile')
			{
				$blnMobile = true;
			}
			elseif (\Input::cookie('TL_VIEW') == 'desktop')
			{
				$blnMobile = false;
			}

			$intId = ($blnMobile && $objPage->mobileLayout) ? $objPage->mobileLayout : $objPage->layout;
			$objLayout = \LayoutModel::findByPk($intId);

			// check for layout
			if( null !== $objLayout )
			{
				$objPage->hasJQuery = $objLayout->addJQuery;
				$objPage->hasMooTools = $objLayout->addMooTools;
				$objPage->isMobile = $blnMobile;

				// HOOK: modify the page or layout object
				if (isset($GLOBALS['TL_HOOKS']['getPageLayout']) && is_array($GLOBALS['TL_HOOKS']['getPageLayout']))
				{
					foreach ($GLOBALS['TL_HOOKS']['getPageLayout'] as $callback)
					{
						\System::importStatic($callback[0])->{$callback[1]}($objPage, $objLayout, new \PageRegular());
					}
				}

				/** @var \ThemeModel $objTheme */
				$objTheme = $objLayout->getRelated('pid');

				// Set the layout template and template group
				$objPage->template = $objLayout->template ?: 'fe_page';
				$objPage->templateGroup = $objTheme->templates;

				// Store the output format
				list($strFormat, $strVariant) = explode('_', $objLayout->doctype);
				$objPage->outputFormat = $strFormat;
				$objPage->outputVariant = $strVariant;
			}
		}

		// get the type and element ID
		list( $strType, $intId ) = trimsplit('::', \Input::get('element'));

		// prepare element
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
