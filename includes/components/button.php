<?php
$rootClass = '';
$rootAttr = '';

$url = $props['url'] ?? '';
$isBlock = $props['block'] ?? false;
$isDisabled = $props['disabled'] ?? false;
$size = $props['size'] ?? 'medium';
$theme = $props['theme'] ?? 'medium';

$isPassive = $props['passive'] ?? false;
$urlsive = $props['passive'] ?? false;

$text = $props['text'] ?? $props['title'] ?? '';
$icon = $props['icon'] ?? '';
$iconBefore = $props['iconBefore'] ?? '';
$iconAfter = $props['iconAfter'] ?? '';

$onlyIcon = ($icon && !$text);

if ($isDisabled) $rootAttr = ' disabled';

$attrNames = ['type', 'target'];
foreach ($attrNames as $attrName) {
  if (!isset($props[$attrName])) continue;
  $rootAttr .= ' ' . $attrName . '="' . $props[$attrName] . '"';
}

$rootClass = cx([
  $isBlock ? 'flex' : 'inline-flex',
  'items-center',
  $size === 'medium' ? 'min-h-[62px] px-20px py-8px text-16px/1_25 font-medium' : null,
  $size === 'large' ? 'min-h-[68px] px-20px py-8px text-16px/1_25 font-medium' : null,
  $size === 'small' ? 'min-h-[58px] px-20px py-8px text-16px/1_25 font-medium' : null,
  $theme === 'default' ? 'custom-gradient-border' : null,
  ($theme === 'default' && !$isDisabled) ? 'custom-gradient-border hover:border-neutral-dark/30' : null,
  $theme === 'red' ? 'text-neutral-white bg-neutral-red' : null,
  ($theme === 'red' && !$isDisabled) ? 'hover:bg-neutral-red/80' : null,
  ($theme === 'dark') ? 'bg-neutral text-white' : null,
  ($theme === 'dark' && !$isDisabled) ? 'hover:bg-neutral/80' : null,
  $theme === 'darkAlpha' ? 'custom-gradient-border--dark-alpha ' : null,
  ($theme === 'darkAlpha' && !$isDisabled) ? 'custom-gradient-border hover:bg-neutral-white/15 hover:border-neutral-white/30' : null,
  'transition-colors',
]);

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<?php if ($isPassive): ?>
  <span class="<?= $rootClass ?>" <?= $rootAttr ?>>
  <?php elseif ($url): ?>
    <a href="<?= $url ?>" class="<?= $rootClass ?>" <?= $rootAttr ?>>
    <?php else: ?>
      <button class="<?= $rootClass ?>" <?= $rootAttr ?>>
      <?php endif; ?>
      <?php if (!$onlyIcon && $iconBefore): ?>
        <?php get_icon($iconBefore, 'icon mr-10px size-24px'); ?>
      <?php endif; ?>
      <?php if ($icon): ?>
        <?php get_icon($icon, 'icon'); ?>
      <?php else: ?>
        <span><?= $text ?></span>
      <?php endif; ?>
      <?php if (!$onlyIcon && $iconAfter): ?>
        <?php get_icon($iconAfter, 'icon'); ?>
      <?php endif; ?>
      <?php if ($isPassive): ?>
  </span>
<?php elseif ($url): ?>
  </a>
<?php else: ?>
  </button>
<?php endif; ?>