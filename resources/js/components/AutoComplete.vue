<template>
  <div>
    <vue-tags-input
      v-model="tag"
      :tags="tags"
      :autocomplete-items="autocompleteItems"
      :add-only-from-autocomplete="false"
      @tags-changed="update"
    />
  </div>
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input'
import axios from 'axios'

export default {

  components: {
    VueTagsInput
  },

  data () {
    return {
      tag: '',
      tags: [],
      autocompleteItems: [],
      debounce: null
    }
  },

  watch: {
    'tag': 'initItems'
  },

  methods: {
    update (newTags) {
      this.autocompleteItems = []
      this.tags = newTags
    },
    initItems () {
      if (this.tag.length < 2) return
      clearTimeout(this.debounce)
      this.debounce = setTimeout(() => {
        axios.get('/api/tags/all').then(response => {
          console.log(response.data)
          this.autocompleteItems = response.data.map(a => {
            return { text: a.name }
          })
        }).catch(() => console.warn('Oh. Something went wrong'))
      }, 600)
    }
  }
}
</script>
