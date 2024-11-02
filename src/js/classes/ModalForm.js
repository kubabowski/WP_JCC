export default class ModalForm {
  constructor() {
    if (document.querySelector("[data-modal-form]")) {
      this.init();
    }
  }

  init() {
    this.modal = document.querySelector("[data-modal-form]");
    this.backdrop = this.modal.querySelector("[data-modal-backdrop]");
    this.btnClose = this.modal.querySelector("[data-modal-form-close]");
    this.subjectInput = this.modal.querySelector('input[name="subject"]');
    this.dateInput = this.modal.querySelector('input[name="date"]');
    this.eventName = this.modal.querySelector(".name-event");
    this.descElement = this.modal.querySelector(".desc-event");

    this.checkEvents();
  }

  open() {
    this.modal.classList.add("open");
    document.body.classList.add("overflow-hidden");
  }

  close() {
    this.modal.classList.remove("open");
    document.body.classList.remove("overflow-hidden");
  }

  checkEvents() {
    this.btnClose.addEventListener("click", () => {
      this.close();
    });

    this.backdrop.addEventListener("click", () => {
      this.close();
    });
  }

  updateEventDetails(title, date, desc) {
    if (this.subjectInput) {
      this.subjectInput.value = title;
    }

    if (this.dateInput) {
      this.dateInput.value = date;
    }

    if (this.eventName) {
      this.eventName.textContent = `${title} - ${date}`;
    }

    if (this.descElement) {
      this.descElement.innerHTML = desc;
    }
  }
}
