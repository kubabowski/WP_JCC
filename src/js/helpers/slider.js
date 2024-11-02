import { setAttrs } from './dom';
import { clamp } from './number';

/**
 * set slide data attribute
 * @param {element} slideEl slide on which it will set data
 * @param {number} slideIndex index of slideEl
 * @param {number} activeIndex slider active slide index
 * @param {string} dataPrefix data attribute prefix
 * @param {number} lastIndex optional lastIndex
 */
export function setSlideAttrs(
  slideEl, slideIndex, activeIndex, dataPrefix = 'data-', lastIndex = null,
) {
  let type;
  if (slideIndex === activeIndex) {
    if (lastIndex !== null && lastIndex !== activeIndex) {
      if (activeIndex > lastIndex) {
        type = 'next-current';
      } else {
        type = 'prev-current';
      }
    } else {
      type = 'current';
    }
  }
  if (slideIndex < activeIndex) type = 'prev';
  if (slideIndex > activeIndex) type = 'next';

  setAttrs(slideEl, {
    'slide-type': type,
    'slide-offset': Math.abs(slideIndex - activeIndex),
  }, dataPrefix);
}

/**
 * returns swiper move factor
 * @param {object} swiper swiper instance
 * @param {boolean} clampAbs clamp abs factor (default: true)
 * @returns {object} move factor object { moveFactor, absMoveFactor }
 */
export function getMoveFactor(swiper, clampAbs = true) {
  const {
    activeIndex,
    translate,
    slidesGrid,
    slidesSizesGrid,
    rtlTranslate,
  } = swiper;

  const sign = rtlTranslate ? -1 : 1;
  const moveFactor = (
    (slidesGrid[activeIndex] + translate * sign) / slidesSizesGrid[activeIndex]
  );

  const tmpAbs = Math.abs(moveFactor);
  const absMoveFactor = clampAbs ? clamp(0, 1, tmpAbs) : tmpAbs;

  return {
    moveFactor,
    absMoveFactor,
  };
}

export default {
  setSlideAttrs,
  getMoveFactor,
};
