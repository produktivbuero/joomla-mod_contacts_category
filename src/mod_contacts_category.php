<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_contacts_category
 *
 * @author     Sebastian Brümmer <sebastian@produktivbuero.de>
 * @copyright  Copyright (C) 2019 *produktivbüro . All rights reserved
 * @license    GNU General Public License version 2 or later
 */

use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

// Include the class of the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
$list = modContactsCategoryHelper::getList($params);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require ModuleHelper::getLayoutPath('mod_contacts_category', $params->get('layout', 'default'));
