import { each } from './array';

/**
 * conditional set css class name on the element
 * @param {element} el DOM element
 * @param {string} className css class name to set
 * @param {boolean} status required status of class
 */
export function setClassName(el, className, status = true) {
  if (status) {
    el.classList.add(className);
  } else {
    el.classList.remove(className);
  }
}

/**
 * set data attributes on the element
 * @param {element} el DOM element
 * @param {string} key attribute key
 * @param {string|null} value attribute value
 * @param {string} prefix attribute key prefix
 */
export function setAttr(el, key, value = '', prefix = '') {
  if (value === null) {
    el.removeAttribute(prefix + key);
  } else {
    el.setAttribute(prefix + key, value);
  }
}

/**
 * set data attributes on the element
 * @param {element} el DOM element
 * @param {object} attrsObj attributes object { attrKey: attrValue }
 * @param {string} prefix attributes key prefix
 */
export function setAttrs(el, attrsObj, prefix = '') {
  each(Object.keys(attrsObj), (attrKey) => {
    setAttr(el, attrKey, attrsObj[attrKey], prefix);
  });
}

/**
 * set styles on the element
 * @param {element} el DOM element
 * @param {string} key style key
 * @param {string} value style value
 */
export function setStyle(el, key, value) {
  el.style[key] = value;
}

/**
 * set styles on the element
 * @param {element} el DOM element
 * @param {object} stylesObj styles object { styleKey: styleValue }
 */
export function setStyles(el, stylesObj) {
  each(Object.keys(stylesObj), (styleKey) => {
    setStyle(el, styleKey, stylesObj[styleKey]);
  });
}

export default {
  setClassName,
  setAttr,
  setAttrs,
  setStyle,
  setStyles,
};
