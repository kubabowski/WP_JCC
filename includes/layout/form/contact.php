<?php
  $lang = apply_filters('getCurrentLang', null);

  $initialData = [
    'fields' => [
      'email' => '',
      'topic' => '',
      'message' => '',
      'lang' => $lang,
      'nonce' => apply_filters('createNonce', 'contact-form'),
    ],
    'errors' => [
      'email' => '',
      'topic' => '',
      'message' => '',
    ],
    'messages' => [
      'emailRequired' => __('Email is required', 'center3'),
      'topicRequired' => __('Topic is required', 'center3'),
      'messageRequired' => __('Message is required', 'center3'),
    ],
    'api' => [
      'method' => 'post',
      'url' => site_url('/') . 'wp-json/api/v1/form/contact',
    ],
  ];
?>
<form
  action="?"
  class="defaultForm"
  data-vue-form="ContactForm"
  data-initial-data="<?= htmlspecialchars(json_encode($initialData)) ?>"
>
  <h2 class="defaultForm__title">
    <?= $title ?>
  </h2>
  <div class="defaultForm__text">
    <?= $text ?>
  </div>
  <div class="defaultForm__fields">
    <div class="defaultForm__field">
      <?php get_part('components/form/formInput', [
        'label' => __('E-mail address:', 'center3'),
        'type'  => 'email',
        'id'    => 'contact-form-email',
        'inputAttr' => 'v-model="fields.email"',
      ]); ?>
      <div
        v-cloak
        v-if="errors.email"
        class="defaultForm__error"
      >{{ errors.email }}</div>
    </div>
    <div class="defaultForm__field">
      <?php get_part('components/form/formInput', [
        'label' => __('Topic:', 'center3'),
        'type'  => 'text',
        'id'    => 'contact-form-topic',
        'inputAttr' => 'v-model="fields.topic"',
      ]); ?>
      <div
        v-cloak
        v-if="errors.topic"
        class="defaultForm__error"
      >{{ errors.topic }}</div>
    </div>
    <div class="defaultForm__field">
      <?php get_part('components/form/formTextarea', [
        'label' => __('Message:', 'center3'),
        'id'    => 'contact-form-message',
        'inputAttr' => 'v-model="fields.message"',
      ]); ?>
      <div
        v-cloak
        v-if="errors.message"
        class="defaultForm__error"
      >{{ errors.message }}</div>
    </div>
    <?php foreach ($bullets as $bullet) : ?>
    <div class="defaultForm__bullet">
      <?= $bullet['text']; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="defaultForm__submit">
    <?php get_part('components/form/formButton', [
      'type'  => 'submit',
      'text'  => __('Send message', 'center3'),
      'color' => 'green',
      'icon'  => 'send',
      'customAttr' => '@click="onSendClick" :disabled="loading"',
    ]); ?>
  </div>
</form>

<script type="text/template" data-popup-tpl="contact-success">
  <div class="defaultPopup">
    <h3 class="defaultPopup__title"><?= __('Send success', 'center3') ?></h3>
  </div>
</script>

<script type="text/template" data-popup-tpl="contact-failed">
  <div class="defaultPopup">
    <h3 class="defaultPopup__title"><?= __('Send failed', 'center3') ?></h3>
  </div>
</script>
