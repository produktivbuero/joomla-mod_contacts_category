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
$show_name = $params->get('show_name', 1);
$show_position = $params->get('show_position', 1);
$show_street_address = $params->get('show_street_address', 1);
$show_suburb = $params->get('show_suburb', 1);
$show_state = $params->get('show_state', 1);
$show_postcode = $params->get('show_postcode', 1);
$show_country = $params->get('show_country', 1);

$show_telephone = $params->get('show_telephone', 1);
$show_mobile = $params->get('show_mobile', 1);
$show_fax = $params->get('show_fax', 1);
$show_email_to = $params->get('show_email_to', 1);
$link_email_to = $params->get('link_email_to', 1);
$text_email_to = $params->get('text_email_to', '');
$show_telephone = $params->get('show_telephone', 1);
$show_mobile = $params->get('show_mobile', 1);
$show_fax = $params->get('show_fax', 1);
$show_webpage = $params->get('show_webpage', 1);
$link_webpage = $params->get('link_webpage', 1);

$symbols = $params->get('symbols', 0);
?>

<ul class="contact-category<?php echo $moduleclass_sfx; ?> mod-list category list-striped">
<?php foreach ($list as $item) : ?>
  <li itemscope itemtype="https://schema.org/Place">

    <?php if (!empty($item->image) && $show_image) : ?>
      <span class="contact-image">
        <?php if ($item_link) : ?><a href="<?php echo $item->link; ?>" itemprop="url"><?php endif; ?>
         <img src="<?php echo $item->image; ?>" alt="<?php echo $item->name; ?>" width="100" height="100">
        <?php if ($item_link) : ?></a><?php endif; ?>
        <br>
      </span>
    <?php endif; ?>

    <?php if ($show_name) : ?>
      <span class="contact-name" itemprop="name">
        <?php if ($item_link) : ?><a href="<?php echo $item->link; ?>" itemprop="url"><?php endif; ?>
        <?php echo $item->name; ?>
        <?php if ($item_link) : ?></a><?php endif; ?>
      </span>
    <?php endif; ?>

    <?php if ($show_position) : ?>
      <span class="contact-position">
          <?php echo $item->con_position; ?>
      </span>
    <?php endif; ?>

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

    <?php if (!empty($item->email_to) && $show_email_to) : ?>
      <span class="contact-mail" itemprop="email">
        <?php if ($symbols != 2) echo modContactsCategoryHelper::getSymbol($symbols, 'email', $item->email_to); ?>
        <?php
          if ($link_email_to) echo JHtml::_('email.cloak', $item->email_to, 1, $text_email_to, 0);
          else echo $item->email_to;
        ?>
      </span>
    <?php endif; ?>

    <?php if (!empty($item->telephone) && $show_telephone) : ?>
      <span class="contact-telephone" itemprop="telephone">
        <?php if ($symbols != 2) echo modContactsCategoryHelper::getSymbol($symbols, 'telephone', $item->telephone); ?>
        <?php echo $item->telephone; ?>
      </span>
    <?php endif; ?>

    <?php if (!empty($item->mobile) && $show_mobile) : ?>
      <span class="contact-mobile" itemprop="telephone">
        <?php if ($symbols != 2) echo modContactsCategoryHelper::getSymbol($symbols, 'mobile', $item->mobile); ?>
        <?php echo $item->mobile; ?>
      </span>
    <?php endif; ?>

    <?php if (!empty($item->fax) && $show_fax) : ?>
      <span class="contact-fax" itemprop="faxNumber">
        <?php if ($symbols != 2) echo modContactsCategoryHelper::getSymbol($symbols, 'fax', $item->fax); ?>
        <?php echo $item->fax; ?>
      </span>
    <?php endif; ?>

    <?php if (!empty($item->webpage) && $show_webpage) : ?>
      <span class="contact-webpage">
        <?php if ($symbols != 2) echo modContactsCategoryHelper::getSymbol($symbols, 'webpage', $item->webpage); ?>
        <?php if ($link_webpage) : ?><a href="<?php echo $item->webpage; ?>" target_="_blank"><?php endif; ?>
        <?php echo $item->webpage; ?>
        <?php if ($link_webpage) : ?></a><?php endif; ?>
      </span>
    <?php endif; ?>

  </li>
<?php endforeach; ?>
</ul>
