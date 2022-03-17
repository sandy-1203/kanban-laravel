/* eslint-disable no-unused-expressions */
/* eslint-disable prefer-promise-reject-errors */
/* eslint-disable no-param-reassign */

import axios from 'axios'
import { TOKEN_KEY } from './jwt.plugin'

const { CancelToken } = axios
const requestQueue = {}

export default {
  install: Vue => {
    const errorOptions = {
      variant: 'danger',
      title: 'Error',
      icon: 'lock',
    }
    const successOptions = {
      variant: 'success',
      title: 'Success',
      icon: 'circle-check',
    }

    const apiService = axios.create({
      baseURL: `${import.meta.env.VITE_BASE_URL}/api`,
    })

    apiService.interceptors.request.use(
      config => {
        const { cancelToken } = config
        if (cancelToken) {
          // cancel previous request and delete from queue
          if (requestQueue[cancelToken]) {
            const source = requestQueue[cancelToken]
            delete requestQueue[cancelToken]
            source.cancel()
          }

          // add current request in queue
          const source = CancelToken.source()
          config.cancelToken = source.token
          requestQueue[cancelToken] = source
        }

        // change some global axios configurations
        // add accessToken header before sending api
        const accessToken = localStorage.getItem(TOKEN_KEY)
        config.headers.common.Authorization = `Bearer ${accessToken}`
        return config
      },
      error =>
        // handle error from sending api requests
        // eslint-disable-next-line implicit-arrow-linebreak
        Promise.reject(error),
    )

    apiService.interceptors.response.use(
      response => {
        const { cancelToken } = response.config
        if (cancelToken) {
          // delete request from queue
          delete requestQueue[response.config.cancelToken]
        }

        const exts = {
          csv: 'text/csv',
          xlsx: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
          pdf: 'application/pdf',
          txt: 'text/plain',
        }
        if (Object.values(exts).includes(response.headers['content-type'].split(';')[0])) {
          let fileName = response.headers['content-disposition'].split(';')[1].split('=')[1]
          if (fileName.includes('"')) {
            fileName = JSON.parse(fileName)
          }
          const url = URL.createObjectURL(
            new Blob([response.data], {
              type: response.headers['content-type'],
            }),
          )
          const link = document.createElement('a')
          link.href = url
          link.setAttribute('download', fileName)
          document.body.appendChild(link)
          link.click()
          response.config.downloaded = true
        }
        return response
      },
      error => {
        const _vm = document.getElementById('app')?.__vue__
        const { response } = error
        if (axios.isCancel(error)) {
          return Promise.reject({ cancelled: true })
        }
        const { cancelToken } = response.config
        if (cancelToken) {
          // delete request from queue
          delete requestQueue[response.config.cancelToken]
        }

        if (error?.response?.status === 401) {
          _vm?.$store.commit('auth/purgeAuth')
          _vm?.$router.push({
            name: 'auth-login',
          })
          _vm?.$toast(errorOptions, 'Your session is expired!. Please start new session to countinue.')
        } else if (error?.response?.status === 403) {
          _vm?.$toast(errorOptions, error?.response?.data?.message || 'Something went wrong!.')
        }
        return Promise.reject(error)
      },
    )

    Vue.prototype.$api = apiService
    Vue.prototype.$apiHandler = {
      apiResponseHandler: (error, options = {}, form = null) => {
        const _vm = document.getElementById('app')?.__vue__
        if (error?.cancelled) return
        const toast =
          typeof options.toast === 'function'
            ? options.toast(error)
            : options.toast || {
                variant: 'danger',
                title: 'Error',
                icon: 'lock',
                text: error?.response?.data?.message || 'Something went wrong!.',
              }

        _vm.$toast(toast, toast.text)
        if (form && error.response?.status === 422) {
          form.setErrors(error?.response?.data?.errors || {})
        }
      },

      apiResponseWrapper: async (cb, form = null, show = true) => {
        const _vm = document.getElementById('app')?.__vue__
        try {
          const res = await cb()
          if (show) {
            _vm.$toast(successOptions, res?.message)
          }
          return res
        } catch (err) {
          if (err?.cancelled || !show) return
          _vm.$toast(errorOptions, err?.response?.data?.message || 'Something went wrong!.')
          if (form && err.response?.status === 422) {
            form.setErrors(err?.response?.data?.errors || {})
          }
        }
      },
    }
  },
}
