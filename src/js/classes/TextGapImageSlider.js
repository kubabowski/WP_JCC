import Swiper, { Pagination } from 'swiper';

import Entities from './shared/Entities';
import SliderTabs from './shared/SliderTabs';
import { creareNavPagination, creareNavForBullets } from './shared/SliderNavHelpers';
import { createBreakpointObserver } from './shared/MediaQuery';

import { each } from '../helpers/array';
import { setSlideAttrs } from '../helpers/slider';

class TextGapImageSliderEntity {

  constructor(rootEl) {
    if (!this.setVars(rootEl)) return;

    this.initSwiper();
    this.initTabs();
    this.bindEvents();
    this.onSlideChange();
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.sliderEl = rootEl.querySelector('[data-text-gap-image-slider-slider]');
    if (!this.sliderEl) return false;

    this.clipEl = rootEl.querySelector('[data-text-gap-image-slider-clip]');
    if (this.clipEl !== null) {
      this.clipClass = this.clipEl.getAttribute('data-text-gap-image-slider-clip');
    }

    this.navEl = rootEl.querySelector('[data-text-gap-image-slider-nav]');
    this.tabsEl = rootEl.querySelector('[data-text-gap-image-slider-tabs]');
    this.dotsEl = rootEl.querySelector('[data-text-gap-image-slider-dots]');

    return true;
  }

  initSwiper() {
    Swiper.use(Pagination);

    const navObj = {};

    if (this.dotsEl !== null) {
      const [updateNav, setNavSwiper] = creareNavForBullets(this.navEl ? [this.navEl] : []);
      this.dotsUpdateNav = updateNav;
      navObj.pagination = {
        el: this.dotsEl,
        type: 'bullets',
        clickable: true,
      };
      navObj.setNavSwiper = setNavSwiper;
    } else {
      const [pagination, setNavSwiper] = creareNavPagination(this.navEl ? [this.navEl] : []);
      navObj.pagination = pagination;
      navObj.setNavSwiper = setNavSwiper;
    }

    this.swiper = new Swiper(this.sliderEl, {
      slidesPerView: 'auto',
      // autoHeight: true,
      loop: false,
      pagination: navObj.pagination,
    });
    navObj?.setNavSwiper(this.swiper);
  }

  initTabs() {
    if (this.tabsEl === null) return;

    this.onTabClickEvent = this.onTabClick.bind(this);
    this.tabs = new SliderTabs({
      element: this.tabsEl,
      activeIndex: 0,
      onTabClick: this.onTabClickEvent,
    });
  }

  bindEvents() {
    const { swiper } = this;

    this.onSlideChangeEvent = this.onSlideChange.bind(this);
    swiper.on('slideChange', this.onSlideChangeEvent);

    if (this.clipEl !== null) {
      swiper.on('sliderFirstMove', () => {
        this.clipEl.classList.add(this.clipClass);
      });
      swiper.on('transitionStart', () => {
        this.clipEl.classList.add(this.clipClass);
      });
      swiper.on('transitionEnd', () => {
        this.clipEl.classList.remove(this.clipClass);
      });
    }

    const isDouble = this.rootEl.parentElement.classList.contains('textGapImageSlider--double');
    if (isDouble) {
      this.onMediaQueryChangeEvent = this.onMediaQueryChange.bind(this);
      this.mediaQueryObserver = createBreakpointObserver('tablet', this.onMediaQueryChangeEvent);
      this.mediaQueryObserver.observe();
    }
  }

  onTabClick({ index }) {
    this.swiper.slideTo(index);
  }

  onSlideChange() {
    const { activeIndex, slides } = this.swiper;

    const dataPrefix = 'data-text-gap-image-slider-';
    each(slides, (slideEl, slideIndex) => {
      setSlideAttrs(slideEl, slideIndex, activeIndex, dataPrefix);
    });

    if (this.dotsUpdateNav) this.dotsUpdateNav(this.swiper);
    if (this.tabs) this.tabs.setState({ activeIndex });
  }

  onMediaQueryChange(matches) {
    if (!this.swiper) return;

    this.swiper.params.slidesPerGroup = matches ? 2 : 1;
    this.swiper.update();
  }

  destroy() {
    if (this.imageSwiper) this.imageSwiper.destroy();
    if (this.swiper) this.swiper.destroy();
    if (this.mediaQueryObserver) this.mediaQueryObserver.unobserve();
  }
}

export default class TextGapImageSlider {
  constructor() {
    this.entities = new Entities(
      'TextGapImageSlider',
      '[data-text-gap-image-slider]',
      TextGapImageSlider.initSingle,
      TextGapImageSlider.destroySingle,
    );
  }

  static initSingle(element) {
    return new TextGapImageSliderEntity(element);
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
