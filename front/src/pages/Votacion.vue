<template>
<q-page>
  <q-card>
    <q-card-section>
      <div class="row">
        <div class="col-12">
          <q-table :rows="predilectas" :filter="filter" :columns="columnsPredilecta">
            <template v-slot:top-right>
              <q-btn flat icon="refresh" @click="refresh" />
              <q-input v-model="filter"  outlined  dense placeholder="Buscar..." />
            </template>
            <template v-slot:body-cell-predilecta="props">
              <q-td :props="props">
                <div class="text-bold">{{props.row.nombre}}</div>
                <div class="text-grey-8">{{props.row.conjunto}}</div>
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
</q-page>
</template>

<script>
export default {
  name: `Votacion`,
  data() {
    return {
      columnsPredilecta:[
        {name: 'predilecta', label: 'Predilecta', field: 'predilecta', align: 'left', sortable: true},
        {name: 'bano', label: 'TRAJE DE BAÑO', field: 'bano', align: 'left', sortable: true},
        {name: 'gala', label: 'TRAJE DE GALA', field: 'gala', align: 'left', sortable: true},
        {name: 'fol', label: 'TRAJE DE FOLKLORICO', field: 'fol', align: 'left', sortable: true},
        {name: 'pre', label: 'PREGUNTAS', field: 'pre', align: 'left', sortable: true},
        {name: 'total', label: 'TOTAL', field: 'total', align: 'left', sortable: true},
      ],
      num:[''],
      filter: '',
      loading:false,
      predilectas:[],
      predilecta:{}
    }
  },
  created() {
    for (let i = 0; i < 100; i++) {
      this.num.push(i)
    }
    this.predilectaGet()
  },
  methods:{
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
      this.$api.get(`predilectaVotos`).then((response) => {
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
