import { setAttr } from '../helpers/dom';

export default class HeaderSearch {
  constructor() {
    // if (!HeaderSearch.init()) return;
    HeaderSearch.init();
  }

  static init() {

    const barEl = document.querySelector('[data-header-search]');
    if (!barEl) return false;

    const inputEl = document.querySelector('[data-header-search-input]');
    if (!inputEl) return false;
    HeaderSearch.handleInputSearch(inputEl);
    
    const buttonEl = document.querySelector('[data-header-search-button]');
    if (!buttonEl) return false;

    let isActive = barEl.getAttribute('data-active') !== null;

    // methods

    function open() {
      if (isActive) return;

      setAttr(barEl, 'data-active', '');
      isActive = true;

      // eslint-disable-next-line no-use-before-define
      document.addEventListener('click', onClickOutside);
    }

    function close() {
      if (!isActive) return;

      setAttr(barEl, 'data-active', null);
      isActive = false;

      // eslint-disable-next-line no-use-before-define
      document.removeEventListener('click', onClickOutside);
    }

    function toggle() {
      if (isActive) {
        close();
      } else {
        open();
      }
    }

    function onClickOutside(e) {
      if (
        (e.target.closest('[data-header-search]') === barEl)
        || (e.target.closest('[data-header-search-button]') === buttonEl)
      ) return;

      close();
    }

    function onButtonClick(e) {
      e.preventDefault();
      toggle();
    }

    buttonEl.addEventListener('click', onButtonClick);

    function destroy() {
      buttonEl.removeEventListener('click', onButtonClick);
    }

    return {
      open,
      close,
      toggle,
      destroy,
    };
  }

  static handleInputSearch(inputEl) {
    const searchSuggestions = window.searchSuggestions || [];
    const resultsContainer = document.querySelector('.results_suggestions');
    const formEl = inputEl.form;

    function clearSuggestions() {
      resultsContainer.innerHTML = '';
    }

    function onInputChange(e) {
      const query = e.target.value.trim();
      clearSuggestions();

      if (query.length >= 3) {
        const filteredSuggestions = getFilteredSuggestions(query);
        displaySuggestions(filteredSuggestions);
      }
    }

    function getFilteredSuggestions(query) {
      return searchSuggestions.filter(suggestion =>
        suggestion.toLowerCase().includes(query.toLowerCase())
      ).slice(0, 4);
    }

    function displaySuggestions(suggestions) {
      suggestions.forEach(suggestion => {
        const suggestionDiv = document.createElement('div');
        suggestionDiv.textContent = suggestion;
        suggestionDiv.classList.add('suggestion-item');

        suggestionDiv.addEventListener('click', () => {
          inputEl.value = suggestion;
          clearSuggestions();
          formEl.submit();
        });

        resultsContainer.appendChild(suggestionDiv);
      });
    }

    inputEl.addEventListener('input', onInputChange);
  }
}
