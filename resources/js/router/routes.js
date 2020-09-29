function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [

  // Public Pages
  { path: '/', name: 'welcome', component: page('frontend/home.vue') },
  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/posts', name: 'posts', component: page('frontend/posts/index.vue') },
  { path: '/posts/single/:id', name: 'posts.single', component: page('frontend/posts/single.vue'), props: { default: true } },
  { path: '/about', name: 'about', component: page('frontend/about.vue') },

  // Log User Pages
  { path: '/profile', name: 'profile', component: page('settings/profile.vue') },
  { path: '/characters', name: 'characters', component: page('frontend/profile/characters.vue') },
  { path: '/character/:id', name: 'character', component: page('frontend/profile/character.vue'), props: { default: true } },

  // Admin Pages
  { path: '/admin', name: 'admin', component: page('backend/admin/index.vue') },
  { path: '/posts/create', name: 'posts.create', component: page('backend/admin/posts/create.vue') },
  { path: '/posts/edit/:id', name: 'posts.edit', component: page('backend/admin/posts/edit.vue'), props: { default: true } },
  { path: '/categories/create', name: 'categories.create', component: page('backend/admin/categories/create.vue') },
  { path: '/categories/edit/:id', name: 'categories.edit', component: page('backend/admin/categories/edit.vue'), props: { default: true } },
  { path: '/users', name: 'users', component: page('backend/admin/users/index.vue') },
  { path: '/user-view/:id', name: 'users.assign', component: page('backend/admin/users/view.vue'), props: { default: true } },

  { path: '*', component: page('errors/404.vue') }
]
