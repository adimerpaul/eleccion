<template>
<q-page>
  <q-card>
    <q-card-section>
      <div class="row">
        <div class="col-12">
          <q-table :rows="predilectas" :filter="filter" :columns="columnsPredilecta" :rows-per-page-options="[0]">
            <template v-slot:top-right>
              <q-btn flat icon="refresh" @click="refresh" />
              <q-input v-model="filter"  outlined  dense placeholder="Buscar..." />
            </template>
            <template v-slot:body-cell-predilecta="props">
              <q-td :props="props" auto-width>
                <q-item class="q-pa-none q-ma-none">
                  <q-item-section avatar class="q-pa-none q-ma-none">
                    <q-btn dense icon="o_assignment_ind" @click="showPredilecta(props.row)" />
                    <q-btn dense icon="o_photo_camera" @click="photoCarosel(props.row)" />
                  </q-item-section>
                  <q-item-section class="q-pa-none q-ma-none">
<!--                    style="width: 150px; white-space: normal;"-->
                    <div class="text-bold "  >
                      {{ props.pageIndex+1 }}.-
                      {{props.row.nombre}}
                    </div>
                    <div class="text-grey-8">{{props.row.conjunto}}</div>
                  </q-item-section>
                </q-item>
              </q-td>
            </template>
            <template v-slot:body-cell-bano="props">
              <q-td :props="props">
<!--                <q-input @keyup="votoUpdate(props.row.bano,props.row.id,'TRAJE DE BAÑO')" :model-value="props.row.bano" outlined dense style="width: 10em;text-align: center" type="number" :rules="[val => val > -1 || 'Debe ser mayor a 0', val => val < 100 || 'Debe ser menor a 100']" />-->
                <q-select @update:model-value="votoUpdate($event,props.row.id,'TRAJE DE BAÑO')" dense outlined v-model="props.row.bano" :options="num" />
              </q-td>
            </template>
            <template v-slot:body-cell-gala="props">
              <q-td :props="props">
<!--                <q-input @keyup="votoUpdate(props.row.gala,props.row.id,'TRAJE DE GALA')"  v-model="props.row.gala" outlined dense style="width: 10em;text-align: center" type="number" :rules="[val => val > -1 || 'Debe ser mayor a 0', val => val < 100 || 'Debe ser menor a 100']" />-->
                <q-select @update:model-value="votoUpdate($event,props.row.id,'TRAJE DE GALA')" dense outlined v-model="props.row.gala" :options="num" />
              </q-td>
            </template>
            <template v-slot:body-cell-fol="props">
              <q-td :props="props">
<!--                <q-input @keyup="votoUpdate(props.row.fol,props.row.id,'TRAJE DE FOLKLORICO')"  v-model="props.row.fol" outlined dense style="width: 10em;text-align: center" type="number" :rules="[val => val > -1 || 'Debe ser mayor a 0', val => val < 100 || 'Debe ser menor a 100']" />-->
                <q-select @update:model-value="votoUpdate($event,props.row.id,'TRAJE DE FOLKLORICO')" dense outlined v-model="props.row.fol" :options="num" />
              </q-td>
            </template>
            <template v-slot:body-cell-pre="props">
              <q-td :props="props">
<!--                <q-input @keyup="votoUpdate(props.row.pre,props.row.id,'PREGUNTAS')" v-model="props.row.pre" outlined dense style="width: 10em;text-align: center" type="number" :rules="[val => val > -1 || 'Debe ser mayor a 0', val => val < 100 || 'Debe ser menor a 100']" />-->
                <q-select @update:model-value="votoUpdate($event,props.row.id,'PREGUNTAS')" dense outlined v-model="props.row.pre" :options="num" />
              </q-td>
            </template>
            <template v-slot:body-cell-total="props">
              <q-td :props="props">
                <div class="text-bold">{{total(props.row.bano,props.row.gala,props.row.fol,props.row.pre)}} P</div>
              </q-td>
            </template>
          </q-table>
        </div>
      </div>
    </q-card-section>
  </q-card>
  <q-dialog full-width full-height v-model="showPhotoCarosel" >
    <q-card >
<!--      <q-card-section class="row items-center">-->
<!--        <div class="text-h6">Fotos {{predilecta.nombre}}</div>-->
<!--        <q-space />-->
<!--        <q-btn icon="close" flat round dense v-close-popup />-->
<!--      </q-card-section>-->
      <q-card-section>

        <q-card-section >
          <center>
            <q-carousel
              style="border: 0px solid #000;height: 80vh;width: 280px"
              animated
              v-model="slide"
              arrows
              navigation
              infinite
            >
              <q-carousel-slide :name="1" :img-src="`${url}../imagenes/${predilecta.foto1}`" />
              <q-carousel-slide :name="2" :img-src="`${url}../imagenes/${predilecta.foto2}`" />
              <q-carousel-slide :name="3" :img-src="`${url}../imagenes/${predilecta.foto3}`" />
            </q-carousel>
          </center>
        </q-card-section>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog v-model="showUpdateUserDialog" >
    <q-card style="width: 700px;max-width: 85vw">
      <q-card-section class="row items-center">
        <div class="text-h6">Predilecta</div>
          <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
      <q-card-section>
<!--        <q-form @submit.prevent="predilectaUpdate">-->
          <q-input dense v-model="predilecta.nombre"  required outlined label="nombre" />
          <q-input dense v-model="predilecta.conjunto"  required outlined label="conjunto" />
          <q-input dense v-model="predilecta.edad"  required outlined label="edad" />
          <q-input dense v-model="predilecta.profesion"  required outlined label="profesion" />
          <q-input dense v-model="predilecta.ocupacion"  required outlined label="ocupacion" />
          <q-input dense v-model="predilecta.estatura"  required outlined label="estatura" />
          <q-input dense v-model="predilecta.medidas"  required outlined label="medidas" />
          <q-input dense v-model="predilecta.pasatiempo"  required outlined label="pasatiempo" />
          <q-input dense v-model="predilecta.color"  required outlined label="color" />
          <q-input dense v-model="predilecta.deporte"  required outlined label="deporte" />
<!--          <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Guardar" class="full-width" />-->
<!--        </q-form>-->
      </q-card-section>
    </q-card>
  </q-dialog>
</q-page>
</template>

<script>
export default {
  name: `Votacion`,
  data() {
    return {
      showUpdateUserDialog: false,
      slide: 1,
      showPhotoCarosel: false,
      columnsPredilecta:[
        {name: 'predilecta', label: 'Predilecta', field: 'predilecta', align: 'left', sortable: true},
        // {name: 'bano', label: 'TRAJE DE BAÑO', field: 'bano', align: 'left', sortable: true},
        // {name: 'gala', label: 'TRAJE DE GALA', field: 'gala', align: 'left', sortable: true},
        // {name: 'fol', label: 'TRAJE DE FOLKLORICO', field: 'fol', align: 'left', sortable: true},
        // {name: 'pre', label: 'PREGUNTAS', field: 'pre', align: 'left', sortable: true},
        // {name: 'total', label: 'TOTAL', field: 'total', align: 'left', sortable: true},
      ],
      url:process.env.API,
      num:[''],
      filter: '',
      loading:false,
      predilectas:[],
      predilecta:{},
      nro:'',
    }
  },
  created() {
    this.$watch(
      () => this.$route.params.id,
      (toParams, previousParams) => {
        console.log('nuevo', toParams)
        console.log('antiguo', previousParams)
        if (toParams == undefined) {
          return false
        }
        this.nro = toParams
        if (this.nro=='nroBano'){
          this.columnsPredilecta.pop()
          this.columnsPredilecta.push({name: 'bano', label: 'TRAJE DE PRESENTACION', field: 'bano', align: 'left', sortable: true})
          for (let i = 0; i <= 25; i++) {
            this.num.push(i)
          }
        }
        if (this.nro=='nroGala'){
          this.columnsPredilecta.pop()
          this.columnsPredilecta.push({name: 'gala', label: 'TRAJE DE GALA', field: 'gala', align: 'left', sortable: true})
          for (let i = 0; i <= 25; i++) {
            this.num.push(i)
          }
        }
        if (this.nro=='nroFol'){
          this.columnsPredilecta.pop()
          this.columnsPredilecta.push({name: 'fol', label: 'TRAJE DE FOLKLORICO', field: 'fol', align: 'left', sortable: true})
          for (let i = 0; i <= 25; i++) {
            this.num.push(i)
          }
        }
        if (this.nro=='nroPre'){
          this.columnsPredilecta.pop()
          this.columnsPredilecta.push({name: 'pre', label: 'PREGUNTAS', field: 'pre', align: 'left', sortable: true})
          for (let i = 0; i <= 25; i++) {
            this.num.push(i)
          }
        }
        this.predilectaGet()
      }
    )
   this.nro=( this.$route.params.id)
    if (this.nro=='nroBano'){
      this.columnsPredilecta=[{name: 'predilecta', label: 'Predilecta', field: 'predilecta', align: 'left', sortable: true}]
      this.columnsPredilecta.push({name: 'bano', label: 'TRAJE DE PRESENTACION', field: 'bano', align: 'left', sortable: true})
      for (let i = 0; i <= 25; i++) {
        this.num.push(i)
      }
    }
    if (this.nro=='nroGala'){
      this.columnsPredilecta=[{name: 'predilecta', label: 'Predilecta', field: 'predilecta', align: 'left', sortable: true}]
      this.columnsPredilecta.push({name: 'gala', label: 'TRAJE DE GALA', field: 'gala', align: 'left', sortable: true})
      for (let i = 0; i <= 25; i++) {
        this.num.push(i)
      }
    }
    if (this.nro=='nroFol'){
      this.columnsPredilecta=[{name: 'predilecta', label: 'Predilecta', field: 'predilecta', align: 'left', sortable: true}]
      this.columnsPredilecta.push({name: 'fol', label: 'TRAJE DE FOLKLORICO', field: 'fol', align: 'left', sortable: true})
      for (let i = 0; i <= 25; i++) {
        this.num.push(i)
      }
    }
    if (this.nro=='nroPre'){
      this.columnsPredilecta=[{name: 'predilecta', label: 'Predilecta', field: 'predilecta', align: 'left', sortable: true}]
      this.columnsPredilecta.push({name: 'pre', label: 'PREGUNTAS', field: 'pre', align: 'left', sortable: true})
      for (let i = 0; i <= 25; i++) {
        this.num.push(i)
      }
    }


    this.predilectaGet()
  },
  methods:{
    showPredilecta(predilecta){
      this.predilecta = predilecta
      this.showUpdateUserDialog = true
    },
    photoCarosel(predilecta){
      this.predilecta = predilecta
      this.showPhotoCarosel = true
    },
    votoUpdate(valor,id,tipo){
      // console.log(model, id)
      console.log(valor,id,tipo)
      // if (valor!='') {
        this.$api.post('voto',{
          tipo:tipo,
          predilecta_id:id,
          puntaje:valor
        }).then(res=>{
          console.log(res.data)
        })
      // }

    },
    refresh(){
      this.predilectaGet()
    },
    total(bano,gala,fol,pre){
      return parseInt(bano==''?0:bano)+parseInt(gala==''?0:gala)+parseInt(fol==''?0:fol)+parseInt(pre==''?0:pre)
    },
    predilectaGet(){
      this.$q.loading.show()
      this.$api.get(`predilectaVotos/${this.nro}`).then((response) => {
        this.predilectas = response.data
        this.$q.loading.hide()
      }).catch((error) => {
        this.$q.loading.hide()
        this.$q.notify({
          color: 'negative',
          message: 'Error al obtener las predilectas',
          icon: 'report_problem'
        })
      })
    }
  }
}
</script>

<style scoped>

</style>
