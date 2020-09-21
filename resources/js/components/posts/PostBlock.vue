<template>
  <div>
    <div class="hexagon" :class="post.slug" v-bind:style="{ backgroundImage: 'url(' + path + post.image + ')' }"
         @mouseenter="startAnimation(post.slug)"
         @mouseleave="stopAnimation(post.slug)"
    >
      <h2 class="post-block-title">
        {{ post.title }}
      </h2>
      <div class="hexTop" />
      <div class="hexBottom" />
    </div>
  </div>
</template>

<script>

import anime from 'animejs'

export default {

  props: ['post'],

  data () {
    return {
      path: 'images/post/thumbnail/'
    }
  },

  mounted () {

  },

  methods: {
    startAnimation (element) {
      var hexagon = document.getElementsByClassName(element)
      console.log('Start')
      anime({
        targets: hexagon,
        rotate: [0, 10],
        scale: [1, 1.1]
      })
    },

    stopAnimation (element) {
      var hexagon = document.getElementsByClassName(element)
      console.log('Stop')
      anime({
        targets: hexagon,
        rotate: [10, 0],
        scale: [1.1, 1]
      })
    }
  }

}
</script>
