import anime from 'animejs/lib/anime.es';

import Entities from './shared/Entities';
import { trigger } from '../helpers/event';

class ImagePreviewEntity {

  constructor(rootEl)
  {
    if (!this.setVars(rootEl)) return;

    this.bindEvents();
  }

  setVars(rootEl)
  {
    this.rootEl = rootEl;
    if (!this.rootEl) return false;

    this.popupEl = document.querySelector('[data-image-preview-popup]');
    if (!this.popupEl) return;

    return true;
  }

  bindEvents()
  {
    this.onSliderItemClickEvent = this.onSliderItemClick.bind(this);
    this.rootEl.addEventListener('click', this.onSliderItemClickEvent);
  }

  onSliderItemClick(e)
  {
    const parentEl = e.target.closest('[data-image-preview]');
    const itemsArr = parentEl.querySelectorAll('[data-image-preview-item]');

    const dataArr = Object.values(itemsArr).map((item) => {
      return item.getAttribute('data-image-preview-item');
    });

    trigger(window, 'ImagePreviewOpen', { dataArr });
  }
}

export default class ImagePreview {
  constructor() {
    this.entities = new Entities(
      'ImagePreview',
      '[data-image-preview]',
      ImagePreview.initSingle,
      // ImagePreview.destroySingle,
    );
  }

  static initSingle(element) {
    return new ImagePreviewEntity(element);
  }

  // static destroySingle({ entityObj }) {
  //   entityObj?.destroy();
  // }
}
