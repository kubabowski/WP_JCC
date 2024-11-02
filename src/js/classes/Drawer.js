import { each } from '../helpers/array';
import { setAttr } from '../helpers/dom';

const KEYS = {
  ESC: 27,
};

export default class Drawer {
  constructor() {
    if (!this.setVars()) return;

    this.bindEvents();
  }

  setVars() {
    this.menuEl = document.querySelector('[data-drawer]');
    if (!this.menuEl) return false;

    this.buttonsArr = document.querySelectorAll('[data-drawer-button]');
    if (this.buttonsArr.length === 0) return false;

    // this.closeButtonEl = this.menuEl.querySelector('[data-drawer-close]');
    // if (!this.closeButtonEl) return false;

    this.overlayEl = document.querySelector('[data-drawer-overlay]');

    this.isOpened = false;

    this.lastButtonEl = null;

    return true;
  }

  bindEvents() {
    this.onButtonClickEvent = this.onButtonClick.bind(this);
    // this.onCloseButtonClickEvent = this.onCloseButtonClick.bind(this);
    this.onClickOutsideEvent = this.onClickOutside.bind(this);
    this.onMenuFocusoutEvent = this.onMenuFocusout.bind(this);
    this.onMenuKeydownEvent = this.onMenuKeydown.bind(this);

    each(this.buttonsArr, (buttonEl) => {
      buttonEl.addEventListener('click', this.onButtonClickEvent);
    });
    // this.closeButtonEl.addEventListener('click', this.onCloseButtonClickEvent);

    this.menuEl.addEventListener('focusout', this.onMenuFocusoutEvent);
    this.menuEl.addEventListener('keydown', this.onMenuKeydownEvent);
  }

  onButtonClick(e) {
    e.preventDefault();
    e.stopPropagation();
    // this.showMenu(e);
    this.toggleMenu(e.currentTarget);
  }

  onCloseButtonClick(e) {
    e.preventDefault();
    e.stopPropagation();
    this.hideMenu(this.lastButtonEl);
  }

  onMenuFocusout(e) {
    // // check inside the current submenu
    // if (e.currentTarget.contains(e.relatedTarget)) return;

    if (e.relatedTarget !== null && this.checkIsOwnElement(e.relatedTarget)) return;

    this.hideMenu(this.lastButtonEl);
  }

  onMenuKeydown(e) {
    // check is not esc key
    if (e.keyCode !== KEYS.ESC) return;

    this.hideMenu(this.lastButtonEl);
  }

  bindDocEvents() {
    document.addEventListener('click', this.onClickOutsideEvent);
  }

  unbindDocEvents() {
    document.removeEventListener('click', this.onClickOutsideEvent);
  }

  onClickOutside(e) {
    if (!this.isOpened) return;

    if (this.checkIsOwnElement(e.target)) return;

    this.hideMenu();
  }

  checkIsOwnElement(el) {
    return (
      el.closest('[data-drawer]') === this.menuEl
      // || el.closest('[data-drawer-close]') === this.closeButtonEl
      || el.closest('[data-drawer-button]') !== null
    );
  }

  toggleMenu(buttonEl)
  {
    if (this.isOpened) {
      this.hideMenu();
    } else {
      this.showMenu(buttonEl);
    }
  }

  showMenu(buttonEl) {
    if (this.isOpened) return;

    this.setAttrs(true);
    this.bindDocEvents();

    this.isOpened = true;

    this.lastButtonEl = buttonEl;

    setTimeout(() => {
      this.menuEl.focus();
    }, 100); // fix visibility hidden -> visible issue
  }

  hideMenu(buttonEl = null) {
    if (!this.isOpened) return;

    this.setAttrs(false);
    this.unbindDocEvents();

    this.isOpened = false;

    if (buttonEl !== null) buttonEl.focus();

    this.lastButtonEl = null;
  }

  setAttrs(status) {
    setAttr(this.menuEl, 'data-active', status ? '' : null);
    each(this.buttonsArr, (buttonEl) => {
      setAttr(buttonEl, 'data-active', status ? '' : null);
      setAttr(buttonEl, 'aria-expanded', status ? 'true' : 'false');
    });
    if (this.overlayEl) setAttr(this.overlayEl, 'data-active', status ? '' : null);
  }
}
