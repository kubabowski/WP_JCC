import { each } from '../../helpers/array';
import { lerp, clamp } from '../../helpers/number';

const observers = {};

export function getObserverKey({ rootMargin, threshold }) {
  return `${(rootMargin ?? '')};${JSON.stringify(threshold ?? 0)}`;
}

/**
 * create custom IntersectionObserver
 * @param {element} el
 * @param {function} callback
 * @param {object} options IntersectionObserver options
 * @returns {object} ScrollObserver object
 */
export function createInVIewObserver(el, callback, options) {
  const observerKey = getObserverKey(options);

  function createObserverObj() {
    const newObserverObj = {
      observer: null,
      handlers: [],
    };

    function sharedCallback(entries) {
      each(entries, (entry) => {
        each(newObserverObj.handlers, (handler) => {
          if (handler.el !== entry.target) return;

          handler.callback(entry);
        });
      });
    }

    newObserverObj.observer = new IntersectionObserver(sharedCallback, options);

    return newObserverObj;
  }

  const observerObj = observers[observerKey] ?? (observers[observerKey] = createObserverObj());

  observerObj.handlers.push({
    el,
    callback,
  });

  function observe() {
    observerObj.observer.observe(el);
  }

  function unobserve() {
    observerObj.observer.unobserve(el);
  }

  function destroy() {
    unobserve();

    const handlerIndex = observerObj.handlers.findIndex(handler => handler.el === el);
    if (handlerIndex !== -1) observerObj.handlers.splice(handlerIndex, 1);
    if (observerObj.handlers.length) delete observers[observerKey];
  }

  return {
    observe,
    unobserve,
    destroy,
  };
}

const DEFAULT_SMOOTH_FORCE = 0.8;
const DEFAULT_SMOOTH_LIMIT = 0.0001;

/**
 * create custom IntersectionObserver
 * @param {element} el
 * @param {array} events
 * @param {object} options
 * @returns {object} ScrollObserver object
 */
export function createScrollObserver(el, events = {}, options = {}) {
  let scrollListening = false;

  const useSmooth = events?.onSmoothScrollProgress !== undefined;
  const useRaf = useSmooth
    || events?.onScroll !== undefined
    || events?.onScrollProgress !== undefined;
  let waitRaf = false;
  let scrollRaf = null;

  let targetFactor = 0;
  let smoothFactor = 0;
  const smoothForce = options?.smoothForce ?? DEFAULT_SMOOTH_FORCE;
  const smoothLimit = options?.smoothLimit ?? DEFAULT_SMOOTH_LIMIT;
  const smoothLerp = 1 - smoothForce;

  function getScrollFactor() {
    const winHeight = window.innerHeight;
    const elRect = el.getBoundingClientRect();

    let factor = (winHeight - elRect.top) / (winHeight + elRect.height);

    factor = clamp(0, 1, factor);

    return factor;
  }

  function onSmoothScroll() {
    if (Math.abs(targetFactor - smoothFactor) < smoothLimit) {
      events?.onSmoothScrollProgress?.(targetFactor);
      smoothFactor = targetFactor;
      events?.onSmoothScrollEnd?.(targetFactor);
      return;
    }

    smoothFactor = lerp(smoothFactor, targetFactor, smoothLerp);
    events?.onSmoothScrollProgress?.(smoothFactor);

    scrollRaf = requestAnimationFrame(onSmoothScroll);
  }

  function onScroll() {
    events?.onScroll?.();

    const scrollFactor = getScrollFactor();
    events?.onScrollProgress?.(scrollFactor);

    waitRaf = false;

    if (!useSmooth) return;

    targetFactor = scrollFactor;
    onSmoothScroll();
  }

  function onNativeScroll() {
    events?.onNativeScroll?.();

    const scrollFactor = getScrollFactor();
    events?.onNativeScrollProgress?.(scrollFactor);

    if (!useRaf) return;

    if (waitRaf) return;
    waitRaf = true;

    cancelAnimationFrame(scrollRaf);
    scrollRaf = requestAnimationFrame(onScroll);
  }

  function onEnter() {
    onNativeScroll();
  }

  function onLeave() {
    onNativeScroll();
  }

  function bindScroll() {
    if (scrollListening) return;

    scrollListening = true;
    window.addEventListener('scroll', onNativeScroll);
  }

  function unbindScroll() {
    if (!scrollListening) return;

    scrollListening = false;
    window.removeEventListener('scroll', onNativeScroll);
  }

  function onObserve(entry) {
    if (entry.isIntersecting) {
      events?.onEnter?.(entry);
      onEnter();
      bindScroll();
    } else {
      unbindScroll();
      onLeave();
      events?.onLeave?.(entry);
    }

    events?.onObserve?.(entry);
  }

  const observer = createInVIewObserver(el, onObserve, {
    threshold: 0,
  });

  function observe() {
    observer?.observe();
  }

  function unobserve() {
    unbindScroll();
    observer?.unobserve();
  }

  function destroy() {
    unbindScroll();
    observer?.destroy();
  }

  return {
    observer,
    observe,
    unobserve,
    destroy,
  };
}

export default {
  createInVIewObserver,
  createScrollObserver,
};
