import Entities from './shared/Entities';
import { createScrollObserver } from './shared/ScrollTrigger';

import { each, mapEach } from '../helpers/array';
import { mapRange } from '../helpers/number';
import { rtlSign } from '../helpers/document';
import easing, { linear } from '../helpers/easing';

const DEFAULT_MOVE = 120;

export default class ScrollAnim {
  constructor() {
    this.entities = new Entities(
      'ScrollAnim',
      '[data-scroll-anim]',
      ScrollAnim.initSingle,
      ScrollAnim.destroySingle,
    );
  }

  static initSingle(containerEl) {
    const itemsArr = Array.prototype.filter.call(
      containerEl.querySelectorAll('[data-scroll-anim-item]'),
      itemEl => itemEl.closest('[data-scroll-anim]') === containerEl,
    );

    const rangeEl = ScrollAnim.getRangeEl(containerEl);

    const itemObjsArr = mapEach(itemsArr, (el) => {
      const [
        mode,
        rangeBegin,
        rangeEnd,
        easingName,
      ] = (el.getAttribute('data-scroll-anim-item') ?? '').split(';');

      return {
        el,
        mode,
        range: [rangeBegin ?? 0, rangeEnd ?? 1],
        easeFn: ScrollAnim.getEasing(easingName),
      };
    });

    function onSmoothScrollProgress(progress) {
      ScrollAnim.updateItems(itemObjsArr, progress);
    }

    const scrollObserver = createScrollObserver(rangeEl, { onSmoothScrollProgress });
    scrollObserver.observe();

    function destroy() {
      // scrollObserver.unobserve();
      scrollObserver.destroy();
    }

    return {
      destroy,
    };
  }

  static getRangeEl(containerEl) {
    const rangeEl = containerEl.querySelector('[data-scroll-anim-range]');
    if (rangeEl !== null && rangeEl.closest('[data-scroll-anim]') === containerEl) return rangeEl;
    return containerEl;
  }

  static updateItems(itemObjsArr, progress) {
    each(itemObjsArr, ({
      el, mode, range, easeFn,
    }) => {
      const factor = easeFn(mapRange(range[0], range[1], 0, 1, progress));
      const invFactor = 1 - factor;

      switch (mode) {
        case 'fadeInStart':
          el.style.transform = `translateX(${-DEFAULT_MOVE * invFactor * rtlSign}px)`;
          el.style.opacity = factor;
          break;

        case 'fadeInEnd':
          el.style.transform = `translateX(${DEFAULT_MOVE * invFactor * rtlSign}px)`;
          el.style.opacity = factor;
          break;

        case 'fadeInUp':
          el.style.transform = `translateY(${-DEFAULT_MOVE * invFactor}px)`;
          el.style.opacity = factor;
          break;

        case 'fadeInDown':
          el.style.transform = `translateY(${DEFAULT_MOVE * invFactor}px)`;
          el.style.opacity = factor;
          break;

        default: break;
      }
    });
  }

  static getEasing(easingName) {
    return easing[easingName] ?? linear;
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
