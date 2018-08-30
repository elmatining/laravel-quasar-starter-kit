<template>
  <q-layout view="Lhh lpr lFf">
    <q-layout-header reveal>
      <q-toolbar color="dark" normal>
        <q-btn
                flat
                round
                dense
                to="pageMeta.backRoute"
                class="cordova-only electron-only"
                icon="arrow_back"
                aria-label="Go back"
        />
        <q-toolbar-title class="text-left">
          <q-icon
                  v-show="pageMeta.icon"
                  style="font-size: 2rem; margin-right: 5px;"
                  :name="pageMeta.icon"
          />
          {{ pageMeta.title }}
        </q-toolbar-title>
        <q-btn
                flat
                round
                dense
                class="within-iframe-hide"
                @click="leftDrawerOpen = !leftDrawerOpen"
                icon="menu"
                aria-label="Menu"
        />
      </q-toolbar>
    </q-layout-header>

    <q-layout-drawer
      v-model="leftDrawerOpen"
      :content-class="$q.theme === 'mat' ? 'bg-grey-2' : null"
    >
      <q-scroll-area style="width: 100%; height: 100%;"
                     :class="$q.theme === 'mat' ? 'bg-grey-3' : null">
        <div class="row flex-center bg-white" style="height: 70px">
          <img :src="user.profile.avatar" class="q-item-avatar" alt="">
          <div class="caption q-ml-md">
            <span class="text-weight-bolder">gaZtronaut CRM</span> v1.0
            <!--<div class="caption" style="line-height: 18px" v-if="env() === 'development'">{{env()}} environment</div>-->
            <div class="caption" style="line-height: 18px">{{user.name}}</div>
          </div>
        </div>
        <q-list no-border>
          <q-item link @click.native="openURL('https://gaztronaut.com')">
            <q-item-side icon="public" />
            <q-item-main label="gaZtronaut" sublabel="gaztronaut.com" />
          </q-item>
          <q-item-separator />
          <q-item
                  to="/crm"
                  exact
                  replace
          >
            <q-item-side icon="timeline" />
            <q-item-main label="Dashboard" />
          </q-item>
          <q-item-separator />
          <template v-for="category in categories">
            <q-list-header :key="`header-${category.title}`">
              {{ category.title }}
            </q-list-header>
            <q-item
                    v-for="feature in category.features"
                    :key="feature.hash"
                    :to="`/crm/${category.hash}/${feature.hash}`"
                    :replace="!category.extract"
            >
              <q-item-side :icon="feature.icon" />
              <q-item-main :label="feature.title" />
              <!--
              <q-item-side right v-if="feature.status">
                <q-chip dense color="faded">{{ feature.status }}</q-chip>
              </q-item-side>
              -->
            </q-item>
            <q-item-separator :key="`separator-${category.title}`" />
          </template>
        </q-list>
      </q-scroll-area>
    </q-layout-drawer>

    <q-page-container>
      <transition
              enter-active-class="animated fadeIn"
              leave-active-class="animated fadeOut"
              mode="out-in"
              :duration="300"
              @leave="resetScroll"
      >
        <router-view />
      </transition>
    </q-page-container>
  </q-layout>
</template>

<script>
import { openURL } from 'quasar'
import { mapState } from 'vuex'
import categories from 'assets/categories'

export default {
  name: 'CRM',
  data () {
    return {
      categories,
      leftDrawerOpen: false
    }
  },
  computed: {
    ...mapState('crm', ['pageMeta']),
    ...mapState('auth', ['user'])
  },
  methods: {
    openURL,
    env () {
      return `${process.env.NODE_ENV}`
    },
    resetScroll (el, done) {
      document.documentElement.scrollTop = 0
      document.body.scrollTop = 0
      done()
    }
  },
  mounted () {
    this.leftDrawerOpen = this.$q.platform.is.desktop
  }
}
</script>

<style>
</style>
