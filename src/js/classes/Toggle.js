import { each, mapEach } from '../helpers/array';
import { setClassName } from '../helpers/dom';
// import anime from 'animejs/lib/anime.es';

import Entities from './shared/Entities';

export default class Toggle {
  constructor() {
    this.entities = new Entities(
      'Toggle',
      '[data-toggle-id]',
      Toggle.initSingle,
    );
  }

  static initSingle(contentEl) {
    const id = contentEl.getAttribute('data-toggle-id');
    const buttonsArr = document.querySelectorAll(`[data-toggle-target="${id}"]`);

    const toggleObj = {
      id,
      contentEl,
      contentActiveClass: contentEl.getAttribute('data-toggle-class'),
      buttonObjsArr: mapEach(buttonsArr, buttonEl => ({
        buttonEl,
        buttonActiveClass: buttonEl.getAttribute('data-toggle-class'),
      })),
      isActive: false,
    };

    function onButtonClick(e) {
      e.preventDefault();

      Toggle.toggle(toggleObj);
    }

    each(toggleObj.buttonObjsArr, ({ buttonEl }) => {
      buttonEl.addEventListener('click', onButtonClick);
    });

    toggleObj.onClickOutside = Toggle.getOnClickOutside(toggleObj);

    return toggleObj;
  }

  static getOnClickOutside(toggleObj) {
    if (toggleObj.contentEl.getAttribute('data-toggle-close-outside') === null) return null;

    return function onClickOutside(e) {
      const { isActive, id, contentEl } = toggleObj;

      if (!isActive) return;

      if (
        e.target.closest(`[data-toggle-id="${id}"]`) === contentEl
        || e.target.closest(`[data-toggle-target="${id}"]`) !== null
      ) return;

      Toggle.hide(toggleObj);
    };
  }

  static bindDocEvents({ onClickOutside }) {
    if (onClickOutside === null) return;

    document.addEventListener('click', onClickOutside);
  }

  static unbindDocEvents({ onClickOutside }) {
    if (onClickOutside === null) return;

    document.removeEventListener('click', onClickOutside);
  }

  static setActive(toggleObj, isActive) {
    setClassName(toggleObj.contentEl, toggleObj.contentActiveClass, isActive);
    each(toggleObj.buttonObjsArr, (buttonObj) => {
      setClassName(buttonObj.buttonEl, buttonObj.buttonActiveClass, isActive);
    });

    toggleObj.isActive = isActive;
  }

  static toggle(toggleObj) {
    if (toggleObj.isActive) {
      Toggle.hide(toggleObj);
    } else {
      Toggle.show(toggleObj);
    }
  }

  static show(toggleObj) {
    if (toggleObj.isActive) return;

    Toggle.bindDocEvents(toggleObj);

    switch (toggleObj.mode) {
      default:
        Toggle.setActive(toggleObj, true);
        break;
    }

    // contentEl.style.height = 0;
    // contentEl.style.opacity = 0;
    // contentEl.classList.add(contentEl.getAttribute('data-toggle-class'));
    // buttonEl.classList.add(buttonEl.getAttribute('data-toggle-class'));
    // anime({
    //   targets: contentEl,
    //   height: contentEl.scrollHeight,
    //   opacity: 1,
    //   easing: 'easeOutCubic',
    //   duration: this.duration,
    //   complete: () => {
    //     contentEl.style.height = '';
    //     contentEl.style.opacity = '';
    //   },
    // });
  }

  static hide(toggleObj) {
    if (!toggleObj.isActive) return;

    Toggle.unbindDocEvents(toggleObj);

    switch (toggleObj.mode) {
      default:
        Toggle.setActive(toggleObj, false);
        break;
    }

    // contentEl.style.height = contentEl.scrollHeight;
    // contentEl.style.opacity = 1;
    // anime({
    //   targets: contentEl,
    //   height: 0,
    //   opacity: 0,
    //   easing: 'easeOutCubic',
    //   duration: this.duration,
    //   complete: () => {
    //     buttonEl.classList.remove(buttonEl.getAttribute('data-toggle-class'));
    //     contentEl.classList.remove(contentEl.getAttribute('data-toggle-class'));
    //     contentEl.style.height = '';
    //     contentEl.style.opacity = '';
    //   },
    // });
  }
}
