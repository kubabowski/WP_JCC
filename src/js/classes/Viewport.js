export default class Viewport {
  constructor() {
    this.setVars();
    this.bindEvents();
    this.updateViewportVars();
  }

  setVars() {
    this.htmlEl = document.querySelector('html');
    // this.htmlEl = document.documentElement;
  }

  bindEvents() {
    this.onResizeEvent = this.updateViewportVars.bind(this);
    window.addEventListener('liteResize', this.onResizeEvent);
  }

  updateViewportVars() {
    // const vh = window.innerHeight / 100;
    // const vw = window.innerWidth / 100;

    // this.htmlEl.style.setProperty('--vh', `${vh}px`);
    // this.htmlEl.style.setProperty('--vw', `${vw}px`);

    const vh = window.innerHeight;
    const vw = window.innerWidth;

    this.htmlEl.style.setProperty('--100vh', `${vh}px`);
    this.htmlEl.style.setProperty('--100vw', `${vw}px`);
  }
}
