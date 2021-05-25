<template>
  <v-app>
    <Menu></Menu>
    <v-main>
      <router-view/>
    </v-main>
    <Snackbar></Snackbar>
  </v-app>
</template>

<script>
  import Menu from './components/Menu.vue'
  import Snackbar from './components/Snackbar.vue'

  export default {
    name: 'App',
    components: {
      Menu,
      Snackbar,
    },
    data: () => ({
      menuLateral: false,
    })
  };
</script>