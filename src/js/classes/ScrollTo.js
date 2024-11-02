import anime from 'animejs/lib/anime.es';

import Entities from './shared/Entities';

export const scrollToTarget = (target) => {
  window.dispatchEvent(new CustomEvent('ScrollToTarget', {
    detail: {
      target,
    },
  }));
};

export const scrollTo = (offset) => {
  window.dispatchEvent(new CustomEvent('ScrollToOffset', {
    detail: {
      offset,
    },
  }));
};

export default class ScrollTo {
  constructor() {
    this.init();
    this.bindDocEvents();

    this.initSingle = this.initSingle.bind(this);
    this.destroySingle = this.destroySingle.bind(this);
    this.entities = new Entities(
      'ScrollTo',
      '[data-scroll-to]',
      this.initSingle,
      this.destroySingle,
    );

    this.checkHash();
  }

  init() {
    this.headerEl = document.querySelector('[data-scroll-to-header]');

    this.animProps = {
      scrollTop: 0,
    };
  }

  bindDocEvents() {
    this.onTriggerClick = this.onTriggerClick.bind(this);
    this.onAnimUpdate = this.onAnimUpdate.bind(this);

    this.onWheel = this.onWheel.bind(this);
    document.addEventListener('wheel', this.onWheel, { passive: true });

    this.onScrollToTarget = this.onScrollToTarget.bind(this);
    window.addEventListener('ScrollToTarget', this.onScrollToTarget);
    this.onScrollToOffset = this.onScrollToOffset.bind(this);
    window.addEventListener('ScrollToOffset', this.onScrollToOffset);
  }

  onScrollToTarget(e) {
    this.scrollToTarget(e.detail.target);
  }

  onScrollToOffset(e) {
    const scrollTop = ScrollTo.scrollTop();
    this.scrollTo(e.detail.offset, scrollTop);
  }

  initSingle(triggerEl) {
    triggerEl.addEventListener('click', this.onTriggerClick);

    return {
      triggerEl,
    };
  }

  destroySingle({ entityObj }) {
    entityObj.triggerEl.removeEventListener('click', this.onTriggerClick);
  }

  onWheel() {
    anime.remove(this.animProps);
  }

  onTriggerClick(e) {
    const targetId = e.currentTarget.getAttribute('data-scroll-to');

    const targetEl = document.querySelector(`[data-scroll-to-target="${targetId}"]`);
    if (!targetEl) return;

    e.preventDefault();
    this.scrollToTarget(targetEl);
  }

  scrollToTarget(targetEl) {
    const targetRect = targetEl.getBoundingClientRect();
    const scrollTop = ScrollTo.scrollTop();
    const headerHeight = this.headerEl.offsetHeight;
    // const headerHeight = 0;

    this.scrollTo(scrollTop + targetRect.top - headerHeight, scrollTop);
  }

  scrollTo(scrollVal, scrollBeginVal = 0) {
    anime.remove(this.animProps);
    anime.set(this.animProps, {
      scrollTop: scrollBeginVal,
    });

    anime({
      targets: this.animProps,
      scrollTop: scrollVal,
      easing: 'easeOutCubic',
      duration: 600,
      update: this.onAnimUpdate,
    });
  }

  onAnimUpdate() {
    ScrollTo.scrollTop(this.animProps.scrollTop);
  }

  static scrollTop(scrollVal) {
    if (scrollVal) {
      document.body.scrollTop = scrollVal;
      document.documentElement.scrollTop = scrollVal;
    } else {
      return window.scrollY
        || window.pageYOffset
        || document.body.scrollTop
        || document.documentElement.scrollTop
        || 0;
    }
  }

  checkHash() {
    setTimeout(() => {
      const hashString = window.location.hash;
      const targetId = hashString.substring(1).split('&').reduce((acc, attrString) => {
        const [key, value] = attrString.split('=');
        if (key === 'scroll-to') return value;
        return acc;
      }, null);

      const targetEl = document.querySelector(`[data-scroll-to-target="${targetId}"]`);
      if (!targetEl) return;

      this.scrollToTarget(targetEl);
    });
  }
}
