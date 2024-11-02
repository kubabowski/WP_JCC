// import './vendors/polyfills/customEvents';
// import './vendors/polyfills/element/closest';

import Core from './classes/Core';
import { ready } from './helpers/ready';

// based on https://github.com/webpack/webpack/issues/7968#issuecomment-417639911
const url = new URL(document.currentScript.src);
const widgetLink = url.href.substring(0, url.href.indexOf('/public/dist') + 1);
__webpack_public_path__ = widgetLink; // eslint-disable-line


ready(() => new Core());
