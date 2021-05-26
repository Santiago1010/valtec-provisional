<template>
  <div>

    <v-app-bar dark color="oscuro" style="max-height: 60px; position: relative; z-index: 2;">
      <v-app-bar-nav-icon @click="sideMenu = true"></v-app-bar-nav-icon>
      <router-link to='/'><v-toolbar-title><v-img :src="logo" style="max-height: 50px; max-width: 22%"></v-img></v-toolbar-title></router-link>
      <v-spacer></v-spacer>
      <v-img :src="sena" style="max-height: 50px; max-width: 2.5%;"></v-img>
    </v-app-bar>

    <v-navigation-drawer color="oscuro" dark app v-model="sideMenu" absolute temporary>

      <v-list nav dense>
        <v-list-item-group active-class="orange accent-4--text text--accent-4">

          <div v-if="session == false">
            <v-list-item to='/'>
              <v-list-item-icon><v-icon>mdi-home</v-icon></v-list-item-icon>
              <v-list-item-title>Inicio</v-list-item-title>
            </v-list-item>

            <v-list-item @click="openCloseDialog(true)">
              <v-list-item-icon><v-icon>login</v-icon></v-list-item-icon>
              <v-list-item-title>Iniciar sesión</v-list-item-title>
            </v-list-item>

            <v-list-item to='/registro'>
              <v-list-item-icon><v-icon>create</v-icon></v-list-item-icon>
              <v-list-item-title>Registrarse</v-list-item-title>
            </v-list-item>

            <v-list-item to='/contrasena'>
              <v-list-item-icon><v-icon>vpn_key</v-icon></v-list-item-icon>
              <v-list-item-title>Recuperar contraseña</v-list-item-title>
            </v-list-item>

            <!--<v-list-item to='/estadisticas'>
              <v-list-item-icon><v-icon>analytics</v-icon></v-list-item-icon>
              <v-list-item-title>Estadísticas</v-list-item-title>
            </v-list-item>-->

            <v-divider></v-divider>

            <v-list-item @click="sideMenu = false">
              <v-list-item-icon><v-icon>cancel</v-icon></v-list-item-icon>
              <v-list-item-title>Cerrar</v-list-item-title>
            </v-list-item>
          </div>
          <div v-else>
            <v-list-item to='/'>
              <v-list-item-icon><v-icon>not_started</v-icon></v-list-item-icon>
              <v-list-item-title>Inicio</v-list-item-title>
            </v-list-item>

            <v-list-item to='/inicio'>
              <v-list-item-icon><v-icon>login</v-icon></v-list-item-icon>
              <v-list-item-title>Iniciar sesión</v-list-item-title>
            </v-list-item>

            <v-list-item to='/inicio/resultados'>
              <v-list-item-icon><v-icon>dns</v-icon></v-list-item-icon>
              <v-list-item-title>Resultados de investigación</v-list-item-title>
            </v-list-item>

            <v-list-item to='/inicio/nuevoResultado'>
              <v-list-item-icon><v-icon>group_work</v-icon></v-list-item-icon>
              <v-list-item-title>Registrar resultado de investigación contraseña</v-list-item-title>
            </v-list-item>

          <v-list-item to='/inicio/usuario'>
            <v-list-item-icon><v-icon>account_circle</v-icon></v-list-item-icon>
            <v-list-item-title>Información de usuario</v-list-item-title>
          </v-list-item>

            <v-divider></v-divider>

            <v-list-item @click="closeSession">
              <v-list-item-icon><v-icon>cancel</v-icon></v-list-item-icon>
              <v-list-item-title>Cerrar sesión</v-list-item-title>
            </v-list-item>
            
          </div>

        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <FormLogin></FormLogin>
  </div>
</template>

<script>
  import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'
  import logo from '../assets/imagenes/logos/isologo.png'
  import sena from '../assets/imagenes/logos/sena.png'

  import FormLogin from './FormLogin.vue'

  export default {

    name: 'MenuIndex',
    components: {
      FormLogin,
    },
    data: () => ({
      logo: logo,
      sena: sena,
      sideMenu: false,
      session: '',
    }),
    computed: {
      ...mapGetters(['route', 'dialogLogin']),
    },
    mounted() {
      this.configSession();
    },
    methods: {
      ...mapActions(['openCloseDialog']),
      configSession() {
        this.session = localStorage.session;
        console.log(localStorage.session);
      },
      closeSession() {
        localStorage.clear();
        localStorage.session = false;
        window.location.href = '/';
      }
    }
  };

</script>