import anime from 'animejs/lib/anime.es';
import { each } from '../helpers/array';

import Entities from './shared/Entities';

const KEYS = {
  UP: 38,
  DOWN: 40,
  SPACE: 32,
  ENTER: 13,
  ESC: 27,
};

class CustomSelectEntity {

  constructor(rootEl) {
    if (!this.setVars(rootEl)) return;

    this.initCustomSelect();
    this.bindEvents();
    this.onSelectChange();
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.selectEl = this.rootEl.querySelector('[data-custom-select-input]');
    // this.optionsArr = this.selectEl.querySelectorAll('option');
    this.optionsArr = this.selectEl.options;
    this.isOpened = false;
    this.theme = this.rootEl.getAttribute('data-custom-select-theme');

    const multipleAttr = this.rootEl.getAttribute('data-custom-select-multiple');
    this.isMultiple = multipleAttr !== null;
    this.selectedText = multipleAttr || '';
    this.placeHolderText = this.rootEl.getAttribute('data-custom-select-placeholder') || '';

    const selectAllAttr = this.rootEl.getAttribute('data-custom-select-all');
    this.withSelectAll = selectAllAttr !== null;
    this.selectAllText = selectAllAttr || '';

    const searchAttr = this.rootEl.getAttribute('data-custom-select-search');
    this.withSearch = searchAttr !== null;
    this.searchPlaceholderText = searchAttr || '';

    this.noResultsText = this.rootEl.getAttribute('data-custom-select-no-results') || '';

    this.focusIndex = null;
    this.lastSelectedIndex = null;

    this.bodyEl = document.querySelector('body');

    this.classes = {
      rootActive: 'select--active',
      rootFocused: 'select--focused',
      rootPlaceholder: 'select--placeholder',
      optionFocused: 'select__option--focused',
      optionSelected: 'select__option--selected',
      optionPartial: 'select__option--partial',
      optionHidden: 'select__option--hidden',
    };

    this.rootEl.CustomSelect = this;

    return true;
  }

  insertAfterSelectEl(el) {
    const nextSiblingEl = this.selectEl.nextElementSibling;
    if (nextSiblingEl !== null) {
      this.rootEl.insertBefore(el, nextSiblingEl);
    } else {
      this.rootEl.appendChild(el);
    }
  }

  initCustomSelect() {
    this.rootFragment = document.createDocumentFragment();
    this.triggerEl = this.withSearch ? this.createSearchEl() : this.createButtonEl();
    this.createValueEl();
    this.createPlaceholderEl();
    this.insertAfterSelectEl(this.rootFragment);

    this.createCustomOptionsEl();

    // hide native select
    this.selectEl.classList.add('select__input--hidden');
  }

  createValueEl() {
    const valueEl = document.createElement('div');
    valueEl.classList.add('select__value');

    this.valueEl = valueEl;
    this.rootFragment.appendChild(valueEl);
  }

  createPlaceholderEl() {
    const placeholderEl = document.createElement('div');
    placeholderEl.classList.add('select__placeholder');
    placeholderEl.innerText = this.placeHolderText;

    this.placeholderEl = placeholderEl;
    this.rootFragment.appendChild(placeholderEl);
  }

  createButtonEl() {
    const buttonEl = document.createElement('button');
    buttonEl.setAttribute('type', 'button');
    buttonEl.classList.add('select__button');
    this.buttonEl = buttonEl;

    this.rootFragment.appendChild(buttonEl);
    return buttonEl;
  }

  createSearchEl() {
    const searchEl = document.createElement('div');
    searchEl.classList.add('select__search');
    this.searchEl = searchEl;

    const searchInputEl = document.createElement('input');
    searchInputEl.setAttribute('type', 'search');
    searchInputEl.setAttribute('placeholder', this.searchPlaceholderText);
    searchInputEl.setAttribute('data-novalidate', '1');
    searchInputEl.classList.add('select__searchInput');
    this.searchInputEl = searchInputEl;

    searchEl.appendChild(searchInputEl);
    this.rootFragment.appendChild(searchEl);

    return searchInputEl;
  }

  createCustomOptionsEl() {
    const customOptionsEl = document.createElement('div');
    customOptionsEl.classList.add('select__options');
    if (this.isMultiple) customOptionsEl.classList.add('select__options--multiple');
    if (this.theme) customOptionsEl.classList.add(`select__options--${this.theme}`);

    this.customOptionsEl = customOptionsEl;

    this.createCustomOptions();
  }

  removeCustomOptions() {
    this.customOptionsEl.innerHTML = '';
    this.customOptions = [];
  }

  createCustomOptions() {
    const { customOptionsEl } = this;

    this.customOptions = [];
    each(this.optionsArr, (optionEl) => {
      const label = optionEl.innerText.trim();
      const customOptionEl = this.createCustomOptionEl(label);

      const customProps = {};

      if (optionEl.disabled) {
        customOptionEl.classList.add('select__option--disabled');
        customOptionEl.disabled = true;
      }

      if (optionEl.getAttribute('data-empty') !== null) {
        customOptionEl.classList.add('select__option--empty');
        customOptionEl.classList.add('select__option--hidden');
        customProps.isEmpty = true;
        customProps.isHidden = true;
      }

      if (optionEl.getAttribute('data-never-hide') !== null) {
        customOptionEl.classList.add('select__option--neverHide');
        customProps.isNeverHide = true;
      }

      this.customOptions.push({
        label,
        nativeOptionEl: optionEl,
        el: customOptionEl,
        isHidden: false,
        isOption: true,
        ...customProps,
      });
      customOptionsEl.appendChild(customOptionEl);
    });

    if (this.isMultiple && this.withSelectAll) {
      const label = this.selectAllText;
      const selectAllOptionEl = this.createCustomOptionEl(label);
      selectAllOptionEl.classList.add('select__option--selectAll');
      customOptionsEl.insertBefore(selectAllOptionEl, this.customOptions[0].el);

      this.customOptions.unshift({
        label,
        nativeOptionEl: null,
        el: selectAllOptionEl,
        isHidden: false,
        isSelectAll: true,
      });

      this.selectAllOptionEl = selectAllOptionEl;
    }

    if (this.withSearch) {
      const label = this.noResultsText;
      const noResultsOptionEl = this.createCustomOptionEl(label);
      noResultsOptionEl.classList.add('select__option--noResults');
      noResultsOptionEl.classList.add('select__option--hidden');
      noResultsOptionEl.classList.add('select__option--disabled');
      noResultsOptionEl.disabled = true;
      customOptionsEl.appendChild(noResultsOptionEl);

      const noResultsOptionObj = {
        label,
        nativeOptionEl: null,
        el: noResultsOptionEl,
        isHidden: true,
        isNoResults: true,
      };

      this.customOptions.push(noResultsOptionObj);

      this.noResultsOptionObj = noResultsOptionObj;
    }

    this.maxIndex = this.customOptions.length - 1;
  }

  createCustomOptionEl(text) {
    const customOptionEl = document.createElement('button');
    customOptionEl.setAttribute('type', 'button');
    customOptionEl.setAttribute('tabindex', -1);
    customOptionEl.classList.add('select__option');
    customOptionEl.innerText = text;

    if (this.isMultiple) CustomSelectEntity.createOptionCheckbox(customOptionEl);

    return customOptionEl;
  }

  static createOptionCheckbox(optionEl) {
    const checkbox = document.createElement('span');
    checkbox.classList.add('select__checkbox');
    optionEl.appendChild(checkbox);
  }

  bindEvents() {
    this.onSelectChange = this.onSelectChange.bind(this);
    this.selectEl.addEventListener('change', this.onSelectChange);

    this.onTriggerClick = this.onTriggerClick.bind(this);
    this.onTriggerKeydown = this.onTriggerKeydown.bind(this);
    this.onTriggerFocus = this.onTriggerFocus.bind(this);
    this.onTriggerBlur = this.onTriggerBlur.bind(this);
    this.triggerEl.addEventListener('click', this.onTriggerClick);
    this.triggerEl.addEventListener('keydown', this.onTriggerKeydown);
    this.triggerEl.addEventListener('focus', this.onTriggerFocus);
    this.triggerEl.addEventListener('blur', this.onTriggerBlur);

    if (this.searchInputEl !== undefined) {
      this.onSearchInput = this.onSearchInput.bind(this);
      this.searchInputEl.addEventListener('input', this.onSearchInput);
    }

    this.onClickOutside = this.onClickOutside.bind(this);

    this.onOptionClick = this.onOptionClick.bind(this);
    this.bindOptionsEvents();

    this.onOptionsUpdate = this.onOptionsUpdate.bind(this);
    this.selectEl.addEventListener('CustomSelectOptionsUpdate', this.onOptionsUpdate);
  }

  onOptionsUpdate(e) {
    this.updateOptions(e.detail.options);
  }

  /**
   * Update options list (native & custom)
   * @param {array} options options list
   * @prop {object} options[element] single option object
   * @prop {string} element.value option value
   * @prop {string} element.label option label
   * @prop {boolean} [element.selected] option is selected
   * @prop {boolean} [element.disabled] option is disabled
   * @prop {boolean} [element.empty] option is empty - hidden empty option non multiple & required only
   * @prop {boolean} [element.neverHide] option never hide on search filtering
   */
  updateOptions(options) {
    this.selectEl.innerHTML = '';
    each(options, (option) => {
      const optionEl = document.createElement('option');
      optionEl.value = option.value;
      optionEl.innerText = option.label;

      if (option.selected) optionEl.setAttribute('selected', 'selected');
      if (option.disabled) optionEl.setAttribute('disabled', 'disabled');
      if (option.empty) optionEl.setAttribute('data-empty', '1');
      if (option.neverHide) optionEl.setAttribute('data-never-hide', '1');

      this.selectEl.appendChild(optionEl);
    });
    this.optionsArr = this.selectEl.options;

    this.updateCustomOptions();
    this.onSelectChange();
  }

  updateCustomOptions() {
    this.unbindOptionsEvents();
    this.removeCustomOptions();
    this.createCustomOptions();
    this.bindOptionsEvents();
  }

  bindOptionsEvents() {
    each(this.customOptions, (optionObj, optionIndex) => {
      optionObj.el.setAttribute('data-option-index', optionIndex);
      optionObj.el.addEventListener('click', this.onOptionClick);
      if (optionObj.isOption && optionObj.nativeOptionEl.selected) {
        this.lastSelectedIndex = optionIndex;
      }
    });
  }

  unbindOptionsEvents() {
    each(this.customOptions, (optionObj) => {
      optionObj.el.removeEventListener('click', this.onOptionClick);
    });
  }

  onTriggerFocus() {
    this.rootEl.classList.add(this.classes.rootFocused);
  }

  onTriggerBlur(e) {
    if (
      e.relatedTarget
      && e.relatedTarget.closest('.select__options') === this.customOptionsEl
    ) return;

    this.rootEl.classList.remove(this.classes.rootFocused);
    this.closeOptions();
  }

  onSearchInput() {
    this.filterOptions(this.searchInputEl.value);
  }

  bindDocEvents() {
    document.addEventListener('click', this.onClickOutside);
  }

  unbindDocEvents() {
    document.removeEventListener('click', this.onClickOutside);
  }

  filterOptions(value) {
    const emptyValue = value === '';
    const regex = new RegExp(`${value}`, 'gi');

    let visibleCount = 0;

    each(this.customOptions, (optionObj) => {
      const {
        label,
        isEmpty,
        isNeverHide,
        isNoResults,
      } = optionObj;

      if (isNeverHide) visibleCount++;
      if (isEmpty || isNeverHide || isNoResults) return true;

      if (emptyValue || label.match(regex)) {
        this.setOptionHidden(optionObj, false);

        visibleCount++;
      } else {
        this.setOptionHidden(optionObj, true);
      }
    });

    this.setOptionHidden(this.noResultsOptionObj, visibleCount !== 0);
  }

  onClickOutside(e) {
    if (
      (e.target.closest('.select__options') === this.customOptionsEl)
      || (e.target.closest('.select') === this.rootEl)
    ) return;

    this.closeOptions();
  }

  onTriggerClick(e) {
    e.preventDefault();
    this.toggleOptions();
  }

  onTriggerKeydown(e) {
    const { keyCode } = e;

    switch (keyCode) {
      case KEYS.ESC:
        e.preventDefault();
        if (this.isOpened) this.closeOptions();
        break;

      case KEYS.DOWN:
        e.preventDefault();
        if (this.isOpened) {
          this.setFocus(this.getEnabledIndex(1, this.focusIndex));
        } else if (!this.isMultiple) {
          this.selectOption(this.getEnabledIndex(1, this.lastSelectedIndex));
        }
        break;

      case KEYS.UP:
        e.preventDefault();
        if (this.isOpened) {
          this.setFocus(this.getEnabledIndex(-1, this.focusIndex));
        } else if (!this.isMultiple) {
          this.selectOption(this.getEnabledIndex(-1, this.lastSelectedIndex));
        }
        break;

      case KEYS.SPACE:
        if (this.isOpened && this.withSearch) break;

        if (!this.isOpened) {
          e.preventDefault();
          this.openOptions();
          break;
        }

        this.selectOption(this.focusIndex);
        break;

      case KEYS.ENTER:
        e.preventDefault();
        if (!this.isOpened) {
          this.openOptions();
          break;
        }

        this.selectOption(this.focusIndex);
        break;

      default:
        break;
    }
  }

  setFocus(index) {
    if (index === this.focusIndex) return;

    const { optionFocused } = this.classes;

    if (this.focusIndex !== null) {
      this.customOptions[this.focusIndex].el.classList.remove(optionFocused);
    }
    if (index !== null) {
      this.customOptions[index].el.classList.add(optionFocused);
    }

    this.focusIndex = index;
  }

  setOptionHidden(optionObj, isHidden = true) {
    if (isHidden) {
      optionObj.el.classList.add(this.classes.optionHidden);
    } else {
      optionObj.el.classList.remove(this.classes.optionHidden);
    }
    optionObj.isHidden = isHidden;
  }

  getEnabledIndex(sign, prevIndex) {
    let optionIndex = prevIndex;

    if (optionIndex === null) {
      optionIndex = (sign > 0) ? -1 : 0;
    }

    for (let i = 0; i <= this.maxIndex; i++) {
      optionIndex += sign;
      if (optionIndex > this.maxIndex) optionIndex = 0;
      if (optionIndex < 0) optionIndex = this.maxIndex;

      const {
        isOption,
        isSelectAll,
        isHidden,
        nativeOptionEl,
      } = this.customOptions[optionIndex];

      if (isSelectAll && !isHidden) return optionIndex;
      if (isOption && !isHidden && !nativeOptionEl.disabled) return optionIndex;
    }

    return prevIndex;
  }

  onOptionClick(e) {
    e.preventDefault();

    this.selectOption(e.currentTarget.getAttribute('data-option-index'));
  }

  selectOption(optionIndex) {
    const optionObj =  this.customOptions[optionIndex];
    if (!optionObj) return;

    const { isSelectAll, isOption, nativeOptionEl } = optionObj;

    if (isSelectAll) {
      this.selectAllToggle();
      return;
    }

    if (!isOption || nativeOptionEl.disabled) return;

    nativeOptionEl.selected = this.isMultiple ? !nativeOptionEl.selected : true;
    this.lastSelectedIndex = optionIndex;

    this.afterSelectOption();
  }

  selectAllToggle() {
    let enabledCount = 0;
    let enabledSelectedCount = 0;
    each(this.customOptions, (optionObj) => {
      const { isOption, nativeOptionEl } = optionObj;
      if (!isOption || nativeOptionEl.disabled) return true;

      enabledCount++;

      if (!nativeOptionEl.selected) return true;

      enabledSelectedCount++;
    });

    const selectedStatus = enabledSelectedCount < enabledCount;

    each(this.customOptions, (optionObj) => {
      const { isOption, nativeOptionEl } = optionObj;
      if (!isOption || nativeOptionEl.disabled) return true;

      nativeOptionEl.selected = selectedStatus;
    });

    this.afterSelectOption();
  }

  afterSelectOption() {
    this.triggerEl.focus();
    this.triggerChange();

    if (!this.isMultiple) {
      this.closeOptions();
    }
  }

  triggerChange() {
    this.selectEl.dispatchEvent(new Event('change'));
    this.selectEl.dispatchEvent(new Event('input'));
    this.selectEl.dispatchEvent(new Event('select'));
    this.selectEl.dispatchEvent(new Event('blur'));
  }

  toggleOptions() {
    if (this.isOpened) {
      this.closeOptions();
    } else {
      this.openOptions();
    }
  }

  closeOptions() {
    if (!this.isOpened) return;

    anime.remove(this.customOptionsEl);
    anime({
      targets: this.customOptionsEl,
      opacity: 0,
      translateY: 0,
      easing: 'easeOutCubic',
      duration: 300,
      complete: () => {
        this.bodyEl.removeChild(this.customOptionsEl);
        this.setFocus(null);
      },
    });

    this.rootEl.classList.remove(this.classes.rootActive);
    this.unbindDocEvents();

    this.isOpened = false;
  }

  openOptions() {
    if (this.isOpened) return;

    const selectRect = this.selectEl.getBoundingClientRect();
    const scrollTop = window.scrollY
      || window.pageYOffset
      || document.body.scrollTop
      || document.documentElement.scrollTop
      || 0;

    const optionsStyle = this.customOptionsEl.style;
    optionsStyle.top = `${(selectRect.top + selectRect.height + scrollTop)}px`;
    optionsStyle.left = `${selectRect.left}px`;
    optionsStyle.width = `${selectRect.width}px`;
    optionsStyle.opacity = 0;

    anime.remove(this.customOptionsEl);
    anime.set(this.customOptionsEl, {
      opacity: 0,
      translateY: 0,
    });

    this.setFocus(null);
    this.bodyEl.appendChild(this.customOptionsEl);

    anime({
      targets: this.customOptionsEl,
      opacity: 1,
      translateY: 0,
      easing: 'easeOutCubic',
      duration: 300,
      complete: () => {
        optionsStyle.opacity = '';
      },
    });

    this.rootEl.classList.add(this.classes.rootActive);
    this.bindDocEvents();

    this.isOpened = true;
  }

  onSelectChange() {
    let value = '';
    let optionsCount = 0;
    let selectedCount = 0;

    each(this.customOptions, (optionObj) => {
      if (!optionObj.isOption) return true;
      optionsCount++;

      const { el, nativeOptionEl, label } = optionObj;
      if (nativeOptionEl.selected) {
        el.classList.add(this.classes.optionSelected);
        value = label;
        selectedCount++;
      } else {
        el.classList.remove(this.classes.optionSelected);
      }
    });

    value = this.getValueText(value, selectedCount);

    this.valueEl.innerText = value;

    this.setPlaceholder(value);
    this.setSelectAll(selectedCount, optionsCount);
  }

  getValueText(value, selectedCount) {
    if (selectedCount <= 0) return '';
    if (selectedCount > 1) return `${this.selectedText} (${selectedCount})`;
    return value;
  }

  setPlaceholder(value) {
    if (value === '') {
      this.rootEl.classList.add(this.classes.rootPlaceholder);
    } else {
      this.rootEl.classList.remove(this.classes.rootPlaceholder);
    }
  }

  setSelectAll(selected, all) {
    if (!this.withSelectAll) return;

    if (selected === 0) { // empty
      this.selectAllOptionEl.classList.remove(this.classes.optionSelected);
      this.selectAllOptionEl.classList.remove(this.classes.optionPartial);
      return;
    }

    if (selected === all) { // full
      this.selectAllOptionEl.classList.remove(this.classes.optionPartial);
      this.selectAllOptionEl.classList.add(this.classes.optionSelected);
      return;
    }

    // partial
    this.selectAllOptionEl.classList.remove(this.classes.optionSelected);
    this.selectAllOptionEl.classList.add(this.classes.optionPartial);
  }

  destroy() {
    if (this.placeholderEl) this.rootEl.removeChild(this.placeholderEl);
    if (this.valueEl) this.rootEl.removeChild(this.valueEl);
    if (this.buttonEl) this.rootEl.removeChild(this.buttonEl);
    if (this.searchEl) this.rootEl.removeChild(this.searchEl);
    if (this.customOptionsEl && this.customOptionsEl.parentElement) {
      this.customOptionsEl.parentElement.removeChild(this.customOptionsEl);
    }

    // show native select
    this.selectEl.classList.remove('select__input--hidden');
  }
}

export default class CustomSelect {
  constructor() {
    this.entities = new Entities(
      'CustomSelect',
      '[data-custom-select]',
      CustomSelect.initSingle,
      CustomSelect.destroySingle,
    );
  }

  static initSingle(element) {
    return new CustomSelectEntity(element);
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
