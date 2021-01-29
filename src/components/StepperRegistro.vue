<template>

  <v-container>

    <v-stepper class="mt-10" style="max-width: 600px; margin: auto;" v-model="e1">

      <v-stepper-header>

        <v-divider></v-divider>

        <v-stepper-step @click="e1 = 1" :complete="e1 > 1" step="1">Datos básicos</v-stepper-step>

        <v-divider></v-divider>

      </v-stepper-header>

      <v-stepper-items>

        <v-stepper-content step="1">

          <v-select v-model="tipoDocumento" :items="tipoDocumentoLista" name="tipoDocumento" :rules="[v => !!v || 'Debe seleccionar un tipo de documento.']" label="Tipo de documento" required></v-select>

          <v-text-field v-model="numeroDocumento" :rules="documentoValidacion" :counter="11" label="Número de documento" required></v-text-field>

          <v-text-field v-model="nombres" :rules="nombresValidacion" label="Nombre(s) completo(s)" required></v-text-field>

          <v-text-field v-model="apellidos" :rules="apellidosValidacion" label="Apellido(s) completo(s)" required></v-text-field>

          <v-text-field v-model="numeroContacto" :rules="numeroContactoValidacion" hint="En caso de no proporcionar este dato, poner 1111111111." label="Número celular"></v-text-field>

          <v-text-field v-model="correoElectronico" :rules="correoValidacion" label="Correo electrónico"></v-text-field>

          <v-text-field v-model="contrasenaNueva" type="password" :rules="contrasenaNuevaValidacion" label="Contraseña que usará en la plataforma" counter required></v-text-field>

          <v-text-field v-model="confirmarContrasena" :rules="confirmarContrasenaValidacion" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Confirme la contraseña" counter @click:append="show1 = !show1" required></v-text-field>

          <v-select v-model="selectRol" :items="roles" item-value="id_rol" item-text="nombre_rol" name="regional" :rules="[v => !!v || 'Debe seleccionar unrol.']" label="Rol" required></v-select>

          <v-select v-model="selectRegional" :items="regionales" item-value="id_regional" item-text="nombre_regional" name="regional" :rules="[v => !!v || 'Debe seleccionar una regional.']" label="Regional" @change="consultarCentros" required></v-select>

          <v-select v-model="selectCentros" :items="centros" item-value="id_centro" item-text="nombre_centro" name="centro" :rules="[v => !!v || 'Debe seleccionar un centro de formacion.']" label="Centro de formación" required></v-select>

          <br/>

          <v-btn color="primary" @click="registrarPersona">Enviar</v-btn>

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
        select: null,
        tipoDocumento: '',
        tipoDocumentoLista: ['T.I.', 'C.C.', 'C.E.'],
        nombres: '',
        apellidos:'',
        nombresValidacion: [

        v => !!v || 'El nombre es requerido.',
        v => /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g.test(v) || 'El nombre deber tener solamente caracteres alfabéticos.',

        ],
        apellidosValidacion: [

        v => !!v || 'El apellido es requerido.',
        v => /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g.test(v) || 'El apellido deber tener solamente caracteres alfabéticos.',

        ],
        numeroDocumento: '',
        documentoValidacion: [

        v => !!v || 'El número de documento es requerido.',
        v => (v && v.length <= 11) || 'La cantidad de números no es válida.',
        v => /^([0-9])*$/.test(v) || 'El número de documento no puede contener caracteres alfabéticos.',

        ],
        numeroContacto: '',
        numeroContactoValidacion: [

        v => !!v || 'El número de celular es requerido.',
        v => (v && v.length <= 10) || 'La cantidad de números no es válida.',
        v => /^([0-9])*$/.test(v) || 'El número de celular no puede contener caracteres alfabéticos.',

        ],
        correoElectronico: '',
        correoValidacion: [

        v => !!v || 'El correo electrónico es requerido.',
        v => /^([a-zA-Z0-9_.+-])+\@((misena|sena)+\.+(edu.co))$/.test(v) || 'El correo electrónico es inválido. Debe ser correo sena, o misena',

        ],
        show1: false,
        contrasenaNueva: '',
        contrasenaNuevaValidacion: [

        v => !!v || 'La contraseña es obligatoria.',
        v => (v && v.length >= 8) || 'La contraseña debe tener más de 8 caracteres.',

        ],
        confirmarContrasena: '',
        confirmarContrasenaValidacion: [

        v => !!v || 'La confirmación es obligatoria.',
        v => (this.contrasenaNueva == this.confirmarContrasena) || 'Las contraseñas no coinciden.',

        ],
        regionales: [],
        selectRegional: '',
        centros: [],
        selectCentros: '',
        snackbar: false,
        textoSnackbar: '',
        selectRol: '',
        roles: [],

      }

    },
    mounted () {

      this.llenarRegionales();
      this.consultarRoles();

    },
    computed: {

      ...mapGetters(['ruta']),

    },
    methods: {

      llenarRegionales: function() {

        axios.post(this.ruta + 'recepcionRegistro.php', {consultarRegional: true}).then(response => {

          this.regionales = response.data;

        });

      },

      consultarCentros() {

        axios.post(this.ruta + 'recepcionRegistro.php', {consultarCentro: this.selectRegional}).then(response => {

          this.centros = response.data;

        });

      },

      consultarRoles() {

        axios.post(this.ruta + 'recepcionRegistro.php', {consultarRol: true}).then(response => {

          this.roles = response.data;

        });

      },

      registrarPersona: function() {

        if (this.tipoDocumento != "" && this.tipoDocumento != null && this.numeroDocumento != "" && this.numeroDocumento != null && this.nombres != "" && this.nombres != null && this.apellidos != "" && this.apellidos != null && this.numeroContacto != "" && this.numeroContacto != null && this.correoElectronico != "" && this.correoElectronico != null && this.contrasenaNueva != "" && this.contrasenaNueva != null && this.confirmarContrasena != "" && this.confirmarContrasena != null && this.selectRegional != "" && this.selectRegional != null && this.selectCentros != "" && this.selectCentros != null && this.selectRol != "" && this.selectRol != null) {

          axios.post(this.ruta + 'recepcionRegistro.php', {tipoDocumento:this.tipoDocumento, numeroDocumento:this.numeroDocumento, nombres:this.nombres, apellidos:this.apellidos, numeroContacto:this.numeroContacto, correoElectronico:this.correoElectronico, contrasenaNueva:this.contrasenaNueva, confirmarContrasena:this.confirmarContrasena, regional:this.selectRegional, centro:this.selectCentros, rol:this.selectRol}).then(response => {

            this.snackbar = true;
            this.textoSnackbar = response.data;

            if (response.data == "Se ha registrado el usuario. Se ha enviado un correo electrónico a la cuenta registrada para confirmarla.") {

              this.tipoDocumento = "";
              this.numeroDocumento = "";
              this.nombres = "";
              this.apellidos = "";
              this.numeroContacto = "";
              this.correoElectronico = "";
              this.contrasenaNueva = "";
              this.confirmarContrasena = "";
              this.selectRegional = "";
              this.selectCentros = "";
              this.selectRol = "";

            }

          });

        }else {

          alert('Complete todos los campos.');

        }

      }

    }

  }

</script>