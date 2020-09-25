import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].role_id !== 1) {
    next({ name: 'login' })
  } else {
    next()
  }
}
