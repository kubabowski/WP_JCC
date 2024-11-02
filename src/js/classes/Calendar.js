import ModalForm from "./ModalForm";
export default class Calendar {
  constructor() {
    if (document.querySelector(".calendar")) {
      this.init();
      this.modalForm = new ModalForm();
    }
  }

  init() {
    this.abortController = null;
    this.calendar = document.querySelector(".calendar");
    this.company = this.calendar.querySelector("select#company");
    this.companyValue = this.company.value;
    this.topic = this.calendar.querySelector("select#topic");
    this.topicValue = this.topic.value;
    this.display = this.calendar.querySelector(".display");
    this.days = this.calendar.querySelector(".days");
    this.previous = this.calendar.querySelector(".left");
    this.next = this.calendar.querySelector(".right");
    this.sidebar = this.calendar.querySelector(".calendar-sidebar");

    this.date = new Date();
    this.year = this.date.getFullYear();
    this.month = this.date.getMonth();

    this.displayCalendar();
    this.addEventListeners();
    this.fetchEvents();
    this.checkActiveEvents();
  }

  fetchEvents() {
    if (this.abortController) {
      this.abortController.abort();
    }

    this.abortController = new AbortController();
    const { signal } = this.abortController;

    const data = {
      year: this.year,
      month: this.month + 1,
    };

    fetch("/wp-admin/admin-ajax.php", {
      method: "POST",
      dataType: "json",
      body: new URLSearchParams({
        action: "get_calendar_events",
        ...data,
      }),
      signal,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          this.displayEventDays(data.data);
        }
      })
      .catch((error) => {
        if (error.name === "AbortError") {
          console.log("Previous request was aborted.");
        } else {
          console.error("Error fetching events:", error);
        }
      });
  }

  displayEventDays(eventDates) {
    this.displayEventDaysOnCalendar(eventDates);
    this.displayListEvents(eventDates);
    this.checkActiveEvents();
  }

  checkActiveEvents() {
    const activeEvents = this.calendar.querySelectorAll(".active-event");

    activeEvents.forEach((eventDay) => {
      if (this.companyValue || this.topicValue) {
        eventDay.parentElement.classList.add("featured");
      } else {
        eventDay.parentElement.classList.remove("featured");
      }
      const topics = eventDay.dataset.topics.split(", ");
      const companies = eventDay.dataset.companies.split(", ");

      const matchesCompany =
        this.companyValue && companies.includes(this.companyValue);
      const matchesTopic = this.topicValue && topics.includes(this.topicValue);

      if (
        (this.companyValue ? matchesCompany : matchesTopic) &&
        (this.topicValue ? matchesTopic : matchesCompany)
      ) {
        eventDay.classList.add("highlight");
      } else {
        eventDay.classList.remove("highlight");
      }
    });
  }

  displayEventDaysOnCalendar(eventDates) {
    const dayElements = this.days.querySelectorAll("div");
    dayElements.forEach((day) => {
      const date = day.dataset.date;
      const eventsForDate = eventDates.filter((event) => event.date === date);

      if (eventsForDate.length > 0) {
        day.classList.add("event-date", "active-event");
        day.setAttribute("id", eventsForDate[0].ID);

        const topicSlugs = eventsForDate
          .flatMap((event) => event.topic.map((t) => t.slug))
          .join(", ");
        const companySlugs = eventsForDate
          .flatMap((event) => event.company.map((c) => c.slug))
          .join(", ");

        day.dataset.topics = topicSlugs;
        day.dataset.companies = companySlugs;

        day.addEventListener("click", () => {
          this.handleDayClick(day, eventsForDate);
        });
      }
    });
  }

  handleDayClick(dayElement, eventsForDate) {
    const isActive = dayElement.classList.contains("active");
    const eventsSidebar = this.sidebar.querySelectorAll(".event");

    const dayElements = this.days.querySelectorAll(".event-date");
    dayElements.forEach((day) => {
      day.classList.remove("active");
    });

    if (!isActive) {
      dayElement.classList.add("active");
    } else {
      dayElement.classList.remove("active");
      eventsSidebar.forEach((event) => {
        event.style.display = "";
        event.classList.remove("active");
      });
      return;
    }

    eventsSidebar.forEach((event) => {
      event.style.display = "none";
      event.classList.remove("active");
    });

    eventsForDate.forEach((event) => {
      const matchingEvent = this.sidebar.querySelector(
        `.event[data-id="${event.ID}"]`
      );
      if (matchingEvent) {
        matchingEvent.style.display = "";
        matchingEvent.classList.add("active");
      }
    });
  }

  displayListEvents(eventDates) {
    eventDates.forEach((event) => {
      const companyNames = event.company.map((c) => c.name).join(", ");

      const topicSlugs = event.topic.map((t) => t.slug).join(", ");
      const companySlugs = event.company.map((c) => c.slug).join(", ");
      const formattedDesc = event.desc
        ? event.desc.replace(/(\r\n|\n|\r)/g, "<br>")
        : "";

      const eventHTML = `<div class="event active-event py-16px border-b border-neutral-dark/70"
        data-topics="${topicSlugs}"   
        data-companies="${companySlugs}"
        data-id="${event.ID}"
        >
          <div class="flex items-center justify-between">
            <div class="flex flex-col">
              <p class="text-20px/1_6 text-neutral-dark font-medium">${
                event.title
              }</p>
              <span class="text-20px/1_6 text-neutral-dark/70">${
                companyNames ? companyNames : ""
              }</span>
            </div>
            <div class="flex flex-col items-end">
              <span class="text-right">&#8599;</span>
              <data class="text-18px/1_6 text-neutral-gray font-medium">${
                event.date ? event.date : ""
              }</data>
              
            </div>
          </div>
          ${formattedDesc ? `<p class="mt-12px">${formattedDesc}</p>` : ""}
        </div>`;

      const eventElement = document.createElement("div");
      eventElement.innerHTML = eventHTML;

      eventElement.querySelector(".event").addEventListener("click", () => {
        this.modalForm.open();
        this.modalForm.updateEventDetails(
          event.title,
          event.date,
          formattedDesc
        );
      });

      this.sidebar.appendChild(eventElement);
    });
  }
  clearListEvents() {
    this.sidebar.innerHTML = "";
  }

  displayCalendar() {
    const firstDay = new Date(this.year, this.month, 1);
    const lastDay = new Date(this.year, this.month + 1, 0);
    let firstDayIndex = (firstDay.getDay() + 6) % 7;
    const numberOfDays = lastDay.getDate();

    const month = this.date.toLocaleString("pl-PL", { month: "long" });
    const formattedMonth = month.charAt(0).toUpperCase() + month.slice(1);
    const year = this.year;

    this.display.innerHTML = `<span>${formattedMonth}</span> ${year}`;

    this.clearDays();
    this.addEmptyDays(firstDayIndex);
    this.addDays(numberOfDays);
  }

  clearDays() {
    this.days.innerHTML = "";
  }

  addEmptyDays(count) {
    for (let x = 0; x < count; x++) {
      const div = document.createElement("div");
      div.innerHTML = "";
      this.days.appendChild(div);
    }
  }

  addDays(numberOfDays) {
    for (let i = 1; i <= numberOfDays; i++) {
      let div = document.createElement("div");
      let currentDate = new Date(this.year, this.month, i);

      const day = String(currentDate.getDate()).padStart(2, "0");
      const month = String(currentDate.getMonth() + 1).padStart(2, "0");
      const year = currentDate.getFullYear();
      const formattedDate = `${day}.${month}.${year}`;

      div.dataset.date = formattedDate;

      div.innerHTML = i;
      this.days.appendChild(div);

      if (
        currentDate.getFullYear() === new Date().getFullYear() &&
        currentDate.getMonth() === new Date().getMonth() &&
        currentDate.getDate() === new Date().getDate()
      ) {
        div.classList.add("current-date");
      }
    }
  }

  changeMonth(increment) {
    if (increment < 0) {
      if (this.month <= 0) {
        this.month = 11;
        this.year -= 1;
      } else {
        this.month -= 1;
      }
    } else {
      if (this.month >= 11) {
        this.month = 0;
        this.year += 1;
      } else {
        this.month += 1;
      }
    }

    this.date.setMonth(this.month);
    this.displayCalendar();
    this.clearListEvents();
    this.fetchEvents();
  }

  addEventListeners() {
    this.previous.addEventListener("click", () => {
      this.changeMonth(-1);
    });

    this.next.addEventListener("click", () => {
      this.changeMonth(1);
    });

    this.company.addEventListener("change", () => {
      this.companyValue = this.company.value;
      this.checkActiveEvents();
    });

    this.topic.addEventListener("change", () => {
      this.topicValue = this.topic.value;
      this.checkActiveEvents();
    });
  }
}
