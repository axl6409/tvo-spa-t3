<template>
  <div class="main-footer">
    <div class="footer-block-left footer-site-title">
      <router-link :to="{ name: 'welcome' }" class="navbar-brand navbar-title">
        TVO
      </router-link>
    </div>
    <div class="footer-block-center footer-nav">
      <ul>
        <li class="nav-link footer-nav-link">Nous rejoindre</li>
        <li>
          <router-link :to="{ name: 'login' }" class="nav-link footer-nav-link" active-class="active">
            {{ $t('login') }}
          </router-link>
        </li>
        <li>
          <router-link :to="{ name: 'register' }" class="nav-link footer-nav-link" active-class="active">
            {{ $t('register') }}
          </router-link>
        </li>
        <li>
          <a href="https://www.bungie.net/" class="nav-link footer-nav-link">Bungie</a>
        </li>
      </ul>
    </div>
    <div class="footer-block-right footer-copyright">
      <p>@Copyright: Site conçu par :<a href="https://www.vectorweb.fr/" class="nav-link">Vector Web</a></p>
    </div>
  </div>
</template>

<script>
export default {

}
</script>
