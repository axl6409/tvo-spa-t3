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
      <tr v-for="(category) in categories" :key="category.id">
        <th scope="row">
          {{ category.id }}
        </th>
        <th>{{ category.name }}</th>
        <th>{{ category.description }}</th>
        <th>{{ category.created_at }}</th>
        <th>
          <i class="fas fa-times" />
          <button class="edit-button">
            <router-link :to="{ name: 'categories.edit', params: { id: category.id } }">
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
import { mapState } from 'vuex'

export default {

  data () {
    return {
    }
  },

  computed: mapState({
    categories: state => state.categories.category
  }),

  created () {
    this.$store.dispatch('categories/fetchCategories')
  },

  methods: {
    deleteCategory (id) {
      this.$store.dispatch('categories/deleteCategory', id)
    }
  }
}
</script>
