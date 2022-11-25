<template>
  <q-page class="">
    <div class="row">
      <div class="col-6 col-md-3 flex flex-center">
        <q-btn to="/votacion/nroBano" color="primary" label="traje de casual" />
      </div>
      <div class="col-6 col-md-3 flex flex-center">
        <q-btn to="/votacion/nroGala" color="primary" label="traje de gala" />
      </div>
      <div class="col-6 col-md-3 flex flex-center">
        <q-btn to="/votacion/nroFOl" color="primary" label="traje de folclorico" />
      </div>
<!--      <div class="col-6 col-md-3 flex flex-center">-->
<!--        <q-btn to="/votacion/nroPre" color="primary" label="preguntas" />-->
<!--      </div>-->
    </div>
  </q-page>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'IndexPage'
})
</script>
