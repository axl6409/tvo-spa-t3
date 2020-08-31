<template>
  <table class="table post-table">
    <thead>
    <tr>
      <th scope="col">
        #
      </th>
      <th scope="col">
        Name
      </th>
      <th scope="col">
        Description
      </th>
      <th scope="col">
        Create At
      </th>
      <th scope="col">
        Actions
      </th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="category in categories" v-bind:key="category.id">
      <th scope="row">
        {{ category.id }}
      </th>
      <th>{{ category.name }}</th>
      <th>{{ category.description }}</th>
      <th>{{ category.created_at }}</th>
      <th>
        <i class="fas fa-times" />
        <button class="edit-button">
          <router-link :to="{ name: 'category.edit' }">
            <fa icon="edit" fixed-width />
          </router-link>
        </button>
        <button class="delete-button" @click="deleteCategory(category.id)">
          <fa icon="times" fixed-width />
        </button>
      </th>
    </tr>
    </tbody>
  </table>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {

    data () {
      return {
      }
    },

    computed: mapGetters({
      categories: 'categories/categories'
    }),

    beforeCreate () {
      this.$store.dispatch('categories/fetchCategories')
    },

    created () {
      this.$store.state
    },

    methods: {
      deleteCategory (id) {
        this.$store.dispatch('categories/deleteCategory', id)
      }
    }
  }
</script>
