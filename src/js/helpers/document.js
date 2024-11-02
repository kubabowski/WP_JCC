/**
 * get or set scrollTop value
 * @param {number} value the scrollTop value to set
 * @returns {number|null} current scrollTop value if not passed value, null if passed
 */
export function scrollTop(value) {
  if (value) {
    document.body.scrollTop = value;
    document.documentElement.scrollTop = value;
    return null;
  }

  return window.scrollY
    || window.pageYOffset
    || document.body.scrollTop
    || document.documentElement.scrollTop
    || 0;
}

/* eslint-disable quote-props */
// keep sync with src\scss\tools\rwd.scss
const RWD_BREAKPOINTS = {
  'phone': 360,
  'large-phone': 480,
  'small-tablet': 600,
  'tablet': 768,
  'large-tablet': 1024,
  'laptop': 1280,
  'large-laptop': 1366,
  'ultra': 1600,
};
/* eslint-enable quote-props */
/**
 * checks that breakpoint is fulfilled or not
 * @param {string} breakpoint breakpoint name
 * @returns {boolean} info that breakpoint is fulfilled or not
 */
export function checkRwd(breakpoint) {
  const width = RWD_BREAKPOINTS[breakpoint];
  if (width === undefined) return false;

  return (window.innerWidth >= width);
}

export const isRtl = document.getElementsByTagName('html')[0].getAttribute('dir') === 'rtl';

export const rtlSign = isRtl ? -1 : 1;

export default {
  scrollTop,
  checkRwd,
  isRtl,
  rtlSign,
};
