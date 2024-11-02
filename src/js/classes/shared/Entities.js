import { each } from '../../helpers/array';

export default class Entities {
  /**
   * Entities constructor
   * @param {String} name name of the entities set - events prefix
   * @param {String} selector single element selector
   * @param {Function} creator single object creator function
   * @param {Function} cleaner single object cleaner function
   * @param {Object} options additional options
   */
  constructor(
    name,
    selector,
    creator = () => ({}),
    cleaner = () => {},
    {
      filter = () => true,
    } = {},
  ) {
    this.name = name;
    this.selector = selector;

    this.creator = creator;
    this.cleaner = cleaner;

    this.filter = filter;

    this.entitiesArr = [];
    this.createNew();

    this.bindEvents();
  }

  createNew(prevEntitiesArr = []) {
    const rawElementsArr = document.querySelectorAll(this.selector);
    if (rawElementsArr.length <= 0) return prevEntitiesArr;

    const elementsArr = Array.prototype.filter.call(rawElementsArr, this.filter);

    this.entitiesArr = [];
    each(elementsArr, (element) => {
      const prevEntity = prevEntitiesArr.find(entity => entity.element === element);
      if (prevEntity !== undefined) {
        this.entitiesArr.push(prevEntity);
        return true;
      }

      this.entitiesArr.push({
        element,
        entityObj: this.creator(element),
      });
    });

    return this.entitiesArr;
  }

  destroyAll() {
    each(this.entitiesArr, (entity) => {
      this.cleaner(entity);
      entity.entityObj = null;
    });
    this.entitiesArr = [];
  }

  bindEvents() {
    this.onCreateNewEvent = this.onCreateNew.bind(this);
    // window.addEventListener(`${this.name}CreateNew`, this.onCreateNewEvent);
    Entities.bindEvent('EntitiesCreateNew', this.name, this.onCreateNewEvent);

    this.onDestroyAllEvent = this.onDestroyAll.bind(this);
    // window.addEventListener(`${this.name}DestroyAll`, this.onDestroyAllEvent);
    Entities.bindEvent('EntitiesDestroyAll', this.name, this.onDestroyAllEvent);

    this.onRefreshEvent = this.onRefresh.bind(this);
    // window.addEventListener(`${this.name}Refresh`, this.onRefreshEvent);
    Entities.bindEvent('EntitiesRefresh', this.name, this.onRefreshEvent);
  }

  onCreateNew() {
    this.createNew(this.entitiesArr);
  }

  onDestroyAll() {
    this.destroyAll();
  }

  onRefresh() {
    this.refresh();
  }

  refresh() {
    this.destroyAll();
    this.createNew();
  }

  getEntityByEl(element) {
    return this.entitiesArr.find(entity => entity.element === element);
  }

  getAll() {
    return this.entitiesArr;
  }

  forEachEntity(callback) {
    each(this.entitiesArr, callback);
  }

  static eventsReady = false;

  static events = {
    // EntitiesCreateNew: {},
    // EntitiesDestroyAll: {},
    // EntitiesRefresh: {},
  };

  static bindGlobalEvents() {
    if (Entities.eventsReady) return;

    window.addEventListener('EntitiesCreateNew', Entities.onEntitiesEvent);
    window.addEventListener('EntitiesDestroyAll', Entities.onEntitiesEvent);
    window.addEventListener('EntitiesRefresh', Entities.onEntitiesEvent);

    Entities.eventsReady = true;
  }

  static bindEvent(eventName, name, handler) {
    if (Entities.events[eventName] === undefined) Entities.events[eventName] = {};

    Entities.events[eventName][name] = handler;
  }

  static unbindEvent(type, name) {
    if (Entities.events[type] === undefined) return;

    delete Entities.events[type][name];
  }

  static trigger(eventName, name, payload) {
    window.dispatchEvent(new CustomEvent(eventName, {
      detail: {
        name,
        payload,
      },
    }));
  }

  static onEntitiesEvent(e) {
    const eventName = e.type;

    const events = Entities.events[eventName];
    if (events === undefined) return;

    const { name } = e.detail;

    const handler = events[name];
    if (handler === undefined) return;

    handler(e);
  }
}

Entities.bindGlobalEvents();
