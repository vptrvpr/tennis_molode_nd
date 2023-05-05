<template>
  <v-card shaped class="mx-auto vue__page_file_links w-100">
    <div class="p-3">
      <h4 class="text-center">Новый файл</h4>
      <div class="pl-5 pr-5">
        <v-text-field :color="$blue" label="Имя" v-model="newFileLink.name" name="name"/>
      </div>
      <div class="pl-5 pr-5">
        <v-file-input :color="$blue" label="Файл" v-model="newFileLink.file" name="file"/>
      </div>
      <div class="pl-5 pr-5">
        <v-btn :color="$blue" @click="createFileLink">Создать</v-btn>
      </div>
    </div>

    <div class="p-3 mt-2">
      <v-simple-table>
        <template v-slot:default>
          <thead>
          <tr>
            <th>Id</th>
            <th>Имя</th>
            <th>Файл</th>
            <th>Управление</th>
          </tr>
          </thead>
          <tbody class="p-2" v-for="fileLink in fileLinks">
          <td>{{ fileLink.id }}</td>
          <td>{{ fileLink.name }}</td>
          <td><a target="_blank" :href="'/storage/file-links/'+fileLink.file">{{ fileLink.name }}</a></td>
          <td>
            <v-btn :color="$red" @click="deleteFileLink(fileLink.id)">Удалить</v-btn>
          </td>
          </tbody>
        </template>
      </v-simple-table>
    </div>

  </v-card>
</template>

<script>
import axios from 'axios'


function initialState () {
  return {
    newFileLink: {
      file: null,
      name: '',
    },
    fileLinks: []
  }
}

export default {
  name: 'FileLinks',
  // middleware: [ 'admin', 'auth' ],
  data () {
    return initialState()
  },
  mounted () {
    this.getFileLink()
  },
  methods: {
    async createFileLink () {
      let formData = new FormData()
      formData.append('file', this.newFileLink.file)
      formData.append('json', JSON.stringify(this.newFileLink))

      const { data } = await axios({
        method: 'POST',
        url: '/api/admin/file-links/store/',
        data: formData,
      })

      this.getFileLink()

    },

    async getFileLink () {
      const { data } = await axios({
        method: 'get',
        url: '/api/admin/file-links',
      })

      this.fileLinks = data
    },

    async deleteFileLink (id) {
      const { data } = await axios({
        method: 'post',
        url: '/api/admin/file-links/delete/' + id,
      })

      this.getFileLink()
    },
  }
}
</script>

<style scoped>

</style>
