// window.Vue = require('vue');
import Vue from 'vue'

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
import VButtonGroup from './components/bootstrap/VButtonGroup'
import VButton from "./components/bootstrap/VButton";
import VButtonModal from "./components/bootstrap/VButtonModal";
import VDropdown from "./components/bootstrap/VDropdown";
import VDropdownGroup from "./components/bootstrap/VDropdownGroup";
import VDropdownItem from "./components/bootstrap/VDropdownItem";
import VDropdownModal from "./components/bootstrap/VDropdownModal";

/**
 * Player
 */
import CoursePlayer from "./components/CoursePlayer";

/**
 * Jobs
 */
import JobStatus from "./components/JobStatus";

/**
 * Icons
 */
import IconPlus from "./components/icons/IconPlus";
import IconEdit from "./components/icons/IconEdit";
import IconDelete from "./components/icons/IconDelete";
import IconTrashEmpty from "./components/icons/IconTrashEmpty";
import IconTrash from "./components/icons/IconTrash";
import IconMoreVertical from "./components/icons/IconMoreVertical";
import IconChevronLeft from "./components/icons/IconChevronLeft";
import IconChevronRight from "./components/icons/IconChevronRight";
import IconDownload from "./components/icons/IconDownload";
import IconPlay from "./components/icons/IconPlay";
import IconUpload from "./components/icons/IconUpload";
import IconVolume from "./components/icons/IconVolume";
import IconRefresh from "./components/icons/IconRefresh";
import IconArchive from "./components/icons/IconArchive";
import IconUsers from "./components/icons/IconUsers";
import IconGlobe from "./components/icons/IconGlobe";
import IconActivity from "./components/icons/IconActivity";
import IconBook from "./components/icons/IconBook";
import IconBookOpen from "./components/icons/IconBookOpen";
import IconMessageSquare from "./components/icons/IconMessageSquare";
import IconList from "./components/icons/IconList";
import IconLogOut from "./components/icons/IconLogOut";
import IconDownloadCloud from "./components/icons/IconDownloadCloud";
import IconUploadCloud from "./components/icons/IconUploadCloud";
import IconRadio from "./components/icons/IconRadio";

/**
 * Development
 */
import Splitter from "./components/Splitter";


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',
    mounted() {
        let input = document.querySelector('[autofocus]');
        if (input) {
            input.focus()
        }
    },
    components: {
        'v-button-group' : VButtonGroup,
        'v-button': VButton,
        'v-button-modal': VButtonModal,
        'v-dropdown': VDropdown,
        'v-dropdown-group': VDropdownGroup,
        'v-dropdown-item': VDropdownItem,
        'v-dropdown-modal': VDropdownModal,
        'course-player': CoursePlayer,
        'job-status': JobStatus,
        'icon-plus': IconPlus,
        'icon-edit': IconEdit,
        'icon-delete': IconDelete,
        'icon-trash-empty': IconTrashEmpty,
        'icon-trash': IconTrash,
        'icon-more-vertical': IconMoreVertical,
        'icon-chevron-left': IconChevronLeft,
        'icon-chevron-right': IconChevronRight,
        'icon-download': IconDownload,
        'icon-play': IconPlay,
        'icon-upload': IconUpload,
        'icon-volume': IconVolume,
        'icon-refresh': IconRefresh,
        'icon-archive': IconArchive,
        'icon-users': IconUsers,
        'icon-globe': IconGlobe,
        'icon-activity': IconActivity,
        'icon-book': IconBook,
        'icon-book-open': IconBookOpen,
        'icon-message-square': IconMessageSquare,
        'icon-list': IconList,
        'icon-log-out': IconLogOut,
        'icon-download-cloud': IconDownloadCloud,
        'icon-upload-cloud': IconUploadCloud,
        'icon-radio': IconRadio,
        'splitter': Splitter,
    }
});
