import { setAttr } from '../helpers/dom';
import { trigger } from '../helpers/event';

export default class Header {
  constructor() {
    if (!this.setVars()) return;

    this.bindEvents();
  }

  setVars() {
    this.headerEl = document.querySelector('[data-header]');
    if (!this.headerEl) return false;

    this.spaceEl = this.headerEl.querySelector('[data-header-space]');
    if (!this.spaceEl) return false;

    this.lastScrollTop = 0;

    this.lastNotTop = false;
    this.darkTimeout = null;
    this.darkDelay = 300;

    return true;
  }

  bindEvents() {
    this.onScrollEvent = this.onScroll.bind(this);
    window.addEventListener('liteScroll', this.onScrollEvent);
  }

  onScroll(e) {
    const { scrollTop } = e.detail;

    const isNotTop = scrollTop > this.spaceEl.offsetHeight;
    const isScrollDown = scrollTop >= this.lastScrollTop;

    setAttr(this.headerEl, 'data-header-not-top', isNotTop ? '' : null);
    setAttr(this.headerEl, 'data-header-scroll-down', isScrollDown ? '' : null);

    trigger(window, 'HeaderScrollDown', {
      isScrollDown,
      scrollTop,
    });

    this.lastScrollTop = scrollTop;
  }
}
