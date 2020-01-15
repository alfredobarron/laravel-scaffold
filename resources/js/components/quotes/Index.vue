<template>
  <div class="container">
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">Cotizaciones</h4>
      <div class="card-header-actions mr-1">
        <a class="btn btn-success" href="/quotes/create">Nueva</a>
      </div>
    </div>
    <div class="card-body px-0">
      <div class="row justify-content-between">
        <div class="col-7 col-md-5">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" @click="filter">
                <i class="fas fa-search"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="Seach" v-model.trim="filters.search" @keyup.enter="filter">
          </div>
        </div>
        <div class="col-auto" v-if="!user.hasRole['vendedor']">
          <multiselect
            v-model="userCurrent"
            :options="users"
            openDirection="bottom"
            track-by="id"
            label="name"
            :loading="loading"
            @select="changeUser"
            @remove="removeUser">
          </multiselect>
        </div>
        <div class="col-auto">
          <multiselect
            v-model="filters.pagination.per_page"
            :options="[25,50,100,200]"
            :searchable="false"
            :show-labels="false"
            :allow-empty="false"
            @select="changeSize"
            placeholder="Search">
          </multiselect>
        </div>
      </div>
      <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <!-- <th class="d-none d-sm-table-cell">
              <a href="#" class="text-dark" @click.prevent="sort('id')">ID</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'id' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'id' && filters.orderBy.direction == 'desc'}"></i>
            </th> -->
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('place')">Lugar</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'place' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'place' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('client')">Cliente</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'client' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'client' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('artist')">Artista</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'artist' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'artist' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('agent')">Vendedor</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'agent' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'agent' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>Comentarios</th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('status')">Estatus</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'status' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'status' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th class="d-none d-sm-table-cell"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="quote in quotes" @click="editQuote(quote.id)" :class="{'table-success': quote.status == 'Contrato', 'table-warning': quote.status == 'Pendiente', 'table-danger': quote.status == 'No Contrato'}">
            <!-- <td class="d-none d-sm-table-cell">{{quote.id}}</td> -->
            <td>
              <div>{{quote.place}}</div>
              <div class="small text-muted">{{quote.date}}</div>
            </td>
            <td>
              <div>{{quote.client}}</div>
              <div class="small text-muted" v-if="quote.client_phone">
                {{quote.client_phone}}
              </div>
            </td>
            <td>
              <div>{{quote.artist}}</div>
              <div class="small text-muted" v-if="quote.artist_cost">
                ${{quote.artist_cost}}
              </div>
            </td>
            <td>
              <div>{{quote.agent}}</div>
              <div class="small text-muted" v-if="quote.origin">
                {{quote.origin}}
              </div>
            </td>
            <td>
              {{quote.notes}}
            </td>
            <td>
              {{quote.status}}
            </td>
            <td class="d-none d-sm-table-cell">
              <a href="#" class="text-muted"><i class="fas fa-pencil-alt"></i></a>
            </td>
          </tr>
        </tbody>
      </table>
      </div>
      <div class="row" v-if='!loading && filters.pagination.total > 0'>
        <div class="col pt-2">
          {{filters.pagination.from}}-{{filters.pagination.to}} of {{filters.pagination.total}}
        </div>
        <div class="col" v-if="filters.pagination.last_page>1">
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
              <li class="page-item" :class="{'disabled': filters.pagination.current_page <= 1}">
                <a class="page-link" href="#" @click.prevent="changePage(filters.pagination.current_page -  1)"><i class="fas fa-angle-left"></i></a>
              </li>
              <li class="page-item" v-for="page in filters.pagination.last_page" :class="{'active': filters.pagination.current_page == page}">
                <span class="page-link" v-if="filters.pagination.current_page == page">{{page}}</span>
                <a class="page-link" href="#" v-else @click.prevent="changePage(page)">{{page}}</a>
              </li>
              <li class="page-item" :class="{'disabled': filters.pagination.current_page >= filters.pagination.last_page}">
                <a class="page-link" href="#" @click.prevent="changePage(filters.pagination.current_page +  1)"><i class="fas fa-angle-right"></i></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="no-items-found text-center mt-5" v-if="!loading && !quotes.length > 0">
        <i class="icon-magnifier fa-3x text-muted"></i>
        <p class="mb-0 mt-3"><strong>Could not find any items</strong></p>
        <p class="text-muted">Try changing the filters or add a new one</p>
        <a class="btn btn-success" href="/quotes/create" role="button">
          <i class="fa fa-plus mr-1"></i>Nueva
        </a>
      </div>
      <content-placeholders v-if="loading">
        <content-placeholders-text/>
      </content-placeholders>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      quotes: [],
      users: [],
      userCurrent: Laravel.user,
      filters: {
        agentId: null,
        pagination: {
          from: 0,
          to: 0,
          total: 0,
          per_page: 25,
          current_page: 1,
          last_page: 0
        },
        orderBy: {
          column: 'id',
          direction: 'asc'
        },
        search: ''
      },
      loading: true
    }
  },
  props: ['user'],
  mounted () {
    if (localStorage.getItem("filtersTableQuotes")) {
      this.filters = JSON.parse(localStorage.getItem("filtersTableQuotes"))
    } else {
      localStorage.setItem("filtersTableQuotes", this.filters);
    }
    if (this.user.hasRole['vendedor']) {
      this.filters.agentId = this.userCurrent.id
    } else {
      this.userCurrent.id = 0
    }
    this.getAgents()
    this.getQuotes()
  },
  methods: {
    getAgents () {
      this.loading = true
      axios.get(`/api/users/getAgents`)
      .then(response => {
        this.users = response.data
        this.loading = false
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.loading = false
      })
    },
    getQuotes () {
      this.loading = true
      this.quotes = []

      if (this.userCurrent.id > 0) {
        this.filters.agentId = this.userCurrent.id
      } else {
        this.filters.agentId = null
      }

      localStorage.setItem("filtersTableQuotes", JSON.stringify(this.filters));

      axios.post(`/api/quotes/filter?page=${this.filters.pagination.current_page}`, this.filters)
      .then(response => {
        this.quotes = response.data.data
        delete response.data.data
        this.filters.pagination = response.data
        this.loading = false
      })
    },
    changeUser (user) {
      this.userCurrent = user
      this.getQuotes()
    },
    removeUser () {
      this.userCurrent.id = 0
      this.getQuotes()
    },
    editQuote (quoteId) {
      location.href = `/quotes/${quoteId}/edit`
    },
    // filters
    filter() {
      this.filters.pagination.current_page = 1
      this.getQuotes()
    },
    changeSize (perPage) {
      this.filters.pagination.current_page = 1
      this.filters.pagination.per_page = perPage
      this.getQuotes()
    },
    sort (column) {
      if(column == this.filters.orderBy.column) {
        this.filters.orderBy.direction = this.filters.orderBy.direction == 'asc' ? 'desc' : 'asc'
      } else {
        this.filters.orderBy.column = column
        this.filters.orderBy.direction = 'asc'
      }

      this.getQuotes()
    },
    changePage (page) {
      this.filters.pagination.current_page = page
      this.getQuotes()
    }
  }
}
</script>
