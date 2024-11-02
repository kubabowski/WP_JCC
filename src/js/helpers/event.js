export function bindEvent(targetEl, eventName, callback, options) {
  targetEl.addEventListener(eventName, callback, options);
}

export function unbindEvent(targetEl, eventName, callback, options) {
  targetEl.removeEventListener(eventName, callback, options);
}

export function trigger(targetEl, eventName, payload = {}) {
  targetEl.dispatchEvent(new CustomEvent(eventName, { detail: payload }));
}

export default {
  bindEvent,
  unbindEvent,
  trigger,
};
