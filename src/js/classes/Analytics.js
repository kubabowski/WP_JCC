import Entities from './shared/Entities';

const EVENTS = {
  NAV_BAR: 'nav_bar',
  BUTTON_CLICK: 'button_click',
  FOLLOW_US: 'follow_us',
  BOOK_YOUR_STAY: 'book_your_stay',
  MEDIA_KIT_DOWNLOAD: 'media_kit_download',
  VRS_DOWNLOADS: 'vrs_downloads',
  NEWSLETTER_SUBSCRIPTION: 'newsletter_subscription',
  FORM_SUBMIT: 'form_submit',
  VIDEO_VIEWS: 'video_views',
};

const WATCH_THRESHOLD = {
  START: 0,
  QUARTER: 25,
  HALF: 50,
  THREE_QUARTERS: 75,
  END: 100,
};

export default class Analytics {
  constructor() {
    Analytics.setGlobals();

    this.entities = new Entities(
      'Analytics',
      '[data-ga]',
      Analytics.initSingle,
      Analytics.destroySingle,
    );
  }

  static setGlobals() {
    // eslint-disable-next-line camelcase
    window.redsea_globals = window.redsea_globals || {};
    window.redsea_globals.analytics = window.redsea_globals.analytics || {};
    window.redsea_globals.analytics.formSubmit = Analytics.formSubmit;
    window.redsea_globals.analytics.videoViews = Analytics.videoViews;
  }

  static initSingle(el) {
    const eventType = el.getAttribute('data-ga');

    switch (eventType) {
      case EVENTS.NAV_BAR:
        return Analytics.createClickEvent(el, {
          event: EVENTS.NAV_BAR,
          // eslint-disable-next-line camelcase
          page_path: Analytics.getPagePath(),
          language: Analytics.getLanguage(),
        });

      case EVENTS.BUTTON_CLICK:
        return Analytics.createClickEvent(el, {
          event: EVENTS.BUTTON_CLICK,
          // eslint-disable-next-line camelcase
          page_path: Analytics.getPagePath(),
          language: Analytics.getLanguage(),
        });

      case EVENTS.FOLLOW_US:
        return Analytics.createClickEvent(el, {
          event: EVENTS.FOLLOW_US,
          // eslint-disable-next-line camelcase
          page_path: Analytics.getPagePath(),
          // language: Analytics.getLanguage(),
        });

      case EVENTS.BOOK_YOUR_STAY:
        return Analytics.createClickEvent(el, {
          event: EVENTS.BOOK_YOUR_STAY,
          // eslint-disable-next-line camelcase
          // page_path: Analytics.getPagePath(),
          // language: Analytics.getLanguage(),
        });

      case EVENTS.MEDIA_KIT_DOWNLOAD:
        return Analytics.createClickEvent(el, {
          event: EVENTS.MEDIA_KIT_DOWNLOAD,
          // eslint-disable-next-line camelcase
          page_path: Analytics.getPagePath(),
          language: Analytics.getLanguage(),
        });

      case EVENTS.VRS_DOWNLOADS:
        return Analytics.createClickEvent(el, {
          event: EVENTS.VRS_DOWNLOADS,
          // eslint-disable-next-line camelcase
          page_path: Analytics.getPagePath(),
          language: Analytics.getLanguage(),
        });

      case EVENTS.NEWSLETTER_SUBSCRIPTION:
        return Analytics.createSubmitEvent(el, {
          event: EVENTS.NEWSLETTER_SUBSCRIPTION,
          // eslint-disable-next-line camelcase
          page_path: Analytics.getPagePath(),
          language: Analytics.getLanguage(),
        });

      case EVENTS.FORM_SUBMIT:
        return Analytics.createSubmitEvent(el, {
          event: EVENTS.FORM_SUBMIT,
          // eslint-disable-next-line camelcase
          page_path: Analytics.getPagePath(),
          language: Analytics.getLanguage(),
        });

      case EVENTS.VIDEO_VIEWS:
        return Analytics.createVideoEvent(el, {
          event: EVENTS.VIDEO_VIEWS,
          // eslint-disable-next-line camelcase
          // page_path: Analytics.getPagePath(),
          language: Analytics.getLanguage(),
        });

      default:
        return {
          destroy: () => {},
        };
    }
  }

  static createClickEvent(buttonEl, typeProps) {
    const staticProps = JSON.parse(buttonEl.getAttribute('data-ga-props') ?? '{}');

    function onClick() {
      Analytics.pushEvent({
        ...typeProps,
        ...staticProps,
      });
    }

    buttonEl.addEventListener('click', onClick);

    function destroy() {
      buttonEl.removeEventListener('click', onClick);
    }

    return {
      destroy,
    };
  }

  static createSubmitEvent(formEl, typeProps) {
    const staticProps = JSON.parse(formEl.getAttribute('data-ga-props') ?? '{}');

    function onSubmit(e) {
      const dynamicProps = e?.detail?.props ?? {};

      Analytics.pushEvent({
        ...typeProps,
        ...staticProps,
        ...dynamicProps,
      });
    }

    formEl.addEventListener('AnalyticsFormSubmit', onSubmit);
    // formEl.addEventListener('submit', onSubmit);

    function destroy() {
      formEl.removeEventListener('AnalyticsFormSubmit', onSubmit);
      // formEl.removeEventListener('submit', onSubmit);
    }

    return {
      destroy,
    };
  }

  static createVideoEvent(videoEl, typeProps) {
    const staticProps = JSON.parse(videoEl.getAttribute('data-ga-props') ?? '{}');

    let isStartComplete = false;
    let isQuarterComplete = false;
    let isHalfComplete = false;
    let isThreeQuartersComplete = false;

    function onTimeUpdate(e) {
      const percentageWatched = Analytics.getVideoPercent(e.target);

      // 0-25% watched
      if (
        !isStartComplete
        && percentageWatched > WATCH_THRESHOLD.START
      ) {
        isStartComplete = true;

        Analytics.pushEvent({
          ...typeProps,
          ...staticProps,
          // eslint-disable-next-line camelcase
          percent_watched: WATCH_THRESHOLD.START,
        });
      }

      // 25-50% watched
      if (
        !isQuarterComplete
        && percentageWatched >= WATCH_THRESHOLD.QUARTER
      ) {
        isQuarterComplete = true;

        Analytics.pushEvent({
          ...typeProps,
          ...staticProps,
          // eslint-disable-next-line camelcase
          percent_watched: WATCH_THRESHOLD.QUARTER,
        });
      }

      // 50-75% watched
      if (
        !isHalfComplete
        && percentageWatched >= WATCH_THRESHOLD.HALF
      ) {
        isHalfComplete = true;

        Analytics.pushEvent({
          ...typeProps,
          ...staticProps,
          // eslint-disable-next-line camelcase
          percent_watched: WATCH_THRESHOLD.HALF,
        });
      }

      // 75-100% watched
      if (
        !isThreeQuartersComplete
        && percentageWatched >= WATCH_THRESHOLD.THREE_QUARTERS
      ) {
        isThreeQuartersComplete = true;

        Analytics.pushEvent({
          ...typeProps,
          ...staticProps,
          // eslint-disable-next-line camelcase
          percent_watched: WATCH_THRESHOLD.THREE_QUARTERS,
        });
      }
    }

    function onEnded() {
      // reset complete flags
      isStartComplete = false;
      isQuarterComplete = false;
      isHalfComplete = false;
      isThreeQuartersComplete = false;
    }

    function onViews(e) {
      const percentageWatched = Analytics.getVideoPercent(e.currentTarget);

      const dynamicProps = {
        // eslint-disable-next-line camelcase
        percent_watched: percentageWatched,
      };

      Analytics.pushEvent({
        ...typeProps,
        ...staticProps,
        ...dynamicProps,
      });
    }

    videoEl.addEventListener('AnalyticsVideoViews', onViews);
    videoEl.addEventListener('timeupdate', onTimeUpdate);
    videoEl.addEventListener('ended', onEnded);
    // videoEl.addEventListener('ended', onViews);

    function destroy() {
      videoEl.removeEventListener('AnalyticsVideoViews', onViews);
      videoEl.removeEventListener('timeupdate', onTimeUpdate);
      videoEl.removeEventListener('ended', onEnded);
      // videoEl.removeEventListener('ended', onViews);
    }

    return {
      destroy,
    };
  }

  static getVideoPercent(videoEl) {
    return ((videoEl.currentTime ?? 0) / (videoEl.duration || 1)) * 100;
  }

  static getPagePath() {
    return window.location.pathname;
  }

  static getLanguage() {
    return window?.redsea_globals?.lang ?? 'English';
  }

  static pushEvent(eventProps) {
    if (window?.redsea_globals?.analytics?.debug === true) {
      console.log('Analytics event ', eventProps);
    } else {
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push(eventProps);
    }
  }

  static formSubmit(formEl, props = {}) {
    formEl.dispatchEvent(new CustomEvent('AnalyticsFormSubmit', {
      detail: { props },
    }));
  }

  static videoViews(videoEl, props = {}) {
    videoEl.dispatchEvent(new CustomEvent('AnalyticsVideoViews', {
      detail: { props },
    }));
  }

  static destroySingle({ entityObj }) {
    entityObj?.destroy();
  }
}
