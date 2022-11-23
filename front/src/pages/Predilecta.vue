<template>
<q-page>
  <q-table :rows="predilectas" :columns="predilectaColums" :filter="search">
    <template v-slot:top-right>
      <q-toolbar>
        <q-btn flat icon="add_circle_outline" @click="showAddUserDialog = true;predilectaCrear=true" />
        <q-input v-model="search"  outlined  dense placeholder="Buscar..." />
      </q-toolbar>
    </template>
    <template v-slot:body-cell-tipo="props">
      <q-td :props="props" auto-width >
        <q-badge dense text-color="white" :color="props.row.tipo=='admin'?'red':'green'">{{props.row.tipo}}</q-badge>
      </q-td>
    </template>
    <template v-slot:body-cell-option="props">
      <q-td :props="props" auto-width >
        <q-btn flat dense icon="o_edit" @click="predilectaEdit(props.row)" />
        <q-btn flat dense v-if="props.row.id!=1" icon="o_delete" @click="predilectaDelete(props.row)" />
        <q-btn flat dense v-if="props.row.id!=1" icon="o_key" @click="updatePassword(props.row)" />
      </q-td>
    </template>
  </q-table>
  <q-dialog v-model="showAddUserDialog" >
    <q-card style="width: 700px;max-width: 85vw">
      <q-card-section class="row items-center">
        <div class="text-h6">Agregar Usuario</div>
      </q-card-section>
      <q-card-section>
        <q-form @submit.prevent="predilectaCreate">
          <q-input v-model="predilecta.name" hint="" required outlined label="Nombre" />
          <q-input v-model="predilecta.email" hint="" required outlined label="Email" />
          <q-input v-model="predilecta.password" type="password" hint="" required outlined label="Password" />
          <q-select v-model="predilecta.tipo" hint="" required outlined label="Tipo" :options="['admin','jurado']" />
          <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Guardar" class="full-width" />
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog v-model="showUpdateUserDialog" >
    <q-card style="width: 700px;max-width: 85vw">
      <q-card-section class="row items-center">
        <div class="text-h6">Agregar Usuario</div>
      </q-card-section>
      <q-card-section>
        <q-form @submit.prevent="predilectaUpdate">
          <q-input v-model="predilecta.name" hint="" required outlined label="Nombre" />
          <q-input v-model="predilecta.email" hint="" required outlined label="Email" />
          <q-select v-model="predilecta.tipo" hint="" required outlined label="Tipo" :options="['admin','jurado']" />
          <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Guardar" class="full-width" />
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</q-page>
</template>

<script>
export default {
  name: `Predilecta`,
  data () {
    return {
      roles: [
        'INSCRIPCION',
        'ACREDITACION',
        'REFRIGERIO',
        'ADMINISTRADOR',
      ],
      showAddUserDialog: false,
      showUpdateUserDialog: false,
      search: '',
      predilectas: [],
      predilecta:{},
      loading: false,
      predilectaCrear: true,
      predilectaColums:[
        {name: 'option', field: 'option', label: 'Opciones', align: 'left', sortable: true},
        {name: 'tipo', field: 'tipo', label: 'Tipo', align: 'left', sortable: true},
        {name: 'id', label: 'ID', field: 'id', align: 'left', sortable: true},
        {name: 'name', label: 'Nombre', field: 'name', align: 'left', sortable: true},
        {name: 'email', label: 'Email', field: 'email', align: 'left', sortable: true},
      ]
    }
  },
  methods:{
    predilectaUpdate(){
      this.loading = true
      this.$api.put(`predilecta/${this.predilecta.id}`,this.predilecta)
      .then(res=>{
        this.loading = false
        this.showUpdateUserDialog = false
        this.$q.notify({
          color: 'green-4',
          textColor: 'white',
          icon: 'check_circle',
          message: 'Usuario actualizado'
        })
        this.predilecta = {}
        this.predilectasGet()
      })
      .catch(err=>{
        this.loading = false
        this.$q.notify({
          color: 'red-4',
          textColor: 'white',
          icon: 'error',
          message: 'Error al actualizar predilecta'
        })
      })
    },
    predilectasGet(){
      this.$q.loading.show()
      this.$api.get('predilecta').then(response => {
        this.predilectas = response.data
        this.$q.loading.hide()
      })
    },
    predilectaCreate(){

      if (this.predilectaCrear){
        this.loading = true
        this.$api.post('predilecta', this.predilecta).then(response => {
          this.predilectasGet()
          this.showAddUserDialog = false
          this.predilecta = {}
          this.loading = false
        }).catch(error => {
          this.loading = false
          this.$q.notify({
            color: 'negative',
            message: error.response.data.message,
            icon: 'report_problem',
            position: 'top'
          })
        })
      }else{
        this.loading = true
        this.$api.put('predilecta/'+this.predilecta.id, this.predilecta).then(response => {
          this.predilectasGet()
          this.showAddUserDialog = false
          this.predilecta = {}
          this.loading = false
        }).catch(error => {
          this.loading = false
          this.$q.notify({
            color: 'negative',
            message: error.response.data.message,
            icon: 'report_problem',
            position: 'top'
          })
        })
      }


    },
    predilectaEdit(predilecta){
      this.predilecta = predilecta
      this.predilectaCrear = false
      this.showUpdateUserDialog = true
    },
    updatePassword(predilecta){
      this.$q.dialog({
        title: 'Cambiar contraseña',
        message: 'Ingrese la nueva contraseña',
        prompt: {
          model: '',
          type: 'password'
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        this.$api.put(`updatePassword/${predilecta.id}`,{password:data})
        .then(res=>{
          this.$q.notify({
            color: 'green-4',
            textColor: 'white',
            icon: 'check_circle',
            position: 'top',
            message: 'Contraseña actualizada'
          })
        })
        .catch(err=>{
          this.$q.notify({
            color: 'red-4',
            textColor: 'white',
            icon: 'error',
            position: 'top',
            message: err.response.data.message
          })
        })
      }).onCancel(() => {
        console.log('Cancel')
      }).onDismiss(() => {
        console.log('Dismissed')
      })
    },
    predilectaDelete(predilecta){
      this.$q.dialog({
        title: 'Eliminar',
        message: '¿Está seguro de eliminar el predilecta?',
        ok: 'Si',
        cancel: 'No'
      }).onOk(() => {
        this.$q.loading.show()
        this.$api.delete('predilecta/'+predilecta.id).then(response => {
          this.predilectasGet()
        })
      })
    }
  },
  created() {
    this.predilectasGet()
  }
}
</script>

<style scoped>

</style>
