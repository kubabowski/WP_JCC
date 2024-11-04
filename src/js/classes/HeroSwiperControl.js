
import HeroHomeSwiper from './HomeBannerSwiper';
import Entities from './shared/Entities';

class HeroHomeControlEntity {
    constructor(rootEl) {
      console.log(rootEl);
      if (!this.setVars(rootEl)) return;
  
      this.init(); 
    }
  
    setVars(rootEl) {

      
      this.rootEl = rootEl;
      if (!this.rootEl) {
        return false;
      }

      setTimeout(() => {
        this.bullet = document.querySelector(".swiper-pagination-bullet");
        this.swiperControl = document.querySelector("#swiper-control");
      }, 300);

      return true;
    }
  
    init() {

      console.log(this.swiperControl);
      
    let isAutoplaying = true;
      
      const reset_animation = () => {
        if (this.bullet) {
          this.bullet.style.animation = 'none';
          this.bullet.offsetHeight; // Trigger reflow
          this.bullet.style.animation = null;
        }
      };
  
        if (this.swiperControl) {
          this.swiperControl.addEventListener("click", () => {
            console.log("pause  clicked")
            if (isAutoplaying) {
              this.mainHeroHomeSwiper.autoplay.pause();
              this.pagination.classList.add("paused");
            } else {
              this.mainHeroHomeSwiper.autoplay.start();
              this.mainHeroHomeSwiper.slideNext(); // Move to the next slide
              this.pagination.classList.remove("paused");
              reset_animation();
            }
            isAutoplaying = !isAutoplaying;
          });
        }
    }
  }
  

  
export default class HeroHomeControl {
  constructor() {

    this.entities = new Entities(
      'HeroHomeControl',              
      '#heroHome',            
      HeroHomeControl.initSingle,       
    );
  }

  static initSingle(element) {
    return new HeroHomeControlEntity(element); 
  }
}

document.addEventListener('DOMContentLoaded', () => {
    new HeroHomeSwiper();
});
  