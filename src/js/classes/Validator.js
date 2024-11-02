import Entities from './shared/Entities';
import { each, mapEach } from '../helpers/array';
import { setAttr } from '../helpers/dom';

export const REGEX_EMAIL = /^([\w\-_]+\.)*[\w\-_]+@([\w\-_]+\.)+[\w\-_]{2,}$/;

export default class Validator {
  constructor() {
    this.entities = new Entities(
      'Validator',
      '[data-validator]',
      Validator.initSingle,
      Validator.destroySingle,
    );
  }

  static initSingle(containerEl) {
    if (containerEl.tagName.toUpperCase() !== 'FORM') return;
    const formEl = containerEl;

    const fieldsArr = formEl.querySelectorAll('[data-validator-field]');
    const fieldObjsArr = mapEach(fieldsArr, (fieldEl) => {
      const { id } = fieldEl;
      const rules = JSON.parse(fieldEl.getAttribute('data-validator-field') ?? '[]');
      const errorEl = containerEl.querySelector(`[data-validator-error="${id}"]`);
      const errorMsgEl = errorEl.querySelector('[data-validator-error-message]');

      return {
        id,
        fieldEl,
        rules,
        errorEl,
        errorMsgEl,
        touched: false,
      };
    });

    function onSubmit(e) {
      if (Validator.validateAllFields(fieldObjsArr)) return;

      e.preventDefault();
      console.warn('Form validation error');
    }

    function onInput(e) {
      const target = e.currentTarget;
      const fieldObj = fieldObjsArr.find(tmpObj => tmpObj.fieldEl === target);
      if (fieldObj === undefined || !fieldObj.touched) return;

      Validator.validateField(fieldObj);
    }

    // bind events

    formEl.addEventListener('submit', onSubmit);

    each(fieldObjsArr, (fieldObj) => {
      fieldObj.fieldEl.addEventListener('input', onInput);
    });

    function destroy() {
      formEl.removeEventListener('submit', onSubmit);

      each(fieldObjsArr, (fieldObj) => {
        fieldObj.fieldEl.removeEventListener('input', onInput);
      });
    }

    return {
      destroy,
    };
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }

  static validateAllFields(fieldObjsArr) {
    const errors = [];
    each(fieldObjsArr, (fieldObj) => {
      fieldObj.touched = true;

      if (Validator.validateField(fieldObj)) return true;

      errors.push(fieldObj.id);
    });

    return (errors.length === 0);
  }

  static validateField(fieldObj) {
    const { value } = fieldObj.fieldEl;

    const errors = [];
    each(fieldObj.rules, (rule) => {
      if (Validator.validateByRule(value, rule)) return true;

      errors.push(rule.msg);
      return false; // stop checking after first error
    });

    Validator.setFieldError(fieldObj, errors);

    return (errors.length === 0);
  }

  static validateByRule(value, rule) {
    switch (rule.type) {
      case 'email':
        return REGEX_EMAIL.test(value);

      // case 'regex':
      //   return (new RegExp(rule.val)).test(value);

      default:
        return true;
    }
  }

  static setFieldError(fieldObj, errors = []) {
    const [error] = errors;
    const isError = error !== undefined;

    setAttr(fieldObj.fieldEl, 'data-invalid', isError ? '' : null);
    setAttr(fieldObj.fieldEl, 'aria-invalid', isError ? error : null);

    fieldObj.errorMsgEl.innerText = isError ? error : '';
    setAttr(fieldObj.errorEl, 'data-active', isError ? '' : null);
  }
}
