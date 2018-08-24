<template>
  <q-page padding>
    <p class="caption">Dashboard</p>

    <q-btn color="primary" @click="isAuth">
      make an api request
    </q-btn>

    <q-btn color="primary" @click="logout">
      log out
    </q-btn>

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
