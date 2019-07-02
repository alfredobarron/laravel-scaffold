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
            <label>Tipo *</label>
            <select class="form-control" :class="{'is-invalid': errors.type}" v-model="quote.type">
              <option value="Publico">Público</option>
              <option value="Privado">Privado</option>
            </select>
            <div class="invalid-feedback" v-if="errors.type">{{errors.type[0]}}</div>
          </div>
          <div class="form-group">
            <label>Aforo del evento *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.capacity}" v-model="quote.capacity">
            <div class="invalid-feedback" v-if="errors.capacity">{{errors.capacity[0]}}</div>
          </div>
          <div class="form-group">
            <label>Horario *</label>
            <input type="datetime-local" class="form-control" :class="{'is-invalid': errors.schedule}" v-model="quote.schedule">
            <div class="invalid-feedback" v-if="errors.schedule">{{errors.schedule[0]}}</div>
          </div>
          <div class="form-group">
            <label>Lugar *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.place}" v-model="quote.place">
            <div class="invalid-feedback" v-if="errors.place">{{errors.place[0]}}</div>
          </div>
          <div class="form-group">
            <label>Nombre del cliente *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.client}" v-model="quote.client">
            <div class="invalid-feedback" v-if="errors.client">{{errors.client[0]}}</div>
          </div>
          <div class="form-group">
            <label>Teléfono del cliente *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.client_phone}" v-model="quote.client_phone">
            <div class="invalid-feedback" v-if="errors.client_phone">{{errors.client_phone[0]}}</div>
          </div>
          <div class="form-group">
            <label>Correo del cliente *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.client_email}" v-model="quote.client_email">
            <div class="invalid-feedback" v-if="errors.client_email">{{errors.client_email[0]}}</div>
          </div>
          <div class="form-group">
            <label>Procedencia *</label>
            <select class="form-control" :class="{'is-invalid': errors.origin}" v-model="quote.origin">
              <option value="Redes">Redes</option>
              <option value="Calidad">Calidad</option>
              <option value="Oficina">Oficina</option>
              <option value="Comediante">Comediante</option>
              <option value="Campo">Campo</option>
            </select>
            <div class="invalid-feedback" v-if="errors.origin">{{errors.origin[0]}}</div>
          </div>
          <div class="form-group">
            <label>Artista *</label>
            <multiselect
              v-model="quote.artist"
              :options="users"
              openDirection="bottom"
              track-by="id"
              label="name"
              :class="{'border border-danger rounded': errors.artist}">
            </multiselect>
            <div class="invalid-feedback" v-if="errors.artist">{{errors.artist[0]}}</div>
          </div>
          <div class="form-group">
            <label>Representante *</label>
            <multiselect
              v-model="quote.agent"
              :options="users"
              openDirection="bottom"
              track-by="id"
              label="name"
              :class="{'border border-danger rounded': errors.agent}">
            </multiselect>
            <div class="invalid-feedback" v-if="errors.agent">{{errors.agent[0]}}</div>
          </div>
          <div class="form-group">
            <label>Teléfono del representante *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.agent_phone}" v-model="quote.agent_phone">
            <div class="invalid-feedback" v-if="errors.agent_phone">{{errors.agent_phone[0]}}</div>
          </div>
          <div class="form-group">
            <label>Costo del artista *</label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">$</span>
              </div>
              <input type="text" class="form-control" :class="{'is-invalid': errors.artist_cost}" v-model="quote.artist_cost">
            </div>
            <div class="invalid-feedback" v-if="errors.artist_cost">{{errors.artist_cost[0]}}</div>
          </div>
          <div class="form-group">
            <label>Coordinacion del evento *</label>
            <select class="form-control" :class="{'is-invalid': errors.event_coordination}" v-model="quote.event_coordination">
              <option value="Si">Si</option>
              <option value="No">No</option>
            </select>
            <div class="invalid-feedback" v-if="errors.event_coordination">{{errors.event_coordination[0]}}</div>
          </div>
          <div class="form-group">
            <label>Instalacion de sonido *</label>
            <select class="form-control" :class="{'is-invalid': errors.sound_installation}" v-model="quote.sound_installation">
              <option value="Si">Si</option>
              <option value="No">No</option>
            </select>
            <div class="invalid-feedback" v-if="errors.sound_installation">{{errors.sound_installation[0]}}</div>
          </div>
          <div class="form-group">
            <label>Vendido *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.sold}" v-model="quote.sold">
            <div class="invalid-feedback" v-if="errors.sold">{{errors.sold[0]}}</div>
          </div>
          <div class="form-group">
            <label>Requiere Factura *</label>
            <select class="form-control" :class="{'is-invalid': errors.invoice_required}" v-model="quote.invoice_required">
              <option value="Si">Si</option>
              <option value="No">No</option>
            </select>
            <div class="invalid-feedback" v-if="errors.invoice_required">{{errors.invoice_required[0]}}</div>
          </div>
          <div class="form-group">
            <label>Forma de pago *</label>
            <select class="form-control" :class="{'is-invalid': errors.method_payment}" v-model="quote.method_payment">
              <option value="Efectivo">Efectivo</option>
              <option value="Transferencia">Transferencia</option>
            </select>
            <div class="invalid-feedback" v-if="errors.method_payment">{{errors.method_payment[0]}}</div>
          </div>
          <div class="form-group">
            <label>Numero de facturas *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.number_invoices}" v-model="quote.number_invoices">
            <div class="invalid-feedback" v-if="errors.number_invoices">{{errors.number_invoices[0]}}</div>
          </div>
          <div class="form-group">
            <label>Fechas de pago *</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.payment_dates}" v-model="quote.payment_dates">
            <div class="invalid-feedback" v-if="errors.payment_dates">{{errors.payment_dates[0]}}</div>
          </div>
          <div class="form-group">
            <label>Estatus *</label>
            <select class="form-control" :class="{'is-invalid': errors.status}" v-model="quote.status">
              <option value="Contrato">Contrato</option>
              <option value="Pendiente">Pendiente</option>
              <option value="No Contrato">No Contrato</option>
            </select>
            <div class="invalid-feedback" v-if="errors.status">{{errors.status[0]}}</div>
          </div>
          <div class="form-group">
            <label>Comentarios *</label>
            <textarea class="form-control" rows="5" :class="{'is-invalid': errors.notes}" v-model="quote.notes"></textarea>
            <div class="invalid-feedback" v-if="errors.notes">{{errors.notes[0]}}</div>
          </div>
          <div class="form-group">
            <legend>
              Información de presupuesto de producción
              <a class="float-right text-muted" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-chevron-down"></i>
              </a>
            </legend>
          </div>
          <div class="collapse" id="collapseExample">
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
      users: [],
      errors: {},
      submiting: false
    }
  },
  mounted () {
    this.getUsers()
  },
  methods: {
    getUsers () {
      axios.get(`/api/users/all`)
      .then(response => {
        this.users = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    create () {
      if (!this.submiting) {
        this.submiting = true
        axios.post(`/api/quotes/store`, this.quote)
        .then(response => {
          this.$toasted.global.error('¡Cotización creada!')
          location.href = '/quotes'
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
