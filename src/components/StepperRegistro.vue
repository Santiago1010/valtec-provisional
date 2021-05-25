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
          <v-form ref="formCreateUser" v-model="validFormCreateUser" lazy-validation @submit="validate">
            <v-text-field v-model="userData.documentUser" :rules="[rules.required, rules.validationDocument]" :counter="10" label="Número de documento" required></v-text-field>
            <v-text-field v-model="userData.nameUser" :rules="[rules.required, rules.validationNames]" label="Nombre(s) completo(s)" required></v-text-field>
            <v-text-field v-model="userData.lastNameUser" :rules="[rules.required, rules.validationNames]" label="Apellido(s) completo(s)" required></v-text-field>
            <v-text-field v-model="userData.phoneUser" :rules="[rules.required, rules.maxPhone]" :counter="10" hint="En caso de no desear proporcionar este dato, poner 1111111111." label="Número de celular"></v-text-field>
            <v-text-field v-model="userData.emailUser" :rules="[rules.required, rules.validationEmail]" label="Correo electrónico"></v-text-field>
            <v-text-field v-model="userData.passwordUser" type="password" :rules="[rules.required, rules.minPassword]" label="Contraseña que usará en la plataforma" counter required></v-text-field>
            <v-text-field v-model="userData.confirmPassword" :rules="[rules.required, rules.minPassword, rules.confirmPassword]" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'" label="Confirme la contraseña" counter @click:append="show1 = !show1" required></v-text-field>
            <v-select v-model="userData.roleUser" :items="roles" item-value="id_rol" item-text="nombre_rol" :rules="[v => !!v || 'Debe seleccionar unrol.']" label="Rol" required></v-select>
            <v-select v-model="userData.regionalUser" :items="regionals" item-value="id_regional" item-text="nombre_regional" :rules="[v => !!v || 'Debe seleccionar una regional.']" label="Regional" required></v-select>
            <v-select v-model="userData.centerUser" :items="centers" item-value="id_centro" item-text="nombre_centro" :rules="[v => !!v || 'Debe seleccionar un centro de formacion.']" label="Centro de formación" required></v-select>
            <br/>
            <v-btn type="submit" :disabled="!validFormCreateUser" color="primary" @click="validate" @submit="validate">Enviar</v-btn>
            <v-btn class="ml-4" dark color="institucional" @click="reset">Cancelar</v-btn>
          </v-form>
        </v-stepper-content>
      </v-stepper-items>
    </v-stepper>
    <Snackbar></Snackbar>
  </v-container>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  import Snackbar from './Snackbar.vue'

  export default {
    name: 'StepperRegistro',
    components: {
      Snackbar,
    },
    data () {
      return {
        e1: 1,
        show1: false,
        validFormCreateUser: true,
        userData: {
          documentUser: '',
          nameUser: '',
          phoneNameUser: '',
          emailUser: '',
          passwordUser: '',
          confirmPassword: '',
          regionalUser: '',
          centerUser: ''
        },
        rules: {
          required: v => !!v || 'Este campo es requerido.',
          minPassword: v => v.length >= 8 || 'La contraseña debe tener mínimo 8 caracteres.',
          validationNames: v => /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g.test(v) || 'Este campo sólo permite caracteres alfabéticos.',
          validationDocument: v => (v && v.length <= 10) || 'La cantidad de números no es válida.',
          validationNumbers: v => /^([0-9])*$/.test(v) || 'El número de documento no puede contener caracteres alfabéticos.',
          maxPhone: v => (v && v.length <= 10) || 'La cantidad de números no es válida.',
          validationEmail: v => /^([a-zA-Z0-9_.+-])+\@((misena|sena)+\.+(edu.co))$/.test(v) || 'El correo electrónico es inválido. Debe ser correo sena, o misena.',
          confirmPassword: v => (this.passwordUser == this.confirmPassword) || 'Las contraseñas no coinciden.'
        },
        regionals: [],
        centers: [],
        roles: [],
      }

    },
    mounted () {},
    computed: {
      ...mapGetters(['route']),
    },
    methods: {
      ...mapActions(['openCloseSnackbar', 'newTextSnackbar']),
      createUser() {
        axios.post(this.ruta + '/receivers/recepcionUsers.php', {typeFunction: 'createUser', dataUser:this.userData}).then(response => {
          this.openCloseSnackbar(false);
          this.openCloseSnackbar(true);
          if (response.data == 1) {
            this.newTextSnackbar('El usuario ha sido registrado. Se ha envíado un correo a la cuenta de correo electrónico registrada para confirmar. En caso de no confirmar, no podrá acceder a la plataforma.');
            this.reset();
          }else {
            this.newTextSnackbar(response.data);
            this.userData.password = '';
            this.userData.passwordUser = '';
          }
        });
      },
      validate() {
        event.preventDefault();
        this.$refs.formCreateUser.validate() ? this.createUser() : '';
      },
      reset() {
        this.$refs.formCreateUser.reset()
      },
      resetValidation() {
        this.$refs.formCreateUser.resetValidation()
      },
      readRegionals() {
        axios.post(this.ruta + '/receivers/recepcionUsers.php', {typeFunction: 'readRegionals'}).then(response => {
          
        }).catch(error => console.log(error));
      }
    }
  }
</script>