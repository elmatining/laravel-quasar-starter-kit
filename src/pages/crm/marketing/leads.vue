<template>
  <q-page padding class="docs-table">
    <q-table
            :grid="$q.screen.xs"
            :hide-header="$q.screen.xs"
            dense
            ref="table"
            color="lime-9"
            title="Server-side Pagination"
            :data="serverData"
            :columns="columns"
            :filter="filter"
            :selected.sync="selected"
            row-key="company"
            :pagination.sync="serverPagination"
            @request="request"
            :loading="loading"
    >
      <!-- Row Carousel -->
      <q-td slot="body-cell-company" slot-scope="props" :props="props">
        <div class="q-mb-xs text-weight-bold">{{ props.value }}</div>
        <q-chip detail square dense icon="folder_shared" class="q-mr-xs">
          <q-tooltip>Number Of Employyes</q-tooltip>
          {{ props.row.numberOfEmployees }}
        </q-chip>
        <q-chip detail square dense icon="attach_money">
          <q-tooltip>Annual Revenue</q-tooltip>
          {{ props.row.annualRevenue }}
        </q-chip>
      </q-td>
      <q-td slot="body-cell-contact_info" slot-scope="props" :props="props">
        <q-chip class="q-mb-xs" detail square dense icon="phone">{{ props.value }}</q-chip>
        <br>
        <q-chip detail square dense icon="mail">{{ props.row.contact.email }}</q-chip>
      </q-td>
      <!--Search -->
      <template slot="top" slot-scope="props">
        <q-search class="col-xs-12 col-sm-6 col-lg-4" color="lime-9" hide-underline v-model="filter" stack-label="Search for an existing lead"/>
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
          <q-btn class="animate-pop q-mr-xs"
                 flat
                 :dense="$q.screen.lt.sm"
                 size="sm"
                 icon="get_app"
                 label="export"
          />
          <q-btn class="animate-pop q-mr-xs"
                 flat
                 :dense="$q.screen.lt.sm"
                 size="sm"
                 icon="add"
                 label="new lead"
                 to="/crm/marketing/leads/add"/>
        </div>
      </template>
      <!-- Grid Mode -->
      <div slot="item"
           slot-scope="props"
           class="q-pa-xs col-xs-12 col-sm-6 col-md-4 transition-generic"
           style="display: none"
      ></div>
    </q-table>
  </q-page>
</template>

<script>
import { format } from 'quasar'
import { leads } from 'assets/dummies'
const { capitalize } = format

export default {
  name: 'Leads',
  data () {
    return {
      serverData: [],
      serverPagination: {
        sortBy: 'company',
        page: 1,
        rowsPerPage: 7,
        rowsNumber: 0
      },
      columns: [
        {
          name: 'company',
          required: true,
          label: 'Company',
          align: 'left',
          field: row => `${capitalize(row.company)}`,
          sortable: true
        },
        {
          name: 'status',
          required: true,
          label: 'Status',
          align: 'left',
          field: row => `${capitalize(row.status)}`,
          sortable: true
        },
        {
          name: 'source',
          required: true,
          label: 'Source',
          align: 'left',
          field: row => `${capitalize(row.source)}`,
          sortable: true
        },
        {
          name: 'location',
          required: true,
          label: 'Location',
          align: 'left',
          field: row => `${row.address.city} ${row.address.country}`,
          sortable: true
        },
        {
          name: 'contact',
          required: true,
          label: 'Contact',
          align: 'left',
          field: row => `${row.contact.firstName} ${row.contact.lastName}`,
          sortable: true
        },
        {
          name: 'contact_info',
          required: true,
          label: '',
          align: 'left',
          field: row => `${row.contact.mobile}`,
          sortable: true
        }
      ],

      filter: '',
      selection: 'single',
      selected: [],
      loading: false
    }
  },
  methods: {
    request (props) {
      this.loading = true
      setTimeout(() => {
        this.serverPagination = props.pagination

        let
          table = this.$refs.table,
          rows = leads.slice(),
          { page, rowsPerPage, sortBy, descending } = props.pagination

        if (props.filter) {
          rows = table.filterMethod(rows, props.filter)
        }

        if (sortBy) {
          rows = table.sortMethod(rows, sortBy, descending)
        }

        this.serverPagination.rowsNumber = rows.length

        if (rowsPerPage) {
          rows = rows.slice((page - 1) * rowsPerPage, page * rowsPerPage)
        }

        this.serverData = rows
        this.loading = false
      }, 1000)
    }
  },
  mounted () {
    this.request({
      pagination: this.serverPagination,
      filter: this.filter
    })
  }
}
</script>

<style>
</style>
