<template>
  <div class="login-box">
    <div class="login-logo">
      <router-link :to="{}"><b>Admin</b>LTE</router-link>
    </div>
    <b-card>
      <b-card-body class="login-card-body p-1">
        <p class="login-box-msg">Sign in to start your session</p>
        <validation-observer ref="signInForm" v-slot="{ handleSubmit, invalid }">
          <b-form @submit.prevent="handleSubmit(onSubmit)">
            <validation-provider rules="required|email" name="Email" vid="email" v-slot="{ errors }">
              <b-form-group class="mb-3" :state="!errors.length" :invalid-feedback="errors[0]">
                <b-input-group>
                  <template #append>
                    <b-input-group-text>
                      <font-awesome-icon icon="envelope" />
                    </b-input-group-text>
                  </template>
                  <b-form-input v-model="form.email" placeholder="Email" :class="{ 'is-invalid': errors.length }" autocomplete="username" />
                </b-input-group>
              </b-form-group>
            </validation-provider>
            <validation-provider rules="required" name="Password" vid="password" v-slot="{ errors }">
              <b-form-group class="mb-3" :state="!errors.length" :invalid-feedback="errors[0]">
                <b-input-group>
                  <template #append>
                    <b-input-group-text>
                      <font-awesome-icon icon="lock" />
                    </b-input-group-text>
                  </template>
                  <b-form-input
                    v-model="form.password"
                    type="password"
                    placeholder="Password"
                    :class="{ 'is-invalid': errors.length }"
                    autocomplete="password"
                  />
                </b-input-group>
              </b-form-group>
            </validation-provider>
            <div class="row">
              <div class="col">
                <b-button type="submit" block variant="primary" :disabled="invalid">Sign In</b-button>
              </div>
            </div>
          </b-form>
        </validation-observer>
        <p class="mt-2 mb-0">
          <router-link :to="{ name: 'sign-up' }" class="text-center">Register a new membership</router-link>
        </p>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  components: {},
  data() {
    return {
      form: {
        email: null,
        password: null,
      },
    }
  },
  methods: {
    ...mapActions('auth', ['signIn']),
    onSubmit() {
      this.$apiHandler.apiResponseWrapper(async () => {
        const res = await this.signIn(this.form)
        this.$router.push({
          name: 'home',
        })
        return res
      }, this.$refs.signInForm)
    },
  },
}
</script>