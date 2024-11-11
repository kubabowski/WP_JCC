<?php
  $rootClass = '';
  $rootAttr = '';


  $categoryTerm = $props['category'] ?? null;
  $items = $props['items'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section>

    <div class="faq">
        <div class="container">

            <div class="faq-container">

                <div class="col-1">
                    <h3 class="h5 fw-900 fs-20 lh-32 color-000030"><?php echo $props["title"] ?></h3>
                    <h3 class="h2 header fw-400 fs-36 lh-44 color-000030"><?php echo $props["header"] ?></h3>
                </div>

                <div class="col-2">
                    <div id="accordion-faq" class="accordion-container accordion-faq">
                        <?php foreach ($props["questions"] as $k => $faqItem): ?>
                            <div class="ac">
                                <div class="ac-header">
                                    <button type="button" class="ac-trigger fw-400 fs-20 lh-24 color-101021">
                                        <?php echo $faqItem["question"] ?>
                                    </button>
                                </div>
                                <div class="ac-panel">
                                    <p class="ac-text fw-400 fs-16 lh-24 color-101021">
                                        <?php echo $faqItem["answer"] ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>


        </div>
    </div>

</section>





