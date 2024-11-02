import anime from 'animejs/lib/anime.es';
import Swiper, { Pagination, Autoplay } from 'swiper';

import { each } from '../helpers/array';

import Entities from './shared/Entities';

class ImagePreviewPopupEntity {

  constructor(rootEl) {
    if (!this.setVars(rootEl)) return;

    this.bindEvents();
  }

  setVars(rootEl) {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.sliderEl = this.rootEl.querySelector('[data-image-preview-popup-slider]');
    if (!this.sliderEl) return;

    this.wrapperEl = this.rootEl.querySelector('[data-image-preview-popup-wrapper]');
    if (!this.wrapperEl) return;

    this.dotsEl = this.rootEl.querySelector('[data-image-preview-popup-dots]');
    if (!this.dotsEl) return;

    this.isActive = false;

    this.classes = {
      popupActive: 'imagePreviewPopup--active',
      slideItem: 'imagePreviewPopup__item',
      swiperSlide: 'swiper-slide',
      imageEl: 'imagePreviewPopup__img',
      closeElClass: 'imagePreviewPopup__close',
      closeIcon: 'icon-cross',
      slideInner: 'imagePreviewPopup__inner',
    };

    return true;
  }

  bindEvents() {
    this.onOpen = this.onOpen.bind(this);
    window.addEventListener('ImagePreviewOpen', this.onOpen);

    this.onOutsideClickEvent = this.onOutsideClick.bind(this);
    this.rootEl.addEventListener('click', this.onOutsideClickEvent);
  }

  bindActionEvents() {
    const closeEl = this.rootEl.querySelectorAll('[data-image-preview-popup-close]');

    this.onCloseClickEvent = this.onCloseClick.bind(this);
    each(closeEl, (item) => {
      item.addEventListener('click', this.onCloseClickEvent);
    });
  }

  onCloseClick() {
    this.onClose();
  }

  onClose() {
    this.rootEl.classList.remove(this.classes.popupActive);

    this.isActive = false;

    this.destroySlides();
    this.destroy();
  }

  onOpen(e) {
    const { dataArr } = e.detail;
    this.isActive = true;

    this.rootEl.classList.add(this.classes.popupActive);

    this.createSlides(dataArr);

    this.bindActionEvents();
  }

  createSlides(data) {
    each(data, (imageArr) => {
      const slide = this.createSlide(imageArr);
      this.wrapperEl.appendChild(slide);
    });

    this.initSlider();
  }

  createSlide(imageUrl) {
    const containerEl = document.createElement('div');
    containerEl.classList.add(this.classes.slideItem);
    containerEl.classList.add(this.classes.swiperSlide);
    containerEl.setAttribute('data-image-preview-popup-item', '');

    const innerEl = document.createElement('div');
    innerEl.classList.add(this.classes.slideInner);

    const imageEl = document.createElement('img');
    imageEl.classList.add(this.classes.imageEl);
    imageEl.setAttribute('src', imageUrl);

    const closeEl = document.createElement('div');
    closeEl.classList.add(this.classes.closeElClass);
    closeEl.classList.add(this.classes.closeIcon);
    closeEl.setAttribute('data-image-preview-popup-close', '');

    innerEl.appendChild(closeEl);
    innerEl.appendChild(imageEl);

    containerEl.appendChild(innerEl);

    return containerEl;
  }

  initSlider() {
    Swiper.use([Pagination, Autoplay]);

    this.swiper = new Swiper(this.sliderEl, {
      slidesPerView: 'auto',
      // autoHeight: true,
      loop: false,
      pagination: {
        el: this.dotsEl,
        type: 'bullets',
        clickable: true,
      },
      autoplay: {
        delay: 3000,
      },
      paginationClickable: true,
    });
  }

  onOutsideClick(e) {
    if (!this.isActive) return;

    if (!e.target.closest('[data-image-preview-popup-slider]')) {
      this.onClose();
    }
  }

  destroySlides() {
    const slides = this.rootEl.querySelectorAll('[data-image-preview-popup-item]');
    if (!slides) return;

    each(slides, (slide) => {
      slide.remove();
    });
  }

  destroy() {
    this.swiper.destroy();
  }
}

export default class ImagePreviewPopup {
  constructor() {
    this.entities = new Entities(
      'ImagePreviewPopup',
      '[data-image-preview-popup]',
      ImagePreviewPopup.initSingle,
      // ImagePreviewPopup.destroySingle,
    );
  }

  static initSingle(element) {
    return new ImagePreviewPopupEntity(element);
  }
}
