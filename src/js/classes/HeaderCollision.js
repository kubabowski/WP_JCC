import Entities from './shared/Entities';
import { setClassName } from '../helpers/dom';

export default class HeaderCollision {
  constructor() {
    this.entities = new Entities(
      'HeaderCollision',
      '[data-header-colision]',
      HeaderCollision.initSingle,
    );
  }

  static initSingle(containerEl) {
    const className = containerEl.getAttribute('data-header-colision');

    let lastCollision = false;

    function onChange(e) {
      const { isScrollDown } = e.detail;

      const rect = containerEl.getBoundingClientRect();

      const nextCollision = !isScrollDown && rect.top < 0;

      if (lastCollision === nextCollision) return;

      lastCollision = nextCollision;

      setClassName(containerEl, className, nextCollision);
    }

    window.addEventListener('HeaderScrollDown', onChange);
  }
}
