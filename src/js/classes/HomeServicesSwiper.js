import Swiper, { Pagination, Navigation, Thumbs, EffectFade  } from 'swiper';
import Entities from './shared/Entities';

Swiper.use([Pagination, Navigation, Thumbs, EffectFade]);

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
      loop: false,
      effect: 'fade',
      allowTouchMove: false,
      centeredSlides: true,
      thumbs: {
        swiper: thumbsServicesSwiper, 
      },
    });

    document
            .querySelectorAll(".accordion-services")
            .forEach((accordionElement) => {
                new Accordion(`#${accordionElement.id}`, {openOnInit: [0]});
                console.log("accordionElement ", accordionElement.id, " initialized");
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