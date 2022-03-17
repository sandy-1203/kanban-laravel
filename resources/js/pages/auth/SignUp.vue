<template>
  <div class="register-box">
    <div class="register-logo">
      <router-link :to="{}"><b>Admin</b>LTE</router-link>
    </div>
    <b-card>
      <b-card-body class="register-card-body p-1">
        <p class="register-box-msg">Register a new membership</p>
        <validation-observer ref="signUpForm" v-slot="{ handleSubmit, invalid }">
          <b-form @submit.prevent="handleSubmit(onSubmit)">
            <validation-provider rules="required" name="Name" vid="name" v-slot="{ errors }">
              <b-form-group class="mb-3" :state="!errors.length" :invalid-feedback="errors[0]">
                <b-input-group>
                  <template #append>
                    <b-input-group-text>
                      <font-awesome-icon icon="user" />
                    </b-input-group-text>
                  </template>
                  <b-form-input v-model="form.name" placeholder="Name" :class="{ 'is-invalid': errors.length }" />
                </b-input-group>
              </b-form-group>
            </validation-provider>
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
                    ref="password"
                    type="password"
                    placeholder="Password"
                    :class="{ 'is-invalid': errors.length }"
                    autocomplete="password"
                  />
                </b-input-group>
              </b-form-group>
            </validation-provider>
            <validation-provider
              rules="required|confirmed:password"
              name="Confirm Password"
              vid="password_confirmation"
              v-slot="{ errors }"
            >
              <b-form-group class="mb-3" :state="!errors.length" :invalid-feedback="errors[0]">
                <b-input-group>
                  <template #append>
                    <b-input-group-text>
                      <font-awesome-icon icon="lock" />
                    </b-input-group-text>
                  </template>
                  <b-form-input
                    v-model="form.password_confirmation"
                    type="password"
                    placeholder="Confirm Password"
                    :class="{ 'is-invalid': errors.length }"
                    autocomplete="password"
                  />
                </b-input-group>
              </b-form-group>
            </validation-provider>
            <div class="row">
              <div class="col-8">
                <b-form-checkbox v-model="iAgree"> I agree to the <router-link :to="{}">terms</router-link> </b-form-checkbox>
              </div>
              <div class="col-4">
                <b-button type="submit" block variant="primary" :disabled="invalid">Sign Up</b-button>
              </div>
            </div>
          </b-form>
        </validation-observer>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data() {
    return {
      form: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
      },
      iAgree: false,
    }
  },
  methods: {
    ...mapActions('auth', { signUp: 'signUp' }),
    onSubmit() {
      if (!this.iAgree) {
        this.$toast(
          {
            title: 'Error',
            icon: 'times-circle',
            variant: 'danger',
          },
          'Please agree to the Terms & Conditions!.',
        )
        return
      }
      this.$apiHandler.apiResponseWrapper(async () => {
        const res = await this.signUp(this.form)
        this.$router.push({
          name: 'home',
        })
        return res
      }, this.$refs.signUpForm)
    },
  },
}
</script>