import anime from 'animejs/lib/anime.es';
import Entities from './shared/Entities';

import { mapEach } from '../helpers/array';
import { setClassName, setStyles } from '../helpers/dom';

const DURATION = 400;

export default class Accordion {
  constructor() {
    this.entities = new Entities(
      'Accordion',
      '[data-accordion]',
      Accordion.initSingle,
      Accordion.destroySingle,
    );
  }

  static initSingle(containerEl) {
    const itemsArr = containerEl.querySelectorAll('[data-accordion-item]');

    const itemObjsArr = mapEach(itemsArr, (el, index) => {
      const headEl = el.querySelector('[data-accordion-item-head]');
      const bodyEl = el.querySelector('[data-accordion-item-body]');
      const activeClass = el.getAttribute('data-accordion-item-active');
      const isActive = el.classList.contains(activeClass);

      return {
        el,
        index,
        headEl,
        bodyEl,
        activeClass,
        isActive,
      };
    });

    let activeIndex = null;

    function toggleItem(index) {
      if (activeIndex === null) {
        Accordion.expandItem(itemObjsArr[index]);
        activeIndex = index;
        return;
      }

      if (index === activeIndex) {
        Accordion.collapseItem(itemObjsArr[index]);
        activeIndex = null;
        return;
      }

      Accordion.collapseItem(itemObjsArr[activeIndex]);
      Accordion.expandItem(itemObjsArr[index]);
      activeIndex = index;
    }

    // nav tabs
    function onHeadClick(e) {
      const clickedHeadEl = e.currentTarget;
      const clickedItem = itemObjsArr.find(({ headEl }) => headEl === clickedHeadEl);
      if (clickedItem === undefined) return;

      toggleItem(clickedItem.index);
    }

    itemObjsArr.forEach((itemObj) => {
      itemObj.headEl.addEventListener('click', onHeadClick);
    });

    // --
    function destroy() {
      itemObjsArr.forEach((itemObj) => {
        itemObj.headEl.removeEventListener('click', onHeadClick);
      });
    }

    return {
      toggleItem,
      destroy,
    };
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }

  static setItemActive(itemObj, isActive) {
    setClassName(itemObj.el, itemObj.activeClass, isActive);

    itemObj.isActive = isActive;
  }

  static expandItem(itemObj) {
    const { isActive, bodyEl } = itemObj;

    if (isActive) return;

    anime.remove(bodyEl);
    anime.set(bodyEl, { height: bodyEl.offsetHeight });
    Accordion.presetBodyStyles(bodyEl);
    Accordion.setItemActive(itemObj, true);

    anime({
      targets: bodyEl,
      height: bodyEl.scrollHeight,
      easing: 'easeOutCubic',
      duration: DURATION,
      complete: () => {
        Accordion.resetBodyStyles(bodyEl);
      },
    });
  }

  static collapseItem(itemObj) {
    const { isActive, bodyEl } = itemObj;

    if (!isActive) return;

    anime.remove(bodyEl);
    anime.set(bodyEl, { height: bodyEl.offsetHeight });
    Accordion.presetBodyStyles(bodyEl);
    Accordion.setItemActive(itemObj, false);

    anime({
      targets: bodyEl,
      height: 0,
      easing: 'easeOutCubic',
      duration: DURATION,
      complete: () => {
        Accordion.resetBodyStyles(bodyEl);
      },
    });
  }

  static presetBodyStyles(itemsEl) {
    setStyles(itemsEl, {
      overflow: 'hidden',
      visibility: 'visible',
    });
  }

  static resetBodyStyles(itemsEl) {
    setStyles(itemsEl, {
      height: '',
      overflow: '',
      visibility: '',
    });
  }
}
