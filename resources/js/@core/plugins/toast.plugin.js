import DefaultToastTitle from '@/@core/components/toasts/DefaultToastTitle.vue'

const defaultOptions = {
  toaster: 'b-toaster-top-right',
  variant: 'default',
  titleTemplate: DefaultToastTitle,
}

const parseTemplate = (Template, props = {}) => {
  const _vm = document.getElementById('app')?.__vue__
  if (Template?.constructor?.name == 'Object')
    return _vm.$createElement(Template, {
      props,
    })
  else if (Template?.constructor?.name == 'VNode2') return [Template]
  return Template
}

export default {
  install(Vue, toastOptions = {}) {
    import('bootstrap-vue/dist/bootstrap-vue.css')

    Vue.prototype.$toast = (options, Body) => {
      const _vm = document.getElementById('app')?.__vue__
      const props = { ...defaultOptions, ...toastOptions, ...options }
      _vm.$bvToast.toast(parseTemplate(Body, props), {
        ...props,
        ...(defaultOptions.titleTemplate ? { title: parseTemplate(defaultOptions.titleTemplate, props) } : {}),
        ...(toastOptions.titleTemplate ? { title: parseTemplate(toastOptions.titleTemplate, props) } : {}),
        ...(options.titleTemplate ? { title: parseTemplate(options.titleTemplate, props) } : {}),
      })
    }
  },
}
