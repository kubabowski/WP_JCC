class TestEntity {
    constructor(rootEl) {
      if (!this.setVars(rootEl)) return;
  
      this.consoleTest(); 
    }
  
    setVars(rootEl) {
      this.rootEl = rootEl;
      if (!this.rootEl) {
        return false;
      }
  
      return true;
    }
  
    consoleTest() {
      console.log('TestEntity initialized for element:', this.rootEl);
    }
  }
  
  export default class Test {
    constructor(rootEl) {
        const rootElement = document.querySelector('#my-element');
      this.test = new TestEntity(rootElement); 
    }
  
    static initSingle(element) {
      return new TestEntity(element);
    }
  }
  