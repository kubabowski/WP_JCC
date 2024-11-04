
import LiteEvents from './LiteEvents';
import MobileMenu from './MobileMenu';
// import BasicSlider from './BasicSlider';
import HomeServicesSwiper from './HomeServicesSwiper';
import Test from './shared/test';
import HeaderScroll from './shared/HeaderScroll';
import HeroHomeSwiper from './HomeBannerSwiper';
import HeroHomeControl from './HeroSwiperControl';

export default class Core {
  constructor() {
    new LiteEvents();
    new MobileMenu(); 
    new HeaderScroll(); 
    // new BasicSlider();
 
    new Test();

    new HeroHomeSwiper();
    new HomeServicesSwiper();
    new HeroHomeControl();


   
  }
}






// import { trigger } from '../helpers/event';

// import HomeServicesSwiper from './HomeServicesSwiper';
// import { Test } from './shared/test';


// import LiteEvents from './LiteEvents';
// import Calendar from "./Calendar";
// // import LockScroll from './LockScroll';
// import Viewport from './Viewport';
// import ScrollTo from './ScrollTo';
// // import Header from './Header';
// import HeaderSearch from './HeaderSearch';
// import MobileMenu from './MobileMenu';
// // import Drawer from './Drawer';
// // import Toggle from './Toggle';
// import Tabs from './Tabs';
// // import Accordion from './Accordion';
// // import InputLabel from './InputLabel';
// // import CustomScroll from './CustomScroll';
// // import CustomSelect from './CustomSelect';
// // import HeaderCollision from './HeaderCollision';
// // import RequiredFields from './RequiredFields';
// import VideoPoster from './VideoPoster';
// // import HeroBanner from './HeroBanner';
// // import TextGapImageSlider from './TextGapImageSlider';
// // import PuffTabs from './PuffTabs';
// // import PuffNestedSlider from './PuffNestedSlider';
// import BasicSlider from './BasicSlider';
// import ScrollAnim from './ScrollAnim';
// import Validator from './Validator';
// import TooltipArea from './TooltipArea';
// // import Analytics from './Analytics';
// // import ImagePreview from './ImagePreview';
// // import ImagePreviewPopup from './ImagePreviewPopup';
// // import Popup from './Popup';
// // import VideoPopup from './VideoPopup';
// import LogoAutoSlider from './LogoAutoSlider';
// import ProductsFilters from './ProductsFilters';

// export default class Core {
//   constructor() {
//     window.triggerEvent = trigger;

//     new Test();

//     new HomeServicesSwiper();
//     new Calendar();
//     new LiteEvents();
//     // new LockScroll();
//     new Viewport();
//     new ScrollTo();
//     // new Header();
//     new HeaderSearch();
//     new MobileMenu();
//     // new Drawer();
//     // new Toggle();
//     new Tabs();
//     // new Accordion();
//     // new InputLabel();
//     // new CustomScroll();
//     // new CustomSelect();
//     // new HeaderCollision();
//     // new RequiredFields();;
//     new VideoPoster();
//     // new HeroBanner();
//     // new TextGapImageSlider();
//     // new PuffTabs();
//     // new PuffNestedSlider();
//     new BasicSlider();
//     new ScrollAnim();
//     new Validator();
//     new TooltipArea();
//     // new Analytics();
//     // new Popup();
//     // new VideoPopup();
//     // new ImagePreview();
//     // new ImagePreviewPopup();
//     new LogoAutoSlider();
//     new ProductsFilters();
//   }
// }
