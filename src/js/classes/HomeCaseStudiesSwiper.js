import Swiper, { Pagination, Navigation, Thumbs, EffectFade  } from 'swiper';
import Entities from './shared/Entities';

Swiper.use([Pagination, Navigation, Thumbs, EffectFade]);

class CaseInsightSwiperEntity {
  constructor(rootEl) {
    if (!this.setVars(rootEl)) return;

    this.initSwipers();
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;


    this.mainSliderEl = this.rootEl.querySelector('#casestudy-swiper');
    if (!this.mainSliderEl) return false;

    return true;
  }

  initSwipers() {

    new Swiper("#casestudy-swiper", {
      // effect: "fade",
      slidesPerView: 2,
      spaceBetween: 30,
      // autoplay: {
      //   delay: 2500,
      //   disableOnInteraction: false,
      // },
      breakpoints: {
        0: {
          slidesPerView: 1,
          spaceBetween: 0
        },

        700: {
          slidesPerView: 2,
          spaceBetween: 30
        }
      },
      navigation: {
        nextEl: "#study-next",
        prevEl: "#study-prev",
      },
    });


  }
}

export default class CaseInsightSwiper {
  constructor() {

    this.entities = new Entities(
      'CaseInsightSwiper',
      '#homeCaseInsight',
      CaseInsightSwiper.initSingle,
    );
  }

  static initSingle(element) {
    return new CaseInsightSwiperEntity(element);
  }
}

document.addEventListener('DOMContentLoaded', () => {
    new CaseInsightSwiper();
});
