<template>
  <div class="container">
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">Cotizaciones Empresa</h4>
      <div class="card-header-actions mr-1">
        <a class="btn btn-success" href="/quotesCompanies/create">Nueva</a>
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
        <div class="col-auto">
          <a class="btn btn-light mr-1" href="#" @click.prevent="showFilters">
            <i class="fas fa-filter"></i>
            <span class="d-md-down-none ml-1">Filtrar</span>
          </a>
          <a class="btn btn-light" href="#" @click.prevent="exportQuotes">
            <i class="fas fa-spinner fa-spin" :disabled="submiting" v-if="submiting"></i>
            <i class="fas fa-file-excel" v-else></i>
            <span class="d-md-down-none ml-1">Exportar</span>
          </a>
          <!-- <multiselect
            v-model="filters.pagination.per_page"
            :options="[25,50,100,200]"
            :searchable="false"
            :show-labels="false"
            :allow-empty="false"
            @select="changeSize"
            placeholder="Search">
          </multiselect> -->
        </div>
      </div>
      <div class="row mt-3" v-show="filtersShow">
        <div class="col-md-4" v-if="!user.hasRole['vendedor']">
          <div class="form-group">
            <label>Vendedor</label>
            <multiselect
              v-model="userCurrent"
              :options="agents"
              openDirection="bottom"
              track-by="id"
              label="name"
              :loading="loadingFilters"
              @select="changeAgent"
              @remove="removeAgent">
            </multiselect>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Fecha</label>
            <FunctionalCalendar
              ref="Calendar"
              v-model="filters.date"
              :is-date-range="true"
              :is-modal="true"
              :is-auto-closeable="true"
              :date-format="'yyyy-mm-dd'"
              @selectedDaysCount="getQuotes">
            </FunctionalCalendar>
          </div>
        </div>
      </div>
      <div class="table-responsive mt-2">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="d-none d-sm-table-cell">
              <a href="#" class="text-dark" @click.prevent="sort('id')">ID</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'id' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'id' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('company')">Empresa</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'company' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'company' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('name')">Contacto</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'name' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'name' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>
              Teléfonos
            </th>
            <th class="d-none d-sm-table-cell"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="quote in quotes" @click="editQuote(quote.id)">
            <td class="d-none d-sm-table-cell">{{quote.id}}</td>
            <td>
              <div>{{quote.company}}</div>
              <div class="small text-muted">{{quote.address}}</div>
            </td>
            <td>
              <div>{{quote.name}}</div>
              <div class="small text-muted">
                {{quote.email}}
              </div>
            </td>
            <td>
              <div class="small" v-if="quote.phone">{{quote.phone}}</div>
              <div class="small" v-if="quote.cellphone">{{quote.cellphone}}</div>
            </td>
            <td class="d-none d-sm-table-cell">
              <a href="#" class="text-muted"><i class="fas fa-pencil-alt"></i></a>
            </td>
          </tr>
        </tbody>
      </table>
      </div>
      <!-- <div class="row" v-if='!loading && filters.pagination.total > 0'>
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
      </div> -->
      <div class="no-items-found text-center mt-5" v-if="!loading && !quotes.length > 0">
        <i class="icon-magnifier fa-3x text-muted"></i>
        <p class="mb-0 mt-3"><strong>Could not find any items</strong></p>
        <p class="text-muted">Try changing the filters or add a new one</p>
        <a class="btn btn-success" href="/quotesCompanies/create" role="button">
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
      agents: [],
      userCurrent: Laravel.user,
      filtersShow: true,
      filters: {
        agentId: null,
        date: {
          dateRange: {}
        },
        // pagination: {
        //   from: 0,
        //   to: 0,
        //   total: 0,
        //   per_page: 25,
        //   current_page: 1,
        //   last_page: 0
        // },
        orderBy: {
          column: 'id',
          direction: 'asc'
        },
        search: ''
      },
      loading: true,
      loadingFilters: false,
      submiting: false
    }
  },
  props: ['user'],
  mounted () {
    if (localStorage.getItem("filtersTableQuotesCompanies")) {
      this.filters = JSON.parse(localStorage.getItem("filtersTableQuotesCompanies"))
    } else {
      localStorage.setItem("filtersTableQuotesCompanies", this.filters);
    }
    if (this.user.hasRole['vendedor']) {
      this.filters.agentId = this.userCurrent.id
    } else {
      this.userCurrent.id = 0
    }
    this.filtersShow = false,
    this.getQuotes()
  },
  methods: {
    getAgents () {
      if (this.agents.length == 0) {
        this.loadingFilters = true
        axios.get(`/api/users/getAgents`)
        .then(response => {
          this.agents = response.data
          this.loadingFilters = false
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.loadingFilters = false
        })
      }
    },
    getQuotes () {
      this.loading = true
      this.quotes = []

      if (this.userCurrent) {
        this.filters.agentId = this.userCurrent.id
      } else {
        this.filters.agentId = null
      }

      axios.post(`/api/quotesCompanies/filter`, this.filters)
      //axios.post(`/api/quotesCompanies/filter?page=${this.filters.pagination.current_page}`, this.filters)
      .then(response => {
        this.quotes = response.data
        //delete response.data.data
        //this.filters.pagination = response.data
        this.loading = false
        localStorage.setItem("filtersTableQuotesCompanies", JSON.stringify(this.filters));
      })
    },
    editQuote (quoteId) {
      location.href = `/quotesCompanies/${quoteId}/edit`
    },
    exportQuotes (e) {
      if (!this.submiting) {
        this.submiting = true
        axios({
          url: '/api/quotesCompanies/export',
          data: this.filters,
          method: 'POST',
          responseType: 'blob', // important
        })
        //.post(`/api/quotes/export`, this.filters)
        .then(response => {
          let blob = new Blob([response.data]),
          url = window.URL.createObjectURL(blob)
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'cotizacionesEmpresas.xlsx'); //or any other extension
          document.body.appendChild(link);
          link.click();
          //location.href = response.data;
          this.submiting = false
        });
      }
    },
    // filters
    showFilters () {
      this.filtersShow = !this.filtersShow
      this.getAgents()
    },
    changeAgent (user) {
      this.userCurrent = user
      this.getQuotes()
    },
    removeAgent () {
      this.userCurrent = {}
      this.getQuotes()
    },
    filter() {
      //this.filters.pagination.current_page = 1
      this.getQuotes()
    },
    // changeSize (perPage) {
    //   this.filters.pagination.current_page = 1
    //   this.filters.pagination.per_page = perPage
    //   this.getQuotes()
    // },
    sort (column) {
      if(column == this.filters.orderBy.column) {
        this.filters.orderBy.direction = this.filters.orderBy.direction == 'asc' ? 'desc' : 'asc'
      } else {
        this.filters.orderBy.column = column
        this.filters.orderBy.direction = 'asc'
      }

      this.getQuotes()
    }
    // changePage (page) {
    //   this.filters.pagination.current_page = page
    //   this.getQuotes()
    // }
  }
}
</script>
