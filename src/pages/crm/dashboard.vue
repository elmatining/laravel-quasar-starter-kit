<template>
  <q-page padding>
    <p class="caption">Dashboard</p>

  </q-page>
</template>

<script>
import { axiosInstance } from '../../plugins/axios'

export default {
  name: 'index',
  methods: {
    logout () {
      return axiosInstance.get('/auth/logout')
    },
    isAuth () {
      return axiosInstance.get('/auth')
        .then((response) => {
          console.log(response.data)
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
}
</script>

<style scoped></style>
