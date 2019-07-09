<template>
  <div class="container">
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">Eventos</h4>
      <div class="card-header-actions mr-1">
        <!-- <a class="btn btn-success" href="#">Crear</a> -->
        <multiselect
          v-model="userCurrent"
          :options="users"
          openDirection="bottom"
          track-by="id"
          label="name"
          @select="changeUser"
          @remove="removeUser">
        </multiselect>
      </div>
    </div>
    <div class="card-body px-0">
      <div class="row">
        <div class="col" style="height: 500px;">
          <calendar-view
            class="theme-default"
            :show-date="showDate"
            locale="es"
            :starting-day-of-week="1"
            @click-date="addEvent"
            @click-event="editEvent"
            :events="events">
            <calendar-view-header
              slot="header"
              slot-scope="t"
              :header-props="t.headerProps"
              @input="setShowDate"/>
          </calendar-view>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{action}} Evento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nombre del cliente *</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.client}" v-model="eventCurrent.client">
              <div class="invalid-feedback" v-if="errors.client">{{errors.client[0]}}</div>
            </div>
            <div class="form-group">
              <label>Teléfono del cliente *</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.client_phone}" v-model="eventCurrent.client_phone">
              <div class="invalid-feedback" v-if="errors.client_phone">{{errors.client_phone[0]}}</div>
            </div>
            <div class="form-group">
              <label>Correo del cliente *</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.client_email}" v-model="eventCurrent.client_email">
              <div class="invalid-feedback" v-if="errors.client_email">{{errors.client_email[0]}}</div>
            </div>
            <div class="form-group">
              <label>Fecha *</label>
              <input type="datetime-local" class="form-control" :class="{'is-invalid': errors.schedule}" v-model="eventCurrent.schedule">
              <div class="invalid-feedback" v-if="errors.schedule">{{errors.schedule[0]}}</div>
            </div>
            <div class="form-group">
              <label>Aforo del evento *</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.capacity}" v-model="eventCurrent.capacity">
              <div class="invalid-feedback" v-if="errors.capacity">{{errors.capacity[0]}}</div>
            </div>
            <div class="form-group">
              <label>Lugar *</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.place}" v-model="eventCurrent.place">
              <div class="invalid-feedback" v-if="errors.place">{{errors.place[0]}}</div>
            </div>
            <div class="form-group">
              <label>Artista *</label>
              <multiselect
                v-model="eventCurrent.artist"
                :options="users"
                openDirection="bottom"
                track-by="id"
                label="name"
                :class="{'border border-danger rounded': errors.artist}">
              </multiselect>
              <small class="form-text text-danger" v-if="errors.artist">{{errors.artist[0]}}</small>
            </div>
            <div class="form-group">
              <label>Instalacion de sonido *</label>
              <select class="form-control" :class="{'is-invalid': errors.sound_installation}" v-model="eventCurrent.sound_installation">
                <option value="Si">Si</option>
                <option value="No">No</option>
              </select>
              <div class="invalid-feedback" v-if="errors.sound_installation">{{errors.sound_installation[0]}}</div>
            </div>
            <div class="form-group">
              <label>Vendido *</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.sold}" v-model="eventCurrent.sold">
              <div class="invalid-feedback" v-if="errors.sold">{{errors.sold[0]}}</div>
            </div>
            <div class="form-group">
              <label>Requiere Factura *</label>
              <select class="form-control" :class="{'is-invalid': errors.invoice_required}" v-model="eventCurrent.invoice_required">
                <option value="Si">Si</option>
                <option value="No">No</option>
              </select>
              <div class="invalid-feedback" v-if="errors.invoice_required">{{errors.invoice_required[0]}}</div>
            </div>
            <div class="form-group">
              <label>Descripcion *</label>
              <textarea class="form-control" rows="5" :class="{'is-invalid': errors.description}" v-model="eventCurrent.description" placeholder="Información del evento"></textarea>
              <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="card-header-action mr-2" href="#" :disabled="submitingDelete" v-if="action == 'Editar'" @click.prevent="deleteEvent">
              <i class="fas fa-spinner fa-spin" v-if="submitingDelete"></i>
              <i class="far fa-trash-alt" v-else></i>
              <span class="ml-1">Borrar</span>
            </a>
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="saveEvent">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    showDate: new Date(),
    eventCurrent: {
      schedule: Vue.moment().format('YYYY-MM-DDTHH:mm')
    },
    events: [],
    users: [],
    userCurrent: Laravel.user,
    errors: {},
    submiting: false,
    submitingDelete: false,
    action: 'Crear'
  }),
  mounted () {
    //this.getEvents()
    this.getUsers()
    this.getEventsByUser(this.userCurrent)
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
    getEvents () {
      axios.get(`/api/events/all`)
      .then(response => {
        this.events = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    getEventsByUser (user) {
      axios.get(`/api/events/byUser/${user.id}`)
      .then(response => {
        this.events = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    changeUser (user) {
      this.getEventsByUser(user)
    },
    removeUser () {
      this.getEvents()
    },
    setShowDate(d) {
      this.showDate = d
    },
    saveEvent () {
      if (this.action == 'Crear') {
        this.storeEvent()
      } else {
        this.updateEvent()
      }
    },
    addEvent (d) {
      this.action = 'Crear'
      this.errors = {}
      this.eventCurrent= {}
      //this.eventCurrent.schedule = Vue.moment(d).format('YYYY-MM-DD')
      this.eventCurrent.schedule = Vue.moment(d).format('YYYY-MM-DDTHH:mm')
      $('#eventModal').modal('show')
    },
    storeEvent () {
      if (!this.submiting) {
        this.submiting = true
        axios.post(`/api/events/store`, this.eventCurrent)
        .then(response => {
          this.events.push(response.data)
          this.eventCurrent = {}
          $('#eventModal').modal('hide')
          this.$toasted.global.error('Evento creado!')
        })
        .catch(error => {
          if (error.response) {
            this.errors = error.response.data.errors
          }
        })
        .then(response => {
          this.submiting = false
        })
      }
    },
    editEvent (e) {
      this.action = 'Editar'
      this.errors = {}
      this.eventCurrent = e.originalEvent
      this.eventCurrent.schedule = Vue.moment(e.originalEvent.schedule).format('YYYY-MM-DDTHH:mm')
      this.eventCurrent.index = this.events.findIndex(x => x.id === e.originalEvent.id)
      $('#eventModal').modal('show')
    },
    updateEvent () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/events/update/${this.eventCurrent.id}`, this.eventCurrent)
        .then(response => {
          this.events[this.eventCurrent.index] = response.data
          this.events[this.eventCurrent.index].schedule = Vue.moment(response.data.schedule).format('YYYY-MM-DDTHH:mm')
          this.eventCurrent = {}
          $('#eventModal').modal('hide')
          this.$toasted.global.error('Evento actualizado!')
        })
        .catch(error => {
          if (error.response) {
            this.errors = error.response.data.errors
          }
        })
        .then(response => {
          this.submiting = false
        })
      }
    },
    deleteEvent () {
      if (!this.submitingDelete) {
        this.submitingDelete = true
        swal({
          title: "¿Estas seguro?",
          text: "Una vez borrado evento, no podras recuperarlo!",
          icon: "warning",
          buttons: true,
          dangerMode: true
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/events/${this.eventCurrent.id}`)
            .then(response => {
              this.events.splice(this.eventCurrent.index, 1)
              this.$toasted.global.error('Evento borrado!')
              $('#eventModal').modal('hide')
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDelete = false
        })
      }
    }
  }
}
</script>
