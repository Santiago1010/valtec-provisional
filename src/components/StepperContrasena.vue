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
          <v-form ref="formRecoverPassword" lazy-validation v-model="validFormRecoverPassword">
            <v-text-field v-model="documentUser" :rules="validationDocument" :counter="10" label="Número de documento" required></v-text-field>
            <br/>
            <v-btn type="submit" :disabled="!validFormRecoverPassword" color="primary" @submit="validate" @click="validate">Enviar</v-btn>
            <v-btn class="ml-4" dark color="institucional" to="/">Cancelar</v-btn>
          </v-form>
        </v-stepper-content>
      </v-stepper-items>
    </v-stepper>
  </v-container>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    data () {
      return {
        e1: 1,
        validFormRecoverPassword: true,
        documentUser: '',
        validationDocument: [
        v => !!v || 'El número de documento es requerido.',
        v => (v && v.length <= 10) || 'La cantidad de números no es válida.',
        v => /^([0-9])*$/.test(v) || 'El número de documento no puede contener caracteres alfabéticos.',
        ],
      }
    },
    computed: {
      ...mapGetters(['route']),
    },
    methods: {
      ...mapActions(['modifyStateSnackbar', 'modifyTextSnackbar']),
      validate (event) {
        event.preventDefault();
        this.$refs.formRecoverPassword.validate() ? this.sendEmailRecoverPassword() : false;
      },
      sendEmailRecoverPassword() {
        axios.post(this.route + 'receivers/receptionPassword.php', { typeFunction:'sendEmailRecoverPassword', documentUserRecoverPassword:this.documentUser }).then(response => {
          this.modifyStateSnackbar(false);
          this.modifyStateSnackbar(true);
          if (response.data == 1) {
            this.modifyTextSnackbar('Se ha enviado el correo electrónico con un link para que pueda acceder y realizar el cambio de su contraseña.');
          }else {
            this.modifyTextSnackbar(response.data);
          }
        });
      }
    }
  }
</script>