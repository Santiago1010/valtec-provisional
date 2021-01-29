<style type="text/css">

.contenedorConceptos {

    min-height: 45vh;
    position: relative;

}

h1.transparente {

    font-size: 6em;
    text-align: center;
    color: transparent;
    -webkit-text-stroke: 2px #FF6B00;
    width: 45%;
    margin: auto;
    border-bottom: 2px solid #FF6B00;

}

.content-all{

    width: 210px;
    margin: auto;
    perspective: 800px;
    position: relative;
    margin-top: 50px;

}

.content-carrousel{

    width: 100%;
    position: absolute;
    animation: rotar 50s infinite linear;
    transform-style: preserve-3d;

}

.content-carrousel:hover{

    animation-play-state: paused;
    cursor: pointer;

}

.content-carrousel figure{

    width: 100%;
    height: 128px;
    overflow: hidden;
    position: absolute;
    box-shadow: 0px 0px 20px 0px black;
    transition: all 300ms;

}

.content-carrousel figure:hover{

    box-shadow: 0px 0px 0px 0px black;
    transition: all 300ms;

}

.content-carrousel figure:nth-child(1){transform: rotateY(0deg) translateZ(300px);}
.content-carrousel figure:nth-child(2){transform: rotateY(40deg) translateZ(300px);}
.content-carrousel figure:nth-child(3){transform: rotateY(80deg) translateZ(300px);}
.content-carrousel figure:nth-child(4){transform: rotateY(120deg) translateZ(300px);}
.content-carrousel figure:nth-child(5){transform: rotateY(160deg) translateZ(300px);}
.content-carrousel figure:nth-child(6){transform: rotateY(200deg) translateZ(300px);}
.content-carrousel figure:nth-child(7){transform: rotateY(240deg) translateZ(300px);}
.content-carrousel figure:nth-child(8){transform: rotateY(280deg) translateZ(300px);}
.content-carrousel figure:nth-child(9){transform: rotateY(320deg) translateZ(300px);}
.content-carrousel figure:nth-child(10){transform: rotateY(360deg) translateZ(300px);}

.content-carrousel img{

    width: 100%;
    transition: all 100ms;

}

@keyframes rotar{

    from{

        transform: rotateY(0deg);

        }to{

            transform: rotateY(360deg);

        }

    }

</style>

<template>

    <div class="contenedorConceptos">

        <h1 class="transparente">CONCEPTOS</h1>

        <div class="content-all">

            <div class="content-carrousel">

                <figure><img :src="infoCTEI" class="imagenes_carrusel" @click="mostrarModalImagen('ctei')"></figure>

                <figure><img :src="infoCTEI" class="imagenes_carrusel" @click="mostrarModalImagen('ctei')"></figure>

                <figure><img :src="infoInvestigacionAplicada" class="imagenes_carrusel" @click="mostrarModalImagen('investigacionAplicada')"></figure>

                <figure><img :src="infoTRL" class="imagenes_carrusel" @click="mostrarModalImagen('trl')"></figure>

                <figure><img :src="infoInvestigacionBasica" class="imagenes_carrusel" @click="mostrarModalImagen('investigacionBasica')"></figure>

                <figure><img :src="infoIDI" class="imagenes_carrusel" @click="mostrarModalImagen('idi')"></figure>

                <figure><img :src="infoPMV" class="imagenes_carrusel" @click="mostrarModalImagen('pmv')"></figure>

                <figure><img :src="infoSpinoff" class="imagenes_carrusel" @click="mostrarModalImagen('spinOff')"></figure>

                <figure><img :src="infoStartUp" class="imagenes_carrusel" @click="mostrarModalImagen('startUp')"></figure>

                <figure><img :src="infoGuiaPropiedad" class="imagenes_carrusel" @click="mostrarModalImagen('guiaPropiedad')"></figure>

            </div>

        </div>

        <v-dialog v-model="modalImagen" width="800">

            <v-card>

                <v-img class="white--text align-end" :src="imagenAgrandada"></v-img>

                <v-card-actions>

                    <v-spacer></v-spacer>

                    <v-btn @click="modalImagen = false" icon>

                        <v-icon>highlight_off</v-icon>

                    </v-btn>

                </v-card-actions>

            </v-card>

        </v-dialog>

    </div>

</template>

<script>

    import infoCTEI from '../assets/imagenes/tarjetas/info_ctei.png';

    import infoInvestigacionAplicada from '../assets/imagenes/tarjetas/info_investigacion_aplicada.png';

    import infoTRL from '../assets/imagenes/tarjetas/info_trl.png';

    import infoInvestigacionBasica from '../assets/imagenes/tarjetas/info_investigacion_basica.png';

    import infoIDI from '../assets/imagenes/tarjetas/info_idi.png';

    import infoPMV from '../assets/imagenes/tarjetas/info_pmv.png';

    import infoSpinoff from '../assets/imagenes/tarjetas/info_spin_off.png';

    import infoStartUp from '../assets/imagenes/tarjetas/info_start_up.png';

    import infoGuiaPropiedad from '../assets/imagenes/tarjetas/info_guia_propiedad.png';

    export default {

        name: 'CarruselIndex',
        data: () => ({

            infoCTEI: infoCTEI,
            infoInvestigacionAplicada: infoInvestigacionAplicada,
            infoTRL: infoTRL,
            infoInvestigacionBasica: infoInvestigacionBasica,
            infoIDI: infoIDI,
            infoPMV: infoPMV,
            infoSpinoff: infoSpinoff,
            infoStartUp: infoStartUp,
            infoGuiaPropiedad: infoGuiaPropiedad,
            modalImagen: false,
            imagenAgrandada: '',

        }),
        methods: {

            mostrarModalImagen: function(ruta) {

                if (ruta == "ctei") {

                    this.imagenAgrandada = infoCTEI;

                }else if (ruta == "investigacionAplicada") {

                    this.imagenAgrandada = this.infoInvestigacionAplicada;

                }else if (ruta == "trl") {

                    this.imagenAgrandada = this.infoTRL;

                }else if (ruta == "investigacionBasica") {

                    this.imagenAgrandada = this.infoInvestigacionBasica;

                }else if (ruta == "idi") {

                    this.imagenAgrandada = this.infoIDI;

                }else if (ruta == "pmv") {

                    this.imagenAgrandada = this.infoPMV;

                }else if (ruta == "spinOff") {

                    this.imagenAgrandada = this.infoSpinoff;

                }else if (ruta == "startUp") {

                    this.imagenAgrandada = this.infoStartUp;

                }else if (ruta == "guiaPropiedad") {

                    this.imagenAgrandada = this.infoGuiaPropiedad;

                }

                this.modalImagen = true;

            }
            
        }

    }

</script>