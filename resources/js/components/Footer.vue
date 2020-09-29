<template>
  <div class="main-footer">
    <div class="footer-block-left">
      <router-link :to="{ name: 'welcome' }" class="navbar-brand navbar-title">
        TVO
      </router-link>
    </div>
    <div class="footer-block-center">
      <ul>
        <li>Nous rejoindre</li>
        <li>
          <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
            {{ $t('login') }}
          </router-link>
        </li>
        <li>
          <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
            {{ $t('register') }}
          </router-link>
        </li>
        <li>
          <a href="https://www.bungie.net/">Bungie</a>
        </li>
      </ul>
    </div>
    <div class="footer-block-right">
      <p>@Copyright:</p>
      <p>Site conçu par :<a href="https://www.vector-web.fr/">Vector Web</a></p>
    </div>
  </div>
</template>

<script>
export default {

}
</script>
