import Entities from './shared/Entities';
import { setClassName } from '../helpers/dom';

export default class InputLabel {
  constructor() {
    this.entities = new Entities(
      'InputLabel',
      '[data-input-label]',
      InputLabel.initSingle,
      InputLabel.destroySingle,
    );
  }

  static initSingle(containerEl) {
    const inputEl = containerEl.querySelector('[data-input-label-input]');
    const className = containerEl.getAttribute('data-input-label');

    setClassName(containerEl, className, inputEl.value);

    function onChange(e) {
      setClassName(containerEl, className, e.target.value);
    }

    inputEl.addEventListener('keyup', onChange);
    inputEl.addEventListener('input', onChange);
    inputEl.addEventListener('change', onChange);

    function destroy() {
      inputEl.removeEventListener('keyup', onChange);
      inputEl.removeEventListener('input', onChange);
      inputEl.removeEventListener('change', onChange);
    }

    return {
      destroy,
    };
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
