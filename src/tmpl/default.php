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

// Module parameters
$item_link = $params->get('item_link', 1);
$show_image = $params->get('show_image', 1);
$show_street_address = $params->get('show_street_address', 1);
$show_suburb = $params->get('show_suburb', 1);
$show_state = $params->get('show_state', 1);
$show_postcode = $params->get('show_postcode', 1);
$show_country = $params->get('show_country', 1);
?>

<ul class="contact-category<?php echo $moduleclass_sfx; ?> mod-list category list-striped">
<?php foreach ($list as $item) : ?>
  <li itemscope itemtype="https://schema.org/Place">

    <?php if (!empty($item->image && $show_image)) : ?>
      <span class="contact-image">
        <?php if ($item_link) : ?><a href="<?php echo $item->link; ?>" itemprop="url"><?php endif; ?>
         <img src="<?php echo $item->image; ?>" alt="<?php echo $item->name; ?>" width="100" height="100">
        <?php if ($item_link) : ?></a><?php endif; ?>
        <br>
      </span>
    <?php endif; ?>

    <span class="contact-name" itemprop="name">
      <?php if ($item_link) : ?><a href="<?php echo $item->link; ?>" itemprop="url"><?php endif; ?>
        <?php echo $item->name; ?>
      <?php if ($item_link) : ?></a><?php endif; ?>
    </span>

    <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
      <?php if (!empty($item->address) && $show_street_address) : ?>
        <span class="contact-street" itemprop="streetAddress">
          <br>
          <?php echo nl2br($item->address); ?>
        </span>
      <?php endif; ?>

      <?php if (!empty($item->suburb) && $show_suburb) : ?>
        <span class="contact-suburb" itemprop="addressLocality">
          <br>
          <?php echo $item->suburb; ?>
        </span>
      <?php endif; ?>

      <?php if (!empty($item->state) && $show_state) : ?>
        <span class="contact-state" itemprop="addressRegion">
          <br>
          <?php echo $item->state; ?>
        </span>
      <?php endif; ?>

      <?php if (!empty($item->postcode) && $show_postcode) : ?>
        <span class="contact-postcode" itemprop="postalCode">
          <br>
          <?php echo $item->postcode; ?>
        </span>
      <?php endif; ?>

      <?php if (!empty($item->country) && $show_country) : ?>
        <span class="contact-country" itemprop="addressCountry">
          <br>
          <?php echo $item->country; ?>
        </span>
      <?php endif; ?>
    </span>

  </li>
<?php endforeach; ?>
</ul>
