<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Editar Cotización</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="update">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
            <a class="card-header-action ml-1" href="#" :disabled="submitingDestroy" @click.prevent="destroy">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
              <i class="far fa-trash-alt" v-else></i>
              <span class="d-md-down-none ml-1">Delete</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="row" v-if="!loading">
            <div class="form-group col-md-9">
              <label>Empresa *</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.company}" v-model="quote.company">
              <div class="invalid-feedback" v-if="errors.company">{{errors.company[0]}}</div>
            </div>
            <div class="form-group col-md-3">
              <label>ID</label>
              <input class="form-control" type="text" v-model="quote.id" readonly>
            </div>
            <div class="col-md-12">
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
              <div class="form-group">
                <label class="col-form-label">Creada</label>
                <p class="form-control-plaintext text-muted">{{quote.created_at | moment("LLL")}}</p>
              </div>
            </div>
          </div>
          <div class="row" v-else>
            <div class="col-md-12">
              <content-placeholders>
                <content-placeholders-text/>
              </content-placeholders>
            </div>
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
      loading: true,
      submiting: false,
      submitingDestroy: false
    }
  },
  mounted () {
    this.getQuote()
  },
  methods: {
    getQuote() {
      this.loading = true
      let str = window.location.pathname
      let res = str.split("/")
      axios.get(`/api/quotesCompanies/${res[2]}`)
      .then(response => {
        this.quote = response.data
      })
      .catch(error => {
        this.$toasted.global.error('¡La cotización no existe!')
        location.href = '/quotesCompanies'
      })
      .then(() => {
        this.loading = false
      })
    },
    update () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/quotesCompanies/update/${this.quote.id}`, this.quote)
        .then(response => {
          this.$toasted.global.error('¡Cotización actualizada!')
          location.href = '/quotesCompanies'
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    destroy () {
      if (!this.submitingDestroy) {
        this.submitingDestroy = true
        swal({
          title: "¿Estas seguro?",
          text: "¡Una vez borrada la cotización, no podras recuperarla!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/quotesCompanies/${this.quote.id}`)
            .then(response => {
              this.$toasted.global.error('¡Cotización borrada!')
              location.href = '/quotesCompanies'
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    }
  }
}
</script>
