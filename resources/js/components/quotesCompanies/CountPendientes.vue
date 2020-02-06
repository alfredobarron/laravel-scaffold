<template lang="html">
  <div class="text-muted text-uppercase font-weight-bold small">Pendientes {{count}}</div>
</template>

<script>
export default {
  data () {
    return {
      count: 0
    }
  },
  mounted () {
    this.countPendientes()
  },
  methods: {
    countPendientes () {
      axios.post(`/api/quotesCompanies/countPendientes`, {userId : Laravel.user.id})
      .then(response => {
        this.count = response.data
      })
    }
  }
}
</script>
