import Entities from './shared/Entities';
import { each } from '../helpers/array';
// import { setAttr } from '../helpers/dom';

// const DEBUG = true;
const REGEX_EMAIL = /\S+@\S+\.\S+/;
const REGEX_TEL = /^\+?[0-9]*$/;

export default class RequiredFields {
  constructor() {
    this.entities = new Entities(
      'RequiredFields',
      '[data-required-fields]',
      RequiredFields.initSingle,
    );
  }

  static initSingle(formEl) {
    // const msgSuccessEl = formEl.querySelector('[data-required-fields-message-success]');
    // const msgErrorEl = formEl.querySelector('[data-required-fields-message-error]');
    const valuesArr = Array.from(formEl.querySelectorAll('[data-required-fields-value]')); // input, textarea, select
    const checksArr = Array.from(formEl.querySelectorAll('[data-required-fields-check]')); // checkbox, radio

    const classes = {
      errorActive: 'input__error--active',
      // messageActive: 'interestForm__message--active',
    };

    const state = {};

    function checkState() {
    //   const someEmpty = Object.values(state).some(field => !field);
    //   console.log(someEmpty)
    //
    //   disabled = someEmpty;
    //   setAttr(submitEl, 'disabled', someEmpty ? 'disabled' : null);
    }

    function setState(name, isNotEmpty = false, skipCheck = false) {
      state[name] = isNotEmpty;

      if (skipCheck) return;

      checkState();
    }

    function checkRuleError(value, { type, error }) {
      switch (type) {
        case 'required': {
          if (value.trim() === '') return error;
          break;
        }

        case 'email': {
          if (!REGEX_EMAIL.test(value)) return error;
          break;
        }

        case 'tel': {
          if (!REGEX_TEL.test(value)) return error;
          break;
        }

        default: break;
      }

      return null;
    }

    function validateValues(arr) {
      return arr.map((fieldEl) => {
        const { value } = fieldEl;

        const errorEl = fieldEl.parentElement.querySelector(
          '.input__error, .textarea__error, .select__error',
        );
        const parentEl = fieldEl.parentElement;

        const rules = JSON.parse(fieldEl.getAttribute('data-required-fields-value') || '[]');

        const l = rules.length;
        for (let i = 0; i < l; i++) {
          const rule = rules[i];

          const error = checkRuleError(value, rule);
          if (error !== null) {
            parentEl.classList.add('error');

            errorEl.textContent = error;
            errorEl.classList.add(classes.errorActive);

            return {
              field: fieldEl,
              valid: false,
            };
          }
        }

        parentEl.classList.remove('error');

        errorEl.classList.remove(classes.errorActive);
        errorEl.textContent = '';

        return {
          field: fieldEl,
          valid: true,
        };
      });
    }

    function validateChecks(arr) {
      return arr.map((elem) => {
        const parentEl = elem.closest('.checkbox, .radio');

        if (elem.checked) {
          parentEl.classList.remove('error');
          return { elem, valid: true };
        } else {
          parentEl.classList.add('error');
          return { elem, valid: false };
        }
      });
    }

    function isValidated(arr) {
      return arr.every(element => element.valid === true);
    }

    function onSubmit(e) {
      e.preventDefault();
      const valuesOk = isValidated(validateValues(valuesArr));
      const checksOk = isValidated(validateChecks(checksArr));

      if (valuesOk && checksOk) {
        e.target.submit();
      }

      // if (DEBUG) {
      //   if (valuesOk && checksOk) {
      //     if (msgSuccessEl) msgSuccessEl.classList.add(classes.messageActive);
      //     if (msgErrorEl) msgErrorEl.classList.remove(classes.messageActive);
      //   } else {
      //     if (msgSuccessEl) msgSuccessEl.classList.remove(classes.messageActive);
      //     if (msgErrorEl) msgErrorEl.classList.add(classes.messageActive);
      //   }
      // }
    }

    function setValueState(el, skipCheck = false) {
      setState(el.name, el.value !== '', skipCheck);
    }

    function setCheckState(el, skipCheck = false) {
      setState(el.name, (el.value !== '' && el.checked), skipCheck);
    }

    function onValueChange(e) {
      setValueState(e.target);
    }

    function onCheckChange(e) {
      setCheckState(e.target);
    }

    each(valuesArr, (valueEl) => {
      setValueState(valueEl, true);

      valueEl.addEventListener('change', onValueChange);
      valueEl.addEventListener('input', onValueChange);
    });

    each(checksArr, (checkEl) => {
      setCheckState(checkEl, true);

      checkEl.addEventListener('change', onCheckChange);
    });

    formEl.addEventListener('submit', onSubmit);

    checkState();
  }
}
