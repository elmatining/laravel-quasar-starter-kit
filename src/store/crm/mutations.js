export const updatePageMeta = (state, meta) => {
  state.pageMeta = {
    title: '',
    hash: '',
    icon: '',
    iframeTabs: false,
    backRoute: '/crm',
    tabs: [],
    ...meta
  }
}

export const updateAuthUser = (state, user) => {
  state.authUser = {
    id: '',
    name: '',
    email: '',
    username: '',
    created_at: '',
    profile: {},
    ...user
  }
}
