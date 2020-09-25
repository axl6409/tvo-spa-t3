<template>
  <div class="admin-users-index">
    <usersList></usersList>
    <rolesList></rolesList>
  </div>
</template>

<script>

import { mapState } from 'vuex'
import UsersList from '../../../../components/lists/UsersList'
import RolesList from '../../../../components/lists/RolesList'

export default {

  components: {
    UsersList,
    RolesList
  },

  data () {
    return {

    }
  },

  computed: mapState({
    users: state => state.users.all
  }),

  created () {
    this.$store.dispatch('users/fetchUsers')
  },

  methods: {
  }

}
</script>
