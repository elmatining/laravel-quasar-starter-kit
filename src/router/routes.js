import categories from 'assets/categories'
import LayoutCrm from 'layouts/crm'

const routes = [
  {
    path: '/',
    component: () => import('pages/index')
  }
]

function lazyLoad (path, meta) {
  return {
    path,
    meta,
    component: () => import('pages/crm/' + path)
  }
}

const crm = {
  path: '/crm',
  component: LayoutCrm,
  children: [
    {
      path: '',
      meta: {
        title: 'gaZtronaut CRM',
        hash: '/crm',
        icon: 'widgets',
        backRoute: '/',
        requiresAuth: true
      },
      component: () => import('pages/crm/dashboard')
    },
    {
      path: 'marketing/leads/add',
      meta: {
        title: 'Create New Lead',
        hash: '/crm/marketing/leads/add',
        icon: 'add_circle',
        backRoute: '/crm/marketing/leads'
      },
      component: () => import('pages/crm/marketing/add_lead')
    }
  ]
}

categories.forEach(category => {
  if (category.extract) {
    return
  }
  category.features.forEach(feature => {
    let path = category.hash + '/' + feature.hash

    if (!feature.tabs) {
      crm.children.push(lazyLoad(path, feature))
      return
    }

    feature.tabs.forEach(tab => {
      let subpath = path + '/' + tab.hash
      crm.children.push(lazyLoad(subpath, {
        title: tab.title,
        hash: '/' + path,
        iframeTabs: feature.iframeTabs,
        icon: feature.icon,
        tabs: feature.tabs
      }))
    })

    routes.push({
      path: '/crm/' + path,
      redirect: '/crm/' + path + '/' + feature.tabs[0].hash
    })
  })
})

routes.push(crm)

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/404.vue')
  })
}

export default routes
