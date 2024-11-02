import Entities from './shared/Entities';

import { each } from '../helpers/array';

export default class ProductsFilters {
  constructor() {
    this.entities = new Entities(
      'ProductsFilters',
      '[data-products-filters]',
      ProductsFilters.initSingle,
      ProductsFilters.destroySingle,
    );
  }

  static initSingle(containerEl) {
    const formEl = containerEl;
    const selectsArr = Array.from(formEl.querySelectorAll('[data-products-filters-select]'));

    // select
    function onSelectChange() {
      formEl.submit();
    }
    each(selectsArr, (selectEl) => {
      selectEl.addEventListener('change', onSelectChange);
    });

    function destroy() {
      each(selectsArr, (selectEl) => {
        selectEl.removeEventListener('change', onSelectChange);
      });
    }

    return {
      destroy,
    };
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
