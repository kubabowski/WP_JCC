import { setAttr } from '../../helpers/dom';

export default class SliderNav {
  constructor(options = {}) {
    if (!this.setVars(options)) return;
    this.bindEvents();
  }

  setVars(options) {
    this.rootEl = options.element;
    if (!this.rootEl) return false;

    this.nextButtonEl = this.rootEl.querySelector('[data-slider-nav-next]');
    this.prevButtonEl = this.rootEl.querySelector('[data-slider-nav-prev]');

    this.numberCurrentEl = this.rootEl.querySelector('[data-slider-nav-number-current]');
    this.numberTotalEl = this.rootEl.querySelector('[data-slider-nav-number-total]');

    this.state = {};
    this.setState({
      current: options.current ?? 1,
      total: options.total ?? 1,
      loop: options.loop !== undefined ? options.loop : true,
    });

    this.onNextClickEvent = options.onNextClick || (() => {});
    this.onPrevClickEvent = options.onPrevClick || (() => {});

    return true;
  }

  setState(state) {
    this.state = {
      ...this.state,
      ...state,
    };

    if (this.numberCurrentEl) SliderNav.setNumber(this.numberCurrentEl, this.state.current);
    if (this.numberTotalEl) SliderNav.setNumber(this.numberTotalEl, this.state.total);

    this.updateArrows();
  }

  bindEvents() {
    this.nextButtonEl.addEventListener('click', this.onNextClickEvent);
    this.prevButtonEl.addEventListener('click', this.onPrevClickEvent);
  }

  unbindEvents() {
    this.nextButtonEl.removeEventListener('click', this.onNextClickEvent);
    this.prevButtonEl.removeEventListener('click', this.onPrevClickEvent);
  }

  updateArrows() {
    if (this.state.loop) return;

    SliderNav.setDisabled(this.prevButtonEl, this.state.current === 1);
    SliderNav.setDisabled(this.nextButtonEl, this.state.current === this.state.total);
  }

  destroy() {
    this.unbindEvents();
  }

  static setNumber(el, number) {
    el.innerText = number;
  }

  static setDisabled(el, status = true) {
    setAttr(el, 'disabled', status ? 'disabled' : null);
  }
}
