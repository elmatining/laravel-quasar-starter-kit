<template>
  <q-page class="row justify-center q-pa-md">
    <div style="width: 90vw; max-width: 90vw;">
      <q-stepper flat ref="stepper" v-model="step" color="dark" :alternative-labels="alt" :contractable="contractable">
        <!-- Overview -->
        <q-step default name="intro" icon="supervised_user_circle" title="Lead Overview">
          <p :class="{'q-caption': $q.screen.gt.md}">
            For each lead that you create, you can control the assignment of individual task to an agent. Change their current status.
            A lead timeline is also provided for you to review the lead's related activities.
          </p>

          <p :class="{'q-caption': $q.screen.gt.md}">
            Click on the button below to begin and provide the necessary information on
            the succeeding steps to complete the lead creation process.
          </p>

          <q-stepper-navigation>
            <q-btn class="q-ml-sm" :class="{'full-width': $q.screen.lt.sm}" color="lime-9" @click="$refs.stepper.next()">Create New Lead</q-btn>
            <q-btn class="q-ml-sm" :class="{'full-width': $q.screen.lt.sm}" color="lime-9" flat to="/crm/marketing/leads">Cancel</q-btn>
          </q-stepper-navigation>
        </q-step>
        <!-- Company Data -->
        <q-step name="company_data" title="Company Information">
          <div class="row gutter-sm">
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-field :error="$v.lead.name.$error"
                       error-label="Opps, we need this information">
                  <q-input color="lime-9"
                           v-model="lead.name"
                           float-label="Name"
                           @blur="$v.lead.name.$touch"
                  />
              </q-field>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-field
                      icon="people"
              >
                <q-input color="lime-9" type="number" v-model="lead.noOfEmployees" float-label="Number Of Employees" />
              </q-field>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.website" float-label="Website" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-field>
                <q-input color="lime-9" type="number" v-model="lead.annualRevenue" float-label="Annual Revenue" prefix="USD"/>
              </q-field>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-field helper="How did you find this lead?">
                <q-select
                        color="lime-9"
                        float-label="Source"
                        v-model="lead.source"
                        :options="leadSources"
                />
              </q-field>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-field>
                <q-select
                        color="lime-9"
                        float-label="Status"
                        v-model="lead.status"
                        :options="leadStatus"
                />
              </q-field>
            </div>
            <div class="col-12">
              <p class="q-body-2 q-mt-md q-mb-none">Company Address</p>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-8">
              <q-input color="lime-9" v-model="lead.street" float-label="Street" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.city" float-label="City" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.region" float-label="State / Region" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.country" float-label="Country" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.zipcode" float-label="Zip Code" />
            </div>
          </div>

          <q-stepper-navigation>
            <q-btn :class="{'full-width': $q.screen.lt.sm}" color="lime-9" @click="$refs.stepper.next()">Continue</q-btn>
            <q-btn :class="{'full-width': $q.screen.lt.sm}" class="q-ml-sm" color="lime-9" flat @click="$refs.stepper.previous()">Back</q-btn>
          </q-stepper-navigation>
        </q-step>
        <!-- Contact Data -->
        <q-step name="lead_data" title="Contact Information">
          <blockquote>
            <small><strong>NOTE: </strong>You can add additional <cite title="Contact Person">Contacts</cite> for a lead later.</small>
          </blockquote>
          <div class="row gutter-sm">
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.contact.firstName" float-label="First Name" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.lastName" float-label="Last Name" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.jobTitle" float-label="Job Title" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.mobile" float-label="Mobile" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.phone" float-label="Phone" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" v-model="lead.fax" float-label="Fax" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" type="email" v-model="lead.email" float-label="Email" />
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-4">
              <q-input color="lime-9" type="email" v-model="lead.secondaryEmail" float-label="Secondary Email" />
            </div>
          </div>

          <q-stepper-navigation>
            <q-btn :class="{'full-width': $q.screen.lt.sm}" color="lime-9" @click="$refs.stepper.next()">Continue</q-btn>
            <q-btn :class="{'full-width': $q.screen.lt.sm}" class="q-ml-sm" color="lime-9" flat @click="$refs.stepper.previous()">Back</q-btn>
          </q-stepper-navigation>
        </q-step>
        <!-- Additional Data -->
        <q-step name="additional_data" title="Notes">
          <div class="row gutter-sm">
            <div class="col-12">
              <q-field :error="false"
                       error-label="Oops, we need this information."
                       helper="You can use this section to provide additional information about this leads.">
                <q-input color="lime-9" v-model="lead.notes" type="textarea" float-label="Notes"/>
              </q-field>
            </div>
          </div>

          <q-stepper-navigation>
            <q-btn :class="{'full-width': $q.screen.lt.sm}" color="lime-9" @click="$refs.stepper.next()">Continue</q-btn>
            <q-btn :class="{'full-width': $q.screen.lt.sm}" class="q-ml-sm" color="lime-9" flat @click="$refs.stepper.previous()">Back</q-btn>
          </q-stepper-navigation>
        </q-step>
        <!-- Review -->
        <q-step name="review" title="Review">
          <q-stepper-navigation>
            <q-btn :class="{'full-width': $q.screen.lt.sm}" color="lime-9">Create</q-btn>
            <q-btn :class="{'full-width': $q.screen.lt.sm}" class="q-ml-sm" color="lime-9" flat @click="$refs.stepper.goToStep('company_data')">Restart</q-btn>
            <q-btn :class="{'full-width': $q.screen.lt.sm}" class="q-ml-sm" color="lime-9" flat @click="$refs.stepper.previous()">Back</q-btn>
          </q-stepper-navigation>
        </q-step>

        <q-inner-loading :visible="progress" />
      </q-stepper>
    </div>
  </q-page>
</template>

<script>
import { leadStatus, leadSources } from 'assets/lookups'
import { required, minLength } from 'vuelidate/lib/validators'

export default {
  name: 'NewLead',
  data () {
    return {
      step: 'first',
      lead: { contact: {} },
      options: ['contractable'],
      leadStatus,
      leadSources
    }
  },
  validations: {
    lead: {
      name: { required, minLength: minLength(4) }
    }
  },
  computed: {
    alt () {
      return this.options.includes('alt')
    },
    contractable () {
      return this.options.includes('contractable')
    },
    progress () {
      return this.options.includes('progress')
    }
  }
}
</script>

<style>
</style>
