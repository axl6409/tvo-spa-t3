import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/free-regular-svg-icons'

import {
  faUser, faLock, faSignOutAlt, faCog, faTimes, faPaperPlane, faEdit, faArrowAltCircleDown, faArrowAltCircleUp, faEye
} from '@fortawesome/free-solid-svg-icons'

import {
  faGithub, faDiscord
} from '@fortawesome/free-brands-svg-icons'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faTimes, faPaperPlane, faEdit, faGithub, faArrowAltCircleDown, faArrowAltCircleUp, faEye, faDiscord
)

Vue.component('fa', FontAwesomeIcon)
