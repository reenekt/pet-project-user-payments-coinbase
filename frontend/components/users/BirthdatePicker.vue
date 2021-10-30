<template>
  <v-menu
    ref="menu"
    v-model="menu"
    :close-on-content-click="false"
    transition="scale-transition"
    offset-y
    min-width="auto"
    :disabled="readonly"
    :return-value="value"
    @update:return-value="$emit('input', $event)"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        :value="dateFormatted"
        :error-messages="errorMessages"
        label="Birthdate"
        prepend-icon="mdi-calendar"
        readonly
        v-bind="attrs"
        @input="$emit('input', $event)"
        v-on="on"
      ></v-text-field>
    </template>
    <v-date-picker
      :value="value"
      no-title
      scrollable
      @input="$emit('input', $event)"
    >
      <v-spacer></v-spacer>
      <v-btn
        text
        color="primary"
        @click="menu = false"
      >
        Cancel
      </v-btn>
      <v-btn
        text
        color="primary"
        @click="$refs.menu.save(value)"
      >
        OK
      </v-btn>
    </v-date-picker>
  </v-menu>
</template>

<script lang="ts">
import Vue, {PropType} from 'vue'
import {PropValidator} from 'vue/types/options'
import {InputMessage} from 'vuetify'

export default Vue.extend({
  name: 'BirthdatePicker',
  props: {
    value: {
      required: true,
      type: null as any as PropType<any>,
    },
    errorMessages: {
      type: [String, Array],
      default: () => [],
    } as PropValidator<InputMessage | null>,
    readonly: {
      required: false,
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      menu: false,
    }
  },
  computed: {
    dateFormatted(): string {
      return this.value ? this.$moment(this.value).format('MM/DD/YYYY') : ''
    },
  },
})
</script>
