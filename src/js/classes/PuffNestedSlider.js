import Swiper, { Pagination } from 'swiper';
import { each, mapEach } from '../helpers/array';
import { setAttr, setAttrs } from '../helpers/dom';
// import { setSlideAttrs } from '../helpers/slider';

import Entities from './shared/Entities';
// import { creareNavPagination } from './shared/SliderNavHelpers';
import SliderNav from './shared/SliderNav';

class PuffNestedSliderEntity {

  constructor(rootEl) {
    if (!this.setVars(rootEl)) return;

    this.initSwiper();
    this.initSliderNav();
    this.initNestedSwipers();
    this.bindEvents();
    // this.onSlideChange();
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.sliderEl = rootEl.querySelector('[data-puff-nested-slider-slider]');
    if (!this.sliderEl) return false;

    this.navEl = rootEl.querySelector('[data-puff-nested-slider-nav]');
    if (!this.navEl) return false;

    this.activeIndex = 0;
    this.maxIndex = 0;
    this.loop = false;

    return true;
  }

  initSwiper() {
    Swiper.use(Pagination);

    // const [pagination, setNavSwiper] = creareNavPagination([this.navEl]);
    this.swiper = new Swiper(this.sliderEl, {
      slidesPerView: 'auto',
      // autoHeight: true,
      loop: false,
      // pagination,
    });
    // setNavSwiper(this.swiper);

    this.maxIndex = (this.swiper?.slides?.length ?? 1) - 1;
    this.loop = this.swiper.params.loop ?? false;
  }

  initSliderNav() {
    this.onNextClickEvent = this.onNextClick.bind(this);
    this.onPrevClickEvent = this.onPrevClick.bind(this);

    this.sliderNav = new SliderNav({
      element: this.navEl,
      onNextClick: this.onNextClickEvent,
      onPrevClick: this.onPrevClickEvent,
      current: this.activeIndex + 1,
      total: this.maxIndex + 1,
      loop: this.loop,
    });
  }

  onNextClick() {
    this.goToIndex(this.activeIndex + 1);
  }

  onPrevClick() {
    this.goToIndex(this.activeIndex - 1);
  }

  initNestedSwipers() {
    const { swiper } = this;

    this.nestedSwipers = mapEach(swiper.slides, (slideEl) => {
      const nestedSliderEl = slideEl.querySelector('[data-puff-nested-slider-nested-slider]');
      if (nestedSliderEl === null) return null;

      const nestedNavEl = slideEl.querySelector('[data-puff-nested-slider-nested-nav]');

      const nestedSwiper = new Swiper(nestedSliderEl, {
        slidesPerView: 'auto',
        // autoHeight: true,
        loop: false,
        pagination: {
          el: nestedNavEl,
          type: 'bullets',
          clickable: true,
        },
        paginationClickable: true,
        nested: true,
      });

      return nestedSwiper;
    });
  }

  bindEvents() {
    const { swiper } = this;

    // this.onSlideChangeEvent = this.onSlideChange.bind(this);
    // swiper.on('slideChange', this.onSlideChangeEvent);

    this.onSlideClickEvent = this.onSlideClick.bind(this);
    each(swiper.slides, (slideEl, slideIndex) => {
      setAttr(slideEl, 'data-puff-nested-slider-slide', slideIndex);
      slideEl.addEventListener('click', this.onSlideClickEvent);
    });
  }

  onSlideClick(e) {
    const index = parseInt(e.currentTarget.getAttribute('data-puff-nested-slider-slide') ?? '-1');
    if (index < 0) return;

    this.goToIndex(index);
  }

  goToIndex(index, skipSwiper = false) {
    let nextIndex = index;
    if (this.loop) {
      if (nextIndex < 0) nextIndex = this.maxIndex;
      if (nextIndex > this.maxIndex) nextIndex = 0;
    } else {
      if (nextIndex < 0) nextIndex = 0;
      if (nextIndex > this.maxIndex) nextIndex = this.maxIndex;
    }
    if (nextIndex === this.activeIndex) return;

    const { slides } = this.swiper;
    each(slides, (slideEl, slideIndex) => {
      let type = 'current';
      if (slideIndex < index) type = 'prev';
      if (slideIndex > index) type = 'next';

      const slideAttrs = {
        'slide-type': type,
        'slide-offset': Math.abs(slideIndex - index),
      };

      setAttrs(slideEl, slideAttrs, 'data-puff-nested-slider-');
    });

    this.activeIndex = nextIndex;
    this.sliderNav.setState({ current: nextIndex + 1 });

    if (!skipSwiper) this.swiper.slideTo(nextIndex);
  }

  // onSlideChange() {
  //   const { activeIndex } = this.swiper;

  //   this.goToIndex(activeIndex, true);
  // }

  destroy() {
    if (this.imageSwiper) this.imageSwiper.destroy();
    if (this.swiper) this.swiper.destroy();
  }
}

export default class PuffNestedSlider {
  constructor() {
    this.entities = new Entities(
      'PuffNestedSlider',
      '[data-puff-nested-slider]',
      PuffNestedSlider.initSingle,
      PuffNestedSlider.destroySingle,
    );
  }

  static initSingle(element) {
    return new PuffNestedSliderEntity(element);
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
