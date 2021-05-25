import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import es from 'vuetify/es5/locale/es';

Vue.use(Vuetify);

export default new Vuetify({
  theme: {
    options: {
      customProperties: true,
    },
    themes: {
      light: {
        primary: '#59B548',
        secondary: '#238276',
        accent: '#82B1FF',
        error: '#BF1304',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107',
        institucional: '#FF6B00',
        oscuro: '#333333'
      },
    },
  },
  lang: {
    locales: { es },
    current: 'es',
  },
});
