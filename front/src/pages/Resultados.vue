<template>
<q-page>
  <q-card>
    <q-card-section>
      <q-table :rows="resultados" :columns="resultadoColumns">
        <template v-slot:top-right>
          <q-btn flat icon="refresh" @click="resultadosGet" />
        </template>
        <template v-slot:body-cell-predilecta="props">
          <q-td :props="props" auto-width>
            <q-item class="q-pa-none q-ma-none">
              <q-item-section class="q-pa-none q-ma-none">
                <div class="text-bold " style="width: 150px; white-space: normal;" >
                  {{ props.pageIndex+1 }}.-
                  {{props.row.nombre}}
                </div>
                <div class="text-grey-8" style="width: 150px; white-space: normal;">{{props.row.conjunto}}</div>
              </q-item-section>
            </q-item>
          </q-td>
        </template>
      </q-table>
    </q-card-section>
  </q-card>
</q-page>
</template>

<script>
export default {
  name: `Resultados`,
  data() {
    return {
      resultados: [],
      users: [],
      resultadoColumns: [
        {name: 'predilecta', label: 'Predilecta', field: 'predilecta', align: 'left', sortable: true},

      ]
    };
  },
  created() {
    this.$api.get('user').then((response) => {
      let con=0;
      response.data.forEach((user) => {
        if (user.tipo=='jurado') {
          con++;
          this.resultadoColumns.push({
            name: 'bano'+(con),
            label: 'bano'+(con),
            field: 'bano'+(con),
            align: 'left',
            sortable: true
          });
          this.resultadoColumns.push({
            name: 'gala'+(con),
            label: 'gala'+(con),
            field: 'gala'+(con),
            align: 'left',
            sortable: true
          });
          this.resultadoColumns.push({
            name: 'fol'+(con),
            label: 'fol'+(con),
            field: 'fol'+(con),
            align: 'left',
            sortable: true
          });
          this.resultadoColumns.push({
            name: 'pre'+(con),
            label: 'pre'+(con),
            field: 'pre'+(con),
            align: 'left',
            sortable: true
          });
        }
      });
      this.resultadoColumns.push({
        name: 'total',
        label: 'total',
        field: 'total',
        align: 'left',
        sortable: true
      });
    });
    this.resultadosGet()
  },
  methods: {
    resultadosGet() {
      this.$q.loading.show();
      this.$api.get(`resultados`)
        .then((response) => {
          this.$q.loading.hide();
          this.resultados = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    },
  },
}
</script>

<style scoped>

</style>
