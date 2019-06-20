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
            <div class="col-md-12">
              <div class="form-group">
                <label>Tipo</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.type}" v-model="quote.type">
                <div class="invalid-feedback" v-if="errors.type">{{errors.type[0]}}</div>
              </div>
              <div class="form-group">
                <label>Aforo del evento</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.capacity}" v-model="quote.capacity">
                <div class="invalid-feedback" v-if="errors.capacity">{{errors.capacity[0]}}</div>
              </div>
              <div class="form-group">
                <label>Horario</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.schedule}" v-model="quote.schedule">
                <div class="invalid-feedback" v-if="errors.schedule">{{errors.schedule[0]}}</div>
              </div>
              <div class="form-group">
                <label>Lugar</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.place}" v-model="quote.place">
                <div class="invalid-feedback" v-if="errors.place">{{errors.place[0]}}</div>
              </div>
              <div class="form-group">
                <label>Nombre del cliente</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.client}" v-model="quote.client">
                <div class="invalid-feedback" v-if="errors.client">{{errors.client[0]}}</div>
              </div>
              <div class="form-group">
                <label>Teléfono del cliente</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.client_phone}" v-model="quote.client_phone">
                <div class="invalid-feedback" v-if="errors.client_phone">{{errors.client_phone[0]}}</div>
              </div>
              <div class="form-group">
                <label>Correo del cliente</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.client_email}" v-model="quote.client_email">
                <div class="invalid-feedback" v-if="errors.client_email">{{errors.client_email[0]}}</div>
              </div>
              <div class="form-group">
                <label>Procedencia</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.origin}" v-model="quote.origin">
                <div class="invalid-feedback" v-if="errors.origin">{{errors.origin[0]}}</div>
              </div>
              <div class="form-group">
                <label>Artista</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.artist}" v-model="quote.artist">
                <div class="invalid-feedback" v-if="errors.artist">{{errors.artist[0]}}</div>
              </div>
              <div class="form-group">
                <label>Representante</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.agent}" v-model="quote.agent">
                <div class="invalid-feedback" v-if="errors.agent">{{errors.agent[0]}}</div>
              </div>
              <div class="form-group">
                <label>Teléfono del representante</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.origin}" v-model="quote.agent_phone">
                <div class="invalid-feedback" v-if="errors.agent_phone">{{errors.agent_phone[0]}}</div>
              </div>
              <div class="form-group">
                <label>Costo del artista</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.artist_cost}" v-model="quote.artist_cost">
                <div class="invalid-feedback" v-if="errors.artist_cost">{{errors.artist_cost[0]}}</div>
              </div>
              <div class="form-group">
                <label>Coordinacion del evento</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.event_coordination}" v-model="quote.event_coordination">
                <div class="invalid-feedback" v-if="errors.event_coordination">{{errors.event_coordination[0]}}</div>
              </div>
              <div class="form-group">
                <label>Instalacion de sonido</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.sound_installation}" v-model="quote.sound_installation">
                <div class="invalid-feedback" v-if="errors.sound_installation">{{errors.sound_installation[0]}}</div>
              </div>
              <div class="form-group">
                <label>Vendido</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.sold}" v-model="quote.sold">
                <div class="invalid-feedback" v-if="errors.sold">{{errors.sold[0]}}</div>
              </div>
              <div class="form-group">
                <label>Requiere Factura</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.invoice_required}" v-model="quote.invoice_required">
                <div class="invalid-feedback" v-if="errors.invoice_required">{{errors.invoice_required[0]}}</div>
              </div>
              <div class="form-group">
                <label>Forma de pago</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.method_payment}" v-model="quote.method_payment">
                <div class="invalid-feedback" v-if="errors.method_payment">{{errors.method_payment[0]}}</div>
              </div>
              <div class="form-group">
                <label>Numero de facturas</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.number_invoices}" v-model="quote.number_invoices">
                <div class="invalid-feedback" v-if="errors.number_invoices">{{errors.number_invoices[0]}}</div>
              </div>
              <div class="form-group">
                <label>Fechas de pago</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.payment_dates}" v-model="quote.payment_dates">
                <div class="invalid-feedback" v-if="errors.payment_dates">{{errors.payment_dates[0]}}</div>
              </div>
              <div class="form-group">
                <legend>Información de presupuesto de producción</legend>
              </div>
              <div class="form-group">
                <label>Hotel</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.hotel}" v-model="quote.hotel">
                <div class="invalid-feedback" v-if="errors.hotel">{{errors.hotel[0]}}</div>
              </div>
              <div class="form-group">
                <label>Numero de habitaciones</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.numbre_rooms}" v-model="quote.numbre_rooms">
                <div class="invalid-feedback" v-if="errors.numbre_rooms">{{errors.numbre_rooms[0]}}</div>
              </div>
              <div class="form-group">
                <label>Tipo de habitaciones</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.type_rooms}" v-model="quote.type_rooms">
                <div class="invalid-feedback" v-if="errors.type_rooms">{{errors.type_rooms[0]}}</div>
              </div>
              <div class="form-group">
                <label>Vuelos</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.flights}" v-model="quote.flights">
                <div class="invalid-feedback" v-if="errors.flights">{{errors.flights[0]}}</div>
              </div>
              <div class="form-group">
                <label>Tipo de vuelos</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.type_flights}" v-model="quote.type_flights">
                <div class="invalid-feedback" v-if="errors.type_flights">{{errors.type_flights[0]}}</div>
              </div>
              <div class="form-group">
                <label>Transportación terrestre</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.ground_transportation}" v-model="quote.ground_transportation">
                <div class="invalid-feedback" v-if="errors.ground_transportation">{{errors.ground_transportation[0]}}</div>
              </div>
              <div class="form-group">
                <label>Especificacion de transportacion terrestre</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.ground_transportation_specifications}" v-model="quote.ground_transportation_specifications">
                <div class="invalid-feedback" v-if="errors.ground_transportation_specifications">{{errors.ground_transportation_specifications[0]}}</div>
              </div>
              <div class="form-group">
                <label>Catering</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.catering}" v-model="quote.catering">
                <div class="invalid-feedback" v-if="errors.catering">{{errors.catering[0]}}</div>
              </div>
              <div class="form-group">
                <label>Camerino</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.camerino}" v-model="quote.camerino">
                <div class="invalid-feedback" v-if="errors.camerino">{{errors.camerino[0]}}</div>
              </div>
              <div class="form-group">
                <label>Rider</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.rider}" v-model="quote.rider">
                <div class="invalid-feedback" v-if="errors.rider">{{errors.rider[0]}}</div>
              </div>
              <div class="form-group">
                <label>Otro</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.other}" v-model="quote.other">
                <div class="invalid-feedback" v-if="errors.other">{{errors.other[0]}}</div>
              </div>
              <div class="form-group">
                <label>Distribución de cortesias</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.distribution_courtesies}" v-model="quote.distribution_courtesies">
                <div class="invalid-feedback" v-if="errors.distribution_courtesies">{{errors.distribution_courtesies[0]}}</div>
              </div>
              <div class="form-group">
                <label>Coordinador (es) y presupuesto</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.coordinator_budget}" v-model="quote.coordinator_budget">
                <div class="invalid-feedback" v-if="errors.coordinator_budget">{{errors.coordinator_budget[0]}}</div>
              </div>
              <div class="form-group">
                <label>Estatus</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.status}" v-model="quote.status">
                <div class="invalid-feedback" v-if="errors.status">{{errors.status[0]}}</div>
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
      axios.get(`/api/quotes/${res[2]}`)
      .then(response => {
        this.quote = response.data
      })
      .catch(error => {
        this.$toasted.global.error('¡La cotización no existe!')
        location.href = '/quotes'
      })
      .then(() => {
        this.loading = false
      })
    },
    update () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/quotes/update/${this.quote.id}`, this.quote)
        .then(response => {
          this.$toasted.global.error('¡Cotización actualizada!')
          location.href = '/quotes'
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
            axios.delete(`/api/quotes/${this.quote.id}`)
            .then(response => {
              this.$toasted.global.error('¡Cotización borrada!')
              location.href = '/quotes'
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
