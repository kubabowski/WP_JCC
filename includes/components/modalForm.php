<?php
$rootClass = '';
$rootAttr = '';

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];

?>
<div class="<?= cx([
                "fixed inset-0 z-50 p-16px",
                "overflow-x-hidden overflow-y-auto",
                "[&.open]:block hidden opacity-100"
            ]); ?>
<?= $rootClass ?>" <?= $rootAttr ?> data-modal-form>
    <div class="wrapper bg-white px-16px py-40px md:p-24px relative z-[60] ">
        <button class="btn-close absolute right-0 top-0 p-10px text-32px/1" data-modal-form-close>&#215;</button>
        <div class="wysiwyg"><?= do_shortcode('[contact-form-7 id="79c8967"]') ?></div>
    </div>

    <div class="fixed inset-0 z-40 bg-black/70" data-modal-backdrop></div>

</div>