<?php
  $rootClass = '';
  $rootAttr = '';
  $langs = [];
  
  if (isset($class)) $rootClass .= ' ' . $class;
  if (isset($attr)) $rootAttr .= ' '.$attr;

  if (function_exists('pll_the_languages')) {
    $langs = pll_the_languages([
      'raw' => 1,
      'echo' => 0,
    ]);
  }

  $current = $langs[pll_current_language()];

  $flag = '';
?>
<div class="lang-choose <?= $rootClass ?>"<?= $rootAttr ?>>
  <ul>
    <?php foreach ($langs as $lang): ?>
      <?php if($lang['current_lang'] == false): ?>
        <a
          class="fw-500 fs-14 lh-24px t-white uppercase"
          href="<?= $lang['url'] ?>"
          data-lang="<?= $lang['slug'] ?>"
        >
          <?= $lang['slug'] ?>
          <img width="20" height="10" src="<?= $lang['flag'] ?>">
        </a>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</div>

