<template>
<q-page>
  <q-card>
    <q-card-section>
      <q-table :rows="resultados" :columns="resultadoColumns" :rows-per-page-options="[0]">
        <template v-slot:top-right>
          <q-btn label="Exportar" @click="exportar" color="green" icon="file_download" />
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
import xlsx from "json-as-xlsx"
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
            label: 'BañoJ'+(con),
            field: 'bano'+(con),
            align: 'left',
            sortable: true
          });
          this.resultadoColumns.push({
            name: 'gala'+(con),
            label: 'GalaJ'+(con),
            field: 'gala'+(con),
            align: 'left',
            sortable: true
          });
          this.resultadoColumns.push({
            name: 'fol'+(con),
            label: 'FolkJ'+(con),
            field: 'fol'+(con),
            align: 'left',
            sortable: true
          });
          this.resultadoColumns.push({
            name: 'pre'+(con),
            label: 'Preg'+(con),
            field: 'pre'+(con),
            align: 'left',
            sortable: true
          });
        }
      });
      // this.resultadoColumns.push({
      //   name: 'asistencia',
      //   label: 'Asistencia 20Pts',
      //   field: 'asistencia',
      //   align: 'left',
      //   sortable: true
      // });
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
    exportar(){
      let columns=[];
      this.resultadoColumns.forEach((column)=>{
        columns.push({ label: column.label, value: column.name })
      });


      let data = [
        {
          sheet: "Adults",
          columns: columns,
          content: this.resultados
        },
      ]

      let settings = {
        fileName: "MySpreadsheet", // Name of the resulting spreadsheet
        writeMode: 'writeFile', // The available parameters are 'WriteFile' and 'write'. This setting is optional. Useful in such cases https://docs.sheetjs.com/docs/solutions/output#example-remote-file
        writeOptions: {}, // Style options from https://github.com/SheetJS/sheetjs#writing-options
        // RTL: true, // Display the columns from right-to-left (the default value is false)
      }

      xlsx(data, settings) // Will download the excel file
    },
    resultadosGet() {
      this.$q.loading.show();
      this.$api.get(`resultados`)
        .then((response) => {
          this.resultados = [];
          response.data.forEach((resultado) => {
            resultado.predilecta = resultado.nombre;
            this.resultados.push(resultado);
          });
          this.$q.loading.hide();
          // this.resultados = response.data
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
