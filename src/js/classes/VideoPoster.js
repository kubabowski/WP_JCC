import Entities from './shared/Entities';
import { createInVIewObserver } from './shared/ScrollTrigger';

import { setAttr } from '../helpers/dom';
import { trigger } from '../helpers/event';

const VIDEO_PLAYING_ATTR = 'data-playing';
const REMOVE_VIDEO_DELAY = 200;

export default class VideoPoster {
  constructor() {
    this.entities = new Entities(
      'VideoPoster',
      '[data-video-poster]',
      VideoPoster.initSingle,
      VideoPoster.destroySingle,
    );
  }

  static initSingle(containerEl) {
    const playEl = containerEl.querySelector('[data-video-poster-play]');
    if (playEl === null) return null;

    const stopEl = containerEl.querySelector('[data-video-poster-stop]');

    const videoEl = containerEl.querySelector('[data-video-poster-video]');
    // const iframeEl = containerEl.querySelector('[data-video-poster-iframe]');

    let playing = false;

    function start() {
      if (playing) return;

      setAttr(containerEl, VIDEO_PLAYING_ATTR, '');
      trigger(containerEl, 'VideoPosterStarted');

      if (videoEl !== null) {
        videoEl.play();
      }

      playing = true;
    }

    function stop() {
      if (!playing) return;

      setAttr(containerEl, VIDEO_PLAYING_ATTR, null);
      trigger(containerEl, 'VideoPosterEnded');

      setTimeout(() => {
        playing = false;

        if (videoEl !== null) {
          videoEl.pause();
          videoEl.currentTime = 0;
        }
      }, REMOVE_VIDEO_DELAY);
    }

    function onPlay() {
      start();
    }

    function onPlayClick() {
      start();
    }

    function onStop() {
      stop();
    }

    function onStopClick() {
      stop();
    }

    function onEnded() {
      stop();
    }

    // function onOutOfView() {
    //   if (!playing) return;

    //   const rect = containerEl.getBoundingClientRect();
    //   const bound = 0.7;

    //   if (rect.y * -1 > rect.height * bound) stop();
    // }

    function onInViewObserve(entry) {
      if (!playing) return;

      if (entry.isIntersecting === false) stop();
    }
    const inViewObserver = createInVIewObserver(containerEl, onInViewObserve, {
      threshold: 0,
    });

    // window.addEventListener('liteScroll', onOutOfView);

    containerEl.addEventListener('VideoPosterPlay', onPlay);
    containerEl.addEventListener('VideoPosterStop', onStop);

    playEl.addEventListener('click', onPlayClick);
    if (stopEl !== null) stopEl.addEventListener('click', onStopClick);
    if (videoEl !== null) videoEl.addEventListener('ended', onEnded);
    if (inViewObserver !== null) inViewObserver.observe();

    function destroy() {
      // window.addEventListener('liteScroll', onOutOfView);

      containerEl.removeEventListener('VideoPosterPlay', onPlay);
      containerEl.removeEventListener('VideoPosterStop', onStop);

      playEl.removeEventListener('click', onPlayClick);
      if (stopEl !== null) stopEl.removeEventListener('click', onStopClick);
      if (videoEl !== null) videoEl.removeEventListener('ended', onEnded);
      // if (inViewObserver !== null) inViewObserver.unobserve();
      if (inViewObserver !== null) inViewObserver.destroy();
    }

    return {
      destroy,
    };
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
