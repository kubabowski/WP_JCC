import anime from 'animejs/lib/anime.es';

import Entities from './shared/Entities';

class VideoPopupEntity {

  constructor(rootEl)
  {
    if (!this.setVars(rootEl)) return;

    this.bindEvents();
  }

  setVars(rootEl)
  {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.buttonEl = this.rootEl.querySelector('[data-video-popup-play]');
    if (!this.buttonEl) return false;

    this.popupEl = this.rootEl.querySelector('[data-video-popup-popup]');
    if (!this.popupEl) return false;

    this.closeButtonEl = this.popupEl.querySelector('[data-video-popup-close]');
    if (!this.closeButtonEl) return false;

    this.videoEl = this.popupEl.querySelector('[data-video-popup-video]');
    if (!this.videoEl) return false;

    this.sourceEl = VideoPopupEntity.createSourceEl(
      this.buttonEl.getAttribute('data-video-popup-play'),
      this.buttonEl.getAttribute('data-video-popup-type'),
    );

    this.classes = {
      popupActive: this.popupEl.getAttribute('data-video-popup-popup-class-active'),
    };

    this.duration = 500;

    return true;
  }

  bindEvents()
  {
    this.onButtonClickEvent = this.onButtonClick.bind(this);
    this.onCloseButtonClickEvent = this.onCloseButtonClick.bind(this);

    this.buttonEl.addEventListener('click', this.onButtonClickEvent);
    this.closeButtonEl.addEventListener('click', this.onCloseButtonClickEvent);
  }

  static createSourceEl(src, type) {
    const sourceEl = document.createElement('source');
    sourceEl.src = src;
    sourceEl.type = type;
    return sourceEl;
  }

  onButtonClick(e)
  {
    e.preventDefault();
    this.showPopup();
  }

  onCloseButtonClick(e)
  {
    e.preventDefault();
    this.hidePopup();
  }

  getTransform() {
    const { rootEl, popupEl } = this;
    const rootRect = rootEl.getBoundingClientRect();
    const popupRect = popupEl.getBoundingClientRect();

    const rootX = rootRect.left + rootRect.width / 2;
    const rootY = rootRect.top + rootRect.height / 2;

    const popupX = popupRect.left + popupRect.width / 2;
    const popupY = popupRect.top + popupRect.height / 2;

    const scaleX = rootRect.width / popupRect.width;
    const scaleY = rootRect.height / popupRect.height;

    return {
      scaleX,
      scaleY,
      translateX: (rootX - popupX) / scaleX,
      translateY: (rootY - popupY) / scaleY,
    };
  }

  showPopup()
  {
    if (this.isActive) return;

    const { popupEl, videoEl, sourceEl } = this;
    const {
      scaleX,
      scaleY,
      translateX,
      translateY,
    } = this.getTransform();

    const halfDuration = this.duration / 2;

    anime.remove(popupEl);
    anime.remove(videoEl);
    anime.set(popupEl, {
      opacity: 0,
      scaleX,
      scaleY,
      translateX,
      translateY,
      borderRadius: '50%',
    });
    anime.set(videoEl, {
      scaleX: (scaleY / scaleX),
    });
    popupEl.classList.add(this.classes.popupActive);
    videoEl.appendChild(sourceEl);
    anime({
      targets: popupEl,
      opacity: 1,
      scaleX: 1,
      scaleY: 1,
      translateX: {
        value: 0,
        duration: halfDuration,
      },
      translateY: {
        value: 0,
        duration: halfDuration,
      },
      borderRadius: '0%',
      easing: 'easeOutCubic',
      duration: this.duration,
      complete: () => {
        popupEl.style.opacity = '';
        popupEl.style.transform = '';
        videoEl.play();
      },
    });
    anime({
      targets: videoEl,
      scaleX: 1,
      easing: 'easeOutCubic',
      duration: this.duration,
      complete: () => {
        videoEl.style.transform = '';
      },
    });

    this.isActive = true;
  }

  hidePopup()
  {
    if (!this.isActive) return;

    const { popupEl, videoEl, sourceEl } = this;
    const {
      scaleX,
      scaleY,
      translateX,
      translateY,
    } = this.getTransform();

    videoEl.pause();
    anime.remove(popupEl);
    anime.remove(videoEl);
    anime({
      targets: popupEl,
      opacity: 0,
      scaleX,
      scaleY,
      translateX,
      translateY,
      borderRadius: '50%',
      easing: 'easeOutCubic',
      duration: this.duration,
      complete: () => {
        popupEl.style.opacity = '';
        popupEl.style.transform = '';
        popupEl.classList.remove(this.classes.popupActive);
        videoEl.currentTime = 0;
        videoEl.removeChild(sourceEl);
      },
    });
    anime({
      targets: videoEl,
      scaleX: (scaleY / scaleX),
      easing: 'easeOutCubic',
      duration: this.duration,
      complete: () => {
        videoEl.style.transform = '';
      },
    });

    this.isActive = false;
  }
}

export default class VideoPopup {
  constructor() {
    this.entities = new Entities(
      'VideoPopup',
      '[data-video-popup]',
      VideoPopup.initSingle,
      // VideoPopup.destroySingle,
    );
  }

  static initSingle(element) {
    return new VideoPopupEntity(element);
  }

  // static destroySingle({ entityObj }) {
  //   entityObj?.destroy();
  // }
}
