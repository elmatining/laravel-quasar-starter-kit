<template>
  <q-page padding>
    <q-table
            :grid="$q.screen.xs"
            :hide-header="$q.screen.xs"
            dense
            ref="table"
            color="lime-9"
            title="Users"
            :data="serverData"
            :columns="columns"
            :filter="filter"
            :selection="selection"
            :selected.sync="selected"
            row-key="name"
            :pagination.sync="serverPagination"
            @request="getUsers"
            :loading="loading"
    >
      <template slot="top" slot-scope="props">
        <q-search class="col-xs-12 col-sm-6 col-lg-4"
                  color="lime-9"
                  hide-underline
                  v-model="filter"
                  :debounce="600"
                  stack-label="Search for an existing user"/>
        <div class="col"/>
        <div class="col-xs-12" v-if="$q.screen.xs">
          <q-carousel color="white" quick-nav>
            <q-carousel-slide v-for="row in serverData" :key="row.company" class="q-pa-none">
              <q-card class="transition-generic cursor-pointer">
                <q-card-title class="relative-position">
                  <span class="q-title text-lime-9" style="text-transform: capitalize">{{ row.company }}</span><br>
                  <q-icon name="place" size="1.2rem" />
                  <span class="q-ml-xs q-caption">{{ `${row.address.city}, ${row.address.country}` }}</span><br>
                  <q-icon name="folder_shared" size="1.2rem" />
                  {{ row.numberOfEmployees }}<span class="q-ml-xs q-caption"> employees</span><br>
                  <q-icon name="attach_money" size="1.2rem" />
                  {{ row.annualRevenue }}<span class="q-ml-xs q-caption">USD annual revenue</span><br>
                  <q-icon name="360" size="1.2rem" />
                  <span class="q-ml-xs q-caption">status: </span><span class="q-body-1" style="text-transform: uppercase">{{ row.status }}</span><br>
                  <q-icon name="location_searching" size="1.2rem" />
                  <span class="q-ml-xs q-caption">source: </span><span class="q-body-1" style="text-transform: uppercase">{{ row.source }}</span><br>
                </q-card-title>
                <q-card-separator />
                <q-card-main>
                  <div class="q-pb-xl">
                    <p class="q-subheading q-mb-xs">{{row.contact.firstName}}, {{row.contact.lastName}}</p>
                    <q-icon name="contact_phone" size="1.5rem" /><span class="q-ml-xs">{{row.contact.mobile}}</span><br>
                    <q-icon name="contact_mail" size="1.5rem" /><span class="q-ml-xs">{{row.contact.email}}</span><br>
                  </div>
                </q-card-main>
              </q-card>
            </q-carousel-slide>
            <q-btn
                    slot="quick-nav"
                    slot-scope="props"
                    color="white"
                    flat
                    dense
                    :label="`${props.slide + 1}`"
                    @click="props.goToSlide()"
                    :class="{inactive: !props.current}"
            />
          </q-carousel>
        </div>
        <div v-else class="row justify-end">
          <q-btn class="animate-pop q-mr-xs"
                 flat
                 :dense="$q.screen.lt.sm"
                 size="sm"
                 :icon="props.inFullscreen ? 'fullscreen_exit' : 'fullscreen'"
                 :label="props.inFullscreen ? 'Exit Fullscreen' : 'Fullscreen'"
                 @click="props.toggleFullscreen"
          />
        </div>
      </template>
    </q-table>
  </q-page>
</template>

<script>
import { format } from 'quasar'
const { capitalize } = format
import { axiosInstance } from 'plugins/axios'

export default {
  name: 'Users',
  data () {
    return {
      serverData: [],
      serverPagination: {
        sortBy: 'name',
        page: 1,
        rowsPerPage: 25,
        rowsNumber: 0
      },
      columns: [
        {
          name: 'name',
          required: true,
          label: 'Name',
          align: 'left',
          field: row => `${capitalize(row.attributes.name)}`,
          sortable: false
        },
        {
          name: 'email',
          required: true,
          label: 'Email',
          align: 'left',
          field: row => `${row.attributes.email}`,
          sortable: false
        },
        {
          name: 'roles',
          required: true,
          label: 'Roles',
          align: 'left',
          field: row => `${row.attributes.roles}`,
          sortable: false
        }
      ],
      filter: '',
      selection: 'single',
      selected: [],
      loading: false
    }
  },

  mounted () {
    this.getUsers({
      pagination: this.serverPagination,
      filter: this.filter
    })
  },

  methods: {
    getUsers (props) {
      this.loading = true
      var token = JSON.parse(window.localStorage.getItem('token'))
      axiosInstance.defaults.headers.common['Authorization'] = token
      let params = props.filter === '' ? props.filter : {params: {filter: props.filter}}
      axiosInstance.get('/users', params)
        .then((response) => {
          this.serverData = response.data.data
          this.serverPagination.rowsNumber = response.data.meta.total
          this.serverPagination.page = response.data.meta.current_page
          this.serverPagination.rowsPerPage = response.data.meta.per_page
          this.loading = false
        })
        .catch(() => {
          this.serverData = []
          this.loading = false
        })
    }
  }
}
</script>

<style>
</style>
