<template>

  <v-carousel height="100vh" cycle hide-delimiters show-arrows-on-hover>

    <v-carousel-item v-for="(item,i) in items" :key="i" :src="item.src"></v-carousel-item>

  </v-carousel>

</template>

<script>

  import bannerCiencia from '../assets/imagenes/carrusel/banner_ciencia.png';

  import bannerProductividad from '../assets/imagenes/carrusel/banner_productividad.png';

  import bannerTecnologia from '../assets/imagenes/carrusel/banner_tecnologia.png';

  export default {

    name: 'CarruselIndex',
    data: () => ({

      slide: 1,
      sliding: null,
      items: [
        {
          src: bannerCiencia,
        },
        {
          src: bannerProductividad,
        },
        {
          src: bannerTecnologia,
        },
      ],

    }),

  };

</script>