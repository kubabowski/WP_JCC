import anime from 'animejs/lib/anime.es';
import { each } from '../helpers/array';
import { trigger } from '../helpers/event';

import Entities from './shared/Entities';

const OPEN_DURATION = 200;
const CLOSE_DURATION = 100;

export default class Popup {
  constructor() {
    this.mainPopupTplEl = document.querySelector('[data-popup-tpl]');
    if (!this.mainPopupTplEl) return;

    [this.bodyEl] = document.getElementsByTagName('body');

    this.initPopup();

    this.entities = new Entities(
      'Popup',
      '[data-popup-target]',
      Popup.initSingle,
    );

    this.bindEvents();
  }

  initPopup() {
    const tplEl = document.createElement('div');
    tplEl.innerHTML = this.mainPopupTplEl.innerHTML;

    this.popupEl = tplEl.querySelector('[data-popup]');
    tplEl.removeChild(this.popupEl);

    this.popupBoxEl = this.popupEl.querySelector('[data-popup-box]');
    this.popupCloseEl = this.popupBoxEl.querySelector('[data-popup-close]');
    this.popupContentEl = this.popupBoxEl.querySelector('[data-popup-content]');

    this.classes = {
      theme: 'popup--',
    };

    this.stack = [];
    this.isOpened = [];
  }

  static initSingle(buttonEl) {
    const id = buttonEl.getAttribute('data-popup-target');
    const tplEl = document.querySelector(`[data-popup-id="${id}"]`);

    if (tplEl === null) {
      console.warn(`Popup template [data-popup-id="${id}"] not found`);
      return null;
    }

    const theme = tplEl.getAttribute('data-popup-theme') || 'default';
    const props = JSON.parse(tplEl.getAttribute('data-popup-props') || '{}');

    const popupObj = {
      id,
      buttonEl,
      tplEl,
      theme,
      props,
    };

    const data = JSON.parse(buttonEl.getAttribute('data-popup-data') || '{}');

    function onClick(e) {
      e.preventDefault();

      trigger(window, 'PopupOpen', { id, data });
    }

    buttonEl.addEventListener('click', onClick);

    return popupObj;
  }

  bindEvents() {
    this.onOpen = this.onOpen.bind(this);
    window.addEventListener('PopupOpen', this.onOpen);

    this.onClose = this.onClose.bind(this);
    window.addEventListener('PopupClose', this.onClose);

    this.onCloseAll = this.onCloseAll.bind(this);
    window.addEventListener('PopupClose', this.onCloseAll);

    this.popupCloseEl.addEventListener('click', this.onClose);
  }

  onOpen(e) {
    const { id, data } = e.detail;
    this.open(id, data);
  }

  onClose() {
    this.closePrev();
  }

  onCloseAll() {
    this.closeAll();
  }

  getEntityById(id) {
    return this.entities.getAll().find(entity => entity.entityObj.id === id);
  }

  bindContentEvents() {
    const closeButtonsArr = this.popupContentEl.querySelectorAll('[data-popup-action-close]');
    each(closeButtonsArr, (closeButtonEl) => {
      closeButtonEl.addEventListener('click', this.onClose);
    });
  }

  static triggerEvents(eventsArr = []) {
    each(eventsArr, ([eventName, payload]) => {
      trigger(window, eventName, payload);
    });
  }

  open(id, data = {}) {
    const entity = this.getEntityById(id);
    if (entity === null) {
      console.warn(`Unnown popup ${id}`);
      return Promise.reject();
    }

    if (this.stack.length <= 0) {
      return this.showPopup(entity.entityObj, data);
    } else {
      return this.hidePopup({
        skipUnmount: true,
      })
        .then(() => this.showPopup(entity.entityObj, data, {
          skipMount: true,
        }));
    }
  }

  showPopup(entityObj, data = {}, { duration = OPEN_DURATION, skipMount = false } = {}) {
    return new Promise((resolve) => {
      anime.remove(this.popupEl);
      anime.set(this.popupEl, { opacity: 0 });
      if (!skipMount) {
        this.bodyEl.appendChild(this.popupEl);
      }

      const {
        tplEl,
        theme,
        props = {},
      } = entityObj;

      let contentHtml = tplEl.innerHTML;
      each(Object.keys(data), (dataKey) => {
        contentHtml = contentHtml.replace(new RegExp(`{{${dataKey}}}`, 'g'), data[dataKey]);
      });
      this.popupContentEl.innerHTML = contentHtml;
      // this.popupContentEl.innerHTML = tplEl.innerHTML;
      if (theme) this.popupEl.classList.add(`${this.classes.theme}${theme}`);

      Popup.triggerEvents([ // global events
        // ['InputLabelCreateNew'],
        ['CustomScrollCreateNew'],
        // ['CustomSelectCreateNew'],
      ]);
      Popup.triggerEvents(props.onMountEvents);
      Popup.triggerEvents(data.onMountEvents);
      this.bindContentEvents();

      this.stack.push(entityObj);

      anime({
        targets: this.popupEl,
        opacity: [0, 1],
        duration,
        easing: 'linear',
        complete: () => {
          resolve();
        },
      });
    });
  }

  hidePopup({ duration = CLOSE_DURATION, skipUnmount = false } = {}) {
    return new Promise((resolve) => {
      anime.remove(this.popupEl);

      anime({
        targets: this.popupEl,
        opacity: 0,
        duration,
        easing: 'linear',
        complete: () => {
          this.stack.pop();

          if (!skipUnmount) {
            this.bodyEl.removeChild(this.popupEl);
            this.popupContentEl.innerHTML = '';
          }

          resolve();
        },
      });
    });
  }

  closePrev() {
    if (this.stack.length > 1) {
      return this.hidePopup({ skipUnmount: true }).then(() => {
        this.showPopup(this.stack[this.stack.length - 1]);
      });
    } else {
      return this.hidePopup();
    }
  }

  closeAll() {
    this.stack = [];
    return this.hidePopup();
  }
}
