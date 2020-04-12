window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Bootstrap
 */
Vue.component('v-button-group', require('./components/bootstrap/VButtonGroup').default);
Vue.component('v-button', require('./components/bootstrap/VButton').default);
Vue.component('v-dropdown', require('./components/bootstrap/VDropdown').default);
Vue.component('v-dropdown-group', require('./components/bootstrap/VDropdownGroup').default);
Vue.component('v-dropdown-item', require('./components/bootstrap/VDropdownItem').default);
Vue.component('v-dropdown-modal', require('./components/bootstrap/VDropdownModal').default);

/**
 * Player
 */
Vue.component('course-player', require('./components/CoursePlayer.vue').default);
Vue.component('job-status', require('./components/JobStatus.vue').default);

/**
 * Icons
 */
Vue.component('icon-plus', require('./components/icons/IconPlus').default);
Vue.component('icon-edit', require('./components/icons/IconEdit').default);
Vue.component('icon-delete', require('./components/icons/IconDelete').default);
Vue.component('icon-trash-empty', require('./components/icons/IconTrashEmpty').default);
Vue.component('icon-trash', require('./components/icons/IconTrash').default);
Vue.component('icon-more-vertical', require('./components/icons/IconMoreVertical').default);
Vue.component('icon-chevron-left', require('./components/icons/IconChevronLeft').default);
Vue.component('icon-chevron-right', require('./components/icons/IconChevronRight').default);
Vue.component('icon-download', require('./components/icons/IconDownload').default);
Vue.component('icon-play', require('./components/icons/IconPlay').default);
Vue.component('icon-upload', require('./components/icons/IconUpload').default);
Vue.component('icon-volume', require('./components/icons/IconVolume').default);
Vue.component('icon-refresh', require('./components/icons/IconRefresh').default);
Vue.component('icon-archive', require('./components/icons/IconArchive').default);
Vue.component('icon-users', require('./components/icons/IconUsers').default);
Vue.component('icon-globe', require('./components/icons/IconGlobe').default);
Vue.component('icon-activity', require('./components/icons/IconActivity').default);
Vue.component('icon-book', require('./components/icons/IconBook').default);
Vue.component('icon-book-open', require('./components/icons/IconBookOpen').default);
Vue.component('icon-message-square', require('./components/icons/IconMessageSquare').default);
Vue.component('icon-list', require('./components/icons/IconList').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',
});
