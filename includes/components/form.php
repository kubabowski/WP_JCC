<?php
  $rootClass = '';
  $rootAttr = '';

  $rootAttr .= ' novalidate';

  $formId = $id;
  if (isset($method)) $rootAttr .= ' method="' . $method . '"';

  $animGroup = 'textButtonBox';
  $animEffect = 'fade-up';

  if (isset($customAnimGroup)) $animGroup = $customAnimGroup;
  if (isset($customAnimEffect)) $animEffect = $customAnimEffect;

  $scrollAnimAttrs = implode('', [
    ' data-scroll-anim-part="' . $animGroup . '"',
    ' data-scroll-anim-effect="' . $animEffect . '"',
  ]);

  if (isset($customClass)) $rootClass .= ' ' . $customClass;
  if (isset($customAttr)) $rootAttr .= ' ' . $customAttr;
?>
<form action="?" class="form<?= $rootClass ?>"<?= $rootAttr ?>>
  <div class="form__body">
    <div class="form__fields">
      <?php foreach ($fields as $field) : ?>
      <?php
        $fieldClass = ' form__field--' . $field['fieldType'];
        $fieldId = null;
        if (isset($field['name'])) $fieldId = 'form-' . $formId . '-' . $field['name'];
      ?>
      <div class="form__field<?= $fieldClass ?>"<?= $scrollAnimAttrs ?>>
        <?php switch ($field['fieldType']) {
          case 'gap': break;

          case 'input':
            get_part('components/floatingLabel', [
              'id' => $fieldId,
              'label' => $field['label'],
              'field' => get_part('components/input', array_merge([
                'id' => $fieldId,
              ], $field), false),
            ]);
            break;

          case 'textarea':
            get_part('components/floatingLabel', [
              'id' => $fieldId,
              'label' => $field['label'],
              'field' => get_part('components/textarea', array_merge([
                'id' => $fieldId,
              ], $field), false),
            ]);
            break;

          case 'checkbox':
            $fieldName = $field['name'];
            if (count($field['options']) > 1) $fieldName .= '[]';

            foreach ($field['options'] as $option) {
              get_part('components/checkbox', array_merge([
                'id' => $fieldId,
                'name' => $fieldName,
              ], $option));
            }
            break;

          case 'radio':
            $fieldName = $field['name'];
            if (count($field['options']) > 1) $fieldName .= '[]';

            foreach ($field['options'] as $option) {
              get_part('components/radio', array_merge([
                'id' => $fieldId,
                'name' => $fieldName,
              ], $option));
            }
            break;

          case 'select':
            $fieldName = $field['name'];
            if (isset($field['multiple']) && $field['multiple']) $fieldName .= '[]';

            get_part('components/floatingLabel', [
              'id' => $fieldId,
              'label' => $fieldName,
              'field' => 'missing select component',
              // 'field' => get_part('components/select', array_merge([
              //   'id' => $fieldId,
              // ], $field), false),
            ]);
            break;

          case 'hidden':
            echo '<input type="hidden" name="' . $field['name'] . '" value="' . $field['value'] . '" />';
            break;

          default: break;
        } ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="form__foot">
    <div
      class="form__submit"
      data-scroll-anim-part="textFormRow__inner"
      data-scroll-anim-effect="fade-left"
    >
      <?php get_part('components/button', [
        'text' => __('Send', 'center3'),
        'type' => 'submit',
        'arrow' => true,
      ]); ?>
    </div>
  </div>
</form>
