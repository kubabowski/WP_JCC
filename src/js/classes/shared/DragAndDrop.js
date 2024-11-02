export default class DragAndDrop {
  constructor(options) {
    if (!this.setVars(options)) return;

    this.bindStatics();
    this.bindThis();
    this.bindBeginEvents();
  }

  setVars(options) {
    const NOOP = () => {};

    const {
      element,
      mouse = true,
      touch = true,
      onBegin = NOOP,
      onMove = NOOP,
      onEnd = NOOP,
    } = options;

    this.rootEl = element;
    if (!this.rootEl) return false;

    this.mouse = mouse;
    this.touch = touch;

    this.onBegin = onBegin;
    this.onMove = onMove;
    this.onEnd = onEnd;

    this.prevPos = { x: 0, y: 0 };
    this.velocity = {};

    this.resetXY();

    return true;
  }

  static eventToXY(e) {
    const touch = e.touch || (e.touches ? e.touches[0] : false);

    return {
      x: touch ? touch.clientX : e.clientX,
      y: touch ? touch.clientY : e.clientY,
    };
  }

  bindStatics() {
    this.eventToXY = DragAndDrop.eventToXY;
  }

  bindThis() {
    this.onMouseDown = this.onMouseDown.bind(this);
    this.onDocMouseMove = this.onDocMouseMove.bind(this);
    this.onDocMouseUp = this.onDocMouseUp.bind(this);
    this.onDocMouseLeave = this.onDocMouseLeave.bind(this);

    this.touchStartOptions = { passive: true };
    this.onTouchStart = this.onTouchStart.bind(this);
    this.onDocTouchMove = this.onDocTouchMove.bind(this);
    this.onDocTouchEnd = this.onDocTouchEnd.bind(this);
  }

  bindBeginEvents() {
    if (this.mouse) this.rootEl.addEventListener('mousedown', this.onMouseDown);
    if (this.touch) {
      this.rootEl.addEventListener('touchstart', this.onTouchStart, this.touchStartOptions);
    }
  }

  unbindBeginEvents() {
    if (this.mouse) this.rootEl.removeEventListener('mousedown', this.onMouseDown);
    if (this.touch) {
      this.rootEl.removeEventListener('touchstart', this.onTouchStart, this.touchStartOptions);
    }
  }

  bindDocEvents() {
    if (this.mouse) this.bindDocMouseEvents();
    if (this.touch) this.bindDocTouchEvents();
  }

  bindDocMouseEvents() {
    document.addEventListener('mousemove', this.onDocMouseMove);
    document.addEventListener('mouseup', this.onDocMouseUp);
    document.addEventListener('mouseleave', this.onDocMouseLeave);
  }

  bindDocTouchEvents() {
    document.addEventListener('touchmove', this.onDocTouchMove);
    document.addEventListener('touchend', this.onDocTouchEnd);
  }

  unbindDocEvents() {
    if (this.mouse) this.unbindDocMouseEvents();
    if (this.touch) this.unbindDocTouchEvents();
  }

  unbindDocMouseEvents() {
    document.removeEventListener('mousemove', this.onDocMouseMove);
    document.removeEventListener('mouseup', this.onDocMouseUp);
    document.removeEventListener('mouseleave', this.onDocMouseLeave);
  }

  unbindDocTouchEvents() {
    document.removeEventListener('touchmove', this.onDocTouchMove);
    document.removeEventListener('touchend', this.onDocTouchEnd);
  }

  onMouseDown(e) {
    if (e.button !== 0) return; // https://developer.mozilla.org/en-US/docs/Web/API/MouseEvent/button#value

    e.preventDefault();
    e.stopPropagation(); // to handle nested DragAndDrop
    this.moveBegin(e);
  }

  onTouchStart(e) {
    // e.preventDefault();
    e.stopPropagation(); // to handle nested DragAndDrop
    this.moveBegin(e);
  }

  onDocMouseMove(e) {
    this.moveUpdate(e);
  }

  onDocMouseUp(e) {
    this.moveEnd(e);
  }

  onDocMouseLeave(e) {
    this.moveEnd(e);
  }

  onDocTouchMove(e) {
    this.moveUpdate(e);
  }

  onDocTouchEnd(e) {
    this.moveEnd(e);
  }

  moveBegin(e) {
    const { rootEl } = this;

    this.prevPos = this.eventToXY(e);
    this.velocity = {
      x: 0,
      y: 0,
    };

    // rootEl.style.userSelect = 'none';
    // rootEl.style.pointerEvents = 'none';

    this.bindDocEvents();

    const beginXY = this.eventToXY(e);
    this.moveBeginXY = beginXY;

    this.onBegin({
      event: e,
      current: beginXY,
      begin: this.moveBeginXY,
      diff: this.moveDiffXY,
      el: rootEl,
    });
  }

  moveUpdate(e) {
    const { rootEl } = this;

    const moveXY = this.eventToXY(e);
    this.moveDiffXY.x = moveXY.x - this.moveBeginXY.x;
    this.moveDiffXY.y = moveXY.y - this.moveBeginXY.y;

    this.velocity = {
      x: this.eventToXY(e).x - this.prevPos.x,
      y: this.eventToXY(e).y - this.prevPos.y,
    };
    this.prevPos = this.eventToXY(e);

    this.onMove({
      event: e,
      current: moveXY,
      begin: this.moveBeginXY,
      diff: this.moveDiffXY,
      el: rootEl,
    });
  }

  moveEnd(e) {
    const { rootEl } = this;

    const endXY = { x: 0, y: 0 };
    endXY.x = this.moveBeginXY.x + this.moveDiffXY.x;
    endXY.y = this.moveBeginXY.y + this.moveDiffXY.y;

    this.onEnd({
      event: e,
      current: endXY,
      begin: this.moveBeginXY,
      diff: this.moveDiffXY,
      el: rootEl,
      velocity: this.velocity,
    });

    this.unbindDocEvents();

    this.resetXY();

    // rootEl.style.userSelect = '';
    // rootEl.style.pointerEvents = '';
  }

  resetXY() {
    this.moveBeginXY = null;
    this.moveDiffXY = { x: 0, y: 0 };
    this.velocity = { x: 0, y: 0 };
  }

  destroy() {
    this.unbindDocEvents();
    this.unbindBeginEvents();
  }
}
