
const tokenKey = '_token'

export default {
  getToken: function () {
    return window.localStorage.getItem(tokenKey)
  },
  setToken: function (token) {
    window.localStorage.setItem(tokenKey, token)
  },
  removeToken: function () {
    window.localStorage.setItem(tokenKey, null)
  },
}