<?php
  $rootClass = '';
  $rootAttr = '';

  $data = $props['data'] ?? [];

  if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
  if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<section class="<?= $rootClass ?>" <?= $rootAttr ?>>
  <div class="wrapper pb-96px">

    <?php
      get_part('components/contentTabs', [
        'active' => 'general_info',
        'items' => array_filter([
          $data['general_info'] ? [
            'label' => __('Informacje ogólne', 'jcc-solutions'),
            'key' => 'general_info',
            'content' => get_part('components/productTabs/general_info', [
              'content' => $data['general_info'],
            ], false),
          ] : null,

          $data['technical_info'] ? [
            'label' => __('Dane techniczne', 'jcc-solutions'),
            'key' => 'technical_info',
            'content' => get_part('components/productTabs/general_info', [
              'content' => $data['technical_info'],
            ], false),
          ] : null,

          $data['characteristic'] ? [
            'label' => __('Charakterystyka produktu', 'jcc-solutions'),
            'key' => 'characteristic',
            'content' => get_part('components/productTabs/characteristic', [
              'items' => $data['characteristic'],
            ], false),
          ] : null,

          $data['sizes'] ? [
            'label' => __('Wymiary', 'jcc-solutions'),
            'key' => 'sizes',
            'content' => get_part('components/productTabs/sizes', [
              'items' => $data['sizes'],
            ], false),
          ] : null,

          $data['others_info'] ? [
            'label' => __('Pozostałe informacje', 'jcc-solutions'),
            'key' => 'others_info',
            'content' => get_part('components/productTabs/others_info', [
              'items' => $data['others_info'],
            ], false),
          ] : null,

          $data['accessories'] ? [
            'label' => __('Akcesoria', 'jcc-solutions'),
            'key' => 'accessories',
            'content' => get_part('components/productTabs/accessories', [
              'items' => $data['accessories'],
            ], false),
          ] : null,

          $data['files'] ? [
            'label' => __('Pliki', 'jcc-solutions'),
            'key' => 'files',
            'content' => get_part('components/productTabs/files', [
              'items' => $data['files'],
            ], false),
          ] : null,
        ], function($tab) { return $tab !== null; }),
      ]);
    ?>

  </div>
</section>