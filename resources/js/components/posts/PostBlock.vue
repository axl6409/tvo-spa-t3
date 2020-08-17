<template>
  <div>
    <h2 class="post-block-title">{{ post.title }}</h2>
    <img class="post-block-image" :src="path + post.image" alt="">
  </div>
</template>

<script>
  export default {

    props: ['post'],

    data () {
      return {
        path: 'images/post/thumbnail/'
      }
    },

    mounted () {
      console.log(process.env.MIX_APP_URL)
    }

  }
</script>
