import Vue from 'vue'

type errorMessageFunc = (paramName: string, errorParam: any) => string
const messagesMap: Record<string, errorMessageFunc> = {
  required: (paramName: string, errorParam: any) => paramName + ' is required',
  requiredIf: (paramName: string, errorParam: any) => paramName + ' is required',
  requiredUnless: (paramName: string, errorParam: any) => paramName + ' is required',
  minLength: (paramName: string, errorParam: any) => `Length of ${paramName} is less than ${errorParam.min}`,
  maxLength: (paramName: string, errorParam: any) => `Length of ${paramName} is greater than ${errorParam.max}`,
  minValue: (paramName: string, errorParam: any) => `${paramName} is less than ${errorParam.min}`,
  maxValue: (paramName: string, errorParam: any) => `${paramName} is greater than ${errorParam.max}`,
  between: (paramName: string, errorParam: any) => `Length of ${paramName} must be between ${errorParam.min} and ${errorParam.max}`,
  alpha: (paramName: string, errorParam: any) => paramName + ' is not a valid alphabet text',
  alphaNum: (paramName: string, errorParam: any) => paramName + ' is not a valid alphanumerics text',
  numeric: (paramName: string, errorParam: any) => paramName + ' is not a valid number',
  integer: (paramName: string, errorParam: any) => paramName + ' is not a valid integer',
  decimal: (paramName: string, errorParam: any) => paramName + ' is not a valid decimal',
  email: (paramName: string, errorParam: any) => paramName + ' is not a valid email',
  ipAddress: (paramName: string, errorParam: any) => paramName + ' is not a valid ip address',
  macAddress: (paramName: string, errorParam: any) => paramName + ' is not a valid mac address',
  sameAs: (paramName: string, errorParam: any) => `${paramName} is not same with ${errorParam.eq}`,
  url: (paramName: string, errorParam: any) => paramName + ' is not a valid url',
}

export default Vue.extend({
  methods: {
    /**
     * Return error message for first error in vuelidate validation rule item
     *
     * @param vuelidateValidationItem VueInstance.$v.someItem like object
     * @param paramName Display param name
     * @param fallbackMessage Fallback error message
     */
    getVuelidateError(
      vuelidateValidationItem: any,
      paramName: string,
      fallbackMessage = 'Validation error'
    ): null | string {
      if (!vuelidateValidationItem || !vuelidateValidationItem.$dirty) {
        return null
      }

      const errorParamEntries: any[] = Object.entries(vuelidateValidationItem.$params)

      let firstError = null

      for (const errorParamEntry of errorParamEntries) {
        if (vuelidateValidationItem[errorParamEntry[0]] === false) {
          firstError = errorParamEntry[1]
          break
        }
      }

      if (!firstError) {
        return null
      }

      if (!(firstError.type in messagesMap)) {
        return fallbackMessage
      }

      return messagesMap[firstError.type](paramName, firstError)
    },

    /**
     * Combine error messages into single array
     *
     * @param errorsLists Error messages or error message lists
     */
    combineErrors(...errorsLists: Array<string|string[]|null|undefined>): string[] {
      let errors: string[] = []

      for (const errorList of errorsLists) {
        if (!errorList) {
          continue
        }
        if (Array.isArray(errorList)) {
          errors = errors.concat(errorList)
        } else if (typeof errorList === 'string') {
          errors.push(errorList)
        }
      }

      return errors
    },
  },
})
