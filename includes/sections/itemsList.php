<?php
  $rootClass = '';
  $rootAttr = '';


  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

//var_dump($props);
?>
<section>
    <div class="container">
        <h2 class="case-list-title fw-400 fs-36 lh-44">
            <?php echo $props['title']; ?>
        </h2>
        <div class="line"></div>

        <div class="case-list">
            <?php foreach($props['list'] as $card): ?>
                <div class="case-card-list pagination-item">
                    <div class="case-card-img">
                        <?php if(isset($card['image']['url'])): ?>
                            <img src="<?php echo $card['image']['url']; ?>">
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if(isset($card['item-category'])): ?>
                            <div class="case-list-category fw-700 fs-12 lh-14">
                                <?php echo $card['item-category'][0]->name; ?>
                            </div>
                        <?php endif; ?>
                        <div class="card-title fw-500 fs-20 lh-28">
                            <?php echo $card['title']; ?>
                        </div>
                        <div class="case-list-date-read">
                        <span class="case-list-date fw-500 fs-12 lh-14 uppercase color-000030">
                            <?php echo $card['date']; ?> -
                        </span>
                            <span class="case-list-read fw-500 fs-12 lh-14 color-blue uppercase">
                            9 min read
                        </span>
                        </div>
                        <div class="card-desc fw-400 fs-16 lh-24">
                            <?php echo $card['desc']; ?>
                        </div>
                        <a href="<?php echo $card['url']; ?>" class="link-btn fw-500 fs-16 lh-22">Read more</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>





