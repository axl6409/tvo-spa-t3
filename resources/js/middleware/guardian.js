import store from '~/store'

export default (to, from, next) => {
  if (store.getters['auth/user'].role_id !== 3) {
    next({ name: 'login' })
  } else {
    next()
  }
}
