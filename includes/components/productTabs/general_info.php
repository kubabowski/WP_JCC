<?php
  $content = $props['content'];
  $content = \ThemeClasses\Controller\Product::parseWysiwyg($content);
?>
<div
  class="wysiwyg"
><?= $content ?></div>
