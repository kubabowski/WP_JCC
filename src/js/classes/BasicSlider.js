import Swiper, { Navigation, Pagination, Autoplay } from 'swiper';
import Entities from './shared/Entities';
import { leadingZero } from '../helpers/number';

import { setAttr } from '../helpers/dom';

export default class BasicSlider {
  constructor() {
    this.entities = new Entities(
      'BasicSlider',
      '[data-basic-slider]',
      BasicSlider.initSingle,
      BasicSlider.destroySingle,
    );
  }

  static initSingle(containerEl) {
    const dotsEl = containerEl.querySelector('[data-basic-slider-dots]');
    const parentSwiperSlide = containerEl.closest('swiper-slide');
    const autoplay = containerEl.closest('[data-basic-slider-autoplay]');
    const loop = containerEl.closest('[data-basic-slider-loop]');

    const nextEl = containerEl.querySelector('[data-basic-slider-next]');
    const prevEl = containerEl.querySelector('[data-basic-slider-prev]');

    const currentEl = containerEl.querySelector('[data-basic-slider-current]');
    const totalEl = containerEl.querySelector('[data-basic-slider-total]');

    let autoplayObj = {};
    if (autoplay) {
      const delay = parseInt(autoplay.getAttribute('data-basic-slider-autoplay'));

      autoplayObj = {
        delay,
      };
    }
    let loopValue = null;
    if (loop) {
      loopValue = loop.hasAttribute('data-basic-slider-loop');
    }

    Swiper.use([Navigation, Pagination, Autoplay]);

    const options = {
      slidesPerView: 'auto',
      // autoHeight: true,
      loop: false,
      navigation: {
        nextEl,
        prevEl,
      },
      pagination: {
        el: dotsEl,
        type: 'bullets',
        clickable: true,
      },
      paginationClickable: true,
      nested: parentSwiperSlide !== null,
    };

    if (autoplay) options.autoplay = autoplayObj;
    if (loop) options.loop = loopValue;

    const swiper = new Swiper(containerEl, options);

    function onAutoplayStop() {
      setAttr(containerEl, 'data-autoplay-stop', '');
    }
    if (autoplay) swiper.on('autoplayStop', onAutoplayStop);

    // current / total
    function updateTotal() {
      if (!totalEl) return;
      BasicSlider.updatePageIndex(totalEl, loop ? swiper.loopedSlides : swiper.slides.length);
    }
    function updateCurrent() {
      if (!currentEl) return;
      BasicSlider.updatePageIndex(currentEl, swiper.realIndex + 1);
    }
    updateTotal();
    updateCurrent();

    function onSlideChange() {
      updateCurrent();
    }
    if (currentEl) swiper.on('slideChange', onSlideChange);

    function destroy() {
      swiper.destroy();
    }

    return {
      destroy,
    };
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }

  static updatePageIndex(elem, value) {
    elem.textContent = leadingZero(value);
  }
}
