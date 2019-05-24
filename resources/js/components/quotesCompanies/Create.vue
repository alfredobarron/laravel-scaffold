<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Nueva Cotización</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="create">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="form-group">
            <label>Empresa *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.company}" v-model="quote.company">
            <div class="invalid-feedback" v-if="errors.company">{{errors.company[0]}}</div>
          </div>
          <div class="form-group">
            <label>Dirección *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.address}" v-model="quote.address">
            <div class="invalid-feedback" v-if="errors.address">{{errors.address[0]}}</div>
          </div>
          <div class="form-group">
            <label>Nombre de contacto *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="quote.name">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
          <div class="form-group">
            <label>Correo electrónico *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.email}" v-model="quote.email">
            <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
          </div>
          <div class="form-group">
            <label>Teléfono *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.phone}" v-model="quote.phone">
            <div class="invalid-feedback" v-if="errors.phone">{{errors.phone[0]}}</div>
          </div>
          <div class="form-group">
            <label>Celular</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="quote.cellphone">
            <div class="invalid-feedback" v-if="errors.cellphone">{{errors.cellphone[0]}}</div>
          </div>
          <div class="form-group">
            <label>Comentarios</label>
            <textarea class="form-control" rows="5" :class="{'is-invalid': errors.notes}" v-model="quote.notes"></textarea>
            <div class="invalid-feedback" v-if="errors.notes">{{errors.notes[0]}}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      quote: {},
      errors: {},
      submiting: false
    }
  },
  mounted () {
  },
  methods: {
    create () {
      if (!this.submiting) {
        this.submiting = true
        axios.post(`/api/quotesCompanies/store`, this.quote)
        .then(response => {
          this.$toasted.global.error('¡Cotización creada!')
          location.href = '/quotesCompanies'
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    }
  }
}
</script>
