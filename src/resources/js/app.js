// Import Common.js Common.css
import * as common from "../js/common";
import * as commonCss from "../css/common.css";

window.common = common;
window.commonCss = commonCss;

// Import App.css
import "../css/app.css";

// Import Bootstrap
import "./bootstrap";

// Import Alpine.js
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
