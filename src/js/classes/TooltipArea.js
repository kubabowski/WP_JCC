import Entities from './shared/Entities';
import { each, mapEach } from '../helpers/array';
import { setAttr } from '../helpers/dom';

export const REGEX_EMAIL = /^([\w\-_]+\.)*[\w\-_]+@([\w\-_]+\.)+[\w\-_]{2,}$/;

export default class TooltipArea {
  constructor() {
    this.entities = new Entities(
      'TooltipArea',
      '[data-tooltip-area]',
      TooltipArea.initSingle,
      TooltipArea.destroySingle,
    );
  }

  static initSingle(containerEl) {
    const boxEl = containerEl.querySelector('[data-tooltip-area-box]');
    const contentEl = boxEl.querySelector('[data-tooltip-area-box-content]');
    const itemsArr = containerEl.querySelectorAll('[data-tooltip-area-item]');

    const itemsObjsArr = mapEach(itemsArr, (itemEl) => {
      const content = itemEl.getAttribute('data-tooltip-area-item');

      return {
        itemEl,
        content,
      };
    });

    function onMouseEnter(e) {
      const target = e.currentTarget || e.target;

      const currObj = itemsObjsArr.find(itemObj => itemObj.itemEl === target);
      if (currObj === undefined) return;

      contentEl.innerText = currObj.content;

      const [x, y] = TooltipArea.mouseEventToPos(e, containerEl);
      TooltipArea.updateBoxPos(boxEl, x, y);

      setAttr(boxEl, 'data-active', '');
    }

    function onMouseMove(e) {
      const [x, y] = TooltipArea.mouseEventToPos(e, containerEl);
      TooltipArea.updateBoxPos(boxEl, x, y);
    }

    function onMouseLeave() {
      setAttr(boxEl, 'data-active', null);
    }

    each(itemsObjsArr, (itemObj) => {
      itemObj.itemEl.addEventListener('mouseenter', onMouseEnter);
      itemObj.itemEl.addEventListener('mousemove', onMouseMove);
      itemObj.itemEl.addEventListener('mouseleave', onMouseLeave);
    });

    function destroy() {
      each(itemsObjsArr, (itemObj) => {
        itemObj.itemEl.removeEventListener('mouseenter', onMouseEnter);
        itemObj.itemEl.removeEventListener('mousemove', onMouseMove);
        itemObj.itemEl.removeEventListener('mouseleave', onMouseLeave);
      });
    }

    return {
      destroy,
    };
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }

  static mouseEventToPos(e, containerEl) {
    const rect = containerEl.getBoundingClientRect();

    return [
      e.clientX - rect.left,
      e.clientY - rect.top,
    ];
  }

  static updateBoxPos(boxEl, x, y) {
    boxEl.style.transform = `translate(${x}px,${y}px)`;
  }
}
