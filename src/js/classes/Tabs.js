import anime from 'animejs/lib/anime.es';
import Entities from './shared/Entities';

import { mapEach, each } from '../helpers/array';
import { setAttr, setStyles } from '../helpers/dom';

const DURATION = 300;

export default class Tabs {
  constructor() {
    this.entities = new Entities(
      'Tabs',
      '[data-tabs]',
      Tabs.initSingle,
      Tabs.destroySingle,
    );
  }

  static initSingle(containerEl) {
    const scopePrefix = containerEl.getAttribute('data-tabs');

    // items
    const itemsEl = containerEl.querySelector('[data-tabs-items]');
    const itemsArr = itemsEl.querySelectorAll('[data-tabs-item]');
    const itemObjsArr = mapEach(itemsArr, el => ({
      el,
      id: el.getAttribute('data-tabs-item'),
      isActive: el.hasAttribute('data-active'),
    })).filter(itemObj => itemObj.id.startsWith(scopePrefix));

    let lastId = itemObjsArr.find(itemObj => itemObj.isActive)?.id ?? null;

    // nav items
    const navItemsArr = containerEl.querySelectorAll('[data-tabs-nav-item]');
    const navItemObjsArr = mapEach(navItemsArr, el => ({
      el,
      id: el.getAttribute('data-tabs-nav-item'),
      isActive: el.hasAttribute('data-active'),
    })).filter(navItemObj => navItemObj.id.startsWith(scopePrefix));

    // select
    const selectEl = containerEl.querySelector('[data-tabs-select]');

    // methods
    function setActive(id) {
      const nextId = id;
      if (nextId === lastId) return;

      lastId = Tabs.animToActive(itemsEl, itemObjsArr, lastId, nextId);
      Tabs.setNavItems(navItemObjsArr, nextId);
      Tabs.setSelect(selectEl, nextId);
    }

    // nav items
    function onNavItemClick(event) {
      const id = event.currentTarget.getAttribute('data-tabs-nav-item');
      if (id === null) return;

      setActive(id);
    }
    each(navItemObjsArr, (navItemObj) => {
      navItemObj.el.addEventListener('click', onNavItemClick);
    });

    // select
    function onSelectChange(event) {
      const id = event.currentTarget.value;
      if (id === '') return;

      setActive(id);
    }
    (selectEl !== null) && selectEl.addEventListener('change', onSelectChange);

    function destroy() {
      each(navItemObjsArr, (navItemObj) => {
        navItemObj.el.removeEventListener('click', onNavItemClick);
      });
      (selectEl !== null) && selectEl.removeEventListener('change', onSelectChange);
    }

    return {
      setActive,
      destroy,
    };
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }

  static setItemActive(itemObj, isActive) {
    setAttr(itemObj.el, 'data-active', isActive ? '' : null);

    itemObj.isActive = isActive;
  }

  static setNavItems(navItemObjsArr, nextId) {
    if (navItemObjsArr.length === 0) return;

    each(navItemObjsArr, ({ el, id }) => {
      const isActive = id === nextId;
      setAttr(el, 'data-active', isActive ? '' : null);
      setAttr(el, 'aria-selected', isActive ? 'true' : 'false');
    });
  }

  static setSelect(selectEl, nextId) {
    if (selectEl === null) return;

    each(selectEl.options, (option) => {
      option.selected = option.value === nextId;
    });

    selectEl.dispatchEvent(new Event('change'));
    selectEl.dispatchEvent(new Event('input'));
    selectEl.dispatchEvent(new Event('select'));
    selectEl.dispatchEvent(new Event('blur'));
  }

  static animToActive(itemsEl, itemObjsArr, prevId, nextId) {
    if (nextId === prevId) return prevId;

    const prevItemObj = itemObjsArr.find(itemObj => itemObj.id === prevId);
    const nextItemObj = itemObjsArr.find(itemObj => itemObj.id === nextId);

    if (nextItemObj === null) return prevId;

    anime.remove(itemsEl);
    const beginHeight = itemsEl.offsetHeight;
    const endHeight = nextItemObj.el.offsetHeight;

    anime.set(itemsEl, {
      height: beginHeight,
    });
    Tabs.presetContentStyles(itemsEl);

    Tabs.setItemActive(prevItemObj, false);
    Tabs.setItemActive(nextItemObj, true);

    if (endHeight === beginHeight) {
      Tabs.resetContentStyles(itemsEl);
      return nextId;
    }

    anime({
      targets: itemsEl,
      height: endHeight,
      easing: 'easeOutCubic',
      duration: DURATION,
      complete: () => {
        Tabs.resetContentStyles(itemsEl);
      },
    });

    return nextId;
  }

  static presetContentStyles(itemsEl) {
    setStyles(itemsEl, {
      overflow: 'hidden',
      visibility: 'visible',
    });
  }

  static resetContentStyles(itemsEl) {
    setStyles(itemsEl, {
      height: '',
      overflow: '',
      visibility: '',
    });
  }
}
