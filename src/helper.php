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

    // Access filter
    $access     = !JComponentHelper::getParams('com_content')->get('show_noauth');
    $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
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
      
      if ($access || in_array($item->access, $authorised))
      {
        // We know that user has the privilege to view the article
        $item->link = JRoute::_(ContactHelperRoute::getContactRoute($item->slug, $item->catid, $item->language));
      }
      else
      {
        $item->link = JRoute::_('index.php?option=com_users&view=login');
      }
    }

    return $items;
  }
}
