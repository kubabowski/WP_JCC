<?php
  $rootClass = '';
  $rootAttr = '';

  $items = $props['items'] ?? [];
  $keyPrefix = wp_unique_id('content-tabs-');
  $activeKey = $keyPrefix . '-' . $props['active'] ?? $items[0]['key'] ?? 0;

  $selectPlaceholder = __('Wybierz', 'jcc-solutions');

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<div class="<?= $rootClass ?>" data-tabs="<?= $keyPrefix ?>"<?= $rootAttr ?>>

  <?php /* get_part('components/select', [
    'class' => '',
    'inputAttr' => 'required data-tabs-select',
    'name' => 'content-tabs-select',
    'id' => $keyPrefix . '-select',
    'placeholder' => $selectPlaceholder,
    'options' => array_map(function($tab, $tabIndex) use ($keyPrefix) {
      $tabKey = $keyPrefix . '-' . ($tab['key'] ?? $tabIndex);
      return [
        'value' => $tabKey,
        'label' => $tab['label'],
      ];
    }, $items, array_keys($items)),
    'value' => $activeKey,
  ]); */ ?>

  <div class="overflow-y-hidden overflow-x-auto">
    <div class="flex">
      <?php foreach ($items as $tabIndex => $tab) : ?>
        <?php
          $tabKey = $keyPrefix . '-' . ($tab['key'] ?? $tabIndex);
          $isActive = ($tabKey === $activeKey);
        ?>
        <button
          class="<?= cx([
            'inline-flex items-center',
            'min-h-[62px] px-20px py-8px text-16px/1_25',
            'text-neutral-gray hover:text-neutral-dark',
            'data-[active]:font-medium data-[active]:bg-neutral-dark/5 data-[active]:text-neutral-dark',
            'transition-colors',
          ]) ?>"
          data-tabs-nav-item="<?= $tabKey ?>"
          id="<?= $tabKey ?>-head"
          aria-controls="<?= $tabKey ?>-body"
          aria-selected="<?= ($isActive ? 'true' : 'false') ?>"
          role="tab"
          <?= $isActive ? 'data-active' : '' ?>
        ><?= $tab['label'] ?></button>
      <?php endforeach; ?>
    </div>
  </div>

  <div
    class="block relative overflow-hidden mt-48px"
    data-tabs-items
  >
    <?php foreach ($items as $tabIndex => $tab) : ?>
      <?php
        $tabKey = $keyPrefix . '-' . ($tab['key'] ?? $tabIndex);
        $isActive = ($tabKey === $activeKey);
      ?>
      <div
        class="<?= cx([
          'block top-0 left-0 w-full',
          'absolute invisible opacity-0',
          'data-[active]:relative data-[active]:visible data-[active]:opacity-100',
          'transition-visibility',
        ]) ?>"
        data-tabs-item="<?= $tabKey ?>"
        id="<?= $tabKey ?>-body"
        aria-labelledby="<?= $tabKey ?>-head"
        role="tabpanel"
        <?= $isActive ? 'data-active' : '' ?>
      ><?= $tab['content'] ?></div>
    <?php endforeach; ?>
  </div>
</div>