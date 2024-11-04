import Swiper, { Pagination, Navigation, Thumbs, EffectFade, Autoplay  } from 'swiper';
import Entities from './shared/Entities';

Swiper.use([Pagination, Navigation, Thumbs, EffectFade, Autoplay]);

class HeroHomeSwiperEntity {
  constructor(rootEl) {
    if (!this.setVars(rootEl)) return; 
    this.initSwipers(); 
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.mainSliderEl = this.rootEl.querySelector('#hero-swiper');
    this.pagination = this.rootEl.querySelector('#hero-pagination');
    this.paginationBullets = this.rootEl.querySelector('#hero-pagination-bullets');

      

    if (!this.mainSliderEl) return false;

    return true; 
  }

  initSwipers() {
    
    this.mainHeroHomeSwiper = new Swiper(this.mainSliderEl, {
      pagination: {
          el: this.pagination,
          clickable: true,
          renderBullet: (index, className) => {
            // Check if this is the last bullet
            if (index === this.paginationBullets.children.length - 1) {
              return `
                <span class="fw-500 fs-14 lh-24 ${className}">
                  ${this.paginationBullets.children[index]?.textContent.trim() || `Slide ${index + 1}`}
                </span>
                <div id="swiper-control" class="relative">
                  <svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.5" y="0.601562" width="43" height="43" stroke="white" stroke-opacity="0.24"/>
                    <rect x="18.5" y="16.1016" width="2" height="12" fill="white"/>
                    <rect x="23.5" y="16.1016" width="2" height="12" fill="white"/>
                  </svg>
                </div>
              `;
            }
        
            // Return the normal bullet for other indices
            return `<span class="fw-500 fs-14 lh-24 ${className}">${this.paginationBullets.children[index]?.textContent.trim() || `Slide ${index + 1}`}</span>`;
          },
      },
      autoplay: {
          delay: 4300,
          disableOnInteraction: false,
      },
      effect: "fade",
      loop: true,
    });

  
      
  }
}

export default class HeroHomeSwiper {
  constructor() {

    this.entities = new Entities(
      'HeroHomeSwiper',              
      '#heroHome',            
      HeroHomeSwiper.initSingle,       
    );
  }

  static initSingle(element) {
    return new HeroHomeSwiperEntity(element); 
  }
}

document.addEventListener('DOMContentLoaded', () => {
    new HeroHomeSwiper();
});