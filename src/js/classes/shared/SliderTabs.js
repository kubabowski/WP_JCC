import { each, mapEach } from '../../helpers/array';
import { setClassName } from '../../helpers/dom';
import { isRtl } from '../../helpers/document';

export default class SliderTabs {
  constructor(options = {}) {
    if (!this.setVars(options)) return;
    this.bindEvents();
  }

  setVars(options) {
    this.rootEl = options.element;
    if (!this.rootEl) return false;

    this.scrollEl = this.rootEl;

    const tabsArr = this.rootEl.querySelectorAll('[data-slider-tabs-tab]');
    this.tabObjsArr = mapEach(tabsArr, (el, index) => ({
      el,
      index,
      activeClass: el.getAttribute('data-slider-tabs-tab-active') ?? '',
      inactiveClass: el.getAttribute('data-slider-tabs-tab-inactive') ?? '',
    }));

    this.state = {};
    this.setState({
      activeIndex: options.activeIndex ?? 0,
    });

    this.onTabClickHandler = options.onTabClick || (() => {});
    this.onTabClickEvent = this.onTabClick.bind(this);

    return true;
  }

  setState(state) {
    this.state = {
      ...this.state,
      ...state,
    };

    this.updateTabs();
  }

  onTabClick(e) {
    const tabEl = e.currentTarget;
    const tabObj = this.tabObjsArr.find(({ el }) => el === tabEl);
    if (tabObj === undefined) return;

    this.scrollToTab(tabObj);
    this.onTabClickHandler(tabObj);
  }

  scrollToTab({ el }) {
    const elRect = el.getBoundingClientRect();
    const firstEl = this.tabObjsArr[0].el;
    const firstElRect = (firstEl === el) ? elRect : firstEl.getBoundingClientRect();

    const offsetProp = isRtl ? 'right' : 'left';

    const offset = firstElRect[offsetProp];
    const scrollLeft = (elRect[offsetProp] - offset);

    this.scrollEl.scroll({
      left: scrollLeft,
      behavior: 'smooth',
    });
  }

  updateTabs() {
    const { activeIndex } = this.state;

    each(this.tabObjsArr, ({
      el, index, activeClass, inactiveClass,
    }) => {
      setClassName(el, activeClass, index === activeIndex);
      setClassName(el, inactiveClass, index !== activeIndex);
    });

    this.scrollToTab(this.tabObjsArr[activeIndex]);
  }

  bindEvents() {
    each(this.tabObjsArr, ({ el }) => {
      el.addEventListener('click', this.onTabClickEvent);
    });
  }

  unbindEvents() {
    each(this.tabObjsArr, ({ el }) => {
      el.removeEventListener('click', this.onTabClickEvent);
    });
  }

  destory() {
    this.unbindEvents();
  }
}
