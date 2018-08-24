import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: `${process.env.API_BASE_URL}`
})

function getCookie (name) {
  var re = new RegExp(name + '=([^;]+)')
  var value = re.exec(document.cookie)

  if (value != null) {
    console.log(value)
    // var decodedToken = JSON.parse(window.atob(value[1]))
    // console.log(decodedToken)
  }
  return (value != null) ? unescape(value[1]) : null
}

export default ({ Vue }) => {
  // for use inside Vue files through this.$axios
  axiosInstance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
  axiosInstance.defaults.headers.common['Content-Type'] = 'application/json'
  let token = document.head.querySelector('meta[name="csrf-token"]')
  let accessToken = getCookie('token')

  if (token) {
    axiosInstance.defaults.headers.common['X-CSRF-TOKEN'] = token.content
    axiosInstance.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`
  }

  Vue.prototype.$axios = axiosInstance
}

export { axiosInstance }
