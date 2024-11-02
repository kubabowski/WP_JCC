import Swiper, { Pagination, Navigation } from 'swiper';
import Entities from './shared/Entities';

class ServicesSwiperEntity {
  constructor(rootEl) {
    console.log("before seVars");
    if (!this.setVars(rootEl)) return; 
    console.log("after seVars");

    this.initSwipers(); 
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.thumbsSliderEl = this.rootEl.querySelector('#services-swiper-thumbs');
    if (!this.thumbsSliderEl) return false;

    this.mainSliderEl = this.rootEl.querySelector('#services-swiper');
    if (!this.mainSliderEl) return false;

    console.log(this.mainSliderEl); 
    console.log(this.thumbsSliderEl); 

    return true; 
  }

  initSwipers() {
    // Initialize thumbs swiper
    const thumbsServicesSwiper = new Swiper(this.thumbsSliderEl, {
      loop: false,
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
      thumbs: {
        swiper: thumbsServicesSwiper, 
      },
    });
  }
}

export default class ServicesSwiper {
  constructor() {

    this.entities = new Entities(
      'ServicesSwiper',              
      '#homeServices',            
      ServicesSwiper.initSingle,       
    );
  }

  static initSingle(element) {
    return new ServicesSwiperEntity(element); 
  }
}

document.addEventListener('DOMContentLoaded', () => {
    new ServicesSwiper();
});