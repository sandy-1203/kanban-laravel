import { defineConfig } from 'laravel-vite'
import {createVuePlugin} from 'vite-plugin-vue2'

export default defineConfig()
	.withPlugin(createVuePlugin)
	.merge({
		// Your own Vite options
	})