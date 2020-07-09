function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },
  { path: '/about', name: 'about', component: page('about.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/dashboard', name: 'dashboard', component: page('frontend/profile/dashboard.vue') },
  { path: '/character', name: 'character', component: page('frontend/profile/character.vue') },

  // Admin Pages
  { path: '/admin', name: 'admin', component: page('backend/admin/index.vue') },

  { path: '*', component: page('errors/404.vue') }
]
