import { each, mapEach } from '../../helpers/array';

import SliderNav from './SliderNav';

/**
 * returns nav click handlers & swiper setter
 * @returns {array<object, function>} instanceof SliderNav
 */
export function getNavClickHandlers() {
  let swiper = null;

  function onNextClick() {
    swiper?.slideNext();
  }

  function onPrevClick() {
    swiper?.slidePrev();
  }

  /**
   * set Swiper instance to controll by nav
   * @param {Swiper} navSwiper Swiper instance to controll by nav
   * @returns {array} [{ onNextClick, onPrevClick }, setNavSwiper]
   */
  function setNavSwiper(navSwiper) {
    swiper = navSwiper;
  }

  return [
    { onNextClick, onPrevClick },
    setNavSwiper,
  ];
}

/**
 * returns array of SliderNav instances
 * @param {array<element>} navArr array of nav elements
 * @param {object} options SliderNav options
 * @returns {array<SliderNav>} instanceof SliderNav
 */
export function initSliderNav(navArr = [], options = {}) {
  const {
    onNextClick,
    onPrevClick,
    current = 1,
    total = 1,
    loop = false,
  } = options;

  return mapEach(navArr, navEl => new SliderNav({
    element: navEl,
    onNextClick,
    onPrevClick,
    current,
    total,
    loop,
  }));
}

/**
 * returns updatePagination function
 * @param {array<SliderNav>} sliderNavArr array of SliderNav instances
 * @returns {function} updatePagination function
 */
export function getUpdatePagination(sliderNavArr = []) {
  return function updatePagination(swiper, current, total) {
    each(sliderNavArr, (sliderNav) => {
      sliderNav.setState({
        current,
        total,
        loop: swiper.params.loop,
      });
    });
  };
}

/**
 * returns Swiper custom pagination options
 * @param {array<SliderNav>} sliderNavArr array of SliderNav instances
 * @returns {object} Swiper custom pagination options
 */
export function getCustomPagination(sliderNavArr = []) {
  return {
    el: document.createElement('div'),
    type: 'custom',
    renderCustom: getUpdatePagination(sliderNavArr),
  };
}

/**
 * create SliderNav instances and returns Swiper custom pagination options
 * @param {array<element>} navArr array of nav elements
 * @param {object} options SliderNav options
 * @returns {array} Swiper custom pagination options and more
 */
export function creareNavPagination(navArr = [], options = {}) {
  const [navClickhandlers, setNavSwiper] = getNavClickHandlers();

  const sliderNavArr = initSliderNav(navArr, {
    ...navClickhandlers,
    ...options,
  });

  return [
    getCustomPagination(sliderNavArr),
    setNavSwiper,
    sliderNavArr,
  ];
}

/**
 * returns updatePagination function
 * @param {array<SliderNav>} sliderNavArr array of SliderNav instances
 * @returns {function} updatePagination function
 */
export function getUpdateNav(sliderNavArr = []) {
  return function updateNav(swiper) {
    each(sliderNavArr, (sliderNav) => {
      sliderNav.setState({
        current: swiper.activeIndex + 1,
        total: swiper.slides.length,
        loop: swiper.params.loop,
      });
    });
  };
}

/**
 * create SliderNav instances and returns Swiper custom pagination options
 * @param {array<element>} navArr array of nav elements
 * @param {object} options SliderNav options
 * @returns {array} Swiper custom pagination options and more
 */
export function creareNavForBullets(navArr = [], options = {}) {
  const [navClickhandlers, setNavSwiper] = getNavClickHandlers();

  const sliderNavArr = initSliderNav(navArr, {
    ...navClickhandlers,
    ...options,
  });

  return [
    getUpdateNav(sliderNavArr),
    setNavSwiper,
    sliderNavArr,
  ];
}

export default {
  initSliderNav,
  getUpdatePagination,
  getCustomPagination,
  creareNavPagination,
  creareNavForBullets,
};
