<template>
<q-page>
  <q-table :rows="predilectas" :columns="predilectaColums" :filter="search" :rows-per-page-options="[20,50,100,0]">
    <template v-slot:top-right>
      <q-toolbar>
        <q-btn label="Crear" no-caps color="primary" icon="add_circle_outline" @click="showAddUserDialog = true;predilecta={};predilectaCrear=true" />
        <q-btn flat icon="refresh" @click="predilectasGet" />
        <q-input v-model="search"  outlined  dense placeholder="Buscar..." />
      </q-toolbar>
    </template>
    <template v-slot:body-cell-nroBano="props">
      <q-td :props="props" auto-width>
        <q-select @update:model-value="nroUpdate($event,props.row.id,'nroBano')" dense outlined v-model="props.row.nroBano" :options="num" />
      </q-td>
    </template>
    <template v-slot:body-cell-nroGala="props">
      <q-td :props="props" auto-width>
        <q-select @update:model-value="nroUpdate($event,props.row.id,'nroGala')" dense outlined v-model="props.row.nroGala" :options="num" />
      </q-td>
    </template>
    <template v-slot:body-cell-nroFol="props">
      <q-td :props="props" auto-width>
        <q-select @update:model-value="nroUpdate($event,props.row.id,'nroFol')" dense outlined v-model="props.row.nroFol" :options="num" />
      </q-td>
    </template>
    <template v-slot:body-cell-nroPre="props">
      <q-td :props="props" auto-width>
        <q-select @update:model-value="nroUpdate($event,props.row.id,'nroPre')" dense outlined v-model="props.row.nroPre" :options="num" />
      </q-td>
    </template>
    <template v-slot:body-cell-fotos="props">
      <q-td :props="props" auto-width @click="photoCarosel(props.row)">
<!--        <a :href="`${url}../imagenes/${props.row.foto1}`" target="_blank">-->
          <q-img :src="`${url}../imagenes/${props.row.foto1}`" style="width: 20px; height: 20px;" />
<!--        </a>-->
        <q-img :src="`${url}../imagenes/${props.row.foto2}`" style="width: 20px; height: 20px;" />
        <q-img :src="`${url}../imagenes/${props.row.foto3}`" style="width: 20px; height: 20px;" />
      </q-td>
    </template>
    <template v-slot:body-cell-nombre="props">
      <q-td :props="props" auto-width >
        <div class="text-bold">{{props.row.nombre}}</div>
        <div class="text-subtitle1">{{props.row.conjunto}}</div>
      </q-td>
    </template>
    <template v-slot:body-cell-option="props">
      <q-td :props="props" auto-width >
        <q-btn flat dense icon="o_edit" @click="predilectaEdit(props.row)" />
        <q-btn flat dense icon="o_delete" @click="predilectaDelete(props.row)" />
        <q-btn flat dense icon="o_photo" @click="predilectaFoto(props.row)" />
      </q-td>
    </template>
  </q-table>
  <q-dialog v-model="showAddUserDialog" >
    <q-card style="width: 700px;max-width: 85vw">
      <q-card-section class="row items-center">
        <div class="text-h6">Agregar Predilecta</div>
      </q-card-section>
      <q-card-section>
        <q-form @submit.prevent="predilectaCreate">
          <q-input v-model="predilecta.nombre" hint="" required outlined label="nombre" />
          <q-input v-model="predilecta.conjunto" hint="" required outlined label="conjunto" />
          <q-input v-model="predilecta.edad" hint="" required outlined label="edad" />
          <q-input v-model="predilecta.profesion" hint="" required outlined label="profesion" />
          <q-input v-model="predilecta.ocupacion" hint="" required outlined label="ocupacion" />
          <q-input v-model="predilecta.estatura" hint="" required outlined label="estatura" />
          <q-input v-model="predilecta.medidas" hint="" required outlined label="medidas" />
          <q-input v-model="predilecta.pasatiempo" hint="" required outlined label="pasatiempo" />
          <q-input v-model="predilecta.color" hint="" required outlined label="color" />
          <q-input v-model="predilecta.deporte" hint="" required outlined label="deporte" />

          <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Guardar" class="full-width" />
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog v-model="showUpdateUserDialog" >
    <q-card style="width: 700px;max-width: 85vw">
      <q-card-section class="row items-center">
        <div class="text-h6">Agregar Predilecta</div>
      </q-card-section>
      <q-card-section>
        <q-form @submit.prevent="predilectaUpdate">
          <q-input v-model="predilecta.nombre" hint="" required outlined label="nombre" />
          <q-input v-model="predilecta.conjunto" hint="" required outlined label="conjunto" />
          <q-input v-model="predilecta.edad" hint="" required outlined label="edad" />
          <q-input v-model="predilecta.profesion" hint="" required outlined label="profesion" />
          <q-input v-model="predilecta.ocupacion" hint="" required outlined label="ocupacion" />
          <q-input v-model="predilecta.estatura" hint="" required outlined label="estatura" />
          <q-input v-model="predilecta.medidas" hint="" required outlined label="medidas" />
          <q-input v-model="predilecta.pasatiempo" hint="" required outlined label="pasatiempo" />
          <q-input v-model="predilecta.color" hint="" required outlined label="color" />
          <q-input v-model="predilecta.deporte" hint="" required outlined label="deporte" />
          <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Guardar" class="full-width" />
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog v-model="photoShow" >
    <q-card style="width: 700px;max-width: 85vw">
      <q-card-section class="row items-center">
        <div class="text-h6">Agregar Predilecta</div>
      </q-card-section>
      <q-card-section>

        <q-form @submit.prevent="predilectaUpdatePhoto">
          <div class="row">
            <div class="col-12 flex-center flex">
              <q-uploader
                accept=".jpg, .png"
                @added="uploadFile1"
                auto-upload
                max-files="1"
                label="Subir foto"
                flat
                max-file-size="5000000"
                @rejected="onRejected"
                bordered
              />
            </div>
            <div class="col-12 flex-center flex">
              <q-uploader
                accept=".jpg, .png"
                @added="uploadFile2"
                auto-upload
                max-files="1"
                label="Subir foto"
                flat
                max-file-size="5000000"
                @rejected="onRejected(3)"
                bordered
              />
            </div>
            <div class="col-12 flex-center flex">
              <q-uploader
                accept=".jpg, .png"
                @added="uploadFile3"
                auto-upload
                max-files="1"
                label="Subir foto"
                flat
                max-file-size="5000000"
                @rejected="onRejected"
                bordered
              />
            </div>
          </div>

          <q-btn :loading="loading" type="submit" color="primary" icon="add_circle_outline" label="Guardar" class="full-width" />
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog full-width full-height v-model="showPhotoCarosel" >
    <q-card >
      <q-card-section class="row items-center">
        <div class="text-h6">Fotos {{predilecta.nombre}}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
      <q-card-section>

        <q-carousel
          style="border: 0px solid #000;height: 80vh;"
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
      num: [],
      slide: 1,
      roles: [
        'INSCRIPCION',
        'ACREDITACION',
        'REFRIGERIO',
        'ADMINISTRADOR',
      ],
      showPhotoCarosel: false,
      url:process.env.API,
      showAddUserDialog: false,
      showUpdateUserDialog: false,
      search: '',
      predilectas: [],
      predilecta:{},
      foto1:'',
      foto2:'',
      foto3:'',
      loading: false,
      photoShow: false,
      predilectaCrear: true,
      predilectaColums:[
        {name: 'option', field: 'option', label: 'Opciones', align: 'left', sortable: true},
        {name: 'nombre', field: 'nombre', label: 'Nombre', align: 'left', sortable: true},
        {name: 'nroBano', field: 'nroBano', label: 'N° Baño', align: 'left', sortable: true},
        {name: 'nroGala', field: 'nroGala', label: 'N° Gala', align: 'left', sortable: true},
        {name: 'nroFol', field: 'nroFol', label: 'N° Folklorico', align: 'left', sortable: true},
        {name: 'nroPre', field: 'nroPre', label: 'N° Pregunta', align: 'left', sortable: true},
        // {name: 'conjunto', field: 'conjunto', label: 'Conjunto', align: 'left', sortable: true},
        {name: 'edad', field: 'edad', label: 'Edad', align: 'left', sortable: true},
        {name: 'fotos', field: 'fotos', label: 'fotos', align: 'left', sortable: true},
        {name: 'profesion', field: 'profesion', label: 'Profesion', align: 'left', sortable: true},
        {name: 'ocupacion', field: 'ocupacion', label: 'Ocupacion', align: 'left', sortable: true},
        {name: 'estatura', field: 'estatura', label: 'Estatura', align: 'left', sortable: true},
        {name: 'medidas', field: 'medidas', label: 'Medidas', align: 'left', sortable: true},
        {name: 'pasatiempo', field: 'pasatiempo', label: 'Pasatiempo', align: 'left', sortable: true},
        {name: 'color', field: 'color', label: 'Color', align: 'left', sortable: true},
        {name: 'deporte', field: 'deporte', label: 'Deporte', align: 'left', sortable: true},
      ]
    }
  },
  methods:{
    nroUpdate(num, id, nro){

      if (nro == 'nroBano'){
        this.$api.put(`predilecta/${id}`, {nroBano: num}).then(res=>console.log(res.data))
      }
      if (nro == 'nroGala'){
        this.$api.put(`predilecta/${id}`, {nroGala: num}).then(res=>console.log(res.data))
      }
      if (nro == 'nroFol'){
        this.$api.put(`predilecta/${id}`, {nroFol: num}).then(res=>console.log(res.data))
      }
      if (nro == 'nroPre'){
        this.$api.put(`predilecta/${id}`, {nroPre: num}).then(res=>console.log(res.data))
      }

    },
    onRejected (rejectedEntries) {
      this.$q.notify({
        type: 'negative',
        message: `${rejectedEntries.length} el archivo paso las restricciones de validación`
      })
    },
    uploadFile1 (file) {
      this.loading=true
      let dialog = this.$q.dialog({
        message: 'Subiendo... 0%',
      })
      let percentage = 0
      const fd = new FormData()
      fd.append('file', file[0])
      return new Promise((resolve, reject) => {
        this.$api.post('upload',
          fd,
          {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (progressEvent) => {
              percentage = Math.round((progressEvent.loaded / progressEvent.total) * 100)
              dialog.update({
                message: `Subiendo... ${percentage}%`
              })
              if (percentage>=100){
                dialog.hide()
              }
            }
          })
          .then(res => {
            this.foto1=res.data
            this.loading=false
            resolve(file)
          })
          .catch(err => reject(err))
      })
    },
    uploadFile2 (file) {
      this.loading=true
      let dialog = this.$q.dialog({
        message: 'Subiendo... 0%',
      })
      let percentage = 0
      const fd = new FormData()
      fd.append('file', file[0])
      return new Promise((resolve, reject) => {
        this.$api.post('upload',
          fd,
          {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (progressEvent) => {
              percentage = Math.round((progressEvent.loaded / progressEvent.total) * 100)
              dialog.update({
                message: `Subiendo... ${percentage}%`
              })
              if (percentage>=100){
                dialog.hide()
              }
            }
          })
          .then(res => {
            this.foto2=res.data
            this.loading=false
            resolve(file)
          })
          .catch(err => reject(err))
      })
    },
    uploadFile3 (file) {
      this.loading=true
      let dialog = this.$q.dialog({
        message: 'Subiendo... 0%',
      })
      let percentage = 0
      const fd = new FormData()
      fd.append('file', file[0])
      return new Promise((resolve, reject) => {
        this.$api.post('upload',
          fd,
          {
            headers: { 'Content-Type': 'multipart/form-data' },
            onUploadProgress: (progressEvent) => {
              percentage = Math.round((progressEvent.loaded / progressEvent.total) * 100)
              dialog.update({
                message: `Subiendo... ${percentage}%`
              })
              if (percentage>=100){
                dialog.hide()
              }
            }
          })
          .then(res => {
            this.foto3=res.data
            this.loading=false
            resolve(file)
          })
          .catch(err => reject(err))
      })
    },
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
          message: 'Predilecta actualizado'
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
    predilectaUpdatePhoto(){
      this.loading = true
      this.predilecta.foto1 = this.foto1
      this.predilecta.foto2 = this.foto2
      this.predilecta.foto3 = this.foto3
      this.$api.put(`predilecta/${this.predilecta.id}`,this.predilecta)
        .then(res=>{
          this.loading = false
          this.photoShow = false
          this.$q.notify({
            color: 'green-4',
            textColor: 'white',
            icon: 'check_circle',
            message: 'Predilecta actualizado'
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
    photoCarosel(predilecta){
      this.predilecta = predilecta
      this.showPhotoCarosel = true
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
    predilectaFoto(predilecta){
      this.foto1 = ''
      this.foto2 = ''
      this.foto3 = ''
      this.predilecta = predilecta
      this.photoShow= true
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
    for (let i = 1; i <= 100; i++) {
      this.num.push(i)
    }
  }
}
</script>

<style scoped>

</style>
