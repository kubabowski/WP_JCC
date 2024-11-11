<?php
  $rootClass = '';
  $rootAttr = '';

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

    $props = $props['featured'];

//    var_dump($props);

  ?>


<div class="t-white fw-400 fs-36 lh-44 header">Featured case</div>
<div class="featured-case-article">
    <div class="col-1">
        <div class="featured-case-img" style="background-image: url('<?php echo $props['image']['url']; ?>')"></div>
    </div>
    <div class="col-2">
        <div class="featured-case-text">
            <div class="case-list-category uppercase fw-700 fs-12 lh-14">
                <?php echo $props['item-category'][0]->name;; ?>
            </div>
            <h3 class="featured-case-title fw-500 fs-56 lh-64 color-000030">
                <?php echo $props['title']; ?>
            </h3>

            <div class="case-list-date-read">
                <div class="case-list-date fw-500 fs-12 lh-14 uppercase color-000030">
                    <?php echo $props['date']." -"; ?>
                </div>
                <div class="case-list-read fw-500 fs-12 lh-14 color-blue uppercase">
                    9<?php echo isset($translteLabels["min read"]) ? $translteLabels["min read"] : 'min read';  ?>
                </div>
            </div>

            <h4 class="fs-400 fs-16 lh-24 color-101021"><?php echo $props['serviceData']['description']; ?></h4>
            <a class="btn btn-lg btn-blue">
                <?php echo isset($translteLabels["Read case study"]) ? $translteLabels["Read case study"] : 'Read case study';  ?>
            </a>

        </div>
    </div>
</div>

