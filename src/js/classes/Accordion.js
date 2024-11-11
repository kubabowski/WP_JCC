import anime from 'animejs/lib/anime.es';

let uniqueId = 0;

export default class Accordion {
  constructor(selectorOrElement, userOptions) {
    this.eventsAttached = false;
    this.options = this.setOptions(userOptions);
    this.container = this.getContainer(selectorOrElement);
    this.init();
  }

  setOptions(userOptions) {
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
    return Object.assign(defaults, userOptions);
  }

  getContainer(selectorOrElement) {
    return typeof selectorOrElement === "string"
      ? document.querySelector(selectorOrElement)
      : selectorOrElement;
  }

  init() {
    this.createDefinitions();
    this.attachEvents();
  }

  createDefinitions() {
    const { elementClass, openOnInit, onlyChildNodes } = this.options;
    const allElements = onlyChildNodes
      ? this.container.childNodes
      : this.container.querySelectorAll(this.cn(elementClass));

    this.elements = Array.from(allElements).filter(
      (el) => el.classList && el.classList.contains(elementClass)
    );

    this.elements.forEach((element) => {
      if (!element.classList.contains('js-enabled')) {
        element.classList.add('js-enabled');
        this.generateIDs(element);
        this.setARIA(element);
        this.setTransition(element);
        const index = this.elements.indexOf(element);
        openOnInit.includes(index) ? this.showElement(element, false) : this.closeElement(element, false);
      }
    });
  }

  setTransition(element, clear = false) {
    const { duration, panelClass } = this.options;
    const panel = element.querySelector(this.cn(panelClass));
    const transition = this.isWebkit("transitionDuration");
    panel.style[transition] = clear ? null : `${duration}ms`;
  }

  generateIDs(element) {
    const { triggerClass, panelClass } = this.options;
    const trigger = element.querySelector(this.cn(triggerClass));
    const panel = element.querySelector(this.cn(panelClass));

    element.setAttribute("id", element.id || `ac-${uniqueId}`);
    trigger.setAttribute("id", trigger.id || `ac-trigger-${uniqueId}`);
    panel.setAttribute("id", panel.id || `ac-panel-${uniqueId}`);
    uniqueId++;
  }

  setARIA(element) {
    const { ariaEnabled, triggerClass, panelClass } = this.options;
    if (!ariaEnabled) return;

    const trigger = element.querySelector(this.cn(triggerClass));
    const panel = element.querySelector(this.cn(panelClass));

    trigger.setAttribute("role", "button");
    trigger.setAttribute("aria-controls", panel.id);
    trigger.setAttribute("aria-disabled", false);
    trigger.setAttribute("aria-expanded", false);
    panel.setAttribute("role", "region");
    panel.setAttribute("aria-labelledby", trigger.id);
  }

  showElement(element, calcHeight = true) {
    const { panelClass, activeClass, collapse, beforeOpen } = this.options;
    if (calcHeight) beforeOpen(element);

    const panel = element.querySelector(this.cn(panelClass));
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
    const panel = element.querySelector(this.cn(panelClass));
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

  updateARIA(element, { ariaExpanded, ariaDisabled }) {
    const { ariaEnabled, triggerClass } = this.options;
    if (!ariaEnabled) return;

    const trigger = element.querySelector(this.cn(triggerClass));
    trigger.setAttribute("aria-expanded", ariaExpanded);
    trigger.setAttribute("aria-disabled", ariaDisabled);
  }

  attachEvents() {
    if (this.eventsAttached) return;
    const { triggerClass, panelClass } = this.options;

    this.elements.forEach((element) => {
      const trigger = element.querySelector(this.cn(triggerClass));
      const panel = element.querySelector(this.cn(panelClass));

      trigger.addEventListener("click", (e) => this.handleClick(e, element));
      trigger.addEventListener("keydown", (e) => this.handleKeydown(e, element));
      panel.addEventListener("transitionend", (e) => this.handleTransitionEnd(e, element));
    });

    this.eventsAttached = true;
  }

  handleClick(e, element) {
    if (e.target.nodeName !== "A") {
      this.toggleElement(element);
    }
  }

  handleKeydown(e, element) {
    // Handle keydown events for navigation
  }

  handleTransitionEnd(e, element) {
    const height = parseInt(e.currentTarget.style.height);
    if (height > 0) {
      e.currentTarget.style.height = "auto";
      this.options.onOpen(element);
    } else {
      this.options.onClose(element);
    }
  }

  toggleElement(element) {
    const { activeClass, collapse } = this.options;
    const isActive = element.classList.contains(activeClass);
    if (isActive && !collapse) return;

    if (!isActive) {
      this.elements.forEach((el) => {
        if (el !== element && el.classList.contains(activeClass)) {
          this.closeElement(el);
        }
      });
    }


    return isActive ? this.closeElement(element) : this.showElement(element);
  }

  cn(className) {
    return `.${CSS.escape(className)}`;
  }

  isWebkit(property) {
    if (typeof document.documentElement.style[property] === "string") {
      return property;
    }
    return `webkit${property.charAt(0).toUpperCase() + property.slice(1)}`;
  }

  // Additional methods (open, close, destroy, etc.) can be added here...
}

document.addEventListener('DOMContentLoaded', () => {
  // Initialize accordions from containers with data-accordion attribute
  // const accordionContainers = document.querySelectorAll('[data-accordion]');
  // accordionContainers.forEach((container) => {
  //   new Accordion(container, { openOnInit: [0] });
  // });

  // Initialize accordions with the class "accordion-services"
  document.querySelectorAll(".accordion-services").forEach((accordionElement) => {
    new Accordion(accordionElement, { openOnInit: [0] });

  });
});
