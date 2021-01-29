<template>

  <v-container>

    <v-stepper class="mt-10" style="max-width: 600px; margin: auto;" v-model="e1">

      <v-stepper-header>

        <v-divider></v-divider>

        <v-stepper-step @click="e1 = 1" :complete="e1 > 1" step="1">Datos de quién desea recuperar la contraseña</v-stepper-step>

        <v-divider></v-divider>

      </v-stepper-header>

      <v-stepper-items>

        <v-stepper-content step="1">

          <v-text-field v-model="numeroDocumento" :rules="documentoValidacion" :counter="11" label="Número de documento" required></v-text-field>

          <br/>

          <v-btn color="primary" @click="recuperarContrasena">Enviar</v-btn>

          <v-btn class="ml-4" dark color="institucional" to="/">Cancelar</v-btn>

        </v-stepper-content>

      </v-stepper-items>

    </v-stepper>

    <v-snackbar v-model="snackbar">

      {{ textoSnackbar }}

      <template v-slot:action="{ attrs }">

        <v-btn color="institucional" text v-bind="attrs" @click="snackbar = false">

          Cerrar

        </v-btn>

      </template>

    </v-snackbar>

  </v-container>

</template>

<script>

  import { mapGetters } from 'vuex'

  export default {

    data () {

      return {

        e1: 1,
        numeroDocumento: '',
        documentoValidacion: [

          v => !!v || 'El número de documento es requerido.',
          v => (v && v.length <= 11) || 'La cantidad de números no es válida.',
          v => /^([0-9])*$/.test(v) || 'El número de documento no puede contener caracteres alfabéticos.',

        ],
        snackbar: false,
        textoSnackbar: '',

      }

    },
    mounted () {

      //

    },
    computed: {

      ...mapGetters(['ruta']),

    },
    methods: {

      recuperarContrasena: function() {

        if (this.numeroDocumento != '' && this.numeroDocumento != null) {

          axios.post(this.ruta + 'recepcionContrasena.php', {documentoCorreo:this.numeroDocumento}).then(response => {

            this.snackbar = true;
            this.textoSnackbar = response.data;

          });

        }

      }

    }

  }

</script>