import Entities from './shared/Entities';
import { setClassName } from '../helpers/dom';
import { rtlSign } from '../helpers/document';

const CLASSES = {
  hiddenTrack: 'customScroll__track--hidden',
  swiperNoSwiping: 'swiper-no-swiping',
};

const KEYS = {
  v: {
    scrollSize: 'scrollHeight',
    offsetSize: 'offsetHeight',
    size: 'height',
    scrollPos: 'scrollTop',
    translate: 'translateY',
    client: 'clientY',
  },
  h: {
    scrollSize: 'scrollWidth',
    offsetSize: 'offsetWidth',
    size: 'width',
    scrollPos: 'scrollLeft',
    translate: 'translateX',
    client: 'clientX',
  },
};

const CENTER_FACTOR = 0.5;

export default class CustomScroll {
  constructor() {
    this.entities = new Entities(
      'CustomScroll',
      '[data-custom-scroll]',
      CustomScroll.initSingle,
      CustomScroll.destroySingle,
    );

    this.bindEvents();
  }

  static initSingle(containerEl) {
    const scrollEl = containerEl.querySelector('.customScroll__scroll');
    if (scrollEl === null) {
      console.warn('Missing .customScroll__scroll element');
      return;
    }

    const align = scrollEl.getAttribute('data-custom-scroll-align') ?? '';

    const axisV = CustomScroll.createAxis('v', containerEl, scrollEl);
    const axisH = CustomScroll.createAxis('h', containerEl, scrollEl);

    function updateSize() {
      axisV.updateSize();
      axisH.updateSize();
    }

    function updatePos() {
      axisV.updatePos();
      axisH.updatePos();
    }

    function update() {
      axisV.update();
      axisH.update();
    }

    function destroy() {
      axisV.destroy();
      axisH.destroy();
    }

    if (align === 'center') {
      axisV.scrollToFactor(CENTER_FACTOR);
      axisH.scrollToFactor(CENTER_FACTOR * rtlSign);
    }

    return {
      updateSize,
      updatePos,
      update,
      destroy,
    };
  }

  static createAxis(axis, containerEl, scrollEl) {
    const minSize = 30;

    let lastOffsetSize = null;
    let lastScrollSize = null;
    let scrollRange = null;
    let barRange = null;
    let barSize = 0;
    let barPos = 0;
    let dragging = false;
    let beginDragVal = null;
    let beginBarPos = null;

    const keys = KEYS[axis] ?? {};

    const trackEl = document.createElement('div');
    trackEl.classList.add('customScroll__track');
    trackEl.classList.add(`customScroll__track--${axis}`);
    trackEl.classList.add(CLASSES.hiddenTrack);

    const barEl = document.createElement('div');
    barEl.classList.add('customScroll__bar');
    barEl.classList.add(`customScroll__bar--${axis}`);
    barEl.classList.add(CLASSES.swiperNoSwiping);

    trackEl.appendChild(barEl);
    containerEl.appendChild(trackEl);

    function updateSize() {
      const scrollSize = scrollEl[keys.scrollSize];
      const offsetSize = scrollEl[keys.offsetSize];
      const trackSize = trackEl[keys.offsetSize];

      if (!(
        scrollSize !== lastScrollSize || offsetSize !== lastOffsetSize
      )) return;

      barEl.style[keys.size] = '';

      setClassName(trackEl, CLASSES.hiddenTrack, scrollSize <= offsetSize);

      lastOffsetSize = offsetSize;
      lastScrollSize = scrollSize;
      scrollRange = scrollSize - offsetSize;

      barSize = scrollSize > 0
        ? Math.max(trackSize * (offsetSize / scrollSize), minSize)
        : 0;
      barEl.style[keys.size] = `${barSize}px`;

      barRange = trackSize - barSize;
    }

    function updatePos() {
      const scrollFactor = scrollRange > 0
        ? scrollEl[keys.scrollPos] / scrollRange
        : 0;

      barPos = barRange * scrollFactor;
      barEl.style.transform = `${[keys.translate]}(${barPos}px)`;
    }

    function scrollToFactor(scrollFactor) {
      scrollEl[keys.scrollPos] = scrollFactor * scrollRange;

      updatePos();
    }

    function update() {
      updateSize();
      updatePos();
    }

    function onScroll() {
      if (dragging === true) return;

      update();
    }

    function eventToDragVal(e) {
      const touch = e.touch || (e.touches ? e.touches[0] : false);

      return touch ? touch[keys.client] : e[keys.client];
    }

    function onBarDragStart(e) {
      dragging = true;
      containerEl.style.userSelect = 'none';

      beginDragVal = eventToDragVal(e);
      beginBarPos = barPos;
    }

    function onBarDragMove(e) {
      if (dragging === false) return;
      const diffDragY = eventToDragVal(e) - beginDragVal;

      const scrollFactor = (beginBarPos + diffDragY) / barRange;
      scrollToFactor(scrollFactor);
    }

    function onBarDragEnd() {
      if (dragging === false) return;

      dragging = false;
      containerEl.style.userSelect = '';

      beginDragVal = null;
      beginBarPos = 0;
    }

    function onMouseDragStart(e) { onBarDragStart(e); }
    function onMouseDragMove(e) { onBarDragMove(e); }
    function onMouseDragEnd(e) { onBarDragEnd(e); }
    function onTouchDragStart(e) { if (e.cancelable) e.preventDefault(); onBarDragStart(e); }
    function onTouchDragMove(e) { onBarDragMove(e); }
    function onTouchDragEnd(e) { onBarDragEnd(e); }

    scrollEl.addEventListener('scroll', onScroll);

    barEl.addEventListener('mousedown', onMouseDragStart);
    document.addEventListener('mousemove', onMouseDragMove);
    document.addEventListener('mouseup', onMouseDragEnd);
    document.addEventListener('mouseleave', onMouseDragEnd);

    barEl.addEventListener('touchstart', onTouchDragStart);
    document.addEventListener('touchmove', onTouchDragMove);
    document.addEventListener('touchend', onTouchDragEnd);

    function destroy() {
      scrollEl.removeEventListener('scroll', onScroll);

      barEl.removeEventListener('mousedown', onMouseDragStart);
      document.removeEventListener('mousemove', onMouseDragMove);
      document.removeEventListener('mouseup', onMouseDragEnd);
      document.removeEventListener('mouseleave', onMouseDragEnd);

      barEl.removeEventListener('touchstart', onTouchDragStart);
      document.removeEventListener('touchmove', onTouchDragMove);
      document.removeEventListener('touchend', onTouchDragEnd);

      containerEl.removeChild(trackEl);
    }

    update();

    return {
      trackEl,
      barEl,
      scrollToFactor,
      updateSize,
      updatePos,
      update,
      destroy,
    };
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }

  bindEvents() {
    this.onResizeEvent = this.onResize.bind(this);
    window.addEventListener('liteResize', this.onResizeEvent);
  }

  onResize() {
    this.entities.forEachEntity(({ entityObj }) => entityObj.update());
  }
}
