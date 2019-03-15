<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_contacts_category
 *
 * @author     Sebastian Brümmer <sebastian@produktivbuero.de>
 * @copyright  Copyright (C) 2019 *produktivbüro . All rights reserved
 * @license    GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\String\StringHelper;

$com_path = JPATH_SITE . '/components/com_contact/';

JLoader::register('ContactHelperRoute', $com_path . 'helpers/route.php');
JModelLegacy::addIncludePath($com_path . 'models');

/**
 * Helper for mod_articles_category
 *
 * @since  0.9.0
 */
abstract class modContactsCategoryHelper
{
  /**
   * Get a list of contacts from a specific category
   *
   * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
   *
   * @return  mixed
   *
   * @since  0.9.0
   */
  public static function getList(&$params)
  {
    $featured = $params->get('featured', 0);
    $instance = $featured ? 'Featured' : 'Category';

    // Get an instance of the generic articles model
    $contacts = JModelLegacy::getInstance($instance, 'ContactModel', array('ignore_request' => true));

    // Set application parameters in model
    $app       = JFactory::getApplication();
    $appParams = $app->getParams();
    $contacts->setState('params', $appParams);

    // Set basic filters
    $contacts->setState('filter.published', 1);
    $contacts->setState('filter.publish_date', true);
    $contacts->setState('filter.language', true);

    // Access filter (do not remove due to routing)
    $access     = !JComponentHelper::getParams('com_content')->get('show_noauth');
    $contacts->setState('filter.access', $access);

    // Set count
    $contacts->setState('list.start', 0);
    $contacts->setState('list.limit', (int) $params->get('count', 0));

    // Set ordering
    $ordering = $params->get('ordering', 'ordering');
    $contacts->setState('list.ordering', $ordering);

    $direction = $ordering == 'rand()' ? '' : $params->get('direction', 'ASC');
    $contacts->setState('list.direction', $direction);

    // Get items
    $items = $contacts->getItems();

    // Category filter
    $categories = $params->get('catid', 0);
    if ( is_array($categories) )
    {
      $items = array_filter($items, function ($item) use ($categories) { return in_array($item->catid, $categories); });
    }

    // Add routing
    foreach ($items as &$item)
    {
      $item->slug = $item->id . ':' . $item->alias;
      
      // Find menu itemid
      $value = $featured ? 'index.php?option=com_contact&view=featured' : ContactHelperRoute::getCategoryRoute($item->catid);
      $menuItem = $app->getMenu()->getItems( 'link', $value, true );
      $itemId = empty($menuItem) ? 0 : $menuItem->id;

      // We know that we have access (see "Access filter")
      $item->link = JRoute::_( ContactHelperRoute::getContactRoute($item->slug, $item->catid).'&Itemid='.$itemId );
    }

    return $items;
  }


  /**
   * Get a symbol or text of contact information
   *
   * @param   int     $symbol  symbol (0) or text (1)
   * @param   string  $type  type of symbol
   *
   * @return  string
   *
   * @since  0.9.2
   */
  public static function getSymbol($symbol, $type)
  {
    $return = '';

    // load language files
    JFactory::getLanguage()->load('mod_contacts_category', JPATH_SITE.'/modules/mod_contacts_category');

    switch ($type)
    {
      case 'email':
          $return = $symbol == 0 ? '<span class="icon-mail"></span> ' : JText::_('MOD_CONTACTS_CATEGORY_EMAIL');
        break;

      case 'telephone':
          $return = $symbol == 0 ? '<span class="icon-phone"></span> ' : JText::_('MOD_CONTACTS_CATEGORY_TELEPHONE');
        break;

      case 'mobile':
          $return = $symbol == 0 ? '<span class="icon-mobile"></span> ' : JText::_('MOD_CONTACTS_CATEGORY_MOBILE');
        break;

      case 'fax':
          $return = $symbol == 0 ? '<span class="icon-print"></span> ' : JText::_('MOD_CONTACTS_CATEGORY_FAX');
        break;

      case 'webpage':
          $return = $symbol == 0 ? '<span class="icon-new-tab"></span> ' : JText::_('MOD_CONTACTS_CATEGORY_WEBPAGE');
        break;
    }

    return $return;
  }
}
