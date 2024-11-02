export default class LiteEvents {
  constructor() {
    this.setEvents();
    this.onScrollThrottle();
  }

  setEvents() {
    this.bindScroll();
    this.bindResize();
  }

  bindScroll() {
    this.onScroll = this.onScroll.bind(this);
    this.onScrollThrottle = this.onScrollThrottle.bind(this);

    window.addEventListener('scroll', this.onScrollThrottle);
  }

  onScrollThrottle() {
    if (this.waitScroll) return;
    this.waitScroll = true;

    this.rafScroll = requestAnimationFrame(this.onScroll);
  }

  onScroll() {
    const scrollTop = window.scrollY
      || window.pageYOffset
      || document.body.scrollTop
      || document.documentElement.scrollTop
      || 0;

    window.dispatchEvent(new CustomEvent('liteScroll', {
      detail: { scrollTop },
    }));

    this.waitScroll = false;
  }

  bindResize() {
    this.onResize = this.onResize.bind(this);
    this.onResizeThrottle = this.onResizeThrottle.bind(this);

    window.addEventListener('resize', this.onResizeThrottle);
  }

  onResizeThrottle() {
    if (this.waitResize) return;
    this.waitResize = true;

    this.rafResize = requestAnimationFrame(this.onResize);
  }

  onResize() {
    const windowWidth = window.innerWidth;
    window.dispatchEvent(new CustomEvent('liteResize', {
      detail: { windowWidth },
    }));

    this.waitResize = false;
  }
}
