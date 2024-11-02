import Swiper, { Pagination, Navigation } from 'swiper';
import Entities from './shared/Entities'; 

class ServicesSwiperEntity {
  constructor(rootEl) {
    if (!this.setVars(rootEl)) return;

    this.initSwipers();
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.thumbsSliderEl = this.rootEl.querySelector('#services-swiper-thumbs');
    if (!this.thumbsSliderEl) return false;

    this.mainSliderEl = this.rootEl.querySelector('#services-swiper');
    if (!this.mainSliderEl) return false;

    // this.paginationEl = this.rootEl.querySelector('#services-pagination');
    // this.nextButtonEl = this.rootEl.querySelector('#services-next');
    // this.prevButtonEl = this.rootEl.querySelector('#services-prev');

    return true;
  }

  initSwipers() {
    // Initialize thumbs swiper
    const thumbsServicesSwiper = new Swiper(this.thumbsSliderEl, {
      loop: true,
      spaceBetween: 2,
      slidesPerView: 3,
      freeMode: true,
      watchSlidesProgress: true,
    });

    // Initialize main swiper
    this.mainServicesSwiper = new Swiper(this.mainSliderEl, {
      loop: true,
      effect: 'fade',
      allowTouchMove: false,
      centeredSlides: true,
    //   pagination: {
    //     el: this.paginationEl,
    //     clickable: true,
    //   },
    //   navigation: {
    //     nextEl: this.nextButtonEl,
    //     prevEl: this.prevButtonEl,
    //   },
      thumbs: {
        swiper: thumbsServicesSwiper,
      },
    });
  }
}

export default class ServicesSwiper {
    constructor() {
        console.log('here');

      this.entities = new Entities(
        'ServicesSwiper',               // Name for the entity
        '.services-swiper',             // Valid CSS selector for the elements you want to manage
        ServicesSwiper.initSingle,       // Creator function
      );
    }
  
    static initSingle(element) {
      return new ServicesSwiperEntity(element);
    }
  }
