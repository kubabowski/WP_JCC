<?php
$rootClass = '';
$rootAttr = '';

$query = get_search_query();

function add_search_suggestions_script_to_footer()
{
  $searchSuggestions = get_field('search_suggestions', 'option') ?? '';
  $searchSuggestionsArray = array_filter(array_map('trim', explode("\n", $searchSuggestions)));

  if (!empty($searchSuggestionsArray)) : ?>
    <script type="text/javascript">
      window.searchSuggestions = <?= json_encode($searchSuggestionsArray); ?>;
    </script>
<?php
  endif;
}
add_action('wp_footer', 'add_search_suggestions_script_to_footer');

if (isset($props['class'])) $rootClass .= ' ' . $props['class'];
if (isset($props['attr'])) $rootAttr .= ' ' . $props['attr'];
?>
<div
  class="<?= cx([
            'absolute top-0 left-0 w-full',
            'bg-neutral-white border-b border-border-menu',
            'transition-all',
            'opacity-0 transform -translate-y-full',
            'data-[active]:visible data-[active]:opacity-100 data-[active]:translate-y-0',
            $rootClass,
          ]) ?>"
  data-header-search
  <?= $rootAttr ?>>
  <div class="wrapper py-24px">
    <form
      action="<?= home_url('/') ?>"
      method="get"
      class="max-w-[45rem] mx-auto"
      autocomplete="off">
      <div class="relative">
        <input
          type="search"
          name="s"
          value="<?= $query ?>"
          placeholder="<?= __('Czego szukasz?', 'jcc-solutions') ?>"
          class="block w-full h-58px p-8px text16px/1_6 border-b border-border-gray"
          data-header-search-input>
        <button
          type="submit"
          class="absolute block size-24px text-24px/1 top-1/2 end-8px -mt-12px" ,><?php get_icon('search', 'icon'); ?></button>
      </div>
      <div class="results_suggestions "></div>
    </form>
  </div>
</div>