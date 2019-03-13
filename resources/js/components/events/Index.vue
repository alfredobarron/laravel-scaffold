<template>
  <div class="container">
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">Eventos</h4>
      <!-- <div class="card-header-actions mr-1">
        <a class="btn btn-success" href="#">Crear</a>
      </div> -->
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
              <label>Fecha</label>
              <input type="date" class="form-control" :class="{'is-invalid': errors.date}" v-model="eventCurrent.date">
              <div class="invalid-feedback" v-if="errors.date">{{errors.date[0]}}</div>
            </div>
            <div class="form-group">
              <label>Comediante</label>
              <multiselect
                v-model="eventCurrent.user"
                :options="users"
                openDirection="bottom"
                track-by="id"
                label="name"
                :class="{'border border-danger rounded': errors.user}">
              </multiselect>
              <small class="form-text text-danger" v-if="errors.user">{{errors.user[0]}}</small>
            </div>
            <div class="form-group">
              <label>Descripcion</label>
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
      date: Vue.moment().format('YYYY-MM-DD')
    },
    events: [],
    users: [],
    errors: {},
    submiting: false,
    submitingDelete: false,
    action: 'Crear'
  }),
  mounted () {
    this.getEvents()
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
    getEvents () {
      axios.get(`/api/events/all`)
      .then(response => {
        this.events = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
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
      this.eventCurrent.date = Vue.moment(d).format('YYYY-MM-DD')
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
      this.eventCurrent.date = e.originalEvent.date
      this.eventCurrent.index = this.events.findIndex(x => x.id === e.originalEvent.id)
      $('#eventModal').modal('show')
    },
    updateEvent () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/events/update/${this.eventCurrent.id}`, this.eventCurrent)
        .then(response => {
          this.events[this.eventCurrent.index] = response.data
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
