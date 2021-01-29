import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {

  	documento: null,
    rol: null,
    ruta: 'https://sistema.valtec.systems/recepcion/',
    //ruta: 'http://localhost/valtec/recepcion/',

  },
  actions: {

    validarInicio({ commit }, usuario) {

      commit('actualizarDocumento', usuario.documento_usuario);

      commit('actualizarRol', usuario.id_rol);

      axios.post(this.state.ruta + 'recepcionLogin.php', {iniciarDocumento:usuario.documento_usuario}).then(response => {

        if (response.data == true || response.data == 1) {

          return true;

        }

      }); 

    },

    verificarInicio(state) {

      if (this.state.documento == null && this.state.rol == null) {

        window.location.href = '/';

      }else {

        console.log(this.state.documento + ", " + this.state.rol);

      }

    },

    eliminarSesion({ commit }) {

      commit('actualizarDocumento', null);

      commit('actualizarRol', null);

      return true;

    },

  },
  mutations: {

    actualizarDocumento(state, documento) {

      state.documento = documento

    },

    actualizarRol(state, rol) {

      state.rol = rol

    }

  },
  getters: {

    documento: state => state.documento,
    rol: state => state.rol,
    ruta: state => state.ruta

  }

})
