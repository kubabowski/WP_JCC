import Swiper, { Pagination, Autoplay } from 'swiper';

import Entities from './shared/Entities';
import { createBreakpointObserver } from './shared/MediaQuery';
import { createScrollObserver } from './shared/ScrollTrigger';

import { setAttr, setClassName } from '../helpers/dom';
import { trigger } from '../helpers/event';

const PLAYING_CLASS = 'heroBanner--playing';

export default class HeroBanner {
  constructor() {
    this.entities = new Entities(
      'HeroBanner',
      '[data-hero-banner]',
      HeroBanner.initSingle,
      HeroBanner.destroySingle,
    );
  }

  static initSingle(containerEl) {
    const posterEl = containerEl.querySelector('[data-hero-banner-video]');
    const videoEl = (posterEl !== null) ? posterEl.querySelector('video') : null;

    let posterPlaying = false;

    const bgVideoEl = containerEl.querySelector('[data-hero-banner-bg-video] video');

    const playEl = containerEl.querySelector('[data-hero-banner-play]');

    const outerEl = containerEl.querySelector('[data-hero-banner-outer]');
    const contentEl = containerEl.querySelector('[data-hero-banner-content]');

    const sliderEl = containerEl.querySelector('[data-hero-banner-slider]');
    const dotsEl = containerEl.querySelector('[data-hero-banner-dots]');

    const swiper = HeroBanner.createSwiper(sliderEl, dotsEl);

    function bgVideoPlay() {
      if (bgVideoEl === null || !bgVideoEl.autoplay || posterPlaying) return;

      bgVideoEl.play();
    }

    function bgVideoPause() {
      if (bgVideoEl === null) return;

      bgVideoEl.pause();
    }

    function onPlayClick() {
      if (posterEl === null) return;

      trigger(posterEl, 'VideoPosterPlay');
    }

    function onStarted() {
      posterPlaying = true;
      setClassName(containerEl, PLAYING_CLASS, true);
      bgVideoPause();
    }

    function onEnded() {
      posterPlaying = false;
      setClassName(containerEl, PLAYING_CLASS, false);
      bgVideoPlay();

      window?.redsea_globals?.analytics?.videoViews?.(videoEl);
    }

    function onWinResize() {
      containerEl.style.maxHeight = `${window.innerHeight}px`;
    }

    function onMediaQueryChange(matches) {
      if (bgVideoEl === null) return;

      setAttr(bgVideoEl, 'autoplay', matches ? '' : null);

      if (matches) {
        bgVideoEl.play();
      } else {
        // bgVideoEl.pause();
        bgVideoEl.load(); // back to poster
      }
    }

    function onScrollProgress(progress) {
      /* eslint-disable no-magic-numbers */
      // const factor = mapRange(0.5, 1, 0, 1, progress);
      const factor = (progress - 0.5) * 2; // becouse hero is first section
      const y = -50 * factor;
      const scale = 1 + factor * 0.2;
      const opacity = 1 - factor;
      /* eslint-enable no-magic-numbers */

      outerEl.style.transform = `translateY(${y}%)`;
      contentEl.style.transform = `scale(${scale})`;
      contentEl.style.opacity = opacity;
    }

    function onObserve(entry) {
      if (entry.isIntersecting) {
        bgVideoPlay();
      } else {
        bgVideoPause();
      }
    }

    const mediaQueryObserver = createBreakpointObserver('tablet', onMediaQueryChange);
    const scrollObserver = createScrollObserver(containerEl, { onScrollProgress, onObserve });

    onWinResize();

    if (playEl) playEl.addEventListener('click', onPlayClick);
    if (posterEl) posterEl.addEventListener('VideoPosterStarted', onStarted);
    if (posterEl) posterEl.addEventListener('VideoPosterEnded', onEnded);
    window.addEventListener('resize', onWinResize);
    mediaQueryObserver.observe();
    scrollObserver.observe();

    function destroy() {
      if (playEl) playEl.removeEventListener('click', onPlayClick);
      if (posterEl) posterEl.removeEventListener('VideoPosterStarted', onStarted);
      if (posterEl) posterEl.removeEventListener('VideoPosterEnded', onEnded);
      window.removeEventListener('resize', onWinResize);
      mediaQueryObserver.unobserve();
      scrollObserver.unobserve();

      if (swiper !== null) swiper.destroy();
    }

    return {
      destroy,
    };
  }

  static createSwiper(sliderEl, dotsEl) {
    if (sliderEl === null) return null;

    if (dotsEl !== null) Swiper.use(Pagination);
    Swiper.use(Autoplay);

    return new Swiper(sliderEl, {
      slidesPerView: 'auto',
      // autoHeight: true,
      loop: true,
      ...(dotsEl !== null ? {
        pagination: {
          el: dotsEl,
          type: 'bullets',
          clickable: true,
        },
      } : {}),
      autoplay: {
        delay: 4000,
      },
    });
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
