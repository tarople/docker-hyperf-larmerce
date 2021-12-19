import config from '../config'
import Auth from '../auth'

var axios = require('axios')
// 接口地址
var apiHost = config.apiHost
/**
 * 判断元素类型
 * @param obj
 * @returns {string}
 */
function toType (obj) {
  return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase()
}

/**
 * 参数过滤
 * @param o
 * @returns {*}
 */
function filterNull (o) {
  for (var key in o) {
    if (o[key] === null) {
      delete o[key]
    }
    if (toType(o[key]) === 'string') {
      o[key] = o[key].trim()
    } else if (toType(o[key]) === 'object') {
      o[key] = filterNull(o[key])
    } else if (toType(o[key]) === 'array') {
      o[key] = filterNull(o[key])
    }
  }
  return o
}

/**
 * 接口请求
 * @param method
 * @param url
 * @param params
 * @param handler 处理返回结果的方法
 * @param errorHandler 处理异常的方法
 */
function apiAxios (method, url, params, handler, errorHandler) {
  if (params) {
    params = filterNull(params)
  }

  axios({
    method: method,
    url: url,
    data: method === 'POST' || method === 'PUT' ? params : null,
    params: method === 'GET' || method === 'DELETE' ? params : null,
    baseURL: apiHost,
    withCredentials: false,
    headers: {
      'Authorization': 'Bearer ' + Auth.getToken()
    }
  }).then(function (res) {
    // token无效时跳转登录界面
    if (res.data.code === -1) {
      Auth.removeToken()
      document.location.href = '#/login'
      return
    }

    if (handler) {
      handler(res.data)
    }
  }).catch(function (err) {    
    if (errorHandler) {
      errorHandler(err)
    }    
  })
}

export default {
  get: function (url, params, handler, errorHandler) {
    return apiAxios('GET', url, params, handler, errorHandler)
  },
  post: function (url, params, handler, errorHandler) {
    return apiAxios('POST', url, params, handler, errorHandler)
  },
  put: function (url, params, handler, errorHandler) {
    return apiAxios('PUT', url, params, handler, errorHandler)
  },
  delete: function (url, params, handler, errorHandler) {
    return apiAxios('DELETE', url, params, handler, errorHandler)
  }
}
