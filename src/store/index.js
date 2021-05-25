import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    route: 'http://localhost/valtec/',
    dialogLogin: false,
    snackbar: false,
    snackbarText: '',
  },
  actions: {
    openCloseDialog({ commit }, newState) {
      commit('dialogLoginOpenClose', newState)
    },
    modifyStateSnackbar({ commit }, newState) {
      commit('openCloseSnackbar', newState)
    },
    modifyTextSnackbar({ commit }, newText) {
      commit('newTextSnackbar', newText)
    }
  },
  mutations: {
    dialogLoginOpenClose(state, newState) {
      state.dialogLogin = newState;
    },
    openCloseSnackbar(state, newState) {
      state.snackbar = newState;
    },
    newTextSnackbar(state, newText) {
      state.snackbarText = newText;
    },
  },
  getters: {
    route: state => state.route,
    dialogLogin: state => state.dialogLogin,
    snackbar: state => state.snackbar,
    snackbarText: state => state.snackbarText
  }

})