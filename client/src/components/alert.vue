<template>
</template>
<script>
import { mapState } from 'vuex'
import { isEmpty } from 'lodash'
export default {
  name: 'alert',
  computed: {
    ...mapState(['messages']),
    hasWarningMessage () {
      return this.messages.warning !== ''
    },
    hasErrorMessages () {
      return this.messages.error.length > 0
    },
    hasValidationMessages () {
      return !isEmpty(this.messages.validation)
    }
  },
  updated () {
    if (this.hasWarningMessage) {
      this.$message({
        message: this.messages.warning,
        type: 'warning'
      })
    } else if (this.hasErrorMessages) {
      this.$message({
        message: this.messages.error,
        type: 'error'
      })
    } else {
      this.$message({
        message: this.messages.validation,
        type: 'error'
      })
    }
  }
}
</script>
