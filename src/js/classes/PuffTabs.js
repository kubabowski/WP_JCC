import Entities from './shared/Entities';
import SliderNav from './shared/SliderNav';
import DragAndDrop from './shared/DragAndDrop';
import { createBreakpointObserver } from './shared/MediaQuery';

import { each, mapEach } from '../helpers/array';
import { setAttrs } from '../helpers/dom';
import { rtlSign } from '../helpers/document';

class PuffTabsEntity {

  constructor(rootEl) {
    if (!this.setVars(rootEl)) return;

    this.initNav();
    this.bindEvents();
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.navEl = rootEl.querySelector('[data-puff-tabs-nav]');
    if (!this.navEl) return false;

    this.mobileNavEl = rootEl.querySelector('[data-puff-tabs-nav-mobile]');
    if (!this.mobileNavEl) return false;

    const bodyArr = rootEl.querySelectorAll('[data-puff-tabs-tab-body]');
    const headArr = rootEl.querySelectorAll('[data-puff-tabs-tab-head]');
    const labelArr = rootEl.querySelectorAll('[data-puff-tabs-tab-label]');

    this.tabObjsArr = mapEach(bodyArr, (bodyEl, index) => ({
      index,
      bodyEl,
      headEl: headArr[index],
      labelEl: labelArr[index],
    }));

    this.maxIndex = this.tabObjsArr.length - 1;

    this.prevIndex = 0;
    this.headWidth = null;
    this.bodyWidth = null;

    this.rtlSign = rtlSign;
    this.dragThreshold = 50;
    this.dragObserving = false;

    return true;
  }

  initNav() {
    this.onNextClickEvent = this.onNextClick.bind(this);
    this.onPrevClickEvent = this.onPrevClick.bind(this);

    this.sliderNavArr = mapEach([this.navEl, this.mobileNavEl], navEl => new SliderNav({
      element: navEl,
      onNextClick: this.onNextClickEvent,
      onPrevClick: this.onPrevClickEvent,
      current: this.prevIndex + 1,
      total: this.maxIndex + 1,
      loop: false,
    }));
  }

  bindEvents() {
    this.onHeadClickEvent = this.onHeadClick.bind(this);
    each(this.tabObjsArr, ({ headEl }) => {
      headEl.addEventListener('click', this.onHeadClickEvent);
    });

    this.onDragEndEvent = this.onDragEnd.bind(this);
    this.dragAndDrop = new DragAndDrop({
      element: this.rootEl,
      onEnd: this.onDragEndEvent,
    });

    this.onMediaQueryChangeEvent = this.onMediaQueryChange.bind(this);
    this.mediaQueryObserver = createBreakpointObserver('tablet', this.onMediaQueryChangeEvent);
    this.mediaQueryObserver.observe();
  }

  onMediaQueryChange(matches) {
    this.dragObserving = !matches;
  }

  onDragEnd({ diff }) {
    if (!this.dragObserving) return;

    if (diff.x < -this.dragThreshold) {
      this.goTo(this.prevIndex + (1 * this.rtlSign));
    } else if (diff.x > this.dragThreshold) {
      this.goTo(this.prevIndex - (1 * this.rtlSign));
    }
  }

  onNextClick() {
    this.goTo(this.prevIndex + 1);
  }

  onPrevClick() {
    this.goTo(this.prevIndex - 1);
  }

  onHeadClick(e) {
    const clickedHeadEl = e.currentTarget;

    const tabObj = this.tabObjsArr.find(({ headEl }) => headEl === clickedHeadEl);
    if (tabObj === null) return;

    this.goTo(tabObj.index);
  }

  goTo(index) {
    let activeIndex = index;

    // // loop
    // if (activeIndex < 0) activeIndex = this.maxIndex;
    // if (activeIndex > this.maxIndex) activeIndex = 0;
    // no loop
    if (activeIndex < 0) activeIndex = 0;
    if (activeIndex > this.maxIndex) activeIndex = this.maxIndex;

    if (activeIndex === this.prevIndex) return;

    each(this.tabObjsArr, (tabObj, tabIndex) => {
      let type = 'current';
      if (tabIndex < activeIndex) type = 'prev';
      if (tabIndex > activeIndex) type = 'next';

      const tabAttrs = {
        'tab-type': type,
        'tab-offset': Math.abs(tabIndex - activeIndex),
      };

      setAttrs(tabObj.bodyEl, tabAttrs, 'data-puff-tabs-');
      setAttrs(tabObj.headEl, tabAttrs, 'data-puff-tabs-');
      setAttrs(tabObj.labelEl, tabAttrs, 'data-puff-tabs-');
    });

    this.prevIndex = activeIndex;

    each(this.sliderNavArr, (sliderNav) => {
      sliderNav.setState({ current: activeIndex + 1 });
    });
  }

  destroy() {
    each(this.tabObjsArr, ({ headEl }) => {
      headEl.removeEventListener('click', this.onHeadClickEvent);
    });

    if (this.dragAndDrop) this.dragAndDrop.destroy();
    if (this.mediaQueryObserver) this.mediaQueryObserver.unobserve();
  }
}

export default class PuffTabs {
  constructor() {
    this.entities = new Entities(
      'PuffTabs',
      '[data-puff-tabs]',
      PuffTabs.initSingle,
      PuffTabs.destroySingle,
    );
  }

  static initSingle(element) {
    return new PuffTabsEntity(element);
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
