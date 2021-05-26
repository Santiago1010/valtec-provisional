  
<template>

  <div>

    <v-app-bar dark color="oscuro" style="max-height: 60px; position: relative; z-index: 2;">

      <v-app-bar-nav-icon @click="menuLateral = true"></v-app-bar-nav-icon>

      <router-link to='/'><v-toolbar-title><img src="../assets/imagenes/logos/isologo.png" style="max-height: 50px; margin-top: 5px;"></v-toolbar-title></router-link>

      <v-spacer></v-spacer>

      <img src="../assets/imagenes/logos/sena.png" style="max-height: 50px; margin-top: 0px;">

    </v-app-bar>

    <v-navigation-drawer color="oscuro" dark app v-model="menuLateral" absolute temporary>

      <v-list nav dense>

        <v-list-item-group active-class="orange accent-4--text text--accent-4">

          <v-list-item to='/'>

            <v-list-item-icon>

              <v-icon>mdi-home</v-icon>

            </v-list-item-icon>

            <v-list-item-title>Inicio</v-list-item-title>

          </v-list-item>

          <v-list-item @click="inicioSesion = true">

            <v-list-item-icon>

              <v-icon>login</v-icon>

            </v-list-item-icon>

            <v-list-item-title>Iniciar sesión</v-list-item-title>

          </v-list-item>

          <v-list-item to='/registro'>

            <v-list-item-icon>

              <v-icon>create</v-icon>

            </v-list-item-icon>

            <v-list-item-title>Registrarse</v-list-item-title>

          </v-list-item>

          <v-list-item to='/contrasena'>

            <v-list-item-icon>

              <v-icon>vpn_key</v-icon>

            </v-list-item-icon>

            <v-list-item-title>Recuperar contraseña</v-list-item-title>

          </v-list-item>

          <v-list-item to='/estadisticas'>

            <v-list-item-icon>

              <v-icon>analytics</v-icon>

            </v-list-item-icon>

            <v-list-item-title>Estadísticas</v-list-item-title>

          </v-list-item>

          <v-divider></v-divider>

          <v-list-item @click="menuLateral = false">

            <v-list-item-icon>

              <v-icon>cancel</v-icon>

            </v-list-item-icon>

            <v-list-item-title>Cerrar</v-list-item-title>

          </v-list-item>

        </v-list-item-group>

      </v-list>

    </v-navigation-drawer>

    <v-dialog v-model="inicioSesion" max-width="800">

      <v-card>

        <v-card-title dark class="headline institucional lighten-2">

          Iniciar Sesión

        </v-card-title>
        
        <v-card-text>

          <v-text-field v-model="documentoLogin" :rules="documentoValidacion" :counter="11" label="Número de documento" prepend-icon="mdi-account-box" required></v-text-field>

          <v-text-field v-model="contrasenaLogin" :rules="confirmarContrasena" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Confirme la contraseña" counter @click:append="show1 = !show1" prepend-icon="mdi-key" required></v-text-field>

        </v-card-text>
        
        <v-divider></v-divider>
        
        <v-card-actions>

          <v-spacer></v-spacer>

          <v-btn color="institucional" @click="cerrarLogin" text>Cerrar</v-btn>

          <v-btn color="primary" @click="iniciarSesion" text>Iniciar Sesión</v-btn>

        </v-card-actions>

      </v-card>

    </v-dialog>

    <v-snackbar v-model="alertaLogin"> {{ textoLogin }}

      <template v-slot:action="{ attrs }">

        <v-btn color="pink" text v-bind="attrs" @click="alertaLogin = false">Cerrar</v-btn>

      </template>

    </v-snackbar>

  </div>

</template>

<script>
  import { mapState, mapMutations, mapActions, mapGetters } from 'vuex'
  export default {
    name: 'MenuIndex',
    data: () => ({
      menuLateral: false,
      inicioSesion: false,
      show1: false,
      documentoLogin: '',
      contrasenaLogin: '',
      documentoValidacion: [
      v => !!v || 'El número de documento es requerido.',
      v => (v && v.length <= 11) || 'La cantidad de números no es válida.',
      v => /^([0-9])*$/.test(v) || 'El número de documento no puede contener caracteres alfabéticos.',
      ],
      confirmarContrasena: [
      v => !!v || 'La contraseña es obligatoria.',
      v => (v && v.length >= 8) || 'La contraseña debe tener más de 8 caracteres.',
      ],
      textoLogin: '',
      alertaLogin: false,
    }),
    computed: {
      ...mapGetters(['documento', 'rol', 'ruta']),
    },
    mounted() {
    },
    methods: {
      ...mapActions(['validarInicio']),
      cerrarLogin: function() {
        this.inicioSesion = false;
        this.documentoLogin = '';
        this.contrasenaLogin = '';
      },
      iniciarSesion: function () {
        axios.post(this.ruta + 'recepcionLogin.php', {documento:this.documentoLogin, contrasena:this.contrasenaLogin}).then(response => {
          if (response.data != null && response.data != false && response.data != "") {
            if (this.validarInicio(response.data)) {
              this.$router.push('inicio')
            }
          }else {
            this.alertaLogin = true;
            this.textoLogin = 'Error al iniciar sesión.';
          }
        });
      }
    }
  };
</script>