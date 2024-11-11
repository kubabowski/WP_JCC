<?php
  $rootClass = '';
  $rootAttr = '';


  $categoryTerm = $props['category'] ?? null;
  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section>

    <div class="contact-details-container">
        <div class="container">
            <h3 class="title fw-900 fs-20 lh-32 color-000030"><?php echo $props['title'] ?></h3>
            <h3 class="header fw-400 fs-36 lh-44 color-000030"><?php echo $props['header'] ?></h3>


            <div class="contact-details">
                <div class="col-1">
                    <div class="contact-details-img" style="background-image: url('<?php echo isset($props['image']) ? $props['image']['url'] : ''; ?>')"></div>

                    <div class="locations-items">
                        <div class="location-icon">
<!--                            --><?php //echo file_get_contents(BASE_PATH . 'assets/icons/location-pin.svg'); ?>
                        </div>

                        <?php if (isset($props['locations']) && is_array($props['locations'])): ?>
                            <?php foreach ($props['locations'] as $index => $location): ?>
                                <?php if ($index < 2): ?>
                                    <div class="location-item">
                                        <div>
                                        <span class="fw-500 fs-28 lh-36 color-000030">
                                            <?php echo isset($location["address_1"]) ? $location["address_1"] : ''; ?>
                                        </span>
                                            <span class="fw-500 fs-20 lh-36 color-000030">
                                            <?php echo isset($location["address_2"]) ? $location["address_2"] : ''; ?>
                                        </span>
                                        </div>

                                        <div class="fw-400 fs-16 lh-24 color-101021">
                                            <?php echo isset($location["address_3"]) ? $location["address_3"] : ''; ?>
                                        </div>
                                        <div class="fw-400 fs-16 lh-24 color-101021">
                                            <?php echo isset($location["address_4"]) ? $location["address_4"] : ''; ?>
                                        </div>

                                        <a href="tel:<?php echo isset($location["phone"]) ? $location["phone"] : ''; ?>" class="fw-400 fs-16 lh-24 link-blue">
                                            <?php echo isset($location["phone"]) ? $location["phone"] : ''; ?>
                                        </a>

                                        <div class="google-maps-icon">
                                            <a href="<?php echo isset($location["location"]["url"]) ? $location["location"]["url"] : ''; ?>">
<!--                                                --><?php //echo file_get_contents(BASE_PATH . 'assets/icons/location-google.svg'); ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="col-2">
                    <div class="contact-details-text">
                        <div class="location-icon">
<!--                            --><?php //echo file_get_contents(BASE_PATH . 'assets/icons/location-message.svg'); ?>
                        </div>

                        <div class="fw-500 fs-28 lh-36 color-000030 contact-details-title"><?php echo  $props["header_2"]; ?></div>

                        <a class="fw-400 fs-16 lh-24 link-blue mb-8" href="<?php echo  $props["mail_1"]["url"]; ?>">
                        <span class="con-details-icon">
<!--                            --><?php //include BASE_PATH . 'assets/icons/mail-icon.svg'; ?>
                        </span>
                            <?php echo  $props["mail_1"]["title"]; ?>
                        </a>

                        <a class="fw-400 fs-16 lh-24 link-blue mb-24" href="<?php echo  $props["mail_2"]["url"]; ?>">
                        <span class="con-details-icon">
<!--                            --><?php //include BASE_PATH . 'assets/icons/mail-icon.svg'; ?>
                        </span>
                            <?php echo  $props["mail_2"]["title"]; ?>
                        </a>

                        <a class="fw-400 fs-16 lh-24 link-blue mb-8" href="<?php echo  $props["phone_1"]["url"]; ?>">
                        <span class="con-details-icon">
<!--                            --><?php //include BASE_PATH . 'assets/icons/phone-icon.svg'; ?>
                        </span>
                            <?php echo  $props["phone_1"]["title"]; ?>
                        </a>

                        <a class="fw-400 fs-16 lh-24 link-blue mb-24" href="<?php echo  $props["phone_2"]["url"]; ?>">
                        <span class="con-details-icon">
<!--                            --><?php //include BASE_PATH . 'assets/icons/phone-icon.svg'; ?>
                        </span>
                            <?php echo  $props["phone_2"]["title"]; ?>
                        </a>

                        <div >
                            <span class="fw-400 fs-16 lh-24 color-101021"><?php echo  $props["text"]; ?></span>
                            <a href="<?php echo  $props["mail_2"]["url"]; ?>">
                                <?php echo  $props["mail_2"]["title"]; ?>
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


</section>





