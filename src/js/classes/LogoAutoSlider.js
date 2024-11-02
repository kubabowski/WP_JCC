import Swiper, { Autoplay } from 'swiper';
import Entities from './shared/Entities';

class LogoAutoSliderEntity {

  constructor(rootEl) {
    if (!this.setVars(rootEl)) return;

    this.initSwiper();
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.sliderEl = this.rootEl.querySelector('[data-logo-auto-slider-slider]');
    if (!this.sliderEl) return;

    return true;
  }

  initSwiper() {
    Swiper.use([Autoplay]);

    this.swiper = new Swiper(this.sliderEl, {
      slidesPerView: 'auto',
      // autoHeight: true,
      loop: true,
      speed: 2500,
      autoplay: {
        delay: 1,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
    });
  }

  destroy() {
    if (this.swiper) this.swiper.destroy();
  }
}

export default class LogoAutoSlider {
  constructor() {
    this.entities = new Entities(
      'LogoAutoSlider',
      '[data-logo-auto-slider]',
      LogoAutoSlider.initSingle,
      LogoAutoSlider.destroySingle,
    );
  }

  static initSingle(element) {
    return new LogoAutoSliderEntity(element);
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
