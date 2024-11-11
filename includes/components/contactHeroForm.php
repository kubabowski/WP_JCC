<?php
  $slider = get_field('heroHome');

  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];



//var_dump($props);

?>

<form id="contactHero">

    <label for="contactName"><?php echo 'Name *'; // $newsletterPlaceHolder ?></label>
    <input name="contact-name" id="contactName" placeholder="<?php echo 'Name *'; // $newsletterPlaceHolder ?>" />

    <label for="contactReason"><?php echo 'Reason for contact*'; // $newsletterPlaceHolder ?></label>
    <select  name="contact-reason" id="contactReason" placeholder="<?php echo 'Reason for contact*'; // $newsletterPlaceHolder ?>">
        <option value="0">Select a reason</option>
        <option value="1">1</option>
        <option value="2">2</option>
    </select>

    <label for="contactMail"><?php echo 'E-mail*'; // $newsletterPlaceHolder ?></label>
    <input name="contact-mail" id="contactMail" placeholder="<?php echo 'Your email address*'; // $newsletterPlaceHolder ?>" />

    <label for="contactCompany"><?php echo 'Company*'; // $newsletterPlaceHolder ?></label>
    <input name="contact-company" id="contactCompany" placeholder="<?php echo 'Name of your company'; // $newsletterPlaceHolder ?>" />

    <label for="contactText"><?php echo 'Message (optional)'; // $newsletterPlaceHolder ?></label>
    <textarea name="contact-text" id="contactText" placeholder="<?php echo 'Tell us why you are contacting us'; // $newsletterPlaceHolder ?>"></textarea>


    <button class="btn btn-blue btn-lg fw-500 fs-14 lh-24" type="submit">Subscribe</button>
</form>
