class HeaderScrollEntity {
    constructor(rootEl) {
      if (!this.setVars(rootEl)) return;
  
      this.init(); 
    }
  
    setVars(rootEl) {
      this.rootEl = rootEl;
      if (!this.rootEl) {
        return false;
      }
  
      return true;
    }
  
    init() {

      window.addEventListener("scroll", function () {
        const header = document.querySelector("header");
      
        if (window.scrollY > 60) {
          header.classList.add("scroll");
        } else {
          header.classList.remove("scroll");
        }
      });
      
      
    }
  }
  
  export default class HeaderScroll {
    constructor(rootEl) {
        const rootElement = document.querySelector('header');
      this.header = new HeaderScrollEntity(rootElement); 
    }
  
    static initSingle(element) {
      return new HeaderScrollEntity(element);
    }
  }
  