<template>
  <div class="index-page bg-grey-2 window-height window-width column items-center no-wrap">
    <div class="banner bg-lime-8 flex flex-center" :class="$q.screen.lt.sm ? 'q-display-3': 'q-display-4'">
      gaztronaut
    </div>
    <div class="text-center">
      <div class="card bg-white shadow-4 column no-wrap flex-center group">
        <div class="q-ml-md">
          <div class="q-mb-xs text-lime-9" :class="{'q-title': $q.screen.gt.sm}"><span class="text-weight-bolder">gaZtronaut CRM</span> v1.0</div>
          <div class="caption" style="line-height: 18px" v-if="env() === 'development'">{{env()}} environment</div>
        </div>
        <br>
        <q-btn
                color="light-blue-10"
                class="full-width"
                type="a"
                :loading="loading"
                @click="fbLogin"
                no-ripple
                no-caps
                label="Login with Facebook"
        />

        <q-btn
                color="lime-9"
                class="full-width"
                type="a"
                href="https://gaztronaut.com"
                target="_blank"
                icon="home"
                no-ripple
                no-caps
                label="gaZtronaut.com"
        />
      </div>
    </div>
    <a class="ribbon" :title="`CRM v1.0 in ${env()}`">&nbsp;</a>
  </div>
</template>

<script>
import { axiosInstance } from 'plugins/axios'

export default {
  name: 'PageIndex',
  data () {
    return {
      color: 'primary',
      response: '',
      loading: false
    }
  },

  methods: {
    env () {
      return `${process.env.NODE_ENV}`
    },
    fbLogin () {
      this.$fb.getLoginStatus((response) => {
        if (response.status === 'connected') {
          console.log(response.authResponse.accessToken)
          this.loginSocial('facebook', response.authResponse.accessToken)
        } else {
          this.$fb.login((response) => {
            this.loginSocial('facebook', response.authResponse.accessToken)
          })
        }
      })
    },
    async isAuthenticated () {
      let response
      let color = 'negative'
      this.loading = true
      try {
        response = ''
        let req = await fetch('/api/api/auth')
        if (!req.ok) throw new Error('error request')
        let {data} = await req.json()
        response = data
        color = 'positive'
      } catch (err) {
        console.log(err)
        response = err.message
      }
      setTimeout(() => {
        this.response = response
        this.color = color
        this.loading = false
      }, 700)
    },
    loginSocial (social, token) {
      this.loading = true
      axiosInstance.defaults.headers.common['X-Authorization'] = token
      return axiosInstance.get(`/auth/login/social/${social}`)
        .then((response) => {
          this.authUser(response.headers.authorization)
        })
    },
    authUser (token) {
      axiosInstance.defaults.headers.common['Authorization'] = token
      return axiosInstance.get('/auth/user')
        .then((response) => {
          if (response.data.user) {
            this.$store.commit('auth/setUser', response.data.user)
            this.$router.push('/crm')
          }
        })
        .catch(() => {
          this.$store.commit('crm/updateAuthUser', {})
        })
    }
  }
}
</script>

<style lang="stylus">
.index-page
  .banner
    height 50vh
    width 100%
    /*font-size 20vmax*/
    color rgba(255, 255, 255, .2)
    overflow hidden
  .card
    width 80vw
    max-width 500px
    padding 10px 25px
    margin-top -90px
    border-radius 2px
    img
     height 140px
     width 140px

.ribbon
  width 14.1em
  height 14.1em
  position absolute
  overflow hidden
  top 0
  right 0
  z-index 39
  pointer-events none
  font-size 15px
  text-decoration none
  text-indent -999999px
  opacity 0.7
  &.fixed
    position fixed
  &:before
    content ''
    padding .38em 0
    background-color white
    background-image linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, .15))
    box-shadow 0 .15em .23em 0 rgba(0, 0, 0, .5)
    pointer-events auto
  &:after
    content attr(title)
    color #757575
    line-height 1.54em
    text-decoration none
    text-align center
    text-indent 0
    padding .15em 0
    margin .15em 0

  &:before, &:after
    position absolute
    display block
    width 23.38em
    height 1.74em
    top 4.8em
    right -5.8em
    transform rotate(45deg)
</style>
