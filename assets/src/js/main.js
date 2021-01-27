/*
    File: Main.js
    Plugin: Directorist - Business Directory Plugin
    Author: Aazztech
    Author URI: www.aazztech.com
*/
/* eslint-disable */

// Modules
import './modules/helpers';
import './modules/review';

// Components
import './../scss/layout/public/main-style.scss';
import './components/atbdSorting';
import './components/atbdAlert';
// import './components/pureScriptTab';
import './components/profileForm';
import './components/atbdModal';
import './components/gridResponsive';
import './components/formValidation';
import './components/atbdFavourite';
import './components/atbdTooltip';
import './components/login';
import './components/tab';
import './components/atbdDropdown';
import './components/atbdSelect';

// Dashboard Js
import './components/dashboard/dashboardImageUploader';
import './components/dashboard/dashboardSidebar';
import './components/dashboard/dashboardTab';
import './components/dashboard/dashBoardMoreBtn';
import './components/dashboard/dashboardPagination';
import './components/dashboard/dashboardSearch';
import './components/dashboard/dashboardListing';
import './components/dashboard/dashboardResponsive';
import './components/dashboard/dashboardAnnouncement';

;(function ($) {

    // Plasma Slider Initialization 
    var single_listing_slider = new PlasmaSlider({
        containerID: "single-listing-slider",
    });

    single_listing_slider.init();

})(jQuery);

// Booking Available Time

const flatWrapper = document.querySelector(".flatpickr-calendar");
const fAvailableTime = document.querySelector(".bdb-available-time-wrapper");

if (flatWrapper != null && fAvailableTime != null) {
    flatWrapper.insertAdjacentElement("beforeend", fAvailableTime);
}