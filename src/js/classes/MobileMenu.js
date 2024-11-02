import { each, mapEach } from '../helpers/array';
import { setAttr } from '../helpers/dom';
import { rtlSign } from '../helpers/document';

export default class MobileMenu {
  constructor() {
    // if (!MobileMenu.init()) return;
    MobileMenu.init();
  }

  static init() {
    const menuEl = document.querySelector('[data-mobile-menu]');
    if (!menuEl) return false;

    const buttonsArr = document.querySelectorAll('[data-mobile-menu-button]');
    if (!buttonsArr) return false;

    // const closeButtonEl = menuEl.querySelector('[data-mobile-menu-close]');
    // if (!closeButtonEl) return false;

    // this.rtlSign = rtlSign;

    let isActive = menuEl.getAttribute('data-active') !== null;

    // this.expandedItemId = null;

    // this.duration = 200;

    // methods

    function open() {
      if (isActive) return;

      setAttr(menuEl, 'data-active', '');
      isActive = true;

      // eslint-disable-next-line no-use-before-define
      document.addEventListener('click', onClickOutside);
    }

    function close() {
      if (!isActive) return;

      setAttr(menuEl, 'data-active', null);
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
        (e.target.closest('[data-mobile-menu]') === menuEl)
        // || (e.target.closest('[data-mobile-menu-close]') === closeButtonEl)
        || (e.target.closest('[data-mobile-menu-button]') !== null)
      ) return;

      close();
    }

    function onButtonClick(e) {
      e.preventDefault();

      toggle();
    }

    // function onCloseButtonClick(e) {
    //   e.preventDefault();
    //   close();
    // }

    each(buttonsArr, (buttonEl) => {
      buttonEl.addEventListener('click', onButtonClick);
    });
    // if (closeButtonEl) closeButtonEl.addEventListener('click', onCloseButtonClick);

    function destroy() {
      each(buttonsArr, (buttonEl) => {
        buttonEl.removeEventListener('click', onButtonClick);
      });
      // if (closeButtonEl) closeButtonEl.removeEventListener('click', onCloseButtonClick);
    }

    return {
      open,
      close,
      toggle,
      destroy,
    };
  }

  // getItemObjsArr(linksArr) {
  //   return mapEach(linksArr, (linkEl) => {
  //     const id = linkEl.getAttribute('data-mobile-menu-link');
  //     const itemEl = this.itemsEl.querySelector(`[data-mobile-menu-item="${id}"]`);
  //     const submenuEl = this.itemsEl.querySelector(`[data-mobile-menu-submenu="${id}"]`);
  //     const backButtonEl = this.itemsEl.querySelector(`[data-mobile-menu-back="${id}"]`);

  //     return {
  //       id,
  //       itemEl,
  //       linkEl,
  //       submenuEl,
  //       backButtonEl,
  //     };
  //   });
  // }

  // getItemObjById(itemId) {
  //   return this.itemObjsArr.find(itemObj => itemObj.id === itemId);
  // }
}
