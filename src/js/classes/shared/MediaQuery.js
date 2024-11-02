// keep in sync with html\src\scss\tools\rwd.scss $breakpointsUp object
const BREAKPOINTS = {
  phone: '(min-width: 360px)',
  'large-phone': '(min-width: 480px)',
  'small-tablet': '(min-width: 600px)',
  tablet: '(min-width: 768px)',
  'large-tablet': '(min-width: 1024px)',
  laptop: '(min-width: 1280px)',
  'large-laptop': '(min-width: 1366px)',
  ultra: '(min-width: 1600px)',
};

/**
 * MediaQueryObserver change callback
 * @callback changeCallback
 * @param {boolean} matches
 * @param {string} media
 */

/**
 * create custom MediaQueryObserver
 * @param {string} mediaQuery
 * @param {changeCallback} handleChange
 * @returns {object} MediaQueryObserver object
 */
export function createMediaQueryObserver(mediaQuery, handleChange) {
  let matchMedia = null;

  function onChange(e) {
    handleChange(e.matches, e.media);
  }

  function observe() {
    matchMedia = window.matchMedia(mediaQuery);

    if (matchMedia === null) return;

    matchMedia.addEventListener('change', onChange);

    handleChange(matchMedia.matches, matchMedia.media);
  }

  function unobserve() {
    if (matchMedia === null) return;

    matchMedia.removeEventListener('change', onChange);

    matchMedia = null;
  }

  return {
    observe,
    unobserve,
  };
}

/**
 * create custom BreakpointObserver
 * @param {string} breakpointKey
 * @param {changeCallback} handleChange
 * @returns {object} MediaQueryObserver object
 */
export function createBreakpointObserver(breakpointKey, handleChange) {
  const query = BREAKPOINTS[breakpointKey];

  return createMediaQueryObserver(query, handleChange);
}

export default {
  createMediaQueryObserver,
  createBreakpointObserver,
};
