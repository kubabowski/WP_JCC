export default class LockScroll {
  constructor() {
    this.setVars();
    this.bindEvents();
  }

  setVars() {
    this.html = document.querySelector('html');

    this.lockClass = 'lockScroll';
  }

  bindEvents() {
    this.onLockScroll = this.onLockScroll.bind(this);
    window.addEventListener('LockScroll', this.onLockScroll);

    this.onUnlockScroll = this.onUnlockScroll.bind(this);
    window.addEventListener('UnlockScroll', this.onUnlockScroll);
  }

  onLockScroll() {
    this.html.classList.add(this.lockClass);
  }

  onUnlockScroll() {
    this.html.classList.remove(this.lockClass);
  }
}
