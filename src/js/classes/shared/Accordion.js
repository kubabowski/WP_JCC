class Accordion {
  static uniqueId = 0;

  constructor(selectorOrElement, userOptions) {
    this.eventsAttached = false;

    // Break the array with the selectors
    if (Array.isArray(selectorOrElement)) {
      if (selectorOrElement.length) {
        return selectorOrElement.map(
          (single) => new Accordion(single, userOptions)
        );
      }
      return false;
    }

    const defaults = {
      duration: 600,
      ariaEnabled: true,
      collapse: true,
      showMultiple: false,
      onlyChildNodes: true,
      openOnInit: [],
      elementClass: "ac",
      triggerClass: "ac-trigger",
      panelClass: "ac-panel",
      activeClass: "is-active",
      beforeOpen: () => {},
      onOpen: () => {},
      beforeClose: () => {},
      onClose: () => {},
    };

    // Extend default options
    this.options = Object.assign(defaults, userOptions);

    const isString = typeof selectorOrElement === "string";
    this.container = isString
      ? document.querySelector(selectorOrElement)
      : selectorOrElement;

    this.createDefinitions();
    this.attachEvents();
  }

  createDefinitions() {
    const { elementClass, openOnInit, onlyChildNodes } = this.options;

    const allElements = onlyChildNodes
      ? this.container.childNodes
      : this.container.querySelectorAll(this._cn(elementClass));

    this.elements = Array.from(allElements).filter(
      (el) => el.classList && el.classList.contains(elementClass)
    );

    this.firstElement = this.elements[0];
    this.lastElement = this.elements[this.elements.length - 1];

    this.elements
      .filter((element) => !element.classList.contains(`js-enabled`))
      .forEach((element) => {
        element.classList.add("js-enabled");

        this.generateIDs(element);
        this.setARIA(element);
        this.setTransition(element);

        const index = this.elements.indexOf(element);
        Accordion.uniqueId++;
        openOnInit.includes(index)
          ? this.showElement(element, false)
          : this.closeElement(element, false);
      });
  }

  setTransition(element, clear = false) {
    const { duration, panelClass } = this.options;
    const panel = element.querySelector(this._cn(panelClass));
    const transition = this._isWebkit("transitionDuration");

    panel.style[transition] = clear ? null : `${duration}ms`;
  }

  generateIDs(element) {
    const { triggerClass, panelClass } = this.options;
    const trigger = element.querySelector(this._cn(triggerClass));
    const panel = element.querySelector(this._cn(panelClass));

    element.setAttribute("id", element.id || `ac-${Accordion.uniqueId}`);
    trigger.setAttribute("id", trigger.id || `ac-trigger-${Accordion.uniqueId}`);
    panel.setAttribute("id", panel.id || `ac-panel-${Accordion.uniqueId}`);
  }

  setARIA(element) {
    const { ariaEnabled, triggerClass, panelClass } = this.options;
    if (!ariaEnabled) return;

    const trigger = element.querySelector(this._cn(triggerClass));
    const panel = element.querySelector(this._cn(panelClass));

    trigger.setAttribute("role", "button");
    trigger.setAttribute("aria-controls", panel.id);
    trigger.setAttribute("aria-disabled", false);
    trigger.setAttribute("aria-expanded", false);
    panel.setAttribute("role", "region");
    panel.setAttribute("aria-labelledby", trigger.id);
  }

  updateARIA(element, { ariaExpanded, ariaDisabled }) {
    const { ariaEnabled, triggerClass } = this.options;
    if (!ariaEnabled) return;

    const trigger = element.querySelector(this._cn(triggerClass));
    trigger.setAttribute("aria-expanded", ariaExpanded);
    trigger.setAttribute("aria-disabled", ariaDisabled);
  }

  attachEvents() {
    if (this.eventsAttached) return;
    const { triggerClass, panelClass } = this.options;

    this.handleClick = this.handleClick.bind(this);
    this.handleKeydown = this.handleKeydown.bind(this);
    this.handleFocus = this.handleFocus.bind(this);
    this.handleTransitionEnd = this.handleTransitionEnd.bind(this);

    this.elements.forEach((element) => {
      const trigger = element.querySelector(this._cn(triggerClass));
      const panel = element.querySelector(this._cn(panelClass));

      trigger.addEventListener("click", this.handleClick);
      trigger.addEventListener("keydown", this.handleKeydown);
      trigger.addEventListener("focus", this.handleFocus);
      panel.addEventListener("webkitTransitionEnd", this.handleTransitionEnd);
      panel.addEventListener("transitionend", this.handleTransitionEnd);
    });

    this.eventsAttached = true;
  }

  detachEvents() {
    if (!this.eventsAttached) return;
    const { triggerClass, panelClass } = this.options;

    this.elements.forEach((element) => {
      const trigger = element.querySelector(this._cn(triggerClass));
      const panel = element.querySelector(this._cn(panelClass));

      trigger.removeEventListener("click", this.handleClick);
      trigger.removeEventListener("keydown", this.handleKeydown);
      trigger.removeEventListener("focus", this.handleFocus);
      panel.removeEventListener("webkitTransitionEnd", this.handleTransitionEnd);
      panel.removeEventListener("transitionend", this.handleTransitionEnd);
    });

    this.eventsAttached = false;
  }

  showElement(element, calcHeight = true) {
    const { panelClass, activeClass, collapse, beforeOpen } = this.options;
    if (calcHeight) beforeOpen(element);

    const panel = element.querySelector(this._cn(panelClass));
    const height = panel.scrollHeight;

    element.classList.add(activeClass);
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        panel.style.height = calcHeight ? `${height}px` : "auto";
      });
    });

    this.updateARIA(element, {
      ariaExpanded: true,
      ariaDisabled: collapse ? false : true,
    });
  }

  closeElement(element, calcHeight = true) {
    const { panelClass, activeClass, beforeClose } = this.options;
    const panel = element.querySelector(this._cn(panelClass));
    const height = panel.scrollHeight;

    element.classList.remove(activeClass);
    if (calcHeight) {
      beforeClose(element);
      requestAnimationFrame(() => {
        panel.style.height = `${height}px`;
        requestAnimationFrame(() => {
          panel.style.height = 0;
        });
      });
    } else {
      panel.style.height = 0;
    }

    this.updateARIA(element, { ariaExpanded: false, ariaDisabled: false });
  }

  toggleElement(element) {
    const { activeClass, collapse } = this.options;
    const isActive = element.classList.contains(activeClass);

    if (isActive && !collapse) return;
    return isActive
      ? this.closeElement(element)
      : this.showElement(element);
  }

  handleClick(e) {
    const target = e.currentTarget;
    this.elements.forEach((element, idx) => {
      if (element.contains(target) && e.target.nodeName !== "A") {
        this.currFocusedIdx = idx;
        this.closeElements();
        this.toggleElement(element);
      }
    });
  }

  handleKeydown(e) {
    switch (e.key) {
      case "ArrowUp":
        return this.focusPrevElement(e);
      case "ArrowDown":
        return this.focusNextElement(e);
      case "Home":
        return this.focusFirstElement(e);
      case "End":
        return this.focusLastElement(e);
      default:
        return null;
    }
  }

  handleFocus(e) {
    const target = e.currentTarget;
    const currElement = this.elements.find((element) => element.contains(target));
    this.currFocusedIdx = this.elements.indexOf(currElement);
  }

  handleTransitionEnd(e) {
    e.stopPropagation();
    if (e.propertyName !== "height") return;

    const { onOpen, onClose } = this.options;
    const panel = e.currentTarget;
    const height = parseInt(panel.style.height);
    const element = this.elements.find((element) => element.contains(panel));

    if (height > 0) {
      panel.style.height = "auto";
      onOpen(element);
    } else {
      onClose(element);
    }
  }

  _cn(className) {
    return `.${CSS.escape(className)}`;
  }

  _isWebkit(property) {
    if (typeof document.documentElement.style[property] === "string") {
      return property;
    }
    property = this._capitalizeFirstLetter(property);
    return `webkit${property}`;
  }

  _capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  // Public methods
  toggle(elIdx) {
    const el = this.elements[elIdx];
    if (el) this.toggleElement(el);
  }

  open(elIdx) {
    const el = this.elements[elIdx];
    if (el) this.showElement(el);
  }

  close(elIdx) {
    const el = this.elements[elIdx];
    if (el) this.closeElement(el);
  }

  destroy() {
    this.detachEvents();
    this.openAll();
    this.elements.forEach((element) => {
      this.removeIDs(element);
      this.removeARIA(element);
      this.setTransition(element, true);
    });

    this.eventsAttached = true;
  }

  openAll() {
    const { activeClass, onOpen } = this.options;
    this.elements.forEach((element) => {
      const isActive = element.classList.contains(activeClass);
      if (!isActive) {
        this.showElement(element, false);
        onOpen(element);
      }
    });
  }

  closeAll() {
    const { activeClass, onClose } = this.options;
    this.elements.forEach((element) => {
      const isActive = element.classList.contains(activeClass);
      if (isActive) {
        this.closeElement(element, false);
        onClose(element);
      }
    });
  }

  update() {
    this.createDefinitions();
    this.detachEvents();
    this.attachEvents();
  }
}

// Exporting the Accordion class
if (typeof module !== "undefined" && typeof module.exports !== "undefined") {
  module.exports = Accordion;
} else {
  window.Accordion = Accordion;
}
